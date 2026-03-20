<?php

    $attack['money'] = 5 * $zoneDistance + $clusterDistance;
    $attack['totalSeconds'] = $zoneDistance * 20 + 3 * $clusterDistance;
    $attack['dataPoints'] = $zoneDistance * 100 + 15 * $clusterDistance;
    $attack['energy'] = 10 * $zoneDistance + $clusterDistance;

    $attack['totalSeconds'] *= 60;
  
    $attack['cant'] = $uclass->hasEnoughResources($user, $attack) ? false : true;
    
    $servers = $uclass->getAvailableServersForAttack();

    $tVars['servers'] = $servers;

  if (!$attack['cant'] && $_POST["initiate"])
  {
      if (!is_array($_POST['servers']))
        $selectedServers = explode(",", $_POST['servers']);
      else $selectedServers = $_POST['servers'];

      $servers = verifySelectedServers($selectedServers, $servers);
      require_once ("class/class.server.php");

      $commandsInfluence = array();
      foreach ($servers as $srv)
      {
        $srv = new Server($container, $srv);
        $srvCommandsInfluence = $srv->computeSkillsCommandsInfluence();
        foreach ($srvCommandsInfluence as $c => $v)
          $commandsInfluence[$c] += $v;
      }

      $stats = array();
      $stats['nisrDefault'] = 5;
      $stats['nisrServersSkills'] = $commandsInfluence['nisr'];
      $stats['nisrTotal'] = $stats['nisrDefault'] + $stats['nisrServersSkills'];
      //$commandsInfluence = $uclass->computeUserSkillsCommandsInfluence($user['id'], false, false, true);
      //$stats['nisrUserSkills'] = $commandsInfluence['nisr'];

      $tVars['stats'] = $stats;
      $servers = implode(",", $servers);
      $tVars['servers'] = $servers;

      if ($_POST['start'])
        if (!there_are_errors())
        {
          initiateAttack(4, $sender, $receiver, $user['id'], false, $attack, $servers);
          
          
        }
  }
  

  $tVars['display'] = "grid/occupy.tpl";
