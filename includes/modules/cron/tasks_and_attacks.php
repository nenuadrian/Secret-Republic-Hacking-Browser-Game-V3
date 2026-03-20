<?php

$user = array();



$tasks = $db->rawQuery('select * from tasks
                       where type in (1, 3) and  ? >= (totalSeconds + start)',
					   array(time()));
$abclass= false;
$user['tasks'] = 1;
foreach($tasks as $task)
{
	if ($array = unserialize($task['data']))
	  $task = array_merge($array, $task);

	require_once("../includes/class/abclass.php");
	$user['id'] = $task['uid'];
	switch($task['type'])
	{
		case 1:

			if (!$abclass)
			{

				$abclass = new Abilities($container);
			}

    		$abclass->upgrade_ability($task["dataid"]);

			break;
    case 3:
      $item = new Item($task);

      if ($item->isApp())
        $reward = array("applications" => array($item->getItemBasicData()));
      else
        $reward = array("components" => array($item->getItemBasicData()));

       $name = $task['repaired'] ? '[Repaired]' : '[Failed]';

       $name .= ' ' . $task['name'];
       $uclass->addReward($task['uid'], $reward, $name);

    break;

	}

	$taskclass->delete_task_session($task["uid"], $task['type']);
}


require("../includes/class/class.battleSystem.php");
require_once ("class/class.server.php");

$type          = "attacks";
$insertLogs    = false;



$rep = "Processing Attacks " . date("d/F/Y H:i:s", $runTime);

// normal attacks
$attacks = $db->where("totalSeconds + created <= ?", array(time()))
	            ->get("attacks_inprogress", null, "sender_user_id, receiver_user_id, attack_id, sender, receiver, created, totalSeconds, type, servers");

foreach ($attacks as $attack) {

  $sender_node = explode(":", $attack['sender']);
  $receiver_node = explode(":", $attack['receiver']);

  $sender   = $db->where("zone_id", $sender_node[0])
  							 ->where("cluster", $sender_node[1])
  							 ->where("node", $sender_node[2])
  				       ->getOne("zone_grid_cluster_nodes zgcn", "zgcn.*");

  $receiver = $db->where("zone_id", $receiver_node[0])
  							 ->where("cluster", $receiver_node[1])
  							 ->where("node", $receiver_node[2])
  				       ->getOne("zone_grid_cluster_nodes zgcn", "zgcn.*");

  $sender['servers'] = explode(",", $attack['servers']);
  if ($attack['type'] == 1)
  {
		$battleSystem = new BattleSystem($container);



		$data   = $battleSystem->computePlayerSpyStats($sender['user_id'], true, false, false, false, $sender['servers']);
		$sender = array_merge($sender, $data);
		$data   = $battleSystem->computePlayerSpyStats($receiver['user_id'], true, false, false, false, array(), true);
		$receiver = array_merge($receiver, $data);


	  // if sender has more spy attack than receiver spy protection - 40%

	  // compute one percent of receiver protection
	  $spyProtection1 = $receiver["spyProtection"] / 100;

	  $spyProtectionOverToConsider = $receiver["spyProtection"] -  $spyProtection1 * 50;

	  $diffPercent = 1;
	  if ($sender["spyAttack"] >= $spyProtectionOverToConsider)
	  {
		$diffPercent = $sender["spyAttack"] - $spyProtectionOverToConsider;
		$diffPercent = $diffPercent / $spyProtection1;
		$diffPercent = $diffPercent <= 100 ? $diffPercent : 100;
	  }

	  // how many skills receiver has
	  $skillsCount = count($receiver["skills"]);

	  // how many of those skills to return?
	  $returnSkills = round(($skillsCount / 100) * $diffPercent);

	  // randomize skills array, to return random x values
	  $receiver["skills"] = shuffle_assoc($receiver["skills"]);

	  // compute the returned skills
	  $returnSkills = array_slice($receiver["skills"], 0, $returnSkills, true);


	  $report["skills"] = $returnSkills;
	 // $report["accuracy"] = round($accuracyPercent, 2);
	  $report["diffPercent"] = $diffPercent;


	  // if spy atack is less than 60 percent more powerfull (well actually
	  // 30% more powerful cause we start at 50) notify receiver
	  if ($diffPercent < 80)
	  {
			$report['attemptDetected']= true;
	  }


  }
  elseif ($attack['type'] == 2)
  {

		$battleSystem = new BattleSystem($container);
		$data   = $battleSystem->computePlayerStats($sender['user_id'], true, false, false, false, $sender['servers']);
		$sender = array_merge($data, $sender);
		$data = $battleSystem->computePlayerStats($receiver['user_id']);
		$receiver = array_merge($data, $receiver);

		$battleSystem->fight($sender, $receiver, true);

		$report = $battleSystem->report;


	  $attack['winner_user_id'] = $report['winner_user_id'];
	  if ($attack['winner_user_id'] == $sender['user_id'])
	  	$attack['winner'] = $attack['sender'];
	  else
	  	$attack['winner'] = $attack['receiver'];


  }elseif ($attack['type'] == 3){


	 	$dataPoints = $receiver['floatingDataPoints'];


  	$db->rawQuery('update zone_grid_cluster_nodes set floatingDataPoints = 0 where zone_grid_cluster_nodes_id = ?',
  								 array($receiver['zone_grid_cluster_nodes_id']));


	 // $message = "You have scavenged ".$dataPoints." Data Points.";
	  $reward['dataPoints'] = $dataPoints;
	  $uclass->addReward($sender['user_id'], $reward, "Grid Scavenging " . $attack['receiver']);

	 // $uclass->send_msg(-1, $sender["user_id"], $message, "Scavenging Report",5);
  }elseif ($attack['type'] == 4)
  {

  	$nodeInUse = false;
  	if ($receiver['user_id'])
  	{
  		$nodeInUse = true;
  	}
  	else
  	{
  		$servers = $sender['servers'];
  		$commandsInfluence = array();

      foreach ($servers as $srv)
      {
        $srv = new Server($container, $srv);
        $srv->fetchSkills();
        $srvCommandsInfluence = $srv->computeSkillsCommandsInfluence();
        foreach ($srvCommandsInfluence as $c => $v)
          $commandsInfluence[$c] += $v;
      }

      $stats = array();
      $stats['nisrDefault'] = 5;
      $stats['nisrServersSkills'] = $commandsInfluence['nisr'];
      $stats['nisrTotal'] = $stats['nisrDefault'] + $stats['nisrServersSkills'];
      $stats['nisrTotal'] = $stats['nisrTotal'] > 100 ? 100 : $stats['nisrTotal'];

      $instantiationSuccessful = rand(1, 100) < $stats['nisrTotal'] ? true : false;

      if ($instantiationSuccessful)
      {
	  		// create or update a node instance with current user
	  		$data = array(
	  			'user_id' => $sender['user_id'],
	  			'zone_id' => $receiver_node[0],
	  			'cluster' => $receiver_node[1],
	  			'node' => $receiver_node[2],
	  			'created' => time(),
	  			);
	  		if ($receiver['zone_grid_cluster_nodes_id'])
	  		{
	  			$db->where('zone_grid_cluster_nodes_id', $receiver['zone_grid_cluster_nodes_id'])
	  				 ->update('zone_grid_cluster_nodes', $data);
	  		}
	  		else
	  		{
	  			$db->insert('zone_grid_cluster_nodes', $data);
	  		}
	  	}

  	}
  }

   $attack["log_created"] = time();
   $attack["report"]      = serialize($report);
   $db->where("attack_id", $attack["attack_id"])->delete("attacks_inprogress", 1);
	 unset($attack["attack_id"]);
   $attack_log_id = $db->insert("attack_logs", $attack);

	switch ($attack['type'])
	{
		case 1:
			  $message = "[URL=".URL."attacks/attack/".$attack_log_id."]Spy report generated and made available in the Spy Reports Interface.[/URL]";
				if ($report['attemptDetected'])
				{
 					$message .= "\n\n".$attack["receiver"]." detected your spy attempt.";
					$messageReceiver = "Detected a spy attempt from ".$attack["sender"].".";
					$uclass->send_msg(-1, $receiver["user_id"], $messageReceiver, 'Spy Report', 2);
				}

	  		$uclass->send_msg(-1, $sender["user_id"], $message, 'Spy Report', 2);
			break;
		case 2:
			$message = "[URL=".URL."attacks/attack/".$attack_log_id."]A report that you can view in the Attack Reports Interface has been generated.[/URL]";
		 	$uclass->send_msg(-1, $receiver["user_id"], $message, "Attack Report", 3);
	  	$uclass->send_msg(-1, $sender["user_id"], $message, "Attack Report", 3);
      break;
	  case 4:
	  	if ($nodeInUse)
				$message = "Node was instantiated by someone else before you!";
			elseif ($instantiationSuccessful)
				$message = "Node " . $attack['receiver'] . " instantiation succeeded.";
			else
				$message = "Node " . $attack['receiver'] . " instantiation failed.";

	  	$uclass->send_msg(-1, $sender["user_id"], $message, "Node instantiated", 4);
		break;
	}
} //$attacks as $attack

$rep .= sprintf("\nProcessed %s attacks", count($attacks));

echo $rep;
