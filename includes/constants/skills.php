<?php
  // simulationRate is a value that gets multiplied with the user skill level
  // when calculating points for attacks
  // layer == an array container the layer numbers
  // if you put -layerIndex it means the skill is used to break the layer down
  // if spy is 1 => contributes to spy protection
  // if -1 the contributes to spying itself
	$theskills=array(
	
		1 => array(
			"name"=>"Dynamic Programming",
			"layer" => array(1 => 1.1, 2 => 1.1, 3 => 1.1, -11 => 0.4, -2 => 0.4, -3 => 0.4),
			"spy" => 0.4,
			"rankingRate" => 1.2,
			"expRate" => 1.5,
			"commands" => array(
				"decrypt" => 2,
				"crack" => 1
			)
		),
		
		// provides protection agains attacks on the first layer
    2 => array(
			"name"=>"Network protection",
			"layer" => array(1 => 1.1,2 => 1.1, 3 => 1.1),
			"spy" => 1.3,
			"rankingRate" => 1,
			"expRate" => 1.2,
			"commands" => array(
				"grid_anti_research" => 2,
				"trace_reduce" => 1,
			)

		),
		
		// provides power of attack towards the first layer
    3 => array(
			"name"=>"Vulnerability analysis",
			"layer" => array(-1 => 0.8, -2 => 0.8, -3 => 0.8),
			"spy" => -1,
			"rankingRate" => 1,
			"expRate" => 1.6,
		    "commands" => array(
				"crack" => 2,
				"decrypt" => 1,
				"ports_scan" => 1,
			)

    ),
		
		4 => array(
			"name"=>"Intrusion detection",
			"layer" => array(1 => 1.4, 3 => 1),
			"spy" => 1,
			"rankingRate" => 1,
			"expRate" => 1.3

		),
		
		5 => array(
			"name"=>"Tracing prevention",
			"layer" => array(-1 => 0.7, -2 => 0.6, -3 => 0.5),
			"spy" => -1,
			"rankingRate" => 1,
			"expRate" => 1.3,
			"commands" => array(
			  "trace_reduce" => 3
			)

		),
		
		6 => array(
			"name"=>"Firewall Cracking",
			"layer" => array(-1 => 1, -2 => 1.1, -3 => 1.3),
			"spy" => -1,
			"rankingRate" => 1,
			"expRate" => 1.4,
			"commands" => array(
				"crack" => 2,
				"ports_scan" => 1
 			)

		),
		
		7 => array(
			"name"=>"Memory Analysis",
			"layer" => array(-2 => 1.4, -3 => 1),
			"spy" => 1,
			"rankingRate" => 1.1,
			"expRate" => 1.6,
			"commands" => array(
				"decrypt" => 2,
 			)
		),
		
		8 => array(
			"name"=>"Task Automation",
			"layer" => array(1=> 1.3, 2=> 1.3, 3=> 1,-1=> 0.6, -2=> 0.6, -3=> 0.6),
			"spy" => -0.5,
			"rankingRate" => 1.1,
			"expRate" => 1.8,
			"commands" => array(
				"decrypt" => 1,
				"crack" => 1,
				"ports_scan" => 1
			)
		),
		
		9 => array(
			"name"=>"Data Processing",
			"layer" => array(-3=> 0.6),
			"spy" => 1,
			"rankingRate" => 1.1,
			"expRate" => 1.3,
			"commands" => array(
				"decrypt" => 1,
				
			)
		),
		
		10 => array(
			"name"=>"Cardinal Operating System",
			"layer" => array(1 => 1.4, 2=> 1.4, 3=>1.1, -1=>0.4, -2=>-0.4, -3 =>0.4),
			"spy" => 0.4,
			"rankingRate" => 1.1,
			"expRate" => 1.6,
			"commands" => array(
				"ports_scan" => 1,
				"port_connect" => 5,
				"decrypt" => 1,
				"trace_reduce" => 1
			)
		),
		
		11 => array(
			"name"=>"Network Sniffing",
			"layer" => array( -1=>0.4, -2=>-0.4, -3 =>0.4),
			"spy" => -0.4,
			"rankingRate" => 1.1,
			"expRate" => 1.4,
			"commands" => array(
				"ports_scan" => 1,
				"grid_research" => 2
			)
		),
		
		16 => array(
			"name"=>"Databases",
			"layer" =>  array(1 => 1.4, 2=> 1.4, 3=>1.1, -1=>0.4, -2=>-0.4, -3 =>0.4),
			"spy" => -0.4,
			"rankingRate" => 1.1,
			"expRate" => 1.4,
			"commands" => array(
				"sql_delete" => 10,
				"sql_drop" => 10
			)
		),
		
		12 => array(
			"name"=>"Data Points Mining",
			"rankingRate" => 1.1,
			"expRate" => 1.9,
			"hideFromUserSkills" => true,
			"commands" => array(
				"data_points_mining" => 10,
			)
		),
		15 => array(
			"name"=>"Node Initialization Success Rate (NISR)",
			"rankingRate" => 0,
			"expRate" => 1.2,
			"commands" => array(
				"nisr" => 3,
			)
		),
		
		13 => array(
			"name"=>"Hardware repair",
			"rankingRate" => 1.1,
			"expRate" => 1.1,
			
			
		),
		14 => array(
			"name"=>"Software repair",
			"rankingRate" => 1.1,
			"expRate" => 1.1,
			
		),
	);
	

    $commandActions = array(
		"crack" => array(
			"name" => "Cracking",
			"verb" => "reducing time",
			),
		"decrypt" => array(
			"name" => "Decrypting",
			"verb" => "reducing time",
			),
		"port_connect" => array(
			"name" => "Port connecting",
			"verb" => "reducing time",
			
		),
		"ports_scan" => array(
			"name" => "Ports scanning",
			"verb" => "reducing time",
			),
		"trace_reduce" => array(
			"name" => "Trace amount",
			"verb" => "reducing gained trace",
			
			),
		"sql_delete" => array(
			"name" => "SQL Delete Command",
			"verb" => "reducing gtime",
			
			),
		"sql_drop" => array(
			"name" => "SQL Drop",
			"verb" => "reducing time",
			
			),
		"data_points_mining" => array(
			"name" => "Data Points mining",
			"verb" => "increasing mining",
			"unit" => " points"
			),
		"grid_research" => array(
			"name" => "Grid Research (pinpoint node)",
			"verb" => "success chance",
			
			),
		"grid_anti_research" => array(
			"name" => "Grid Research (pintpoint node)",
			"verb" => "jamming"
			
			),
		"nisr" => array(
			"name" => "Node Initialization Success Rate",
			"verb" => "increase"
			
			),
	);

?>
