<?php

$cardinal->mustLogin();

$maxServers = floor($user['level'] / 5) + 1;
$tVars['maxServers'] = $maxServers;

if (isset($GET['build']))
{

	$serversCount = $db->where('user_id', $user['id'])->getOne('servers', 'count(*) nrs');

	$canBuild = false;
	$cost = 300;


	if ($user['money'] < $cost)
		$errors[] = "Not enough money available in your balance";

	if ($serversCount['nrs'] >= $maxServers)
		$errors [] = sprintf("You have reached your current limit of %s servers.", $maxServers);

	if (!count($errors))
	{
		$canBuild = true;

		if ($_POST)
		{
			$in = array(intval($_POST['cpu']), intval($_POST['motherboard']), intval($_POST['case']), intval($_POST['power_source']));

			$storage = $uclass->getUserStorage(false, $in);

			if (count($storage) == 4)
			{
				$power_usage = $power = 0;
				foreach ($storage as $s)
				{
					$power += $s['power'];
					$power_usage += $s['power_usage'];
				}
				if ($power_usage > $power)
					$errors[] = "The selected configuration uses more energy that the designated power source can provide.";

				if (!count($errors))
				{
					require("../includes/class/class.server.php");
					$server = new Server();

					$dataInsert = array(
						"user_id" => $user['id'],
						"created" => time(),
						"ip" => $server->generateUniqueIP(),
						"hostname" => "New server "
					);

					if ($server_id = $db->insert("servers", $dataInsert))
					{
						$db->rawQuery("delete from storage where storage_id in (".implode(",", $in).")");
						$db->rawQuery('update servers set hostname = ? where server_id = ? limit 1',
										       array($dataInsert['hostname'] . $server_id, $server_id));

						$uclass->updatePlayer(array("money" => $user['money'] - $cost));

						foreach ($storage as $s)
							$db->insert("server_components", array("component_id" => $s['component_id'], "server_id" => $server_id));

						if (!$user['server'])
							$uclass->updatePlayer(array('server' => $server_id));

						$server = new Server($server_id);
						$server->recomputeServerResources();
						$uclass->recomputeDataPointsStats($user['id']);


						$cardinal->redirect(URL."servers/server/".$server_id);
					}
					else
						$errors[] = "A technical error has occurred. Server not created.";
				}
			}
		}

		$storage = $uclass->getUserStorage();
		$tVars['storage'] = $storage;
	}

	$tVars['serversCount'] = $serversCount['nrs'];
	$tVars['cost'] = $cost;
	$tVars['canBuild'] = $canBuild;
	$tVars['display'] = 'servers/build_server.tpl';
}
elseif (isset($GET['server']))
{
	require_once('../includes/class/class.server.php');

	if (!$user['cardinal'])
		$db->where('user_id', $user['id']);


	$server = $db->where('server_id', $GET['server'])
		         ->getOne('servers s', 's.*');



	if (!$server['server_id']) $cardinal->redirect(URL."servers");

	$server = new Server($server['server_id'], $server);

	//$server->recomputeServerResources();
	if ($GET['change'] == "hostname")
	{
		if (!$_SESSION['premium']['serversHostname'])
		{
			$_SESSION['error'] = "You need to activate the Hostname Changer service to access it";
			$cardinal->redirect(URL.'alpha_coins/option/serversHostname');
		}

		if ($hostname = $_POST['hostname'])
		{
			if (strlen($hostname) < 3 && strlen($hostname) > 30 )
				$errors[] = "Hostname must have between 3 and 30 characters";

			if (!count($errors))
			{
				$hostname = strip_tags($hostname);
				$dataUpdate = array("hostname" => $hostname);
				$db->where('server_id', $server->server_id)->update('servers', $dataUpdate, 1);
				$_SESSION['success'] = "Hostname changed to ".$hostname;
				$cardinal->redirect(URL.'servers/server/'.$server->server_id);
			}
		}
		$tVars['server'] = $server;
		$tVars['display'] = "servers/server_change_hostname.tpl";
	}
	elseif ($GET['transfer'])
	{

		if ($_POST)
		{
			$toServer = $db->where("server_id", $_POST["server"])->where("user_id", $user['id'])->getOne("servers");
			if ($toServer['server_id'])
			{
				$toServer = new Server($toServer['server_id'], $toServer);

				$toServer->fetchComponents();

				$app = $db->where("process_id", $_POST['app'])->where('server_id', $server->server_id)->getOne('server_apps');
				$server->processApp($app);
				if ($app['process_id'])
				{
					if ($toServer->server['hdd_usage'] + $app['hdd'] > $toServer->server['total_hdd'])
						$errors[] = "There's not enough HDD available on target";

					if (!count($errors))
					{
						$db->where('process_id', $app['process_id'])->update("server_apps", array('server_id' => $toServer->server_id), 1);
						$_SESSION['success'] = "Transfer complete";
					}
				}
			}
			$cardinal->redirect(URL."servers/server/".$server->server_id);
		}
		$apps =
		$db->rawQuery('select sa.*, a.* from server_apps sa
		               left outer join applications a on a.app_id = sa.app_id
					   where sa.server_id = ? and sa.running = 0',
					   array($server->server_id));

		$servers = $db->where("user_id", $user['id'])->where("server_id != ?", array($server->server_id))->get('servers');

		$tVars['apps'] = $apps;
		$tVars['servers'] = $servers;
		$tVars['display'] = 'servers/server_transfer_app.tpl';
	}
	else
	{


		if ($_POST['runKill'])
		{
			$app = $db->join("applications a", "a.app_id = sa.app_id", "left outer")
				       ->where("server_id", $server->server_id)
				      ->where("process_id", $_POST['runKill'])->getOne("server_apps sa", "sa.*, a.*");
			if ($app['process_id'])
				if ($app['running'])
				{
					$db->where("process_id", $app['process_id'])->update('server_apps', array('running' => 0));
					$_SESSION['success'] = "Process has been killed";
					$_SESSION['voice'] = "app_killed";
				}
				elseif( ($server->server['total_cpu']- $server->server['cpu_usage']) >= $app['cpu'] && ($server->server['total_ram'] - $server->server['ram_usage']) >= $app['ram'])
				{
					$db->where("process_id", $app['process_id'])->update('server_apps', array('running' => time()));
					$_SESSION['success'] = "App has been started";
					$_SESSION['voice'] = "app_execute";
				} else $errors[] = "Not enough resources available to run the app";

			if (!count($errors))
			{
				$server->recomputeServerResources();
				if ($app['skill_id'] == 12)
					$uclass->recomputeDataPointsStats($user['id']);
			}
			$cardinal->redirect(URL_C);
		}

		if ($_POST['remove'])
		{
			$app = new Item();
			$app->loadFromServerApps($_POST['remove'], false, $server->server_id);
			if (!$app->isRunning())
				$app->removeFromServer();

			$cardinal->redirect(URL_C);
		}

		if ($_POST['unmount_hdd'] || $_POST['unmount_ram'])
		{
			$unmountType = $_POST['unmount_hdd'] ? "hdd" : "ram";
			$relation_id = $_POST['unmount_' . $unmountType];

			$component = $server->getComponent($relation_id);

			if ($component)
				if (($server->server['total_hdd'] - $component['hdd']) < $server->server['hdd_usage'])
					$errors[] = "Cannot remove card as available HDD will be lower than HDD in use.";
				elseif (!$uclass->getAvailableStorageSlots())
					$errors[] = "No available space in <a href='".URL."storage'>your storage area</a>.";
				else
				{
					$dataInsert = array('user_id' => $user['id'],
										 'component_id' => $component['component_id'],
									   'damage' => $component['damage']);

					if ($db->insert('storage', $dataInsert))
					{
						$db->where('relation_id', $component['relation_id'])->delete('server_components', 1);

						$server->recomputeServerResources();
						$uclass->recomputeDataPointsStats($user['id']);
						$_SESSION['success'] = "Component sent to storage";
					}
				}
			$cardinal->redirect(URL_C);
		}
		//$server = new Server($server['server_id'], $server);
		$server->fetchComponents();
		$server->fetchApps();
		$server->fetchSkills();
//$server->recomputeServerResources();
		
		if ($server->server['disabled'])
			$errors [] = "Server is currently disabled and all running apps have been killed. Probably components are using more power than the current power source can provide.";

		$tVars['theskills'] = $theskills;
		$tVars['commandActions'] = $commandActions;
		$tVars['server'] = $server;
		$tVars['display'] = 'servers/server.tpl';
	}
}
else
{
	if ($_POST['main'])
	{
		$server = $db->where('server_id', $_POST['main'])
			         ->where('user_id', $user['id'])
			         ->getOne('servers', 'server_id');
		if ($server['server_id'])
			$uclass->updatePlayer(array('server' => $server['server_id']));

		$cardinal->redirect(URL_C);
	}
	$servers = $db->where("user_id", $user['id'])->get('servers s', null, 's.*, (select avg(damage) from server_components sc where sc.server_id = s.server_id) damaged');

	$tVars['servers'] = $servers;
	$tVars['display'] = 'servers/servers.tpl';
}
