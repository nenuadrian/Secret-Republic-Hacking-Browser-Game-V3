<?php

function verifySelectedServers($selectedServers, $validServers)
{
  $serverIds = array();

  foreach($validServers as $server)
    if (!$server['cant_use']) $serverIds[] = $server['server_id'];
  $servers = array();
  foreach ($selectedServers as $key => $server_id)
    if (in_array($server_id, $serverIds))
      $servers[] = $server_id;

  return $servers;
}

function initiateAttack($type, $sender, $receiver, $sender_user_id, $receiver_user_id, $attack, $servers = "")
{
  global $container;
  $db = $container->db();
  $uclass = $container->uclass();
  $cardinal = $container->get('cardinal');

  $insertData = array(
  'sender_user_id' => $sender_user_id,
  'sender' => $sender,
  'receiver' => $receiver,
  'created' => time(),
  'totalSeconds' =>  $attack['totalSeconds'],
  'type' => $type,
  'servers' => $servers,
  );

  if ($receiver_user_id)
  	$insertData['receiver_user_id'] = $receiver_user_id;


  $attack_id = $db->insert('attacks_inprogress', $insertData);

  if ($attack_id)
  {
  	$uclass->substractResources($attack, $sender_user_id);
    add_alert('Everything is in order. Operation in progress.', "success");
  }
  else
    add_alert('Unknow error. Operation aborted.');

  $cardinal->redirect(URL);
}

$cardinal->mustLogin();


$userNode = explode(":",$user['main_node']);

$userNode = $db->where('zone_id', $userNode[0])
							 ->where('cluster', $userNode[1])
							 ->where('node', $userNode[2])
			   			 ->getOne('zone_grid_cluster_nodes');

$currentZone = $_SESSION['gridZone'] ? $_SESSION['gridZone'] : $userNode['zone_id'];
$currentCluster = isset($_SESSION['gridCluster']) ? $_SESSION['gridCluster'] : $userNode['cluster'];


if($GET['show'] == 'clusters')
{
	require('clusters.php');
}
elseif ($GET['layers'])
{
	require ("../includes/class/class.battleSystem.php");
	$battleSystem = new BattleSystem($container);
	$player = $battleSystem->computePlayerStats($user['id'], true, true);

	$tVars['theskills']  = $theskills;
	$tVars['player']  = $player;

	$tVars['display'] = "grid/layers.tpl";
}
else
{

	if (GET('node') && GET('node') > 0 && GET('node') < 11)
	{
		$node_id = intval(GET('node'));
		if (!$_POST['collect']) $db->where('user_id', $user['id'] , "!=");

		$node = $db->join('users u', 'u.id = user_id', 'left outer')
						   ->where('zone_id', $currentZone)
						   ->where('cluster', $currentCluster)
						   ->where('node', $node_id)
					     ->getOne('zone_grid_cluster_nodes zgcn', 'zgcn.*, u.username, u.organization, zone_id zone');

		if (!$node['user_id'])
		{
			$node['node'] = $node_id;
			$node['zone_id'] = $currentZone;
			$node['cluster'] = $currentCluster;
		}

		$zoneDistance = abs($node['zone_id'] - $userNode['zone_id']);
		$clusterDistance  = abs($node['cluster'] - $userNode['cluster']) + 1;
		$sender = $user['main_node'];
		$receiver = $node['zone_id'].':'.$node['cluster'].':'.$node['node'];

		if ($node['user_id'])
		{
			if ($friends) $warnings[] = "You are <a href='".URL."friends'>friends</a> with the owner of this Grid Node.";
	    if ($node['organization'] && $node['organization'] == $user['organization'])
	    	$warnings[] = "You are in the same organization as the owner of this Grid Node. You can continue to plan your attack.";

	  	$friends = $uclass->areUsersFriends($node['user_id'], $user['id']);

			  if (GET('attack')) {
					require ("attack.php");
			  } //$_POST['attack']
			  elseif (GET('spy')) {
					require ("spy.php");
			  } //$_POST['spy']
			  elseif (GET('collect')) {
					require ("collect.php");
			  } //$_POST['spy']
			  else $cardinal->redirect(URL);
		}
		else
		{


			if (GET('occupy')) {
					require ("occupy.php");
			}
			else
				$cardinal->redirect(URL);

		}

		$tVars["node"] = $node;
  	$tVars['attack'] = $attack;
	}
	elseif (submitted_form('browse_grid')) {
		if ($_POST['direction'])
		  switch ($_POST['direction']) {
			case '<<':
			  $currentCluster -= 10;
			  $dpCost = 10 * $config['gridBrowseNode'];
			  break;
			case '<':
			  $currentCluster -= 1;
			  $dpCost =  $config['gridBrowseNode'];
			  break;
			case '>':
			  $currentCluster += 1;
			  $dpCost =  $config['gridBrowseNode'];
			  break;
			case '>>':
			  $currentCluster += 10;
			  $dpCost = 10 * $config['gridBrowseNode'];
			  break;
		  } // switch
		else
		{
			$newCluster = intval($_POST['gridCluster']);
			$newCluster = $newCluster >= 0 && $newCluster <= configs('gridClustersPerZone') ? $newCluster : $currentCluster;
			$dpCost = abs($newCluster - $currentCluster) * $config['gridBrowseNode'];
			$currentCluster = $newCluster;


			$newZone =  intval($_POST['zone']);
			$newZone = $newZone > 0 && $newZone < 7 ? $newZone : $currentZone;
			$dpCost += abs($newZone - $currentZone) * $config['gridBrowseZone'];
			$currentZone = $newZone;

		}
		if ($dpCost > $user['dataPoints'])
		{
			$errors[] = "Not enough Data Points to browser selected location. You need ".number_format($dpCost)." DP to execute that commmand.";
			$cardinal->redirect(URL_C);
		}
		else{
			$uclass->updatePlayer(array('dataPoints' => $user['dataPoints'] - $dpCost));
			$_SESSION['gridCluster'] = $currentCluster;
			$_SESSION['gridZone'] = $currentZone;

		}

	  $cardinal->redirect(URL_C);
	} //$_POST
	else
	{

	  $cluster  = $db->where('zone_id', $currentZone)
	  				 ->where('cluster', $currentCluster)
			   		 ->getOne('zone_grid_clusters');

	  if ($cluster['last_name_change'] + 15 * 24 * 60 * 60 < time())
	  {
	  	$checkIfUserIsInThisCluster = $db->where('user_id', $user['id'])
	  									 ->where('cluster', $currentCluster)
	  									 ->where('zone_id', $currentZone)->getOne('zone_grid_cluster_nodes', 'user_id');
	  	if ($checkIfUserIsInThisCluster['user_id'])
			$cluster['can_change_name'] = true;
	  }
	  if (submitted_form('change_cluster_name') && $cluster['can_change_name'])
	  {
	  	$name = $_POST['name'];
	  	$dataUpdate = array('name' => htmlentities(strip_tags($name)), 'last_name_change' => time());
	  	$db->where('cluster', $currentCluster)
	  	   ->where('zone_id', $currentZone)->update('zone_grid_clusters', $dataUpdate);

	  	$cardinal->redirect(URL_C);
	  }

	  $clusterNodes = $db->rawQuery('select zgcn.*, u.username, o.tag orgTag, organization, u.level, lastActive
	  								 from zone_grid_cluster_nodes zgcn
	  								 left outer join users u on u.id = zgcn.user_id
	  								 left outer join organizations o on o.id = u.organization
	  						         where cluster = ? and zone_id = ?', array($currentCluster, $currentZone));

	  $clusterNodesFinal = array();
	  for ($n=1;$n<=10;$n++) $clusterNodesFinal[$n] = array('node' => $n);

	  foreach ($clusterNodes as $n)
	  {
	  	if ($n['lastActive'] < time() - 10*24*60*60)
	  		$n['innactive'] = true;
	  	$clusterNodesFinal[$n['node']] = $n;
	  }

	  $tVars['cluster']    = $cluster;

	  $tVars['clusterNodes']    = $clusterNodesFinal;

	  $tVars['display']     = 'grid/grid.tpl';
	}
}

$tVars['currentCluster'] = $currentCluster;
$tVars['currentZone'] = $currentZone;
$tVars['userNode'] = $userNode;

?>
