<?php

	


  require("../includes/class/qclass.php");
  
  
  $guestTask = $taskclass->check_fetch_task($user, 101, true);
			
  $qclass = new QClass($container, $guestTask);

   if($guestTask["id"]){
   
    $taskclass->process_task_general($guestTask);
    
    if($guestTask["remainingSeconds"] <= 0 || $_POST["console"] == "complete delusion"){
    
      $taskclass->delete_task_session($user["id"], $guestTask["type"], true);
       unset($guestTask);
      if ($_POST["console"] == "complete delusion")
       $_SESSION["error"] = "Mission failed";
      else $errors [] = "Mission failed";
    }
    
    $tVars["qtask"] = $guestTask;
   		
   	$tVars["display"] = 'quests/quest_play.tpl';
    
    
     // has user just finished working? Give him a juicy reward
    if ($qclass->finished)
    {

      $cardinal->redirect($config['url']);
  
    }
  } // guestTask
  
  
 
  if (!$guestTask["id"])
  {
            
              
            $qclass->forceStartQuest(33, 101, null, true);
            
     
  }

?>