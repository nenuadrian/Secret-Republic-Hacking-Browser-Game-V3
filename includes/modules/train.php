<?php

define('cardinal_system', true);
$cardinal->mustLogin();
require_once('../includes/header.php');
require_once('../includes/class/tclass.php');

  $page_title="Training facility";

	$trainTask = $taskclass->check_fetch_task($user, 9);

	$tclass = new TrainClass($trainTask);
	

	if($tclass->trainTask)
    if($tclass->trainTask["remainingSeconds"]<=0 ){
      $tclass->end_training();
     
    }
    else
	{
	//require("../includes/class/gclass.php");
	//$game = new Game();
		
	if ($trainTask['dataid'] == 1)
    {
      require_once("../includes/class/recaptchalib.php");
         
      
      
      if(isset($_POST["answer"]) || $finish)
      {
  
                                      
         if (!$cardinal->verify_captcha_response() && !$finish) {
            // What happens when the CAPTCHA was entered incorrectly
            $errors [] = "Invalid decrypted data. New encrypted string fetched.";
          
          } else {
            $trainTask['steps'] -- ;
            $success = "Correct answer. File decrypted";
            
            if ($trainTask['steps'] == 0)
            {
              $tclass->end_training(true);
				
            }
            else
			{
				$dataUpdate['data'] = unserialize($trainTask['data']);
				$dataUpdate['data']['steps'] = $trainTask['steps'];	
				$taskclass->updateTask($trainTask['id'], $dataUpdate);
			}
			 
          }  
		  $cardinal->redirect(URL_C);
      }
	  $tVars["captcha"] = $cardinal->generate_captcha_box();
    }
	elseif ($trainTask['dataid'] == 2)
	{
		
		if ($_POST['answer'])
		{
				
			if ($finish) $answered = true;
			
			elseif ($_POST['answer'] == $trainTask['step']['numbers'][$trainTask['step']['answer_missing']])
				$answered = true;
			
			if ($answered)
			{
				require('../includes/class/gclass.php');
				$game = new Game();
				$trainTask['steps']--;
				if ($trainTask['steps'] <= 0)
            	{
              		$tclass->end_training(true);
					
           		}
				
				$trainTask['failed'] = 0;
				$trainTask['step'] = $game->generateNumbersPattern($trainTask['difficulty']);
				
				$success[] = "You matched the pattern perfectly. Well done!";
				
				
			} 
			else 
			{
				$trainTask['failed']++;
				if ($trainTask['failed'] == 3) 
				{
					$tclass->end_training();
					
				}
				else
					$errors[] = "Incorrect answer. You can try 3 times per pattern before failing your training ^^.";
			}
			$task = unserialize($trainTask['data']);
			$task['steps'] = $trainTask['steps'];
			$task['step'] = $trainTask['step'];
			$task['failed'] = $trainTask['failed'];
			
			$dataUpdate = array("data" => $task);
			$taskclass->updateTask($trainTask['id'], $dataUpdate);
			$cardinal->redirect(URL_C);
		}
	}
	}
   
   
if(!$tclass->trainTask){
	
  $trainLog = $db->where("user_id", $user["id"])
                  ->where("created", array(">" =>  (time() - $config['trainEvery']) ))
                  ->orderBy("created", "desc")
                  ->getOne("user_train_logs", "log_id, created");
  
 
  if (!$trainLog["log_id"] || $finish)  
  {          
      if($_POST["train"])
		if ($uclass->canDoTask())
		{
      		if ($_POST['train'] == "low") $difficulty = 1;
		  	elseif ($_POST['train'] == "mid") $difficulty = 2;
		    else $difficulty = 3;
		  
        $dataInsert = array(
              "user_id" => $user["id"],
              "created" => time());
            
        $task['train_log'] = $db->insert("user_train_logs", $dataInsert);
       
		if ($difficulty != 3)
			$rand = rand(100, 299);
		else $rand = rand(200, 299);
		  
 		$game_type = intval($rand/100);
		 
		
		  
		if ($game_type == 1)
		{
			
			switch ($difficulty)
			{
				case 1:
					$steps = rand(10, 20);
					$takes = 20 * $steps;
					break;
				case 2:
					$steps = rand(20, 30);
					$takes = 9 * $steps;
					break;
				default:
					$steps = rand(25, 35);
					$takes = 4 * $steps;
			}
			
			$task['steps'] = $steps;
			
				
			
		}
		  else
		{
		
			require('../includes/class/gclass.php');
			$game = new Game();
			
			switch ($difficulty)
			{
				case 1:
					$steps = rand(3, 5);
					$takes = 5 * 60 * $steps;
					break;
				case 2:
					$steps = rand(4, 7);
					$takes = 4 * 60 * $steps;
					break;
				default:
					$steps = rand(5, 10);
					$takes = 3 * 60 * $steps;
			}

			$task['steps'] = $steps;
			$task['step'] = $game->generateNumbersPattern($difficulty);

		}
		  
		$task['difficulty'] = $difficulty;
		$taskclass->add_task_session($user["id"], 9, $takes, $task, $game_type);
        $_SESSION['voice'] = 'training_initiated';
        $cardinal->redirect(URL_C);
      
      }
    
  }
	else
	{
		$trainLog["remaining"] = $config['trainEvery'] - time() + $trainLog["created"];
		$tVars["trainLog"] = $trainLog;
		$tVars["trainEvery"] = $config['trainEvery'];
	}
	
	$history = $db->where('user_id', $user['id'])->orderBy('created', 'desc')
		          ->get('user_train_logs', 10);
	$tVars['history'] = $history;
}
	

	
		
  $tVars["trainTask"] = $tclass->trainTask;
  
  

	$tVars["display"] = 'train/train.tpl';


?>
