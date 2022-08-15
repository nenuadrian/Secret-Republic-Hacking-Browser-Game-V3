<?php

if ($GET['logs'])
{
	$load = "logs";
	
if ($GET['hacker'])
	$db->where('uid', $GET['hacker']);

$tasks = $db->getOne('task_logs', 'count(*) nrt');

$pages = new Paginator;
$pages->items_total = $tasks['nrt'];

$pages->paginate();
$db->pageLimit = $pages->items_per_page;
if ($GET['hacker'])
	$db->where('uid', $GET['hacker']);

$db->join('users u', 'u.id = task_logs.uid', 'left outer');
$db->orderBy('start', 'desc');
$tasks = $db->paginate('task_logs', $pages->current_page, 'task_logs.*, u.username');

}
else
{

if ($_POST['update'])
{
	$updateData = $_POST;
	unset($updateData['update'], $updateData['id']);

	
	foreach ($updateData as $col => $val)
		if ($val == "") $updateData[$col] = NULL;
		
	$db->where('id', $_POST['id'])->update('tasks', $updateData, 1);
	$success[] = "Task has been updated.";
	$cardinal->redirect(URL_C);
}elseif ($_POST['delete'])
{
	$db->where('id', $_POST['id'])->delete('tasks', 1);
	$success[] = "Task has been deleted.";
	$cardinal->redirect(URL_C);
}

if ($GET['hacker'])
	$db->where('uid', $GET['hacker']);


$tasks = $db->getOne('tasks', 'count(*) nrt');

	$pages = new Paginator;
$pages->items_total = $tasks['nrt'];

$pages->paginate();



if ($GET['hacker'])
	$db->where('uid', $GET['hacker']);
	$db->pageLimit = $pages->items_per_page;
$db->join('users u', 'u.id = tasks.uid', 'left outer');
$db->orderBy('start', 'desc');
$tasks = $db->paginate('tasks', $pages->current_page, 'tasks.*, u.username');
}


foreach($tasks as &$task){
	$task['processed']['username'] = $task['username'];
	unset($task['username']);
	$task['processed']['data'] = unserialize($task['data']);
	
	$task['processed']['duration'] = sec2hms($task['totalSeconds']);
	$task['processed']['start'] = date("d/F H:i", $task['start']);
	if ($task['log_created'] )
		$task['processed']['log_created'] = date("d/F H:i", $task['log_created']);
	}

$tVars['tasks'] = $tasks;
$tVars['load'] = $load;
$tVars['display'] = "admin/tasks.tpl";