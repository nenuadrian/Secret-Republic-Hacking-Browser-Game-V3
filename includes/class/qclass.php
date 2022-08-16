<?php

// @author: Nenu Adrian Mircea
require('quests/MiniTaskManagement.php');
require('quests/SSHCommandsManagement.php');
require('quests/ConsoleManagement.php');
class QClass extends Alpha
{

  use ConsoleManagement;
  use MiniTaskManagement;
  use SSHCommandsManagement;

  private $connected;
  private static $bouncesPerHost = 3;
  private static $ddosPerHost = 3;
  private static $userGameEmail = '@secretrepublic.net';
  private static $cardinalOS = 'Cardinal OS V2.2';

  function __construct(&$questTask = null)
  {
    parent::__construct();


    $this->questTask =& $questTask;

    if ($this->questTask) {

      $this->jsonOutput = array();
      $this->questTask['canPause'] = true;

	  /* PARTY INSTANCE */
      if ($this->questTask['instance_id'])
	  {
		$this->questTask['canPause'] = false;
        $instance = $this->db->where('instance_id', $this->questTask['instance_id'])->getOne('party_quest_instances');
        // PARTY HAS ENDED OR SOMETHING
		if (!$instance['instance_id'])
		{
			$this->refresh = true;
			$this->error = "Party instance has ended.";
			$this->taskclass->delete_task_session($this->user["id"], $questTask["type"]);

		}
        $this->questTask['questData'] = array_merge($this->questTask['questData'], unserialize($instance['data']));

      } //$this->questTask['instance_id']

	  $this->handlePauseEvent();

	  if ($this->questTask['paused'])
	  {
		  $this->templateVariables['paused'] = true;
		  return;
	  }
      //Fetch and process quest data
      $this->processQuestTaskData();




      //Process console input commands
      if ($this->consoleInput = strip_tags($_POST['console'])) {
        $micro = microtime(true);
        if ($_SESSTION['lastConsole'] <= ($micro - 0.8)) {

          $_SESSTION['lastConsole'] = $micro;
          $this->console();
        } //$_SESSTION['lastConsole'] <= ($micro - 0.8)
        else
          $this->consoleOutput = 'Server is busy';
      } //$this->consoleInput = $_POST['console']

      $notepadAllowed = $_SESSION['premium']['missionNotepad'];

      if (($content = $_POST['notepad']) && $notepadAllowed && strlen($content) < 1002)
	  {
        $this->db->where('task_id', $this->questTask['id'])->where('user_id', $this->user['id'])->update('quest_notepad', array(
          'content' => $content
        ), 1);
        $this->jsonOutput['notepadUpdated'] = true;
        $this->voice                        = 'note_saved';
        //$this->doUpdate = true;
      } //($content = $_POST['notepad']) && $notepadAllowed && strlen($content) < 1002
      else {
        //Check user tracing level
        $this->check_trace();

        //Process in-quest tasks
        if ($this->questData['task'])
		{
          $this->jsonOutput['taksInProgress'] = true;
          $this->taskclass->process_task_general($this->questData['task']);
          $this->jsonOutput['countdown']      = $this->questData['task']['totalSeconds'];
          $this->jsonOutput['countdownTitle'] = $this->questData['task']['title'];
          $this->minitask();
        } //$this->questData['task']

        if ($_SESSION['lastConsoleOutput']) {

          $this->consoleOutput           = $_SESSION['lastConsoleOutput'];
          unset($_SESSION['lastConsoleOutput']);
        } //$_SESSION['lastConsoleOutput']
      }
      //Update quest data
      if ($this->doUpdate)
        $this->do_update();

      $this->templateVariables['notepadAllowed'] = $notepadAllowed;
      $this->finalProcessing();
    } //$this->questTask
    elseif ($_POST['json']) {

      echo json_encode(array(
        'refresh' => true
      ));
      die();
    } //$_POST['json']


  } // constructor

  function handlePauseEvent()
  {

	  if ($this->questTask['canPause'] && $_POST['pause'])
	  {
		  if (!$this->questTask['paused'])
			  $taskUpdateData = array(
				  'paused' => time()
				);
		  else
			  $taskUpdateData = array(
				  'paused' => NULL,
				  'start' => $this->questTask['start'] + time() - $this->questTask['paused']
				);

		  $this->taskclass->updateTask($this->questTask['id'], $taskUpdateData, $this->questTask['type'], true);
		  $this->redirect(URL_C);
	  }
  }
  function processQuestTaskData()
  {

    $this->questData = $this->questTask['questData'];

    unset($this->questTask['data'], $this->questTask['questData']);

    $this->connected =& $this->questData['connected'];
    $this->connected['ip']   = $this->connected['ip'] ? $this->connected['ip'] : $this->questData['main'];
    $this->connected['port'] = $this->connected['port'] ? $this->connected['port'] : 22;
    $this->host =& $this->questData['hosts'][$this->connected['ip']];
    $this->service =& $this->host['services'][$this->connected['port']];
  }

  function finalProcessing()
  {
    $this->json();

    /* console history */
    if (!$this->jsonOutput['unknownCommand'] && ($this->consoleInput || strlen($this->consoleOutput) > 10)) {

	  $dataInsert = array(
		  "input" => $this->consoleInput,
          "output" => $this->consoleOutput,
          "task_id" => $this->questTask['id'],
		  "instance_id" => $this->questTask['instance_id'],
		  "user_id" => $this->user['id'],
          "quest_id" => $this->questTask['questID'],
	   );

      $this->db->insert('quest_console_history', $dataInsert);
    } //!$this->jsonOutput['unknownCommand'] && $this->consoleInput

    if (!$_POST['json']) {
      $notepad = $this->db->where('task_id', $this->questTask['id'])->where('user_id', $this->user['id'])->getOne('quest_notepad', 'content, notepad_id');
      if (!$notepad['notepad_id'])
        $this->db->insert('quest_notepad', array(
          'user_id' => $this->user['id'],
          'task_id' => $this->questTask['id']
        ));

      $this->templateVariables['notepad'] = $notepad['content'];
      $this->templateVariables['quest']   = $this->questData;

      $this->templateVariables['result'] = $this->consoleOutput;
    } //!$_POST['json']
  }

  function json($done = false)
  {


    if (!$_POST['json'] && $done) {

      $this->redirect(C_URL);

    } //!$_POST['json'] && $done
    elseif ($done)
      $this->refresh = true;
    else if ($_POST['json']) {

      if ($_POST['currentObjective'] != $this->questData['objective']['id']) {
        $this->jsonOutput['newObjective']     = $this->questData['objective']['story'];
        $this->jsonOutput['currentObjective'] = $this->questData['objective']['id'];
      } //$_POST['currentObjective'] != $this->questData['objective']['id']

      $this->jsonOutput['refresh'] = $this->refresh;

      if ($this->questData['task']) {
        $this->jsonOutput['taksInProgress']       = true;
        $this->jsonOutput['taskRemainingSeconds'] = $this->questData['task']['remainingSeconds'];
      } //$this->questData->task
      $this->jsonOutput['result'] = $this->consoleOutput;
      $this->jsonOutput['trace']  = $this->questData['trace'] ? $this->questData['trace'] : 0;
       $this->jsonOutput['remainingSeconds'] = $this->questTask['remainingSeconds'];
       $this->jsonOutput['totalSeconds'] = $this->questTask['totalSeconds'];

      if (!$this->user['id'] || $this->user['aiVoice'] && $_SESSION['premium']['ai']) {
        $this->jsonOutput['voice'] = $this->voice;
      } //$_SESSION['premium']['ai'] > time() || $this->user['cardinal']

      echo json_encode($this->jsonOutput);

      $this->templateVariables['json'] = true;
      if ($this->refresh && !$this->noConsoleSession)
        $_SESSION['lastConsoleOutput'] = $this->consoleOutput;


    } //$_POST['json']
  }

  function update_quest()
  {
    $this->doUpdate = true;
  }

  function do_update()
  {
    $data = array(
      'questID' => $this->questTask['questID'],
      'questData' => $this->questData
    );

    if ($this->questTask['instance_id']) {
      $array = array(
        'bounces',
        'ddos',
        'task',
        'connected',
        'discovered',
      );
      foreach ($data['questData'] as $key => $d)
        if (!in_array($key, $array)) {
          $instance[$key] = $d;
          unset($data['questData'][$key]);
        } //!in_array($key, $array)

      $this->db->where('instance_id', $this->questTask['instance_id'])->update('party_quest_instances', array(
        'data' => serialize($instance)
      ));
    } //$this->questTask['instance_id']
    $this->taskclass->updateTask($this->questTask['id'], array(
      'data' => $data
    ), $this->questTask['type'], true);
  }



  function completedObjective($type, $data, $forceComplete = false)
  {
    $completedObjectives = array();
    $objectiveCompleted = true;
  	$data2 = explode("|", $data);
  	$data2[count($data2) - 1] = explode(":", $data2[count($data2) - 1]);
  	if (count($data2[count($data2) - 1]) == 2 && $data2[count($data2) - 1][0] != "*" && $data2[count($data2) - 1][1] != "*")
  	{
  		$data3 = $data2;
  		$data3[count($data3) - 1][0] = "*";
  		$data3[count($data3) - 1] = implode(":", $data3[count($data3) - 1]);
  		$data3 = implode("|", $data3);
  		$this->completedObjective($type, $data3);

  		$data3 = $data2;
  		$data3[count($data3) - 1][1] = "*";
  		$data3[count($data3) - 1] = implode(":", $data3[count($data3) - 1]);
  		$data3 = implode("|", $data3);
  		$this->completedObjective($type, $data3);

  		$data2[count($data2) - 1] = "*:*";
  		$data2 = implode("|", $data2);
  		$this->completedObjective($type, $data2);


  	}



    foreach ($this->questData['objective']['sideObjectives'] as &$sideObjective)
    {
      // check if we've found the completed side-obj
      if ($sideObjective['done'] || $sideObjective['type'] != $type || $sideObjective['data'] != $data)
        continue;

		  $completedObjectives[] = $sideObjective['id'];
		  /****
        If there are other side objectives with the same sub-obj order in this objective
        then set them as completed as well. It's like an x side OR y side thing
       ****/
		  if ($sideObjective['oorder'])
			  foreach ($this->questData['objective']['sideObjectives'] as &$sd)
				  if ($sd['oorder'] == $sideObjective['oorder'])
	    		  $sd['done'] = true;

      $sideObjective['done'] = true;

      if ($sideObjective['achievement_id'])
        $this->questData['rewards']['achievements'][] = $sideObjective['achievement_id'];

      if ($sideObjective['extraTime']) {
        $this->taskclass->addTaskTime($this->questTask, $sideObjective['extraTime']);
        //$this->refresh = true;
      } //$sideObjective['extraTime']
      $this->update_quest();
      break;
    }

    if (!$forceComplete)
    	foreach ($this->questData['objective']['sideObjectives'] as $side)
    	  if ($side['compulsory'] && !$side['done'])
    	  {
          $objectiveCompleted = false; break;
        }


    if ($objectiveCompleted) {

	  $completedObjectives[] = $this->questData['objective']['id'];

      if ($this->questData['objective']['extraTime']) {
        $this->taskclass->addTaskTime($this->questTask, $this->questData['objective']['extraTime']);
        //$this->refresh = true;
      } //$this->questData['objective']['extraTime']
      if ($this->questData['objective']['achievement_id'])
        $this->questData['rewards']['achievements'][] = $this->questData['objective']['achievement_id'];

      // get next objective
	  $newObjective = $this->fetchNextObjectiveData();

      if ($newObjective)
  	  {
        $this->questData['objective']          = $newObjective;

        $this->parseQSyntaxRecursively($this->questData['objective']);
        $this->consoleOutput .= '<br/> Objective completed';

        //$_SESSION['messenger'] = array('message' => 'A mission objective has been completed', 'type' => 'success');
        $this->jsonOutput['newObjective'] = $this->questData['objective']['story'];

        $this->update_quest();
      } //$newObjective
      else
  	  {
          $this->refresh          = true;
          $this->noConsoleSession = true;


          $this->result = 'Mission complete';

          $this->finished =$this->taskclass->delete_task_session($this->user['id'], $this->questTask['type']);


      } // finished objectives
    } //$objectiveCompleted || $forceComplete

	  /*** REMOVE SIDE-OBJECTIVE REQUIREMENTS FROM FILES ****/
	if (count($completedObjectives))
		foreach ($this->questData['hosts'] as &$host)
			foreach($host['services'] as &$service)
			  if ($service['files'])
			  {
				foreach($service['files'] as $k => &$f)
					if (in_array($f['requiredObjective'], $completedObjectives))
						unset($f['requiredObjective']);
			 }elseif ($service['emails'])
				foreach($service['emails'] as $k => &$f)
					if (in_array($f['requiredObjective'], $completedObjectives))
						unset($f['requiredObjective']);

  }

  public static function generateMacAddress()
  {
    $vals = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
    if (count($vals) >= 1) {
      $mac = array(
        '00'
      ); // set first two digits manually
      while (count($mac) < 6) {
        shuffle($vals);
        $mac[] = $vals[0] . $vals[1];
      } //count($mac) < 6
      $mac = implode(':', $mac);
    } //count($vals) >= 1
    return $mac;
  }

  /*************************
	Fetch the next objective, making sure you find one even if the next objective order is not incremental
	in comparison to previous one. Also if two or more objectives have the same order number, pick one randomly.
  **************************/
  function fetchNextObjectiveData($quest_id = false)
  {
	  if (!$quest_id) $quest_id = $this->questTask['questID'];
	  if (!$quest_id) return false;

	  $objective = $this->db->rawQuery('select id, story, oorder, extraTime, achievement_id
                                                  from quest_objectives
                                                  where qid = ? and side is null
												  and oorder = (select qo.oorder from quest_objectives qo where qid = ? and side is null and oorder > ? order by oorder asc limit 1)
                                                  order by RAND()
                                                  limit 1',
												 array($quest_id, $quest_id, intval($this->questData['objective']['oorder'])));

    $objective = $objective[0];

    if ($objective['id'])
		{
      $parser = new \JBBCode\Parser();
      $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
    	$objective['sideObjectives'] = $this->db->where('qid', $quest_id)->where('side', $objective['id'])->get('quest_objectives');
      $parser->parse($objective['story']);
      $objective['story'] =  $parser->getAsHtml();
  		return $objective;
	   }
	    return false;
  }

  function initiateMission($quest, $type = 15, $questData = null, $session = false, $party = false, $instance_id = false, $extraTaskData = array())
  {

	// get requested quest data
    $quest = $this->db->where('id', $quest['id'])->getOne('quests');

    $party = $party && !$quest['party'] ? false : $party;

    $task = array();

    $takes = $quest['time'] * 60;

    $task['questID'] = $quest['id'];


    /* GET USER SERVERS */
	if ($this->user['id'])
    $servers = $this->db->where('user_id', $this->user['id'])->get("servers", null, "ip, hostname, server_id");
    // FIND USER MAIN SERVER
    foreach ($servers as $key => $server)
      if ($server['server_id'] == $this->user['server']) {
        $mainServer = $server;
        unset($servers[$key]);
      } //$server['server_id'] == $this->user['server']

	// user is not in party or initiates a new mission instance
    if (!($party && $instance_id)) {

      //$data['ips'] = $quest['ips'];

      if ($questData)
        $data = array_merge($data, $questData);
      else {

        $this->questData['random_strings'] = array();

		// first objective

        $data['objective'] = $this->fetchNextObjectiveData($quest['id']);

        $data['hosts'] = $this->db->where('qid', $quest['id'])->get('quest_hosts', null, 'id, hostname, discovered, maxBounces');

        foreach ($data['hosts'] as $k => &$host) {
          if ($k == 0)
		  {
            $host['hostname'] = "[MAIN] " . $mainServer['hostname'];
			  $host['discovered'] = true;
			  $host['myServer'] = true;

		  }

          $host['ip'] = 'IP_' . $k;
          $host['mac'] = $this->generateMacAddress();

          $services = $this->db->where('hid', $host['id'])->get('quest_services', null, 'service_id, type, port, encryption');
          foreach ($services as $serviceKey => $service) {
            if ($service['type'] == 'ssh') {
			  if ($k == 0)
			  {
				$files = $this->db->join('applications a', 'a.app_id = sa.app_id', 'left outer')
			                ->where('server_id', $mainServer['server_id'])
			                ->get('server_apps sa', null, 'a.name title');

				  foreach($files as &$f)
					  $f['running'] = $f['cantKill'] = true;

				  $service['files'] = $files;
				  $service['files'] = array_merge($service['files'], $this->getServiceFiles($service['service_id']));
			  }
			  else
              	$service['files']            = $this->getServiceFiles($service['service_id']);

              $service['process_id_start'] = rand(1, 999);
            } //$service['type'] == 'ssh'
            elseif ($service['type'] == 'smtp')
              $service['emails'] = $this->getServiceEmails($service['service_id']);
            elseif ($service['type'] == 'sql')
              $service['tables'] = $this->getServiceTables($service['service_id']);

            unset($service['hid']);
			$this->parseQSyntaxRecursively($service['port']);
            $host['services'][$service['port']] = $service;
            unset($host['services'][$service['port']]['port'], $services[$serviceKey]);

          } // foreach service

          if (!is_array($host['services']))
            $host['services'] = array();

          unset($host['id']);
        } // foreach host



        // MAKE SURE NONE OF THE QUESTS IPs ARE DUPLICATES DUE TO USER SERVERS
        $blackListIPs = array();
        for ($i = 0; $i < count($servers); $i++)
          $blackListIPs[] = $servers[$i]['ip'];

        // GENERATE QUEST UNIQUE IPs
        $this->questData['ips'] = generate_ips(count($data['hosts']), $blackListIPs);



		// add list of generated IPs to task data
        $data['ips'] = $this->questData['ips'];

        // PARSE SPECIAL SYNTAX INCLUDING IP_X

        $this->parseQSyntaxRecursively($data);
        $data['random_strings'] = $this->questData['random_strings'];
        $data['main'] = $data['hosts'][0]['ip'];

		// prepare and add user servers
        foreach ($servers as &$server) { 

          $blackListIPs[]              = $server['ip'];
          $server['discovered']        = true;
          $server['mac']               = $this->generateMacAddress();
		  $server['myServer'] = true;
          $service['process_id_start'] = rand(1, 999);
          $service['welcome']          = "This server is property of " . $user['username'] . '.';
          $service['type']             = "ssh";
          $service['encryption']       = 0;


		  $files = $this->db->join('applications a', 'a.app_id = sa.app_id', 'left outer')
			                ->where('server_id', $server['server_id'])
			                ->get('server_apps sa', null, 'a.name');

		  foreach($files as &$f)
			  $f['running'] = $f['cantKill'] = true;

		  $service['files'] = $files;
		  $server['services'][22]      = $service;
          $data['hosts'][]             = $server;
        } //$servers as &$server
        //array_splice($data['hosts'], 1, 0, ($servers));


		//wrap up hosts processing
		$hosts = array();
        foreach ($data['hosts'] as $k => $aHost) {
          // $aHost['ip']         = $k == 0 ? 'main' : $aHost['ip'];
          $hosts[$aHost['ip']] = $aHost;
          unset($hosts[$aHost['ip']]['ip']);
        } //$data['hosts'] as $k => $aHost

        $data['hosts'] = $hosts;

      }


      $data['trace'] = 0;


    } //!($party && $instance_id)

	// if user is creating a new party mission instance
    if ($party && !$instance_id) {

        $instance = $data;

        $instanceData = array(
          'party_id' => $party,
          'created' => time(),
          'data' => serialize($instance),
          'quest_id' => $quest['id'],
		  'user_id' => $this->user['id'],
          'start' => time(),
          'totalSeconds' => $takes
        );
        $instance_id  = $this->db->insert('party_quest_instances', $instanceData);

		// we need not store in the user task the following
        unset($data['objective'], $data['ips'], $data['trace']);
    } //$party && !$instance_id
	// user is in party and is joining an instance id
    elseif ($party && $instance_id) {
      $instance      = $this->db->where('instance_id', $instance_id)->getOne('party_quest_instances');
      $d             = unserialize($instance['data']);
      $data['hosts'] = $d['hosts'];

    } //$party && $instance_id

	// whatever the case, compute the discovered by default hosts
    $data['discovered'] = array();
    foreach ($data['hosts'] as $ip => &$host)
      if ($host['discovered']) {

        unset($host['discovered']);
        $data['discovered'][$ip] = $host['hostname'];
      } //$host['discovered']

    if ($party)
      unset($data['hosts']);


    $data['bounces'] = $data['ddos'] = array();

    $task['questData'] = $data;
    $task = array_merge($task, $extraTaskData);
    $this->questTask = $this->taskclass->add_task_session($this->user['id'], $type, $takes, $task, 0, $quest['title'], $session, $party, $instance_id);

    $_SESSION['messenger'] = array(
      'message' => 'Mission accepted and initialised',
      'type' => 'success'
    );

    if (!$_SESSION['voice'])
      $_SESSION['voice'] = 'systems_initiated_welcome';

    $this->redirect($this->url);


  }



  function getServiceFiles($service_id)
  {
    $files = $this->db->where('service_id', $service_id)->get('quest_files', null, 'file_id, title, encryption, canRun, requiredToRun,
                             requiredOnMainToRun, running, parameters, cantKill, requiredObjective, executionTime, burst');
    foreach ($files as &$file) {
      foreach ($file as $column => $value)
        if (!$value)
          unset($file[$column]);
      if ($file['parameters'])
        $file['parameters'] = explode("|", $file['parameters']);
      if ($file['requiredToRun'])
        $file['requiredToRun'] = explode("|", $file['requiredToRun']);
      if ($file['requiredOnMainToRun'])
        $file['requiredOnMainToRun'] = explode("|", $file['requiredOnMainToRun']);

    } // foreach files

    return $files;
  }

  function getServiceEmails($service_id)
  {
    $emails = $this->db->where('service_id', $service_id)->get('quest_files', null, 'file_id,title, sender, requiredObjective');
    return $emails;
  }

  function getServiceTables($service_id)
  {
    $tables = $this->db->where('service_id', $service_id)->get('quest_files', null, 'title, content');

    foreach ($tables as &$file)
      $file['content'] = $this->parseServiceTableContent($file['content']);
    return $tables;
  }
  function parseServiceTableContent($content)
  {
    $content = explode("\n", $content);
    foreach ($content as $k => &$row) {
      $row = explode('|', $row);
      if (isset($content[$k + 1]))
        $row[count($row) - 1] = substr($row[count($row) - 1], 0, -1);
    } //$content as $k => &$row
    return $content;
  }


  function forceStartQuest($qID, $taskType = 18, $questData = null, $session = false, $party = false, $extraTaskData = array())
  {
    $quest = $this->db->where('id', $qID)->getOne('quests', 'id, time, creatorid, title');

    if ($quest['id'])
      $this->initiateMission($quest, $taskType, $questData, $session, $party, false,  $extraTaskData);

  } // forceStartQuests


  function check_trace()
  {

    if ($this->questData['trace'] >= 100) {

      $this->taskclass->delete_task_session($this->user['id'], $this->questTask['type']);
      $_SESSION['error'] = 'You have been traced and failed the missions!';
      //$this->redirect(URL . 'quests');
      $this->refresh     = true;
    } //$this->questData['trace'] >= 100
  }




  /*
   *
   * SQL COMMANDS
   *
   */

  function sqlDropCommand($tableName)
  {

        if ($table = $this->fileExists($tableName, $this->service['tables'])) {
			$takes               = 30;
			$influence = $this->uclass->computeUserSkillsCommandsInfluence();
				$reduction = ceil(($takes / 100) * $influence['sql_drop']);
				$takes    -= $reduction;

				$this->consoleOutput = sprintf("Dropping table %s (%s [%s%%] time reduction by skills)",
												 $tableName, sec2hms($reduction), $influence['sql_drop']);

			  $takes = $takes >= 3 ? $takes : 3;


		//	$this->consoleOutput = 'Dropping ' . $tableName;

          $taskData            = array(
            'tableKey' => $table['key'],
          );
          $this->addMinitask('sql_drop', $this->consoleOutput, $takes, $taskData);


        } //$table = $this->fileExists($tableName, $this->service['tables'])
        else
          $this->consoleOutput = 'Unknown table ' . $tableName;

  }

  function sqlSelectCommand()
  {
    preg_match('/select\*from(\w+)/', $this->consoleInput, $matches);
    if ($matches[0] == $this->consoleInput) {
      if ($tableName = $matches[1]) {
        if ($table = $this->fileExists($tableName, $this->service['tables'])) {
          $this->consoleOutput = '<div style=\'white-space:pre;\'>';
          // determine columns lengths
          foreach ($table['content'] as $row)
            foreach ($row as $colKey => $column)
              $colsWidth[$colKey] = $colsWidth[$colKey] < strlen($column) ? strlen($column) : $colsWidth[$colKey];


          foreach ($table['content'] as $row) {
            foreach ($row as $colKey => $column)
              $this->consoleOutput .= str_pad($column, $colsWidth[$colKey] + 2, ' ');

            $this->consoleOutput .= "\n";
          } //$table['content'] as $row
          $this->consoleOutput .= '</div>';

        } //$table = $this->fileExists($tableName, $this->service['tables'])
        else
          $this->consoleOutput = 'Unknown table ' . $tableName;
      } //$tableName = $matches[1]
      else
        $this->consoleOutput = 'Invalid select syntax';
    } //$matches[0] == $this->consoleInput
    else
      $this->consoleOutput = 'Invalid select syntax';
  }

  function sqlDeleteCommand()
  {
    preg_match('/deletefrom(\w+)where(\w+)="([\w\s]+)"/', $this->consoleInput, $matches);
    if (!($tableName = $matches[1])) return false;

    if (!($table = $this->fileExists($tableName, $this->service['tables'])))
		{$this->consoleOutput = 'Unknown table ' . $tableName; return false;}

        foreach ($table['content'][0] as $colKey => $column)
          if ($column == $matches[2]) {
            foreach ($table['content'] as $rowKey => $row)
              if ($rowKey != 0 && str_replace(' ', '', $row[$colKey]) == $matches[3])
                $rowsToDelete[] = $rowKey;
            break;
          } //$column == $matches[2]
          else
            $column = false;

        if ($rowsToDelete) {

			$takes = count($rowsToDelete) * 15;

			$influence = $this->uclass->computeUserSkillsCommandsInfluence();
				$reduction = ceil(($takes / 100) * $influence['sql_delete']);
				$takes    -= $reduction;

				$this->consoleOutput = sprintf("Deleting %s rows from table %s (%s [%s%%] time reduction by skills)",
													  count($rowsToDelete), $tableName, sec2hms($reduction), $influence['sql_delete']);

			  $takes = $takes >= 3 ? $takes : 3;


          //$this->consoleOutput = 'Deleting ' . count($rowsToDelete) . ' rows from table ' . $tableName;
          $takes               = 5;
          $taskData            = array(
            'rowsToDelete' => $rowsToDelete,
            'tableKey' => $table['key'],
            'column' => $column,
            'value' => $matches[3]
          );
          $this->addMinitask('sql_delete', $this->consoleOutput, $takes, $taskData);
        } //$rowsToDelete
        elseif (!$column)
          $this->consoleOutput = 'Unknow column ' . $matches[2];
        else
          $this->consoleOutput = 'No match found. 0 rows altered.';


  } // sqlDeleteCommand



  /****************************************************
   *
   *  QSYNTAX PARSING
   *
   ***************************************************/

  function parseQSyntaxRecursively(&$array)
  {
    if (is_array($array)) {
      foreach ($array as &$subArray)
        $this->parseQSyntaxRecursively($subArray);
    } //is_array($array)
    else {
      $this->replace_ip($array);
      $this->replace_hidden_ip($array);
      $this->replace_reveal_ip($array);

      $this->replace_random_strings($array);
      $this->replace_random_number($array);
		$this->replace_base64($array);

    }

  }

  function replace_base64(&$string)
  {
    preg_match_all('#base64\((.*?)\)#', $string, $matches);

    foreach ($matches[1] as $match)
      $string = str_replace("base64(" . $match . ")", base64_encode($match), $string);

  }
  function replace_ip(&$string)
  {
    preg_match_all('/IP_(\d{1,2})/', $string, $matches, PREG_SET_ORDER);

    foreach ($matches as $match)
      $string = str_replace($match[0], $this->questData['ips'][$match[1]], $string);

    $string = str_replace('USERNAME', $this->user['username'], $string);
  }

  function generateRandomString($length)
  {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++)
        $randomString .= $characters[rand(0, $charactersLength - 1)];

	return $randomString;
  }

  function checkIfRandStringExistsOrGenerate($nrIndex)
  {
	  if (!$this->questData['random_strings'][$nrIndex])
			for ($index = 0; $index <= $nrIndex - count($this->questData['random_strings'])+1; $index++)
			{
				$this->questData['random_strings'][] = $this->generateRandomString(50);
			}
  }
  function replace_random_strings(&$string)
  {
    preg_match_all('/RAND_S_(\d{1,2})_(\d{1,2})_(\d{1,2})/', $string, $matches, PREG_SET_ORDER);
    foreach ($matches as $match)
	{
		// ADD MORE RANDOM STRINGS IF NEEDED
		$this->checkIfRandStringExistsOrGenerate($match[1]);

         $string = str_replace($match[0], substr($this->questData['random_strings'][$match[1]], $match[2], $match[3]), $string);
	}

	preg_match_all('/RAND_S_(\d{1,2})_(\d{1,2})/', $string, $matches, PREG_SET_ORDER);
    foreach ($matches as $match)
	{
		// ADD MORE RANDOM STRINGS IF NEEDED
		$this->checkIfRandStringExistsOrGenerate($match[1]);
        $string = str_replace($match[0], substr($this->questData['random_strings'][$match[1]], 0, $match[2] - 1), $string);
	}
  }

  function replace_random_number(&$string)
  {
    preg_match_all('/RAND_N_(\d{1,5})_(\d{1,5})/', $string, $matches, PREG_SET_ORDER);

    foreach ($matches as $match)
         $string = str_replace($match[0], rand($match[1], $match[2]), $string);
  }

  function replace_hidden_ip(&$string)
  {
    preg_match_all('/IHP_(\d{1,2})_(\d{1,2})/', $string, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
      $ip                = explode('.', $this->questData['ips'][$match[1]]);
      $ip[$match[2] - 1] = str_repeat('x', strlen($ip[$match[2] - 1]));
      $ip                = implode('.', $ip);


      $string = str_replace($match[0], $ip, $string);
    } //$matches as $match

  }
  function replace_reveal_ip(&$string)
  {
    preg_match_all('/IRP_(\d{1,2})_(\d{1,2})/', $string, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
      $ip = explode('.', $this->questData['ips'][$match[1]]);
      foreach ($ip as $key => &$ipPart)
        if ($key != $match[2] - 1)
          $ipPart = str_repeat('x', strlen($ipPart));
      $ip = implode('.', $ip);


      $string = str_replace($match[0], $ip, $string);
    } //$matches as $match

  }



}


?>
