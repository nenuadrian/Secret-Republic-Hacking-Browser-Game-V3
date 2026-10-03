<?php
	

$type = "hourly";

$report = "Hourly Cron ".date("d/F/Y H:i:s", $runTime);


$db->rawQuery("update users set energy = energy + (maxEnergy/20)");

$db->rawQuery("update users set energy = energy + (maxEnergy/20) where (select recoveryRateDouble from user_premium up where up.user_id = users.id limit 1) > ?",
			   array(time()));

$db->rawQuery("update users set energy = maxEnergy where energy > maxEnergy");

$report .= ("\nUpdated energy of users");

// update zones
$db->rawQuery('update zones set nrm = (select count(id) from users where zone = zones.id), avg_level = coalesce(round((select avg(level) from users where zone = zones.id), 2), 0)');

$report .= ("\nUpdated zones nrm");




// parties 
$parties = $db->where('created', time() - 4 * 60 * 60, '<=')->delete('parties');




echo $report;
