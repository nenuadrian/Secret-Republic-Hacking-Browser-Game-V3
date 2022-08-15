<?php

  

$cardinal->mustLogin();

$page_title="Friendships";

  if($GET["requests"]){
      
    if($request_id = $_POST["request"]){
      
      $fr = $db->where('receiverid', $user['id'])->where('request_id', $request_id)->getOne('friend_requests', 'senderid,request_id');
      if($fr["request_id"])
      {
        $msg = "[url=".URL."profile/hacker/".$user["username"]."]".$user["username"]."[/url] ";
        if($_POST["accept"])
        {
          //ACCEPT
          $friendship = array('user1id' => $fr['senderid'],
                    'user2id' => $user['id'],
                    'date' => time());
          $db->insert('friendships', $friendship);

                  /**************
            ACHIEVEMENT 
           **************/
          $nrf = $db->where('user1id = ? or user2id = ?', array($user["id"],$user["id"]))->getOne('friendships', 'count(*) nrf');
          if (in_array($nrf['nrf'], array(50, 100, 300, 500, 700, 1000)))
          {
            $reward['money'] = 100;
            $reward['achievements'] = array(8);
            $uclass->addReward($user['id'], $reward, 'Frienception - You\'ve got '.number_format($nrf['nrf']).' friends');
          }
          $title = 'Friend request accepted';
          $msg .=" has accepted your friend request";          
        }
        else
        {
          //DECLINE
          $title = 'Friend request declined';
          $msg .= "has declined your friend request";

          // DECLINE CARDINAL'S FRIEND REQUEST? => ACHIEVEMEEEENT
          if ($fr['senderid'] == 1564)
          {
            $reward = array("achievements" => array(4));
            $reward['money'] = 100;
            $uclass->addReward($user['id'], $reward, 'Unfriendzoned - declined Cardinal\'s friendship');
          }
        }
        unset($_SESSION['lastFriendCheck']);
        $user['friend_requests']--;
              $db->where('request_id', $fr['request_id'])->delete('friend_requests', 1);

        $uclass->send_msg(-1, $fr["senderid"], $msg, $title);   
              
      } // if friend request exists
    } // answer fr
      
    
    
    
    $pages = new Paginator;
    $pages->items_total = $user["friend_requests"];

  $pages->paginate();
  $db->pageLimit = $pages->items_per_page;

    $requests = $db->where('receiverid', $user['id'])
                   ->join('users hu', 'hfr.senderid=hu.id', 'left outer')
                   ->orderBy('created', 'desc')
                   ->paginate('friend_requests hfr', $pages->current_page, 'hfr.request_id,senderid,created,hu.username as sender');


  
    foreach($requests as &$req)
      $req["created"]=date_fashion($req["created"]);
    

    $tVars["requests"] = $requests;
    $tVars["display"] = "friends/friend_requests.tpl";
  
  }else{
  
    if(ctype_digit($_POST["unfriend"]))
    {
    
      $friendship = 
        $db->where('(user1id=? or user2id= ? ) and id=?', array($user["id"],$user["id"],$_POST["unfriend"]))
           ->getOne('friendships', 'id, user1id, user2id');

      if($friendship["id"]){
          $db->where('id', $friendship["id"])->delete('friendships');

      
          //$msg = $user["username"] . " has canceled your friendship";
      
          //$uclass->send_msg(-1, $friendship["user1id"] == $user["id"] ? $friendship["user2id"] : $friendship["user1id"], $msg, 'Friendship ended: '.$user['username']);   
      
          add_alert("Friendship erased", 'success');
        } else add_alert("Permission denied");
    
    
    } // if unfriend
  
    $friendsNumber = $db->where('user1id = ? or user2id = ?', array($user["id"],$user["id"]))->getOne('friendships', 'count(*) nrf');
    $pages = new Paginator;
    $pages->items_total = $friendsNumber["nrf"];
    $pages->paginate();
    
    $friends = $uclass->get_friends($user["id"],$pages->limit);
    
    $tVars["nrf"] = $friendsNumber['nrf'];
    $tVars["friends"] = $friends;
    $tVars["display"] = "friends/friends.tpl";
  }


?>
