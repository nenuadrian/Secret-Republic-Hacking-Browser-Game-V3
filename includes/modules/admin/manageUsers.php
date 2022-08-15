<?php
$hacker = $db->where('id', $hacker)->getOne('users');
if ($hacker['id']) {
  $hackerCredentials = $db->where('uid', $hacker['id'])->getOne('user_credentials');
  $tVars['credentials'] = $hackerCredentials;

  if ($hackerCredentials['uid']) {
	if ($GET['load'] == 'attacks') {
      $tVars['load'] = 'attacks';
	}

    elseif ($GET['load'] == 'credentials' && $user['cardinal'])
    {
      if ($_POST) {
        $db->where('uid', $hacker['id']);
        $db->update('user_credentials', $_POST);

        $_SESSION['success'] = 'Hacker credentials updated';

        $cardinal->redirect(URL_C);

      } //$_POST
      $groups = $db->get('groups', null, 'group_id, name');
      $tVars['groups'] = $groups;
      $tVars['load'] = 'credentials';

    }elseif ($GET['load'] == 'bans' )
    {
      if ($hackerCredentials['banned'] && $_POST['unban'])
      {
        $db->where('uid', $hacker['id'])->update('user_credentials', array('banned' => null));
        $_SESSION['success'] = 'Unbanned';

        $cardinal->redirect(URL_C);
      }elseif ($_POST['reason'])
      {
        $expires = strtotime($_POST['day'].' '.$_POST['month'].' '.$_POST['year']);
        if ($hackerCredentials['banned'])
          $currentBan = $db->where("ban_id", $hackerCredentials['banned'])->getOne("user_bans", "expires");

        if ($currentBan['expires'] > $expires)
        {
          $errors[] = "New ban not higher than old ban";
        }else
        if ($expires > time())
        {
          $ban = $db->insert("user_bans",
            array(
              "by_user_id" => $user["id"],
              "user_id"    => $hacker["id"],
              "created"    => time(),
              "expires"    => $expires,
              "reason"     => htmlentities($_POST["reason"])
              ));
          if ($ban)
          {
            $db->where('uid', $hacker['id'])->update('user_credentials', array('banned' => $ban));
            $db->where('id', $hacker['id'])->update('users', array('session' => NULL));
            $_SESSION['success'] = 'Banned';
            $cardinal->redirect(URL_C);
          } else $errors[] = "Unknown error";
        } else $errors[] = "Time is in the past or wrong format received";
      }
      for ($i=1;$i<=12;$i++)
        $tVars["months"][] = date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));

      $bans =
        $db->where('user_id', $hacker['id'])
           ->join('users u', 'u.id = user_bans.by_user_id', 'LEFT OUTER')
           ->orderBy('expires', 'desc')
           ->get('user_bans', null, 'reason, expires, created, u.username by_username');
      foreach ($bans as &$ban)
      {
         $ban['created'] = date('d/F/Y H:i:s', $ban['created']);
         $ban['expires'] = date('d/F/Y', $ban['expires']);
      }
      $tVars['bans'] = $bans;
      $tVars['load'] = 'bans';

    }elseif ($GET['load'] == 'missions') {
      $tVars['load'] = 'missions';

      if($user['cardinal'] && ctype_digit($_POST['quest']))
      {
        if ($_POST['del'])
        {
          $db->where('quest', $_POST['quest'])
             ->where('user_id', $hacker['id'])
             ->orderBy('created', 'desc')
             ->delete('quests_user', 1);
          $success[] = 'Record deleted';
        }
      }

      $missions = $db->where('user_id', $hacker['id'])->getOne('quests_user', 'count(distinct(quest)) nrm');

      $pages                 = new Paginator;
      $pages->items_total    = $missions['nrm'];
      $pages->items_per_page = 40;
      $pages->mid_range      = 5;
      $pages->paginate();
      $db->pageLimit = $pages->items_per_page;

      $missions = $db->join('quests', 'quests.id = quests_user.quest', 'LEFT OUTER')
                     ->join('quest_groups', 'quest_groups.qgroup_id = quests.qgroup_id', 'LEFT OUTER')
                     ->where('user_id', $hacker['id'])
                     ->groupBy('quest')
                     ->orderBy('created', 'desc')
                     ->paginate('quests_user', $pages->current_page, 'quests_user.created, quests.title, quests.type, quest, quest_groups.name groupName');
      foreach ($missions as &$mission)
        $mission['created'] = date('d/F/Y H:i:s', $mission['created']);

      $tVars['missions'] = $missions;
    } //$GET['load'] == 'missions'
      elseif ($GET['load'] == 'achievements') {
      $tVars['load'] = 'achievements';

      if (ctype_digit($aid = $_POST['add'])) {

        if ($uclass->giveAchievement($hacker['id'], $aid))
          $success = $achievement['name'] . ' added to ' . $hacker['username'];

      } //ctype_digit($aid = $_POST['add'])

      elseif ($_POST['update'] && ctype_digit($uaid = $_POST['achievement'])) {
        $newTimes = array(
          'times' => intval($_POST['times'])
        );
        $db->where('achievement_id', $uaid)->where('user_id', $hacker['id'])->update('user_achievements', $newTimes);
        $success = 'Updated';
      } //$_POST['update'] && ctype_digit($uaid = $_POST['achievement'])
        elseif ($_POST['del'] && ctype_digit($uaid = $_POST['achievement'])) {
        $db->where('achievement_id', $uaid)->where('user_id', $hacker['id'])->delete('user_achievements');
        $success = 'Deleted';
      } //$_POST['del'] && ctype_digit($uaid = $_POST['achievement'])


      $userAchievements = $db->where('user_id', $hacker['id'])->get('user_achievements');
      $achievements     = $db->get('achievements');

      $tVars['userAchievements'] = $userAchievements;
      $tVars['achievements']     = $achievements;

    } elseif ($GET['load'] == 'skills') {

      $tVars["load"] = "skills";
      if ($_POST)
      {
        $uclass->addSkillExperience($hacker["id"], $_POST["skill"], $_POST["exp"]);
        $success = "Added";
      }
      $tVars["theskills"] = $theskills;

      $tVars["skills"] = $db->where("uid", $hacker["id"])->get("skills");


    } //$GET['load'] == 'achievements'
      elseif ($GET['duality']) {
      $_SESSION['duality'] = $hacker['id'];
      $_SESSION['group']   = $cardinal->loginSystem->getUserPermissions($hackerCredentials['group_id']);

      $cardinal->redirect(URL);
    } //$GET['duality']
      elseif ($_POST) {
      $db->where('id', $hacker['id']);
      $db->update('users', $_POST);

      $_SESSION['success'] = 'Hacker updated';

      $cardinal->redirect(URL_C);

    } //$_POST

    $smarty->assign('hacker', $hacker);

    $tVars['display'] = 'admin/hacker/hacker.tpl';

  } //$hackerCredentials['uid']
  else
    $cardinal->show_404();
} //$hacker['id']
else
  $cardinal->show_404();
;
