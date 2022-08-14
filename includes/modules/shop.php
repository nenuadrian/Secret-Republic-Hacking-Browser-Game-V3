<?php

$cardinal->mustLogin();

	if (!$user['server'])
		$warnings[] = "You have yet to build a <a href='".URL."servers'>main Server</a> so we've <strong>limited your choices on this shop to the cheapest</strong> components and software available.";
	if ($GET['software'])
	{
		if ($_POST['buy'])
		{

			$item = $db->join('applications data', 'data.app_id = si.app_id', 'left outer')
					   ->where("si.app_id is not null")
				       ->where("si.item_id", $_POST['buy'])
				       ->getOne("shop_items si", null, "si.*, data.*");

			if ($item["item_id"] && $item['price'] <= $user['money'])
			{
				if ($_POST["server"])
				{
					$server = $db->where('user_id', $user['id'])->where("server_id", $_POST['server'])->getOne('servers');
					if ($server['server_id'])
					{
						require("../includes/class/class.server.php");
						$server = new Server($server['server_id'], $server);

						if ($server->server['total_hdd'] - $server->server['hdd_usage'] < $item['hdd'])
							add_alert("Not enough HDD to store the new item available on server");

						if (!there_are_errors())
						{


							$_SESSION['success'] = "Item has been bought and delivered to server";
							$uclass->updatePlayer(array( "money" => $user['money'] - $item['price'] ));

							$server->installApp($item);

							$cardinal->redirect(URL_C);
						}
					}
				}
				$servers = $db->where("user_id", $user['id'])->get("servers");
				$tVars['servers'] = $servers;
				$tVars['load'] = "pick_server";
			}
		}
		else
		{
			$db->join('applications data', 'data.app_id = si.app_id', 'left outer');
			$db->where("si.app_id is not null");

		$db->orderBy('skill_id', 'asc');
		$db->orderBy('price', 'asc');
			if (!$user['server'])
				$db->where('noob', 1);

			$items = $db->get("shop_items si", null, "si.*, data.*");

			$tVars['theskills'] = $theskills;
		}
	}
	else
	{
		if ($_POST["buy"])
		{
			if (!$uclass->getAvailableStorageSlots())
				$errors[] = "No available space in <a href='".URL."storage'>your storage area</a>.";

			if (!count($errors))
			{
				$item = $db->join('components data', 'data.component_id = si.component_id', 'left outer')
						   ->where("si.component_id is not null")
						   ->where("si.item_id", $_POST['buy'])
						   ->getOne("shop_items si", null, "si.*, data.*");

				if ($item["item_id"] && $item['price'] > $user['money'])
					$errors[] = "Not enough money.";
				else
				{


					$db->insert("storage", array("user_id" => $user['id'], "component_id" => $item["component_id"]));
					$uclass->updatePlayer(array( "money" => $user['money'] - $item['price'] ));

					$_SESSION['success'] = "Item has been bought and delivered to <a href='".URL."storage'>storage</a>.";

					$cardinal->redirect(URL_C);
				}
			}
		}

		$db->join('components data', 'data.component_id = si.component_id', 'left outer');
		$db->where("si.component_id is not null");
		$db->orderBy('data.type', 'asc');
		$db->orderBy('price', 'asc');

		if (!$user['server'])
			$db->where('noob', 1);

		$items = $db->get("shop_items si", null, "si.*, data.*");
	}




	$tVars['items'] = $items;

$tVars['display'] = "shop/shop.tpl";
