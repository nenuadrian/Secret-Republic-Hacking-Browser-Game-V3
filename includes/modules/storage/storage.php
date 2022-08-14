<?php

$cardinal->mustLogin();

require('storage_functions.php');


if ($_POST['sell'])
{
	if ($component = sellComponentFromStorage($user['id'], $_POST['sell']))
		$success[] = "Sold for " . $component["default_sell_price"] . "$.";

	$cardinal->redirect(URL_C);

}
elseif (isset($_POST['mount']))
{
	$component = fetchComponentFromStorage($user['id'], $_POST['mount']);

	if (!$component) $cardinal->redirect(URL_C);

	if (isset($_POST['server']))
	{
		require('../includes/class/class.server.php');

		$server = $db->where('server_id', $_POST['server'])->where('user_id', $user['id'])->getOne('servers');

		if ($server['server_id'])
		{
			$server = new Server($server['server_id'], $server);
			$server->fetchComponents();

			// CPU
			if ($component['type'] == 1)
			{
				if ($server->server['cpu_usage'] > $component['cpu'])
					$errors[] = "Current running apps on server consume more CPU power than the new component has to offer.";
				if ($server->server['power_usage'] - $server->components['motherboard']['power_usage'] + $component['power_usage'] > $server->components['power_source']['power'])
					$errors[] = "The mounted power source cannot support the new component.";
			}
			// MOTHERBOARD
			elseif ($component['type'] == 2)
			{
				if ($server->server['used_ram_slots'] > $component['slots'])
						$errors[] = sprintf("New component supports only %s while the server has %s RAM cards mounted", $component['slots'], $server->server['used_ram_slots']);

				if ($server->server['power_usage'] - $server->components['motherboard']['power_usage'] + $component['power_usage'] > $server->components['power_source']['power'])
					$errors[] = "The mounted power source cannot support the new component.";

			}
			// CASE
			elseif ($component['type'] == 3)
			{
				if ($server->server['used_hdd_slots'] > $component['slots'])
					$errors[] = sprintf("New component does not have enough slots to support your %s mounted HDDs", $server->server['used_hdd_slots']);
			}
			// POWER SOURCE
			elseif ($component['type'] == 4)
			{
				if ($server->server['power_usage'] > $component['power'])
					$errors[] = "New component cannot power all the other current components of the server.";
			}
			// RAM and HDD
			elseif ($component['type'] == 5 || $component['type'] == 6)
			{
				$componentToReplace = handlePickSlotForComponent($server, $component, $_POST['slot']);
			}

			if (!there_are_errors() && ($load != 'pick_slot' || $componentToReplace))
			{
					if(replaceComponentWithComponent($server, $component, $componentToReplace, $user['id']))
					{
						add_alert(sprintf("Replaced <strong>%s</strong> with <strong>%s</strong> on <strong>%s</strong>", $componentToReplace['name'], $component['name'], $server->server['hostname']), "success");

						$cardinal->redirect(URL."storage");
					}
			}
		}


	}

	$servers = $db->where('user_id', $user['id'])->get('servers');

	$tVars['servers'] = $servers;
	$tVars['component'] = $component;
	$tVars['loadd']    = $load;
	$tVars['load'] = 'mount_component';
	$tVars['display'] = 'storage/storage.tpl';
}
else
{
	$availableSlots = $uclass->getTotalStorageSlots();

	$storage = $uclass->getUserStorage();

	foreach ($storage as &$component)
	{
		$component["default_sell_price"] -= ($component["default_sell_price"]/100) * $component['damage'];
	}
	$tVars['availableSlots'] = $availableSlots;
	$tVars['storage'] = $storage;
	$tVars['display'] = 'storage/storage.tpl';

}
