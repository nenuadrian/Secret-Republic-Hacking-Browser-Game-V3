<?php
  
$hackTask = $taskclass->check_fetch_task($user, 5);
  
$taskclass->process_task_general($hackTask);

if ($hackTask["id"]) {
  
    if (  $hackTask["remainingSeconds"] <= 0 || $_POST["console"] == "complete delusion") {
      
          $taskclass->delete_task_session($user["id"], $hackTask["type"]);
    
      $errors [] = "Mission failed";
      
      $cardinal->redirect(URL_C);
  }

    
    
    
    
    require("../includes/class/qclass.php");
  
 
      
    $qclass = new QClass($hackTask);
    
    $tVars["qtask"] = $hackTask;
       
     $tVars["display"] = 'quests/quest_play.tpl';

    
  
  
   if ($qclass->finished)
    {
    
    $hackingPoints = 2;
      $oclass->addHackingPoints($hackingPoints, false, $user['id'], $qclass->finished,  2);
  
    }
  
    
  }
else
{
  $lastHack = $db->where('org_id', $oclass->organization['id'])->where('user_id', $user['id'])
                 ->where('source_type', 2)
                 ->orderBy('created', 'desc')->getOne('org_hacking_points_logs', 'created');
  
  if ($lastHack['created'] <= time() - 24*60*60)
    unset($lastHack);
  
  if (!$lastHack['created'] && $_POST['hack'])
    if ($uclass->canDoTask())
        {
          $quest = $db->join("quest_groups qg", "qg.qgroup_id = q.qgroup_id", "LEFT OUTER")
                ->where("qg.type", 8)
                ->where("isLive", 1)
                ->orderBy("RAND()")
                ->getOne("quests q", "id");
  
          if ($quest["id"])
          { 
        
    
            require("../includes/class/qclass.php");



             $qclass = new QClass();

            $qclass->forceStartQuest($quest["id"], 5, null, false, false, array());


          } // quest


        }
  
      if ($oclass->perms['manageHackingPoints'])
      {
      $nrmUpgradeCost = 5 * $oclass->organization['level'];
      
        if ($_POST['upgradeNRM'])
          if ($oclass->organization['hacking_points'] < $nrmUpgradeCost)
            $error = "Not enough hacking points";
          else
          {
            $success = "Operation successful";
            $oclass->updateOrganization(array('max_nrm' => $oclass->organization['max_nrm'] + 1, 'hacking_points' => $oclass->organization['hacking_points'] - $nrmUpgradeCost));
          }
      
      $tVars['nrmUpgradeCost'] = $nrmUpgradeCost;
      }
    if ($GET['history'])
    {
      $history = $db->where('org_id', $oclass->organization['id'])->orderBy('created', 'desc')
            ->getOne('org_hacking_points_logs', 'count(*) nrh');
      $pages = new Paginator;
          $pages->items_total = $history["nrh"];
          $pages->paginate();
          $db->pageLimit = $pages->items_per_page;

      $history = $db->where('org_id', $oclass->organization['id'])->orderBy('created', 'desc')
            ->join('users u', 'u.id = user_id', 'left outer')
            ->paginate('org_hacking_points_logs ohpl', $pages->current_page, 'username, created, hackingPoints, source_type');
      $tVars['history'] = $history;
    }
    elseif ($GET['rankings'])
    {
      $pages = new Paginator;
          $pages->items_total = $oclass->organization["nrm"];
          $pages->paginate();
      
      $rankings = $db->rawQuery("SELECT username, 
                  (select sum(hackingPoints) from org_hacking_points_logs ohpl where user_id = u.id and org_id = ?) hackingPoints
                  from users u
                  where u.organization = ?
                  order by hackingPoints desc ". $pages->limit,
                   array($oclass->organization['id'], $oclass->organization['id']));
      $tVars['rankings'] = $rankings;
    }
      
  
      $tVars['lastHack'] = $lastHack;
      $tVars['load'] = 'hackingPoints';
}