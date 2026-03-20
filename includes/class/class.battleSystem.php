<?php

class BattleSystem extends Alpha {
  function __construct(Container $container) {
    parent::__construct($container);
  }
  function computePlayerStats($user_id, $computeLayers = true, $computeSpy = false, $skills = false, $servers = false, $serversUsed = array(), $dontTakeUsedServersInAccount = false) {
    global $theskills;
    if (!$skills) {
      $skillsToFetch = array_keys($theskills);
      $playerSkills  = $this->uclass->getUserSkills($user_id, $skillsToFetch);

      foreach ($playerSkills as $skill)
        $player["skills"][$skill["skill"]] = $skill["level"];
    } else
      $player['skills'] = $skills;


    $serversUsed = array_filter($serversUsed);

    if (!$servers) {
      $servers = array();
      if ($dontTakeUsedServersInAccount) {
        $servers = $this->uclass->getAvailableServersForAttack($user_id);
        foreach ($servers as $key => $s)
          if ($s['cant_use'])
            unset($servers[$key]);
      } elseif (count($serversUsed)) {

        $this->db->where('user_id', $user_id);

        $this->db->where('server_id in (' . implode(",", $serversUsed) . ')');

        $servers = $this->db->get('servers');
      }

      $player['servers'] = $servers;
      require_once("../includes/class/class.server.php");

      foreach ($player['servers'] as &$server) {
        $server['server'] = new Server($this->container, $server['server_id'], $server);
        //$server['server']->fetchComponents();
        $server['server']->fetchSkills();
      }
    } else
      $player['servers'] = $servers;

    if ($computeLayers) {
      // calculate for all layers
      for ($layerIndex = 1; $layerIndex <= 3; $layerIndex++) {
        // go through all skills
        foreach ($theskills as $skillID => $skillData) {
          if (isset($skillData["layer"])) {
            // find skills that matter for current layer

            // skills that give protection to layer
            if (in_array($layerIndex, array_keys($skillData["layer"]))) {

              //$senderLayers[$layerIndex]["defense"] += $sender["skills"][$skillID] * $skillData["layer"][$layerIndex];
              $player['layers'][$layerIndex]["defense"] += $player["skills"][$skillID] * $skillData["layer"][$layerIndex];
            } //in_array($layerIndex, array_keys($skillData["layers"]))

            // skills that damage layer
            if (in_array(-$layerIndex, array_keys($skillData["layer"]))) {
              $player['layers'][$layerIndex]["attack"] += $player["skills"][$skillID] * $skillData["layer"][-$layerIndex];
              //$receiverLayers[$layerIndex]["attack"] += $receiver["skills"][$skillID] * $skillData["layer"][-$layerIndex];
            } //in_array(-$layerIndex, $skillData["layer"])
          } //isset($skillData["layer"])
        } //$theskills as $skillID => $skillData



        foreach ($player['servers'] as $serv)
          foreach ($serv['server']->skills as $skill => $data) {
            if (in_array($layerIndex, array_keys($theskills[$skill]["layer"]))) {
              $player['layers'][$layerIndex]["defense"] += $data["level"] * $theskills[$skill]["layer"][$layerIndex];
            }
            if (in_array(-$layerIndex, array_keys($theskills[$skill]["layer"]))) {
              $player['layers'][$layerIndex]["attack"] += $data["level"] * $theskills[$skill]["layer"][-$layerIndex];
            }

          }

        $player['layers'][$layerIndex]["attack"] *= 100;
        $player['layers'][$layerIndex]["defense"] *= 100;
        // $receiverLayers[$layerIndex]["attack"] *= 100;
        //$receiverLayers[$layerIndex]["defense"] *= 100;
      } //$layerIndex = 1; $layerIndex <= 2; $layerIndex++
    }
    if ($computeSpy) {
      foreach ($player['skills'] as $skillID => $level)
        if (isset($theskills[$skillID]["spy"]))
          if ($theskills[$skillID]["spy"] > 0) {
            $player["spyProtection"] += $level * $theskills[$skillID]["spy"];

          } else
            $player["spyAttack"] += $level * (-$theskills[$skillID]["spy"]);

      foreach ($player['servers'] as $serv)
        foreach ($serv['server']->skills as $skill => $data)
          if ($theskills[$skill]["spy"] > 0)
            $player["spyProtection"] += $data['level'] * $theskills[$skill]["spy"];
          else
            $player["spyAttack"] += $data['level'] * (-$theskills[$skill]["spy"]);

      $player["spyProtection"] *= 100;
      $player["spyAttack"] *= 100;
    }
    return $player;
  }


  function computePlayerSpyStats($user_id) {
    return $this->computePlayerStats($user_id, false, true);
  }


  function executeLayersFight($attacker, $defender) {
    $rounds       = array();
    $layerDefense = $defender['defense'];

    while ($attacker['defense'] > 0 and $attacker['defense'] > 0 and $defender['attack'] > 0 and $defender['attack'] > 0) {
      $round = array();

      $attacker["attack"] -= $defender['defense'] * 0.15;
      $attacker["attack"] = $attacker["attack"] > 0 ? $attacker["attack"] : 0;

      $defender["defense"] -= $attacker['attack'] * 0.5;
      $defender["defense"] = $defender["defense"] > 0 ? $defender["defense"] : 0;

      $round['layerDamage'] = $attacker['attack'] * 0.5;

      $defender["attack"] -= $attacker['defense'] * 0.15;
      $defender["attack"] = $defender["attack"] > 0 ? $defender["attack"] : 0;

      $attacker["defense"] -= $defender['attack'] * 0.5;
      $attacker["defense"] = $attacker["defense"] > 0 ? $attacker["defense"] : 0;


      $round['layers']['attacker'] = $attacker;
      $round['layers']['defender'] = $defender;

      $rounds[] = $round;
    }

    if ($defender['defense'] <= 0) {
      $breachingPercentage = 100;
    } else {
      $breachingPercentage = 100 - $defender['defense'] / ($layerDefense / 100);
    }

    return array(
      "breaching" => $breachingPercentage,
      "rounds" => $rounds
    );
  }
  function fight($sender, $receiver, $computeSendPenaltiesAndRewards = false) {


    $currentLayer                 = 0;
    $report                       = array();
    $report["sender"]["layers"]   = $sender['layers'];
    $report["receiver"]["layers"] = $receiver['layers'];
    $report["winner_user_id"]     = $receiver["user_id"];
    $report['layerFights']        = array();
    $report['brokenLayers']       = 0;

    while ($currentLayer < 3) {
      $currentLayer++;
      $layerFight                           = $this->executeLayersFight($sender['layers'][$currentLayer], $receiver['layers'][$currentLayer]);
      $report['layerFights'][$currentLayer] = $layerFight;
      if ($layerFight['breaching'] != 100)
        break;
      $report['brokenLayers']++;
    }


    // what layers have been broken?
    $senderDamage         = 2;
    $senderSoftwareDamage = 2;


    if ($report['brokenLayers'] >= 1) {
      $report["winner_user_id"] = $sender["user_id"];
      $receiverDamage           = 1;
      $receiverSoftwareDamage   = 1;

    } else // attacker not breached past first layer
      {
      $senderDamage         = 4;
      $senderSoftwareDamage = 4;

      $receiverDamage         = 2;
      $receiverSoftwareDamage = 2;
    }
    // we have a winner


    if ($report['brokenLayers'] >= 2) {

      // we can maybe steal max 25% of available money
      // so steal lastLayerBreakingPercentage% out of 25%
      if ($computeSendPenaltiesAndRewards) {
        $recData = $this->db->where('id', $receiver['user_id'])->getOne('users', 'money, dataPoints');

        // what max percent of receiver resources
        $maxMoneyPercent      = 20;
        $maxDataPointsPercent = 20;


        $moneyPercent      = ($maxMoneyPercent / 100) * $report['layerFights'][3]['breaching'];
        $dataPointsPercent = ($maxDataPointsPercent / 100) * $report['layerFights'][3]['breaching'];


        $reward['money']       = ($recData['money'] / 100) * $moneyPercent;
        $reward['dataPoints']  = ($recData['dataPoints'] / 100) * $dataPointsPercent;
        $reward['skillPoints'] = 4;

      }

      $receiverDamage         = 3;
      $receiverSoftwareDamage = 3;


      // if we've broken through layer 3
      // decide on some special reward
      // an achievement maybe
      // and * 1.5 rewards ?

      if ($currentLayer >= 3) {
        if ($computeSendPenaltiesAndRewards) {
          $reward['money']       = ($reward['money'] * 1.25);
          $reward['skillPoints'] = ($reward['skillPoints'] * 1.5);
          $reward['dataPoints']  = ($reward['skillPoints'] * 1.3);

        }

        $receiverDamage         = 5;
        $receiverSoftwareDamage = 5;
        $senderDamage           = 2;
        $senderSoftwareDamage   = 2;

      }

      if ($computeSendPenaltiesAndRewards) {
        foreach ($reward as $key => $value)
          $reward[$key] = floor($value);

        $lostMoney      = $reward['money'];
        $lostDataPoints = $reward['dataPoints'];

        $floatingDataPoints = ($lostDataPoints / 100) * 20;
        $lostDataPoints += $floatingDataPoints;


        $this->uclass->updatePlayer(array(
          'money' => $recData['money'] - $lostMoney,
          'dataPoints' => $recData['dataPoints'] - $lostDataPoints
        ), $receiver['user_id']);


        $this->uclass->addReward($sender["user_id"], $reward, "Grid battle");

        $this->db->rawQuery('update zone_grid_cluster_nodes set floatingDataPoints = floatingDataPoints + ?
                      where zone_grid_cluster_nodes_id = ? limit 1', array(
          $floatingDataPoints,
          $receiver['zone_grid_cluster_nodes_id']
        ));

      }

    }

    if ($computeSendPenaltiesAndRewards) {
      if ($receiverDamage || $receiverSoftwareDamage)
        $this->dealDamageToUserServer($receiver['user_id'], $receiverDamage, $receiverSoftwareDamage);
      if ($senderDamage || $senderSoftwareDamage)
        $this->dealDamageToUserServer($sender['user_id'], $senderDamage, $senderSoftwareDamage);
    }




    $report['serversDamage'] = array(
      'sender' => array(
        'damage' => $senderDamage,
        'softwareDamage' => $senderSoftwareDamage
      ),
      'receiver' => array(
        'damage' => $receiverDamage,
        'softwareDamage' => $receiverSoftwareDamage
      )
    );

    $this->report = $report;


  }

  function dealDamageToUserServer($user_id, $damage, $softwareDamage) {
    $comps = $this->db->rawQuery('select sc.*, s.server_id from server_components sc
                left outer join servers s on s.server_id = sc.server_id
                where s.user_id = ? and sc.damage < 100
                order by rand() limit 3', array(
      $user_id
    ));

    $apps = $this->db->rawQuery('select sa.*, s.server_id from server_apps sa
                left outer join servers s on s.server_id = sa.server_id
                where s.user_id = ? and sa.damage < 100
                order by rand() limit 3', array(
      $user_id
    ));

    require_once("../includes/class/class.server.php");
    $serverClass = new Server($this->container);
    $damage      = ceil($damage / count($comps));
    foreach ($comps as $component) {
      $serverClass->dealComponentDamage($component, $damage);
    }

    $damage = ceil($softwareDamage / count($apps));
    foreach ($apps as $app) {
      $serverClass->dealAppDamage($app, $damage);
    }

  }


}
