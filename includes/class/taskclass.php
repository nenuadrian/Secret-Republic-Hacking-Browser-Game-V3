<?php

class Tasks extends Alpha{

		function __construct(Container $container){
		  parent::__construct($container);
		}
		function add_task_session($uid,$tasktype,$takes,$data = array(),$dataid = NULL,$name='', $session = false, $party_id = false, $instance_id = false){

			$name=htmlspecialchars($name);

			$dataInsert
			  = array( 'uid' => $uid,
			           'type' => $tasktype,
			           'start' => time(),
			           'totalSeconds' => $takes,
			           'data' => $session ? $data : serialize($data),
			           'dataid' => $dataid,
			           'name' => $name,
			          );
			if ($party_id){
			 $dataInsert['party_id'] = $party_id;

			}
			if ($instance_id){
				$instance = $this->db->where('instance_id', $instance_id)->getOne('party_quest_instances', 'start, totalSeconds');
			 $dataInsert['instance_id'] = $instance_id;
			 $dataInsert['start'] = $instance['start'];
			 $dataInsert['totalSeconds'] = $instance['totalSeconds'];

			}
			$data = is_array($data) ? $data : array();
			$data = array_merge($data, $dataInsert);

			if($this->user['id']==$uid) $this->user['tasks']++;

			if ($session)
			{
			  $data['id'] = rand(1,1000);
			  $_SESSION['tasks'][$tasktype] = $data;
			}
			else
			{
        $this->db->insert('tasks', $dataInsert);
			}

			return $data;
		}
		function delete_task_session($uid,$tasktype, $session = false, $party = false){
		  if ($session)
		  {
		    unset($_SESSION[$tasktype]);
		    return;
		  }
		  if ($party)
			$task = $this->db->where('party_id', $party)->where('type', $tasktype)->getOne('tasks');
		  else
			$task = $this->db->where('uid', $uid)->where('type', $tasktype)->getOne('tasks');

			if($task['id']){
				$this->db->where('id', $task['id'])->delete('tasks');

				unset($task['id'], $task['paused']);
				$task['log_created'] = time();

				return $this->db->insert('task_logs', $task);

			}
		}

		function check_fetch_task($user,$tasktype)
		{


        if ($party)
        $this->db->where('party_id', $party);
        else
        $this->db->where('uid', $user['id']);

        $data = $this->db->where('type', $tasktype)->getOne('tasks');
        if($data['id']){
          if(is_array($data2=unserialize($data['data'])))
            $data=array_merge($data,$data2);
          $data['name']=$data['name'];
          return $data;
        }
			return false;

		}
		function process_task_general(&$task){

			$task['finish']           = $task['start'] + $task['totalSeconds'];
			$task['remainingSeconds'] = $task['finish'] - time();
			$task['remainingSeconds'] = $task['remainingSeconds'] >= 0 ? $task['remainingSeconds'] : 0;

		}

    // Receive task data and a value in seconds
    // increased the finish time of task with value
		function addTaskTime($task, $time)
		{
		  $updateData = array('totalSeconds' => $task['totalSeconds'] + $time);

		  $this->db->where('id', $task['id'])->update('tasks', $updateData);
		} // addTaskTme

	  function updateTask($task_id, $updateData, $tasktype = false, $session = false)
	  {
	    if($session)
	    {
	      if (isset($_SESSION['tasks'][$tasktype]))
	      {
	        if (isset($updateData['data']))
	        {
            $updateData = array_merge($updateData, $updateData['data']);
            unset($updateData['data']);
          }
          $_SESSION['tasks'][$tasktype]= array_merge($_SESSION['tasks'][$tasktype], $updateData);
	        return;
	      }
	    }
      if (isset($updateData['data']))
        $updateData['data'] = serialize($updateData['data']);

      $this->db->where('id', $task_id)->update('tasks', $updateData);
	  }
	}
?>
