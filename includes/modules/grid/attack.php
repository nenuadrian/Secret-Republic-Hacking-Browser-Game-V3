<?php

  	
  $attack["totalSeconds"] = $zoneDistance * 60  + 5 * $clusterDistance;
  $attack["energy"] = 20 * $zoneDistance + 1 * $clusterDistance;
  $attack["money"] = 50 + $zoneDistance * 30 + $clusterDistance * 5;
  $attack["dataPoints"] = 50 + $zoneDistance * 100 + $clusterDistance * 20;
  $attack["totalSeconds"] *= 60;

  $attack["cant"] = $uclass->hasEnoughResources($user, $attack) ? false : true;    
  
  $servers = $uclass->getAvailableServersForAttack();

  $tVars['servers'] = $servers;

  if (!$attack['cant'] && $_POST["initiate"])
  {

      if (!is_array($_POST['servers']))
        $selectedServers = explode(",", $_POST['servers']);
      else $selectedServers = $_POST['servers'];

      $servers = verifySelectedServers($selectedServers, $servers);
      require("../includes/class/class.battleSystem.php");
      $battleSystem = new BattleSystem($container);
		  $stats =  $battleSystem->computePlayerStats($user['id'], true, false, false, false, $servers)['layers'];

      $tVars['stats'] = $stats;
      $servers = implode(",", $servers);
      $tVars['servers'] = $servers;

  		  
  		if ($_POST['start'])
        if (!there_are_errors())
    		{
    			initiateAttack(2, $sender, $receiver, $user['id'], $node['user_id'], $attack, $servers, $type == "soft" ? 0 : 1);

    		}
  }
 
  $tVars['display'] = 'grid/attack.tpl';
 
 