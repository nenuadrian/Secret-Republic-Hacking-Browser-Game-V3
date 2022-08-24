<?php

	


	$selectColumns = 'hu.id, g.name, ho.name  oname, ho.orank ,username, gavatar,organization,`rank`,
	                  zrank, zone,blogs,hu.points, hu.level,rep, uc.banned, uc.youtube';
	         
	
	    
	// get user id from parameters
	if (isset($GET['hacker']))
	{
		
		//if(ctype_digit($GET['hacker']) && $GET['hacker'] != $quser['id'])
		//	$db->where('id', $GET['hacker']);
		//elseif($GET['hacker'] != $user['username'] && $cardinal->loginSystem->validateUsername($GET['hacker']))
		$db->where('username', $GET['hacker']);
		
        $checkIfHackerExists = $db->getOne('users', 'id');
		
		$user_id = $checkIfHackerExists['id'];
	}
	
	if(!$user_id && $cardinal->loginSystem->logged && $quser = $user)
		$user_id = $user["id"];

    if ($user_id)
	{
    $db->join("organizations ho", "ho.id = hu.organization", "LEFT OUTER")
	   ->join("user_credentials uc", "uc.uid = hu.id", "LEFT OUTER")
	   ->join("groups g", "g.group_id = uc.group_id", "LEFT OUTER");
    $quser = $db->where("hu.id", $user_id)->getOne("users hu", $selectColumns);
	}
  // succesfully fetched a profile?
	if(!$quser['id'])
		$cardinal->show_404();
		
      if (!$quser['banned'])
      {

		  $blogs = $db->where('user_id', $quser['id'])->get('blogs', null,  'blog_id, name, nra, nrs');

		  $forumThreads = $db->where('parent is null')->where('user_id', $quser['id'])->get("forum_posts", 5,"title,id,replies" );

		  if ($logged && $quser['id']!=$user['id'])
		  {
			
					if($_POST['reputation'])
					{
						if ($user['level'] < 5)
							add_alert("You must be at least level 5 to give reputation to other hackers");
						else
						{
							$count = $db->where('sender', $user['id'])->where('created', time()-24*60*60,'>')->getOne('users_reputation', 'count(*) nrr')['nrr'];
							if($count >= $user['dailyRep'])
								add_alert('You have already given '.$user['dailyRep'].' reputation points in the last 24 hours');
						}
						
						if (!there_are_errors())
						{
							$dataInsert = array('sender' => $user['id'], 'receiver' => $quser['id'], 'created' => time());
							$db->insert('users_reputation', $dataInsert);
							$uclass->updatePlayer(array("rep" => $quser['rep'] + 1), $quser['id']);
							add_alert("Reputation point awarded to " . $quser['username'], 'success');
						}

						$cardinal->redirect(URL_C);
					}

				  $checkIfFriends = 
				  	$db->where('(user1id=? and user2id=?)', array($user['id'],$quser['id']))
				  		 ->orWhere('(user2id=? and user1id=?)', array($user['id'],$quser['id']))
				  		 ->getOne('friendships', 'id');


				  if($checkIfFriends['id']) $areFriends = true;

				  if(!$areFriends)
				  {
					$checkIfRequestSent = 
						$db->where('(senderid=? and receiverid=?)', array($user['id'],$quser['id']))
				  		 ->orWhere('(receiverid=? and senderid=?)', array($user['id'],$quser['id']))
				  		 ->getOne('friend_requests', 'request_id,senderid, receiverid');
				  		 
					
					if($checkIfRequestSent['request_id']) 
					  $waitingRequest = $checkIfRequestSent['receiverid'];
				  }
				  if ($_POST['cancelFriendRequest'] && $waitingRequest == $quser['id'])
				  {
				  	$db->where('request_id', $checkIfRequestSent['request_id'])
				  		 ->delete('friend_requests');

						$waitingRequest = $areFriends = false;
						$success = 'Request canceled';
				  }

				  if($_POST['sendFriendRequest'] && !$areFriends && !$waitingRequest)
				  {
					$request = array('created' => time(), 'senderid' => $user['id'], 'receiverid' => $quser['id']);
					$db->insert('friend_requests', $request);

					$waitingRequest = $quser['id'];
					$success = 'Friend request has been sent to '.$quser['username'];      
				  }

				  $tVars['areFriends'] = $areFriends;
				  $tVars['waitingRequest'] = $waitingRequest;

		
			
		  }


		  $page_title.=$quser['username'].'\'s hacker profile';

		  $achievements=$db->rawQuery('select ua.achievement_id, ua.times, a.image, a.name, description from user_achievements ua 
										   left outer join achievements as a on ua.achievement_id = a.achievement_id
										   where user_id = ?', array($quser['id']));

		
		  $tVars['forumThreads'] = $forumThreads;
		  $tVars['blogs']        = $blogs;
		  $tVars['achievements'] = $achievements;

	} // not banned
		$tVars['quser'] = $quser;
		$tVars['display'] = 'profile/profile.tpl';
	

	
	

?>
