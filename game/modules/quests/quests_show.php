<?php
    if ($_POST["play"] && $user["questManager"]) {
      $qclass->forceStartQuest(intval($_POST["play"]), 18, null, false, $user['in_party']);
    } //$_POST["play"] && $user["questManager"]


    if ($user['in_party']) {
      if ($_POST['instance']) {
        $instance = $db->where('party_id', $user['in_party'])->where('instance_id', $_POST['instance'])->getOne('party_quest_instances pqi', 'pqi.instance_id, quest_id');
        if ($instance['instance_id']) {
          $myQuest['id'] = $instance['quest_id'];
          $qclass->initiateMission($myQuest, 15, null, false, $user['in_party'], $instance['instance_id']);
        } //$instance['instance_id']
      } //$_POST['instance']

      $templateVariables['instances'] = $db->join('quests q', 'q.id = pqi.quest_id', 'left outer')
		                                   ->join('users u', 'u.id = pqi.user_id', 'left outer')
		                                   ->where('party_id', $user['in_party'])
		                                   ->get('party_quest_instances pqi', null, 'q.title, pqi.instance_id, u.username');


    } //$user['in_party']

      // group fetching
      $db->where('live_quests > 0 and hqg.type = 1 and ? >= hqg.level', array( $user['level']))
		 ->where('(hqg.qparent = 0 or  (select id from quests_user qu where qu.user_id = ? and qu.quest = hqg.qparent limit 1) is not null )',
				array($user['id']));

      if ($user['in_party'])
        $db->where('live_party_quests', 0, '>');

      if ($GET["group"])
	  {

        $group = $GET["group"];

        $db->where('hqg.qgroup_id', $group);
        $group = $db->getOne('quest_groups hqg', 'story, premium, hqg.qgroup_id, hqg.name, live_quests nrQuests, live_party_quests,(select count(distinct(quest)) from quests_user qu left outer join quests q on q.id = qu.quest where qu.user_id = ' . $user['id'] . ' and q.qgroup_id = hqg.qgroup_id and q.isLive = 1) questsDone');

        if (!$group["qgroup_id"])
          $cardinal->redirect(URL);
        if ($group['premium'] && !$_SESSION['premium'][$group['premium']])
			$cardinal->redirect(URL.'alpha_coins/option/' . $group['premium']);

        if ($user['in_party'])
          $group['nrQuests'] = $group['live_party_quests'];

        // fetch available quest(s)
        $db->join('quests_user qu', 'qu.user_id = ' . $user['id'] . ' and qu.quest = q.id', 'left outer')->join('quests_user qur', 'q.required_quest_id != 0 and qur.user_id = ' . $user['id'] . ' and qur.quest = q.required_quest_id', 'left outer')->where('qgroup_id', $group['qgroup_id'])->where('isLive', 1)->where('(q.required_quest_id = 0 or qur.id is not null)')->where('q.level', $user['level'], '<=');

        if ($user['in_party'])
          $db->where('party', 1);

        if ($GET["mission"])
		{

          $quest = $GET["mission"];

          $db->where("q.id", $quest);

          $myQuest = $db->getOne("quests q", "q.id, q.title, q.summary, q.time,q.energy,  q.id, q.level, qu.last_done done, qu.times, q.type, experience, q.money, q.skillPoints, q.creator_name, party");

          if (!$myQuest["id"])
            $cardinal->redirect(URL);


          if ($myQuest["type"] == 1 && $myQuest["done"])
            if (canRedoDailyWhenLastIs($myQuest['done']))
              unset($myQuest["done"]);

          if ($_POST["play"] && ($myQuest['type'] == 2 || !$myQuest["done"]) && $myQuest['energy'] < $user['energy'])
		  if ($myQuest['party'] && !$user['in_party'])
		  {
			  $errors[] = "Must be in party";
			  $cardinal->redirect($url);
		  }
		  else
		  {
			if ($uclass->canDoTask())
              $qclass->initiateMission($myQuest, 15, null, false, $user['in_party']);

          } //$_POST["play"] && !$quest["done"]

          if ($myQuest['done'])
            $myQuest['doneDate'] = date('d/F/Y H:i:s', $myQuest['done']);
            $parser = new \JBBCode\Parser();
            $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
            $parser->parse($myQuest["summary"]);
          $myQuest["summary"] = $parser->getAsHtml();
          $messenger[]        = array(
            "message" => $myQuest["title"] . " loaded",
            "type" => "success"
          );

        } //$GET["mission"]
        else {


          $db->groupBy('q.id');
          $db->orderBy('qgroup_order', 'desc');
          $quests = $db->get('quests q', null, 'q.id, q.title, q.summary, q.time, q.id, q.level, qu.last_done done, q.type ,qur.quest as qdone, party, q.qgroup_id');

          $messenger[] = array(
            "message" => count($quests) . " out of " . $group["nrQuests"] . " total missions currently available in '" . $group["name"] . "'",
            "type" => "success"
          );

        }

        $parser = new \JBBCode\Parser();
        $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
        foreach ($quests as &$quest)
	    {
        $parser->parse($quest["summary"]);
      $quest["summary"] = $parser->getAsHtml();
        // check daily properly!!!!
          if ($quest["type"] == 1 && $quest["done"])
            if (canRedoDailyWhenLastIs($quest["done"]))
              unset($quest["done"]);
		}
        $templateVariables['group']   = $group;
        $templateVariables["quests"]  = $quests;
        $templateVariables["myQuest"] = $myQuest;

      } //$GET["group"]
      else {
        // fetch quests the user can do
        $db->groupBy('hqg.qgroup_id')->orderBy('gorder', 'asc');

		if ($user['in_party'])
		$groups = $db->get('quest_groups hqg', null, 'story, premium, hqg.qgroup_id, hqg.name, live_party_quests nrQuests, (select count(distinct(quest)) from quests_user qu left outer join quests q on q.id = qu.quest where qu.user_id = ' . $user['id'] . ' and q.qgroup_id = hqg.qgroup_id and q.isLive = 1 and q.party = 1) questsDone');
	    else
        $groups = $db->get('quest_groups hqg', null, 'story, premium, hqg.qgroup_id, hqg.name, live_quests nrQuests, live_party_quests, (select count(distinct(quest)) from quests_user qu left outer join quests q on q.id = qu.quest where qu.user_id = ' . $user['id'] . ' and q.qgroup_id = hqg.qgroup_id and q.isLive = 1) questsDone');



        $messenger[] = array(
          "message" => "Missions interface loaded",
          "type" => "success"
        );

        $templateVariables["groups"] = $groups;


		$usersCount = $db->rawQuery('select count(*) nru from users where level >= 5');
		$usersCount = $usersCount[0]['nru'];
		$usersCount = $usersCount % 100;
		$templateVariables['usersCount'] = $usersCount;
      }


      $templateVariables["user"] = $user;
      $templateVariables["config"] = $config;
      $smarty->assign($templateVariables);
    //} //!$smarty->isCached('quests/questsCached.tpl', $cache_id) || $GET["mission"]
    $templateVariables["questsCached"] = $smarty->fetch("quests/questsCached.tpl", $cache_id);
    $templateVariables["display"]      = 'quests/quests_available.tpl';
    $smarty->caching                   = 0;
