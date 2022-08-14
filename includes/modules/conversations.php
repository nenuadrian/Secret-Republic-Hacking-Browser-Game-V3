<?php



$cardinal->mustLogin();

$systemUsername = array(-1 => '<strong>Cardinal System</strong>', -2 => '<strong>Organization Mainframe</strong>');

function validateMessage($content)
{
  global $errors;

  if  (isset($content[9]) && !isset($content[4000]))
    return true;

  $errors[]="Message should have between 10 and 4000 characters";
}
function validateTitle($title)
{
  global $errors;

  if  (isset($title[4]) && !isset($title[50]))
    return true;

  $errors[]="Title should have between 4 and 50 characters";
}
if ($GET['new'])
{
  if ($_POST)
  {
    $to = $_POST['username'];
    $message = $_POST['message'];
    $title = $_POST['title'];
	if ($user['dataPoints'] < $config['newMessageDataPoints'])
		$errors[] = "Not enough Data Points available";
   elseif (validateTitle($title) && validateMessage($message))
      if (!$cardinal->loginSystem->validateUsername($to))
        $errors[] = 'Invalid username provided';
      elseif(!($to = $cardinal->loginSystem->isUsernameUsed($to)))
        $errors[] = 'Hacker not found';
      else
      {
	    $uclass->updatePlayer(array("dataPoints" => $user['dataPoints'] - $config['newMessageDataPoints']));
        $message_id = $uclass->send_msg($user['id'], $to, $message, $title);
        $cardinal->redirect($config['url'].'conversations/message/'.$message_id);
      }

  }

  $tVars["display"] = 'conversations/new_message.tpl';
}
elseif ($message_id = $GET['message'])
{

	$message = $db->rawQuery('select title, username, message_id, created, replies, last_reply_by_user_id, last_reply_seen, sender_user_id,receiver_user_id
	                              from conversations m
	                              left outer join users u on
								  case m.sender_user_id
									when ? then u.id = receiver_user_id
									else u.id = m.sender_user_id
								  end
								  where message_id = ? and parent_message_id is null
								        and (receiver_user_id = ? or sender_user_id = ?) limit 1',
							      array($user['id'],  $message_id, $user['id'], $user['id']))[0];

	$conversationWith = $message['sender_user_id'] == $user['id'] ? $message['receiver_user_id'] : $message['sender_user_id'];



	if ($message['message_id'])
	{
		if ($conversationWith <= 0)
		  {
			$message['username'] = $systemUsername[$conversationWith];
			$replyNotAllowed = true;
		  }
		  else $message['username'] = profile_link($message['username']);
		if ($message['last_reply_by_user_id'] != $user['id'] && !$message['last_reply_seen'])
		{
			if ($user["newMsg"]){
				$user["newMsg"] --;
				unset($_SESSION['lastMsgCheck']);
			}
			$db->where('message_id', $message_id)->update('conversations', array('last_reply_seen' => 1));
		}
		if ($_POST)
		{
			  $reply = $_POST['message'];
      		  if ($user['dataPoints'] < $config['newMessageReplyDataPoints'])
					$errors[] = "Not enough Data Points available";
			  elseif(validateMessage($reply))
			  {
          $parser = new \JBBCode\Parser();
          $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
          $parser->parse($reply);
          $reply = $parser->getAsHtml();
				  $reply = array(
					'message' => $reply,
					'sender_user_id' => $user['id'],
					'created' => time(),
					'parent_message_id' => $message['message_id'],
				  );
				  if ($reply_id = $db->insert('conversations', $reply))
				  {
					$db->rawQuery("update conversations
					               set replies = replies + 1, last_reply_by_user_id = ?, last_reply_date = ?, last_reply_seen = 0
								   where message_id = ? limit 1",
								   array($user['id'], time(), $message_id));
					$success = "Message sent";

					  $uclass->updatePlayer(array("dataPoints" => $user['dataPoints'] - $config['newMessageReplyDataPoints']));

				  	$cardinal->redirect(URL_C);
				  } else $errors[] = "Could not add";
			  }
		}


		$pages = new Paginator;
		$pages->items_total = $message['replies'];

		$pages->paginate();

	  $replies = $db->rawQuery('select m.*, u.username from conversations m
								left outer join users u on
								  case m.sender_user_id
									when ? then u.id = receiver_user_id
									else u.id = m.sender_user_id
								  end
								where message_id = ? or parent_message_id = ? order by created asc '.$pages->limit,
							   array($user['id'], $message_id, $message_id));

	  foreach ($replies as &$reply)
	  {
	  	if ($reply['sender_user_id'] <= 0)
      		$reply['username'] = $systemUsername[$reply['sender_user_id']];
	  	else $reply['username'] = profile_link($reply['username']);
	  }

		$tVars['message'] = $message;
	  $tVars['replyNotAllowed'] = $replyNotAllowed;
	  $tVars['replies'] = $replies;
	  $tVars['display'] = 'conversations/message.tpl';
	} else $cardinal->redirect(URL.'conversations');

}
else
{
  if($_POST['readall'])
  {
          $db->rawQuery('update conversations set last_reply_seen = 1 where
                         parent_message_id is null and (sender_user_id = ? or receiver_user_id = ?) and last_reply_by_user_id != ? and last_reply_seen = 0',
                         array($user['id'], $user['id'],$user['id']));
	 	$success[] = "All messages marked as read.";
	  unset($_SESSION['lastMsgCheck']);
		$cardinal->redirect(URL_C);
  }

  $filter = "";
  $filters = array("normal" => 1, "spy" => 2, "attacks" => 3, "org" => 4, "scavenge" => 5, "cardinal"=>6);

  if ($GET['filter'] && isset($filters[$GET['filter']])) $filter = "and type = ".$filters[$GET['filter']];
  $messages = $db->rawQuery("select count(*) nrm from conversations m where parent_message_id is null and (m.sender_user_id = ? or m.receiver_user_id = ?) ".$filter,
							 array($user['id'], $user['id']));
  $pages = new Paginator;
  $pages->items_total = $messages[0]['nrm'];
  $pages->items_per_page = 14;
  $pages->paginate();
  $messages = $db->rawQuery('select message_id, u.username, title, type, last_reply_seen, last_reply_by_user_id, sender_user_id, receiver_user_id, last_reply_date, replies
                             from conversations m
							 left outer join users u on
                              case m.sender_user_id
                                when ? then u.id = receiver_user_id
                                else u.id = m.sender_user_id
                              end
							  where parent_message_id is null and (m.sender_user_id = ? or m.receiver_user_id = ?)
							  '.$filter.'
							  order by last_reply_date desc'.$pages->limit,
						   array($user['id'], $user['id'], $user['id']));

  foreach ($messages as &$message)
  {
	  if ($message['last_reply_by_user_id'] == $user['id']) $message['last_reply_seen'] = 1;
	  $message['last_reply_date'] = date_fashion($message['last_reply_date']);

	  if ($message['last_reply_by_user_id'] <= 0)

      	$message['last_reply_username'] = $systemUsername[$message['last_reply_by_user_id']];

	  elseif ($message['last_reply_by_user_id'] == $user['id'])

		  $message['last_reply_username'] = profile_link($user['username']);

	  else
		  $message['last_reply_username'] = $message['username'];



	  $conversationWith = $message['sender_user_id'] == $user['id'] ? $message['receiver_user_id'] : $message['sender_user_id'];

	  if ($conversationWith <= 0)
      $message['username'] = $systemUsername[$conversationWith];
	  else $message['username'] = profile_link($message['username']);

	  $message['lastPage'] = ceil($message['replies']/15);
  }
  $tVars["messages"] = $messages;
  $tVars["display"] = 'conversations/messages.tpl';
}


?>
