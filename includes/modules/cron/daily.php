<?php

	

$type = "daily";

$report = "Daily Cron ".date("d/F/Y H:i:s", $runTime);

$userSessionOlderThan = $runTime - 3*24*60*60;
$userTrainLogOlderThan = $runTime - 24*31*24*60*60;
$userDailyQuestLogsOlderThan = $runTime - 24*31*24*60*60;
$errors404OlderThan = $runTime - 30*24*60*60;
$cronsOlderThan = $runTime - 7*24*60*60;
$pageStatLogsOlderThan = $runTime- 7*24*60*60;
$joinedBeginnerOrgXago = $runTime- 3*7*24*60*60;


$count = $db->rawQuery('delete from users where username is null');
$report .= sprintf("\nDeleted %s non-usernamed accounts", $count);


// delete user sessions
$count = $db->where("time <= " . $userSessionOlderThan)->delete("user_session");
$report .= sprintf("\nDeleted %s user sessions", $count);

// delete user train logs
$count = $db->where("created <= " . $userTrainLogOlderThan)->delete("user_train_logs");
$report .= sprintf("\nDeleted %s user sessions", $count);

// delete cron logs
$count = $db->where("created <= " . $cronsOlderThan)->delete("debug_cron_logs");
$report .= sprintf("\nDeleted %s cron logs", $count);

// delete daily quest logs

// check bans past expiration date and remove those
$users = $db
      ->join("user_bans", "ban_id = banned", "LEFT OUTER")
      ->where("expires <= " . $runTime)
      ->get("user_credentials", null, "uid");
      
foreach ($users as $u)
      $db->where("uid", $u["uid"])->update("user_credentials",  array("banned" => 0));

$report .= sprintf("\n%s bans removed", count($users));
unset($users);

// delete 404 logs
$count = $db->where("created <= " . $errors404OlderThan)->delete("debug_404_errors");
$report .= sprintf("\nDeleted %s 404 error logs", $count);

// delete 404 logs
$count = $db->where("created <= " . (30 * 24 * 60 * 60))->delete("friend_requests");
$report .= sprintf("\nDeleted %s friendship requests", $count);


$beginnerOrganizations = $db->get("org_zone_beginners");
$orgIds = array();
foreach($beginnerOrganizations as $o)
	$orgIds[] = $o['org_id'];


$usersToKick = $db->rawQuery('select id, organization,username from users
                              left outer join organization_members_logs zml on zml.org_id = organization and zml.user_id = users.id and zml.left_date is null
							  where (zml.joined_date is null or ? > zml.joined_date)  and organization in ('.implode(",", $orgIds).')  ',
							   array( $joinedBeginnerOrgXago ));



require('../includes/class/oclass.php');


foreach($usersToKick as $kick)
{
$oclass = new Organization($kick['organization']);
	
$oclass->kickMember($kick, false, "Your allocated time in a beginner organization has passed. You must now live on your own. Create or join another organization as soon as possible!", false);
	
}

$db->rawQuery("update organizations set nrm = (select count(*) from users u where u.organization = organizations.id)");

$report .= sprintf("\n%s users removed from beginner organizations", count($usersToKick));



$tasks = $db->rawQuery('select * from tasks where type not in (1,3,4) and ? >= (start+totalSeconds)',
					   array( time() -  7 * 24 * 60 * 60));

//$db->rawQuery('select * from tasks where (start + totalSeconds) < ?', array(time() - 2 * 7 * 24 * 60 * 60));


$report .= sprintf("\nFound %s tasks to update", count($tasks));

$user['tasks'] = 1;
foreach($tasks as $task)
{
	$user['id'] = $task['uid'];
		$types[$task['type']]++;
	
	//$abtask = $taskclass->check_fetch_task($user, $task['type']);
	/*
	switch($task['type'])
	{
		
	}*/
	$taskclass->delete_task_session($task["uid"], $task['type']);
}
foreach ($types as $type => $count)
	$report.="\nEnded: Type ".$type." => ".$count."\n";

// Clear all cache 
$smarty->clearAllCache();
echo nl2br($report);
