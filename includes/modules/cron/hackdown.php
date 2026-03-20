<?php

	

$type = "hackdown";

$report = "Hackdown Cron ".date("d/F/Y H:i:s", $runTime) ;



if (date('w') == 6)
{
$lastSaturday = strtotime("this Saturday");

$hackDownId = $lastSaturday;

}
else
{
	$hackDownId = strtotime("last Saturday");
}

$report = "HACKDOWN ID: ".$hackDownId."\n";
require("../includes/class/class.battleSystem.php");
$processed = 0 ;
while (count($battle = $db->where('hackdown_id', $hackDownId)->where('status', 1)->orderBy('RAND()')->get('hackdown_arena', 2)) == 2)
{
	$processed ++;
		$battleSystem = new BattleSystem($container);
	
		if ($battle[0]['servers'])
	    $servers = explode(",", $battle[0]['servers']);
	
		$sender   = $battleSystem->computePlayerStats($battle[0]['user_id'], true, false, false, false, $servers);

		if($battle[1]['servers'])
	    $servers = explode(",", $battle[1]['servers']);
		$receiver = $battleSystem->computePlayerStats($battle[1]['user_id'], true, false, false, false, $servers);


		$battleSystem->fight($sender, $receiver, "hard" , true);
		$attackReport = $battleSystem->report;
	
	   
	    $loser = $battle[0]['user_id'] == $attackReport['winner'] ? $battle[0]['user_id'] : $battle[1]['user_id'];
		
	   $attack["log_created"] = time();
	   $attack["created"] = time();
       $attack["report"]      = serialize($attackReport);
       $attack["type"]      = 4;
       $attack["sender_user_id"] = $battle[0]['user_id'];
       $attack["receiver"] = '0:0:0';
       $attack["sender"] = '0:0:0';
       $attack["receiver_user_id"] = $battle[1]['user_id'];
       $attack["winner_user_id"]      =  $attackReport['winner'];
	   $attack['servers'] = $battle[0]['servers'];
	
	
	 	$attack_log_id1 = $db->insert("attack_logs", $attack);
	
		$attack['servers'] = $battle[1]['servers'];
	 	$attack_log_id2 = $db->insert("attack_logs", $attack);
	
		$db->where('arena_id', $battle[0]['arena_id'])->update('hackdown_arena', array('status' => $loser == $battle[0]['user_id'] ? 2 : 3, 'attack_log_id' => $attack_log_id1));
		$db->where('arena_id', $battle[1]['arena_id'])->update('hackdown_arena', array('status' => $loser == $battle[1]['user_id'] ? 2 : 3, 'attack_log_id' => $attack_log_id2));
	
		$message = "[URL=".URL."attacks/attack/".$attack_log_id1."]A report has been generated, which you can view in the Attack Reports Interface by clicking here.[/URL]";
		 	$uclass->send_msg(-1, $battle[0]['user_id'], $message, "Hackdown Report",3);
	
		$message = "[URL=".URL."attacks/attack/".$attack_log_id2."]A report has been generated, which you can view in the Attack Reports Interface by clicking here.[/URL]";

	  		$uclass->send_msg(-1, $battle[1]['user_id'], $message, "Hackdown Report",3);
}

$report .= $processed . " processed arena battles.\n";

$expiredArena = $db->where('hackdown_id', $hackDownId)->where('status', 1)
	               ->where('created < ?', array(time() - 20 * 60))
	               ->get('hackdown_arena', null, 'arena_id, user_id');
foreach($expiredArena as $expired)
{
		$db->where('arena_id', $expired['arena_id'])->update('hackdown_arena', array('status' => 4));
	$message = "The Cardinal System did not find anyone worthy to be your opponent in the Hackdown Arena.\n\nHence the system has freed you from the Arena but you can join again if you so desire.";
	$uclass->send_msg(-1, $expired['user_id'], $message, "Hackdown Arena - No Match Found", 3);
}

$report .= count($expiredArena) . " expired arena entries. ";
echo nl2br($report);