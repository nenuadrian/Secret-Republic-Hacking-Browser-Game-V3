<?php



	$page_title="Simulator";



if ($GET['simulation'])
{
	if (!$_SESSION['premium']['attackSimulator'])
	{
		$_SESSION['error'] = "You need to activate the Attack Simulator to access it.";
		$cardinal->redirect(URL."alpha_coins/option/attackSimulator");
	}

	if (!$user['manageUsers'])
		$db->where('user_id', $user['id']);

	$simulation = $db->where('simulation_id', $GET['simulation'])->getOne('user_simulations');

	$simulation['report'] = unserialize($simulation['report']);
	//echo "<pre>".var_export($simulation['report'], true);
	$tVars['attack'] = $simulation;
	$tVars['simulation'] = true;
	$tVars['display'] = "attacks/attack.tpl";
}
elseif ($GET['simulate'])
{

	if (!$_SESSION['premium']['attackSimulator'])
{
	$_SESSION['error'] = "You need to activate the Attack Simulator to access it.";
	$cardinal->redirect(URL."alpha_coins/option/attackSimulator");
}

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, true);

	if ($request['simulate'])
	{
		class Server2{};

		$simulationData = array();
		foreach ($theskills as $skill => $data)
		{
			$simulationData['sender']['skills'][$skill] = intval($request['simulationData']['attacker']['skills'][$skill]);
			$simulationData['receiver']['skills'][$skill] = intval($request['simulationData']['defender']['skills'][$skill]);
		}

		$simulationData['sender']['servers'] = array();
		foreach ($request['simulationData']['attacker']['servers'] as $server)
		{
			$newServer = new Server2;
			foreach ($theskills as $skill => $data)
			{
				$newServer->skills[$skill] = array("level" => intval($server['skills'][$skill]));
			}
			$simulationData['sender']['servers'][] = array("server" => $newServer);
		}

		$simulationData['receiver']['servers'] = array();
		foreach ($request['simulationData']['defender']['servers'] as $server)
		{
			$newServer = new Server2;
			foreach ($theskills as $skill => $data)
			{
				$newServer->skills[$skill] = array("level" => intval($server['skills'][$skill]));
			}
			$simulationData['receiver']['servers'][] = array("server" => $newServer);
		}



		require("../includes/class/class.battleSystem.php");
		$battleSystem = new BattleSystem();



		$sender   = $battleSystem->computePlayerStats(0, true, false, $simulationData['sender']['skills'], $simulationData['sender']['servers']);
		$receiver   = $battleSystem->computePlayerStats(0, true, false, $simulationData['receiver']['skills'],  $simulationData['receiver']['servers']);

		$sender['username'] = "BOT1";
		$sender['id'] = "1";
		$receiver['id'] = "2";

		$battleSystem->fight($sender, $receiver);
		$parser = new \JBBCode\Parser();
		$parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
		$parser->parse($battleSystem->message);

		$dataInsert = array(
			'created' => time(),
			'user_id' => $user['id'],
			'simulationData' => serialize($simulationData),
			'message' => $parser->getAsHtml(),
			'report' => serialize($battleSystem->report),

		);

		if ($simId = $db->insert('user_simulations', $dataInsert))
		{
			echo json_encode(array('simulated' => $simId));
		}

		die();
	}
	$skills = array();
	foreach($theskills as $skill => $skillData)
		if ($skillData['layer'])
		$skills[] = array("name" => $skillData['name'], 'skill_id' => $skill);

	$tVars['skills'] = $skills;
	$tVars['display'] = "simulator/simulator.tpl";
}
else
{
	$simulations = $db->where('user_id', $user['id'])->getOne('user_simulations', 'count(*) nrs');

	$pages = new Paginator;
    $pages->items_total = $simulations["nrs"];
    $pages->paginate();
	$db->pageLimit = $pages->items_per_page;

	$simulations = $db->where('user_id', $user['id'])
		              ->orderBy('created', 'desc')
		              ->paginate('user_simulations', $pages->current_page);

	foreach ($simulations as &$simulation)
			$simulation['created'] = date("d/F H:i", $simulation['created']);
	$tVars['simulations'] = $simulations;
	$tVars['display'] = "simulator/simulations.tpl";
}
