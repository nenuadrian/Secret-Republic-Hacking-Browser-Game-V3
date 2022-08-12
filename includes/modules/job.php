<?php

	

  $cardinal->mustLogin();

  require("../includes/constants/jobs.php");
  require("../includes/class/qclass.php");

  $jobTask = $taskclass->check_fetch_task($user, 12);
			
  $qclass = new QClass($jobTask);
			
   if($jobTask["id"]){
   
    $taskclass->process_task_general($jobTask);
    if($jobTask["remainingSeconds"] <= 0 || $_POST["console"] == "complete delusion"){
     	
      $taskclass->delete_task_session($user["id"], $jobTask["type"]);
       unset($jobTask);
		
		 $errors [] = "Mission failed";
		$_SESSION['voice'] = 'work_failed';
     
    }
    
    $tVars["qtask"] = $jobTask;
   		
   	$tVars["display"] = 'quests/quest_play.tpl';
    
    
     // has user just finished working? Give him a juicy reward
    if ($qclass->finished)
    {

      $job = $uclass->getJob($user["id"]);
      
      // get percentage of time it took user to finish given quest
      $timeToFinish = time() - $jobTask["start"];
      $timePercentage = intval($timeToFinish / ($jobTask["totalSeconds"] / 100));
      
      // calculate base job experience
      $reward["jobExp"] = rand(15, 20);
      $reward["jobExp"] *= $job["level"];
      
      $reward["exp"] = intval($reward["jobExp"]);
      
      $reward["money"] = rand(50 * ($job["level"] > 1 ? ceil($job["level"] / 2)  : 1), 200 * $job["level"]);
      $reward['skillPoints'] = rand(1, $job['level']);
      
      
      $uclass->addReward($user["id"], $reward, "Job wage");
      
  
    }
  } // jobtask
  
  
  
 
  
  if (!$jobTask["id"])
  {
  
    
    
    
    $job = $uclass->getJob($user["id"], $config['timeBetweenJobs']);
    
    
                  
    if (!$job["last_work"])
    {
      
      
      if ($_POST["work"])
        if ($uclass->canDoTask())
          if ($myJob = $jobs[$_POST["work"]])
          {
            $quest = $db->join("quest_groups qg", "qg.qgroup_id = q.qgroup_id", "LEFT OUTER")
                        ->where("qg.type", 2)
                        ->where("isLive", 1)
                        ->where("qgroup_order", $myJob["qgroup_order"])
                        ->where("q.level <=" . $job["level"])
                        ->orderBy("RAND()")
                        ->getOne("quests q", "id");
            if ($quest["id"])
            { 
              $dataInsert = array(
                "user_id" => $user["id"],
                "created" => time(),
                "job_id"  => $_POST["work"],
                "quest_id"=> $quest["id"]);
            
              $db->insert("user_job_logs", $dataInsert);
              $_SESSION['voice'] = 'work_initiated';
              $qclass->forceStartQuest($quest["id"], 12);
            
        
            } // quest
          }
        
    }
    else
      $job["remainingSeconds"] = $config['timeBetweenJobs'] - time() + $job["last_work"];
  
    $tVars["timeBetweenJobs"] = $config['timeBetweenJobs'];
    $tVars["job"] = $job;
    $tVars["jobs"] = $jobs;
  
    $tVars["display"] = "job/job.tpl";
  }

?>
