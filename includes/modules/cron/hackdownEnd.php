<?php
	

$type = "hackdownEnd";

$report = "Hackdown End Cron ".date("d/F/Y H:i:s", $runTime);



if (date('w') == 6)
{
$lastSaturday = strtotime("this Saturday");

$hackDownId = $lastSaturday;

}
else
{
	$hackDownId = strtotime("last Saturday");
}

$db->where('hackdown_id', $hackDownId)->delete('hackdown_rankings_users');
$db->where('hackdown_id', $hackDownId)->delete('hackdown_rankings_organizations');
$db->where('hackdown_id', $hackDownId)->delete('hackdown_rankings_zones');

$users = $db->rawQuery('SELECT distinct(user_id) uid, 
                        (select count(*) from hackdown_logs hll where hll.user_id = uid and task_log_id is not null) points, 
                        (select count(*) from hackdown_arena ha where ha.user_id = uid and status = 3) arenaPoints 
                        FROM hackdown_logs hl where hl.hackdown_id = ?;',
					  array($hackDownId));
$dataInsert = array(
	'hackdown_id' => $hackDownId,
	'created' => time(),
);
foreach ($users as $u)
{
	$dataInsert['user_id'] = $u['uid'];
	$dataInsert['points'] = $u['points'];
	$dataInsert['points'] += ceil($u['arenaPoints'] * 1.5);
	$db->insert('hackdown_rankings_users', $dataInsert);
}
$report .= "Added rankings for ".count($users). " users\n";

$organizations = $db->rawQuery("
SELECT distinct(u.organization) from hackdown_logs hl
left outer join users u on u.id = hl.user_id
where hl.hackdown_id = ?", array($hackDownId));

$dataInsert = array(
	'hackdown_id' => $hackDownId,
	'created' => time(),
);

foreach($organizations as $org)
{
	
	if (!$org['organization']) continue;
	$dataInsert['org_id'] = $org['organization'];
	$points = $db->rawQuery('select sum(hru.points) points from hackdown_rankings_users hru
	                         left outer join users u on u.id = hru.user_id
							 where hru.hackdown_id = ? and u.organization = ?',
						   array($hackDownId, $org['organization']));
	
	$dataInsert['points'] = $points[0]['points'];
	$db->insert('hackdown_rankings_organizations', $dataInsert);
	
}

$report .= "Added rankings for ".count($organizations). " organizations\n";
$dataInsert = array(
	'hackdown_id' => $hackDownId,
	'created' => time(),
	
);
for ($zone = 1; $zone <= 6; $zone++)
{
	$dataInsert['zone'] = $zone;
	$points = $db->rawQuery('select sum(hru.points) points from hackdown_rankings_users hru
	                         left outer join users u on u.id = hru.user_id
							 where hru.hackdown_id = ? and u.zone = ?',
						   array($hackDownId, $zone));
	$dataInsert['points'] = $points[0]['points'];
	$db->insert('hackdown_rankings_zones', $dataInsert);
}

$report .= "Added rankings for zones\n";

/*****************
	REWARDS
*****************/

$rows = $db->rawQuery('SELECT * from hackdown_rankings_users
                        where hackdown_id = ?
                        order by points desc',
                        array($hackDownId));

$rewards = array(
	"money" => 3000,
	"dataPoints" => 3000,
	"skillPoints" => 20,
	'achievements' => array(9)
);
$atWhatRankToAdaptRewards = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200, 300, 400, 500);
$withHowMuchToReduce =      array(10, 10, 20, 10, 10, 10, 10, 10, 10, 10 , 10 , 15 , 20 , 30);

$string = "";
foreach ($rows as $rank => $row)
{
	if ($key = array_search($rank + 1, $atWhatRankToAddaptRewards))
		foreach ($rewards as $stats => &$value)
			$value -= ($value / 100 ) * $withHowMuchToReduce[$key];
	
	if ($rank + 1 > 15) unset ($rewards['achievements']);
		
	$uclass->addReward($row['user_id'], $rewards, "Hackdown Reward - Ranked #" . number_format($rank + 1));
	$uclass->send_msg(-1, $row['user_id'], 
	                      'Thank you for participating in this Hackdown. We\'ve delivered your reward! Congratuluations, you were on place: #' . number_format($rank+1), 
	                      'Hackdown has ended');
	$string .= " when ".$row['user_id']." then ".($rank + 1);
}
if ($string){
  $query = 'update hackdown_rankings_users set rank = case user_id '.$string.' end';
$db->rawQuery($query);
}
$rows = $db->rawQuery('SELECT * from hackdown_rankings_organizations
                        where hackdown_id = ?
                        order by points desc',
                        array($hackDownId));

$atWhatRankToAdaptRewards = array(10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 200, 300, 400, 500);
$withHowMuchToReduce =      array(10, 10, 20, 10, 10, 10, 10, 10, 10, 10 , 10 , 15 , 20 , 30);
$rewards['hackingPoints'] = 50;
require('../includes/class/oclass.php');
$oclass = new Organization();
$title = "Organization Hackdown Reward";
$string = "";
foreach ($rows as $rank => $row)
{
	if ($key = array_search($rank + 1, $atWhatRankToAddaptRewards))
		foreach ($rewards as $stats => &$value)
			$value -= ($value / 100 ) * $withHowMuchToReduce[$key];
	
	$string .= " when ".$row['org_id']." then ".($rank + 1);
	
	$message = "Your organization has earned ".number_format($rewards['hackingPoints'])." hacking points in the latest [url=".$config['url']."hackdown]Hackdown[/url].";
	
    $oclass->addHackingPoints($rewards['hackingPoints'], $row['org_id'], null, null, 2);
	$oclass->sendMessageToEveryone($message, $title, $row['org_id']);
}

if ($string){
  $query = 'update hackdown_rankings_organizations set rank = case org_id '.$string.' end';
$db->rawQuery($query);
}
echo nl2br($report);