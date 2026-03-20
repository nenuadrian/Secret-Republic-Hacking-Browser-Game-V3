<?php
class TrainClass extends Alpha{

	function __construct(Container $container, $trainTask = null){
	  parent::__construct($container);
	  
	  $this->trainTask = $trainTask;
	  
    if ($this->trainTask)
    {
      $this->taskclass->process_task_general($this->trainTask,true);
    }
	} // constructor

	function computeTrainingRewards()
	{
		if ($this->user['level'] <= 10)
         	 $exp = rand(4,6);
		  elseif ($this->user['level'] <= 20)
			  $exp = rand(2,4);
			else $exp = rand(1,3);
			
          $exp = intval(round( ($this->user["expNext"] / 100) * $exp));
		
          $reward["exp"] = $exp;
		  $reward['skillPoints'] = rand(1, 5);
			
		  
		  $increasePercent = $this->trainTask['difficulty'] - 1;
		  $increasePercent *= 30;
		  foreach($reward as $r => &$value)
			$value += intval(($value/100) * $increasePercent);
		
		return $reward;
	}
	function end_training( $success = false){

        if ($success)
        {
		  $reward = $this->computeTrainingRewards();
          $reward_id = $this->uclass->addReward($this->user["id"], $reward, "Training");

					$this->success="Training completed";
		}
		else
				{
				  $this->errors = "You've failed this training session. Bad luck! Remember to come again later.";
					$this->voice = 'training_failed';
				}	
		
		
		$task_log_id = $this->taskclass->delete_task_session($this->trainTask["uid"],9);
	
		if ($success)
		
		if ($this->trainTask['train_log'])
			$this->db->where("log_id", $this->trainTask['train_log'])->update('user_train_logs', array('success' => $task_log_id, 'reward_id' => $reward_id));	
		
		$this->redirect(URL_C);
	}

}
?>