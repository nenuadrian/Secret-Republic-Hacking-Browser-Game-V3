<?php



if ($GET["key1"] != "MDMwN2Q3OGRiYmM4Y2RkOWZjNTBmMzA4MzViZDZiNjQ=") { $cardinal->show_404(); return; }

    $runTime = time();
	  $user = array();
    $insertLogs = true;

    if ($GET["daily"])
      require("daily.php");
    elseif ($GET["hackdown"])
      require("hackdown.php");
	elseif ($GET["hackdownEnd"])
      require("hackdownEnd.php");
    elseif ($GET["hourly"])
      require("hourly.php");
    elseif ($GET["monthly"])
      require("monthly.php");
    elseif ($GET["rankings"])
      require("rankings.php");
    elseif ($GET["attacks"])
      require("tasks_and_attacks.php");
	elseif ($GET["resources"])
      require("resources.php");

    $insertData = array(
      "data" => $report,
      "created" => $runTime,
      "type" => $type
    );
    if ($insertLogs)
      $db->insert("debug_cron_logs", $insertData);
