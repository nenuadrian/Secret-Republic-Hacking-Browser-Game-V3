<?php




if ($GET['war'])
{

$war = $db->rawQuery('select ow.*, o.name org1_name, oo.name org2_name 
                      from org_wars ow 
                      left outer join organizations o on o.id = ow.org1_id
                      left outer join organizations oo on oo.id = ow.org2_id
                      where war_id = ? limit 1',
                      array($GET['war']));
$war = $war[0];
if (!$war['war_id']) $cardinal->redirect($config['url'].'organization/view/wars');

$page_title = $war['org1_name'] . ' vs ' . $war['org2_name'];

require('../includes/class/organizationWars.php');
$owars = new organizationWars;

$owars->processWar($war);
if (!$war) $cardinal->redirect($config['url'].'organization/view/wars');


$tVars['war'] = $war; 
$tVars['display'] = 'organization_wars/view_war.tpl'; 

if ($war['status'] == 2 && $user['organization'])
{
  require("../includes/class/qclass.php");

  $orgPrefix = $user['organization'] == $war['org1_id'] ? 'org1' : 'org2';
   
  
  $fightTask = $taskclass->check_fetch_task($user, 30);
  
  
			
   if($fightTask["id"]){
   
    $taskclass->process_task_general($fightTask);
    if($fightTask["remainingSeconds"] <= 0 || $_POST["console"] == "complete delusion")
	{
     
      $taskclass->delete_task_session($user["id"], $fightTask["type"]);
       unset($fightTask);
       $_SESSION['error'] = 'Mission Failed - Sometimes by losing a battle you find a new way to win the war. - Donald Trump';
		
    }
    
    
    $qclass = new QClass($fightTask);
    
     // has user just finished working? Give him a juicy reward
    if ($qclass->finished)
    {
      $addPoints = 1;
      
      $updateWar = array(
        $orgPrefix.'_points' => $war[$orgPrefix.'_points'] + $addPoints,
      );

      $war = array_merge($war, $updateWar);
      $db->where('war_id', $war['war_id'])->update('org_wars', $updateWar);
      
      $_SESSION['success'] = 'You\'ve earned '.$addPoints.' points for your organization.'; 

      
  
    }
  } // fightTask  
 
  
  if (!$fightTask['id'])
  {
	 
	$canFight = $war['org1_id'] == $user['organization'] || $war['org2_id'] == $user['organization'];
	  
    if ($canFight && $_POST['fight'])
		if ($uclass->canDoTask())
		{
		  $quest = $db->join("quest_groups qg", "qg.qgroup_id = q.qgroup_id", "LEFT OUTER")
					  ->where("qg.type", 4)
					  ->where("isLive", 1)
					  ->where("? >= q.level", array($user["level"]))
					  ->orderBy("RAND()")
					  ->getOne("quests q", "id");
		$qclass = new QClass();
		  $qclass->forceStartQuest($quest['id'], 30);

		} 
	$tVars['canFight'] = $canFight;
  }
  else
  {
    $tVars["qtask"] = $fightTask;
   	$tVars["display"] = 'quests/quest_play.tpl';
  }
  
}

}
else
{	
	$inprogress = $db->rawQuery('select ow.*, o.name org1_name, oo.name org2_name
                      from org_wars ow 
                      left outer join organizations o on o.id = ow.org1_id
                      left outer join organizations oo on oo.id = ow.org2_id 
					  order by start desc');
	
	
	$wars = $db->rawQuery('select count(oew.war_id) nrw from org_ended_wars oew');
	$pages = new Paginator;
		$pages->items_total = $wars[0]["nrw"];
		$pages->paginate();
	$wars = $db->rawQuery('select oew.*, o.name org1_name, oo.name org2_name
				
                      from org_ended_wars oew 
                      left outer join organizations o on o.id = oew.org1_id
                      left outer join organizations oo on oo.id = oew.org2_id 
					  order by finished desc '. $pages->limit);
	
	
	$tVars['inprogress'] = $inprogress;
	$tVars['wars'] = $wars;
 	$tVars['display'] = "organization_wars/org_wars.tpl";
}


