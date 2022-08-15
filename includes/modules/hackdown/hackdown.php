<?php
$cardinal->mustLogin();

// is saturday?
if (date('w') == 6)
{
$lastSaturday = strtotime("this Saturday");

$hackDownId = $lastSaturday;
$lastSaturdayEnd = $lastSaturday + 24*60*60;

$hackdownRemaining = $lastSaturdayEnd - time();
}
else
{
	$hackDownId = strtotime("last Saturday");
}
//$hackdownRemaining = 10000;




$hackdownTask = $taskclass->check_fetch_task($user, 4);
  
$taskclass->process_task_general($hackdownTask);

if ($hackdownTask["id"]) {
	
    if (  $hackdownTask["remainingSeconds"] <= 0 || $_POST["console"] == "complete delusion") {
      
          $taskclass->delete_task_session($user["id"], $hackdownTask["type"]);
		
		  $errors [] = "Mission failed";
		  
		  $cardinal->redirect(URL_C);
	}

	  
	  
	  
	  
    require("../includes/class/qclass.php");
  
 
			
    $qclass = new QClass($hackdownTask);
    
    $tVars["qtask"] = $hackdownTask;
   		
   	$tVars["display"] = 'quests/quest_play.tpl';

	  
	 $tVars['hackdown'] = $hackdown;
	
	
	 if ($qclass->finished)
    {
	  
      $db->where('log_id', $hackdownTask['hackdown_log_id'])
		 ->update('hackdown_logs', array('task_log_id' => $qclass->finished, 'status' => 2), 1);
      // get percentage of time it took user to finish given quest
      $timeToFinish = time() - $hackdownTask["start"];
      $timePercentage = intval($timeToFinish / ($hackdownTask["totalSeconds"] / 100));
      
      // calculate base job experience
     
      
      $reward["exp"] = 100;
      
   
      $reward['skillPoints'] = rand(1, 4);
	
      $uclass->addReward($user["id"], $reward, "Hackdown");
      
  
    }
	
	  
  }
else
{
	
	if ($GET['rankings'])
	{
		$hackDownId = strtotime("last Saturday");
		if ($GET['organizations'])
		{
			$organizations = $db->where('hackdown_id', $hackDownId)
			                    ->getOne('hackdown_rankings_organizations hro', 'count(*) nro');
			
			$pages = new Paginator;
			$pages->items_total = $organizations["nro"];
			$pages->paginate();
			$db->pageLimit = $pages->items_per_page;

			$organizations = $db->join('organizations o', 'o.id = hro.org_id', 'left outer')
			                    ->where('hackdown_id', $hackDownId)
			                    ->orderBy('points', 'desc')
			                    ->paginate('hackdown_rankings_organizations hro', $pages->current_page, 'hro.*, o.name');
			
			$tVars['organizations'] = $organizations;
		}
		elseif ($GET['zones'])
		{
		
			$zones = $db->where('hackdown_id', $hackDownId)
			            ->orderBy('points', 'desc')->get('hackdown_rankings_zones');
			
			$tVars['zones'] = $zones;
		}
		else
		{
			$users = $db->where('hackdown_id', $hackDownId)
			            ->getOne('hackdown_rankings_users hru', 'count(*) nru');
			
			$pages = new Paginator;
			$pages->items_total = $users["nru"];
			$pages->paginate();
			$db->pageLimit = $pages->items_per_page;
			$users = $db->join('users u', 'u.id = hru.user_id', 'left outer')
			            ->where('hackdown_id', $hackDownId)
			            ->orderBy('points', 'desc')
				        ->paginate('hackdown_rankings_users hru', $pages->current_page, 'hru.*, username');
			
			$tVars['users'] = $users;
		}
		$tVars['lastDate'] = date("d/F", $hackDownId );
		$tVars['display'] = 'hackdown/hackdown_rankings.tpl';
	}
	else
	{
		
	


		if (!$hackdownRemaining)
		{
			$nextSaturday = strtotime("Saturday");
			$nextSaturdayRemaining = $nextSaturday - time();
			$tVars['nextSaturdayRemaining'] = $nextSaturdayRemaining;

		}
		else
		{
			$arena = $db->where('hackdown_id', $hackDownId)->where('status', 1)->where('user_id', $user['id'])->getOne('hackdown_arena');

			if ($arena['arena_id'])
			{
				$tVars['inArena'] = $arena;
			}
			else
			{
				if ($_POST['arena'])
				{
				  
				  $servers = $uclass->getAvailableServersForAttack();
				  $tVars['servers'] = $servers;
				  
				  
				  
				  if ($_POST["initiate"])
				  {
		 
					  $serverIds = array();
			  
					  foreach($servers as $server) if (!$server['cant_use']) $serverIds[] = $server['server_id'];
					  foreach ($_POST['servers'] as $key => $server_id)
						  if (!in_array($server_id, $serverIds))
							unset($_POST['servers'][$key]);

					  $servers = implode(",", $_POST['servers']);
		  
					
						$dataInsert = array(
							'user_id' => $user['id'],
							'created' => time(),
							'hackdown_id' => $hackDownId,
							'servers' => implode(',', $servers),
						);
						if ($db->insert('hackdown_arena', $dataInsert))
						{
							$info[] = "You are inside the Arena!";
							$cardinal->redirect(URL_C);

						}
						else
						  $errors[] = 'Unknow error.';

				
				  }
			
					
					
				}
				
				if ($_POST['hackdown'])
				if ($uclass->canDoTask())
				{
					$quest = $db->join("quest_groups qg", "qg.qgroup_id = q.qgroup_id", "LEFT OUTER")
								->where("qg.type", 7)
								->where("isLive", 1)


								->orderBy("RAND()")
								->getOne("quests q", "id");
					if ($quest["id"])
					{ 
					  $dataInsert = array(
						"user_id" => $user["id"],
						"created" => time(),
						"quest_id"=> $quest["id"],
						 "hackdown_id" => $hackDownId
					  );

					  $task['hackdown_log_id'] = $db->insert("hackdown_logs", $dataInsert);

					  require("../includes/class/qclass.php");



					   $qclass = new QClass();

						$qclass->forceStartQuest($quest["id"], 4, null, false, false, $task);


					} // quest


				}

				$hacks = $db->rawQuery('select (select count(*) from hackdown_logs where status = 2 and user_id = ? and hackdown_id = ?) nrMissions,
										(select count(*) from hackdown_arena where status = 3 and user_id = ? and hackdown_id = ?) nrAttacks',
									   array($user['id'], $hackDownId, $user['id'], $hackDownId));
				$hacks=$hacks[0];
				$tVars['hacks'] = $hacks;
			
			}
				$tVars['hackdownRemaining'] = $hackdownRemaining;
		}
		$tVars['display'] = "hackdown/hackdown.tpl";
	}
	
	
}
