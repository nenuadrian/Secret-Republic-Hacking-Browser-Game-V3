<?php

$cardinal->mustLogin();

/*
	MAIN SERVER REQUIRED - has user built and set a main server?
*/
if (!$user['server'])
{
	$_SESSION['error'] = "You need to have a MAIN server in order to access missions. Please proceed to building and assigning one.";
	$cardinal->redirect(URL."servers");
}

if ($GET["feedback"]) {
	require('feedback.php');
} //$GET["feedback"]
else {


  require_once('../includes/class/qclass.php');

  function canRedoDailyWhenLastIs($last)
  {
    return date('Ymd', $last) <= date('Ymd', strtotime('yesterday'));
  }


  // real quest

  $qtask = $taskclass->check_fetch_task($user, 15);
  // beta quest
  if (!$qtask['id'] && ($user['questManager'] || $user['cardinal']))
    $qtask = $taskclass->check_fetch_task($user, 18);


  if ($qtask["id"]) {

    $taskclass->process_task_general($qtask);
    if ( (!$qtask["paused"] && $qtask["remainingSeconds"] <= 0) || $_POST["console"] == "complete delusion") {

      $taskclass->delete_task_session($user["id"], $qtask["type"]);

	  if ($qtask['instance_id'] && !($_POST["console"] == "complete delusion")) {
        $db->where('instance_id', $qtask['instance_id'])->delete('party_quest_instances');
      } //$qclass->questTask['instance_id']

      unset($qtask);
      if ($_POST["console"] == "complete delusion")
        $_SESSION["error"] = "Mission failed";

      else
        $errors[] = "Mission failed";
    } //$qtask["remainingSeconds"] <= 0 || $_POST["console"] == "complete delusion"

  } //$qtask["id"]

  $qclass = new QClass($qtask);

  if ($qtask) {
    //QUEST IN PROGRESS

    require('quest_inprogress.php');

  } //$qtask
  else {

    require('quests_show.php');
  }
}
?>
