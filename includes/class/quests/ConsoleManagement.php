<?php

 /****************************************************
   *
   *  CONSOLE
   *
   ***************************************************/

$commandsList = array(
	"clear" => array(
		"format" => "clear",
		"description" => "Clear console text",
		"example" => "clear"
	),
	"ifconfig" => array(
		"format" => "ifconfig",
		"description" => "Show some data about current host (IP, MAC, port)",
		"example" => "ifconfig"
	),
	"complete delusion" => array(
		"format" => "complete delusion",
		"description" => "Abort current mission",
		"example" => "complete delusion",
	),
	"time delusion" => array(
		"format" => "<a href='".URL."alpha_coins/option/extraTime'>time delusion</a>",
		"description" => "Increase the available time to complete the mission at hand. <a href='".URL."alpha_coins/option/extraTime'>You will need a Time Distortion Device.</a>",
		"example" => "time delusion",
	),
	"abort" => array(
		"format" => "abort",
		"description" => "Abort current taks (e.g. decryption)",
		"example" => "abort",
	),
	"ssh" => array(
		"format" => "ssh IP port",
		"description" => "Connect to SSH service",
		"example" => "ssh 156.233.14.23 22",
	),
	"ls" => array(
		"format" => "ls",
		"description" => "List of available files",
		"example" => "ls",
	),
	"cat" => array(
		"format" => "cat filename",
		"description" => "Fetch contents of file",
		"example" => "cat data.txt",
	),
	"base64" => array(
		"format" => "<a href='".URL."alpha_coins/option/base64'>base64 encode/decode string</a>",
		"description" => "Decode and encode strings from and to base64. <a href='".URL."alpha_coins/option/base64'>You will need to activate the BASE64 command service.</a>",
		"example" => "base64 encode test | base64 decode dGVzdA==",
	),

	"rm" => array(
		"format" => "rm filename OR rm logs",
		"description" => "Remove a specific filename when used as rm filename or remove 80% of the trace earned on the service it gets executed on. SSH services store the logs for all other services on the same server.",
	    "example" => "rm test.txt OR rm logs",
	),
	"touch" => array(
		"format" => "touch newfilename",
		"description" => "Creates a file on host with give filename.",
	    "example" => "touch virus.vir",
	),
	"run" => array(
		"format" => "run filename",
		"description" => "Execute file",
		"example" => "run trojan.vir",
	),
	"kill" => array(
		"format" => "kill processID",
		"description" => "Kill process",
		"example" => "kill 9456",
	),
	"decrypt" => array(
		"format" => "decrypt filename",
		"description" => "Decrypt file",
		"example" => "decrypt file.enc",
	),
	"ps" => array(
		"format" => "ps",
		"description" => "List running processes",
		"example" => "ps",
	),
	"nmap" => array(
		"format" => "nmap IP",
		"description" => "Find open ports on target",
		"example" => "nmap 23.234.102.12",
	),
	"crack" => array(
		"format" => "crack IP port",
		"description" => "Break through the security of given target on given port",
		"example" => "crack 23.234.102.12 22",
	),
	"transfer" => array(
		"format" => "transfer filename IP port",
		"description" => "Transfer mentioned file from current host to given one. Deletes file from current host after transfer.",
		"example" => "transfer data.txt 23.234.102.12 22",
	),
	"scp" => array(
		"format" => "scp filename IP port",
		"description" => "Copy mentioned file from current host to given one. Keeps a copy on current host.",
		"example" => "scp data.txt 23.234.102.12 22",
	),
	"bounce" => array(
		"format" => "bounce add IP/remove IP/status",
		"description" => "Add, remove or obtain the status of hosts on the list to bounce through when executing instruction which raise your trace level.",
		"example" => "bounce add 23.234.102.12 OR bounce remove 23.234.102.12 OR bounce status",
	),
	"ddos" => array(
		"format" => "ddos add IP/remove IP/status/initiate IP port",
		"description" => "Add, remove or obtain the status of hosts on the list to use when initiating DDOS attacks. The initiate parameter will launch the attack on given target and port, attempting to shut it down.",
		"example" => "ddos add 23.234.102.12 OR ddos remove 23.234.102.12 OR ddos status OR ddos initiate 23.234.102.12 22 ",
	),
	"logout" => array(
		"format" => "logout",
		"description" => "Logout form current service",
		"example" => "logout",
	),
	"smtp" => array(
		"format" => "smtp IP port",
		"description" => "Connect to SMTP service",
		"example" => "smtp 156.233.14.23 333",
	),
	"smtp read" => array(
		"format" => "read ID",
		"description" => "Fetch contents of email with ID from current SMTP service.",
		"example" => "read 1",
	),
	"smtp delete" => array(
		"format" => "delete ID",
		"description" => "Delete email with ID from current SMTP service.",
		"example" => "delete 1",
	),
	"smtp forward" => array(
		"format" => "forward ID email",
		"description" => "Forward email with ID to given email. Forwarding to ".$user['username']."@secretrepublic.net will deliver to your inbox.",
		"example" => "forward 1 ".$user['username']."@secretrepublic.net",
	),
	"sql" => array(
		"format" => "sql IP port",
		"description" => "Connect to SQL service",
		"example" => "sql 156.233.14.23 3306",
	),
	"sql show" => array(
		"format" => "show tables",
		"description" => "Show a list of tables available on service",
		"example" => "show tables",
	),
	"sql drop" => array(
		"format" => "drop table",
		"description" => "Delete a table. Similar to rm for files.",
		"example" => "drop users",
	),
	"sql select" => array(
		"format" => "select * from TABLE",
		"description" => "Show data from specified table from current SQL service",
		"example" => "select * from users",
	),
	"sql delete" => array(
		"format" => "delete from TABLE where COLUMN = \"VALUE\"",
		"description" => "Delete rows from TABLE where specified COLUMN has given VALUE",
		"example" => "delete from users where username = \"".$user['username']."\"",
	),
	
);
trait ConsoleManagement
{
 
  function findHost($host)
  {
    
    if (filter_var($host, FILTER_VALIDATE_IP)) {
      
      if ($this->questData['hosts'][$host]) {
        
        return $this->questData['hosts'][$host];
        
      } //$this->questData['hosts'][$host]
      else
        $this->consoleOutput = 'Could not reach host';
      
    } //filter_var($host, FILTER_VALIDATE_IP)
    else
      $this->consoleOutput = 'Invalid IP format';
    
    
  }
  
  function console()
  {
	global $commandsList;
    if (!$this->questData['task']) {
    
      $console = explode(' ', str_replace('  ', ' ', ($this->consoleInput)));
		$console[0] = strtolower($console[0]);
		
	  if ($console[0] == "base64")
	  {
		  if (!$_SESSION['premium']['base64'])
		  {
			  $this->consoleOutput = "You need to activate <a href='".URL."alpha_coins/option/base64'>the Base64 Encoding/Decoding Command service</a> to use this command for easy encoding and decoding of base64 strings. Alternatevely, you can find base64 encoders and decoders by <a href='http://lmgtfy.com/?q=base64+encode+decode' target='_blank'>searching online</a>.";
		  }
		  elseif ($console[1] == "encode")
		  {
		  	$this->consoleOutput = "Encoded string: <strong>" . base64_encode($console[2]) . "</strong>";
		  }
		  elseif ($console[1] == "decode")
		  {
			  $this->consoleOutput = "Decoded string: <strong>" . base64_decode($console[2]) . "</strong>";
		  }
	  }
	  elseif ($console[0] == "man")
	  {
		  unset($console[0]);
		  $command = implode(" ", $console);
		  
		  if (isset($commandsList[$command]))
		  {
			  $command = $commandsList[$command];
			  $this->consoleOutput = "Format: <span class='badge alert-success'>".$command['format']."</span><br/>Example: <strong>".$command['example']."</strong><br/>Description: ".$command['description'];
		  }
	  }
	  elseif ($this->consoleInput == 'time delusion')
	  {
		  if (!$_SESSION['premium']['extraTime'])
			  $this->consoleOutput = "You are not in <a href='".URL."alpha_coins'>posession of a Time Distortion Device</a>.";
		  else
		  {
		    $mustHaveNoExecutedADelusionAfter = strtotime('today midnight');
			$this->db->where('created >= ?', array($mustHaveNoExecutedADelusionAfter))
				     ->where('user_id = ?', array($this->user['id']));
			  
			if ($this->questTask['instance_id'])
				$this->db->where('instance_id', $this->questTask['instance_id']);
			  
			else $this->db->where('task_id',$this->questTask['id']);
			$check = $this->db->getOne("user_time_delusion");
			  
		    if ($check['delusion_id'])
			{
				$this->consoleOutput = "You've alredy used the device today. You can use it again in ".sec2hms(strtotime('tomorrow - 1 second') - time());
			}
			else
			{
			   $totalSeconds = $this->questTask['totalSeconds']  + 25 * ceil($this->questTask['remainingSeconds'] / 100);
			   $this->consoleOutput = "Device powered on, time perception changed. Standing by until the day of tomorrow.";
			   $this->consoleOutput .= "<br/>Time influenced from ".sec2hms($this->questTask['remainingSeconds'])." to ".sec2hms($totalSeconds).".";
			   
			   $delusionInsert = array("user_id" => $this->user['id'], 'created' => time(), 'task_id' => $this->questTask['id'],
									    'instance_id' => $this->questTask['instance_id']);
			  $this->db->insert("user_time_delusion", $delusionInsert);
				
			  if ($this->questTask['instance_id'])
			  {
				  $this->consoleOutput .= "<br/>Influence spreads to mission party instance.";
				  
				  $this->db->where("instance_id", $this->questTask['instance_id'])
					       ->update("party_quest_instances", array("totalSeconds" => $totalSeconds));
				  $this->db->where("instance_id", $this->questTask['instance_id'])
					       ->update("tasks", array("totalSeconds" => $totalSeconds));
			  }
			  
			   $this->taskclass->updateTask($this->questTask['id'], array(
				  'totalSeconds' => $totalSeconds
				), $this->questTask['type'], true);
			  
			  $this->questTask['totalSeconds'] = $totalSeconds;
			  $this->questTask['remainingSeconds'] = $this->questTask['start'] + $totalSeconds - time();
			}
		  }
	  }
      elseif ($this->consoleInput == '/help')
      {
          
        $this->consoleOutput = '
              <p>Your email address is '.$this->user['username'].'@secretrepublic.net. Forwarding an email to this address will deliver it to your out-of-missions inbox.</p>
           
			  <p>Follow the instructions carefully and if you find yourself stuck try the forums.</p>
              <p>Pay attention to your Trace level. If it reaches 100% you will be found out and fail.</p>
             <p>You can repeat the Computer Science missions teaching you how to\'s of commands as they are vital.</p>
              <p>Use <span class="badge alert-info">man command</span> (e.g. <strong>man ls</strong>) to get specific instructions.</p>
			  <p><span class="badge alert-danger">Fair warning: these are not all available commands</span></p>
			  <p>Most commands are influenced by your skills and there\'s a chance they will cause damage to the software of your main server which influences the skills used by them. On the Skills interface click on a skill to find out what it influences.</p>
			  <strong>common commands</strong><br/>
			  -----------------------------------------
              ';
        
		foreach ($commandsList as $command => $data)
			$this->consoleOutput .= "<br/><span class='badge alert-success'>" . $command ."</span> - <strong>" . $data['format'] . "</strong>";
      }

      if ($this->user['questManager'])
        switch ($console[0]) {
          case 'cardinal':
            if ($console[1] == 'finish' && $this->user['questManager'])
            {
              $this->consoleOutput = 'Finishing objective';
              $this->completedObjective(null, null, true);
              }
            break;
        } //$console[0]
      if (!$this->consoleOutput)
      if ($console[0] == 'logout')
        $this->logoutCommand();
      else if ($this->service['type'] == 'ssh')
        switch ($console[0]) {
          case 'ping':
            $this->pingCommand($console);
            break;
          case 'crack':
            $this->crackCommand($console);
            break;
          case 'ssh':
            $this->connectPortCommand($console);
            break;
          case 'sql':
            $this->connectPortCommand($console, 'sql');
            break;
          case 'smtp':
            $this->connectPortCommand($console, 'smtp');
            break;
          case 'ls':
            $this->lsCommand($console);
            break;
          case 'ps':
            $this->psCommand();
            break;
          case 'cat':
            $this->catCommand($console);
            break;
          case 'decrypt':
            $this->decryptCommand($console);
            break;
          case 'transfer':
            $this->transferCommand($console);
            break;
          case 'scp':
            $this->transferCommand($console, false);
            break;
          case 'nmap':
            $this->nmapCommand($console);
            break;
          case 'rm':
            $this->rmCommand($console);
            break;
		  case 'touch':
            $this->touchCommand($console);
            break;
          case 'bounce':
            $this->bounceCommand($console);
            break;
          case 'run':
            $this->runCommand($console);
            break;
          case 'kill':
            $this->killCommand($console);
            break;
          case 'ifconfig':
            $this->ifconfigCommand();
            break;
          case 'ddos':
            $this->ddosCommand($console);
            break;
          
          default:
            $this->consoleOutput = 'Command not recognized or invalid syntax. Try /help';
            $this->jsonOutput['unknownCommand'] = true;
            $this->voice = 'command_error';
        } //$console[0]
      elseif ($this->service['type'] == 'smtp')
        switch ($console[0]) {
          case 'get':
            if (is_array($this->service['emails']))
              foreach ($this->service['emails'] as $key => $email)
			  {
				if ($email['requiredObjective']) continue;
                $this->consoleOutput .= str_pad($key, 4, ' ') . ' | ' . $email['title'] . '<br/>';
				$nre++;
			  }
            $this->consoleOutput .= $nre . ' emails found';
            break;
          case 'read':
            if ($email = $this->emailExists($console[1], $this->service['emails']))
			{
              $takes               = 5;
              $this->consoleOutput = 'Fetching content for email ID: ' . $console[1];
              $taskData = array('emailKey' => $console[1]);
              $this->addMinitask('read_email', $this->consoleOutput, $takes, $taskData);
            } //ctypeelse
              
            break;
          case 'delete':
            if ($this->emailExists($console[1], $this->service['emails']))
			{
              $this->consoleOutput = 'Deleting email..';
              $takes               = 5;
              $taskData = array('emailKey' => $console[1]);
              $this->addMinitask('delete_email', $this->consoleOutput, $takes, $taskData);
            } 
       
            break;
          
          case 'forward':
            if ( $this->emailExists($console[1], $this->service['emails']))
			{
              if (filter_var($console[2], FILTER_VALIDATE_EMAIL)) {
                $this->consoleOutput = 'Forwarding..';
                $takes               = 5;
                $taskData = array('emailKey' => $console[1], 'toEmail' => $console[2]);
                $this->addMinitask('forward_email', $this->consoleOutput, $takes, $taskData);
              } //filter_var($console[2], FILTER_VALIDATE_EMAIL)
              else
                $this->consoleOutput = 'Invalid email address';
            } //$email = $this->service['emails'][intval($console[1])]
           
            break;
          default:
            $this->consoleOutput = 'Command not recognized or invalid syntax. Try /help';
             $this->jsonOutput['unknownCommand'] = true;
             $this->voice = 'command_error';
        } //$console[0]
        elseif ($this->service['type'] == 'sql')
        {
          $this->consoleInput = str_replace(' ', '', $this->consoleInput);
          if ($this->consoleInput[strlen($this->consoleInput)-1] == ';')
            $this->consoleInput = substr($this->consoleInput,0,-1);
            
          if (strpos($this->consoleInput, 'showtables' ) !== false)
          {
            $this->lsCommand(null, 'tables');
          }else
          switch ($console[0]) {
            case 'delete':
              $this->sqlDeleteCommand();
              break;
            case 'select':
              $this->sqlSelectCommand();
            break; 
			case 'drop':
			  if ($console[1][strlen($console[1])-1] == ';')
            		$console[1] = substr($console[1],0,-1);
              $this->sqlDropCommand($console[1]);
            break; 
            
            default:
              $this->consoleOutput = 'Command not recognized or invalid syntax. Try /help';
               $this->jsonOutput['unknownCommand'] = true;
               $this->voice = 'command_error';
            
          }
        }
    } //!$this->questData['task']
    elseif ($this->consoleInput == 'abort') {
      unset($this->questData['task']);
      $this->consoleOutput = 'Procedure canceled';
      $this->update_quest();
      $this->refresh = true;
      
    } //$this->consoleInput == 'abort'
    elseif($this->consoleInput == 'cardinal task' && $this->user['questManager'])
      $this->questData['task']['totalSeconds'] = 0;
    else
      $this->consoleOutput = $this->questData['task']['title'];
  } // console
  
  private function emailExists($emailID, $emails)
  {
	  if (ctype_digit($emailID) && $emails[$emailID])
	  {
		  if ($emails[$emailID]['requiredObjective']) return false;
		  return $emails[$emailID];
	  }
	  
	 $this->consoleOutput = 'Invalid email ID';
	  return false;
  }
  /*
   * Parses an array and checks if the given filename is
   * a title of one of the elements of the array
   * returns the element + its key 
   */
  private function fileExists($filename, $files)
  {
    
    if (is_array($files)) {
      $filename = strtolower($filename);
      foreach ($files as $fileKey => $file) {
        if (strtolower($file['title']) == $filename) {
		  if ($file['requiredObjective']) break;
          $file['key'] = $fileKey;
          return $file;
        } // if file found
      } // parse files
      if (!$this->consoleOutput)
        $this->consoleOutput = 'File not found';
      
    } //is_array($files)
    else
      $this->consoleOutput = 'No files on host';
  } // fileExists
  
  // given a trace amount
  // compute taking in account bounces
  function increaseTraceBy($amount, $takeBounceInAccount = true, $targetIP)
  {
    $perServerAmount = $amount;
    if ($takeBounceInAccount)
    {
      $bounceCount = 0;
      foreach ($this->questData['bounces'] as $ip)
        if ($this->questData['hosts'][$ip]['bounces'] < $this->questData['hosts'][$ip]['maxBounces'])
          $bounceCount++;
          
      if ($bounceCount)
      {
        $amount -= $bounceCount;
        
        $amount = $amount > 0 ? $amount : 3;
        
        $perServerAmount = $amount / ($bounceCount + 1);
      
        // go through all bounces and add logs on them
        foreach ($this->questData['bounces'] as $ip)
          if ($this->questData['hosts'][$ip]['bounces'] < $this->questData['hosts'][$ip]['maxBounces'])
          {
            $this->questData['hosts'][$ip]['trace'] += $amount;   
            $this->questData['hosts'][$ip]['bounces']++;
          }   
      }
    }
    $influence = $this->uclass->computeUserSkillsCommandsInfluence();

		$perServerAmount -= ($perServerAmount / 100) * $influence['trace_reduce'];
		$amount -= ($amount / 100) * $influence['trace_reduce'];
			
			
    // and a log on the server we do strage stuff on
    
    $this->questData['hosts'][$targetIP]['trace'] += $perServerAmount;
    
    $this->questData['trace'] += $amount;
    
    $this->consoleOutput .= '<br/>Trace increase by '.$amount.'%';
    $this->jsonOutput['traceIncrease'] = $amount;
  }
	
  function damageSoftwareThroughUsage($softwareWhichInfluences, $damage)
  {
	  global $theskills;
	  require('includes/constants/skills.php');
	  $skills = array();
	  foreach ($theskills as $skill => $s)
		  foreach ($s['commands'] as $c=>$inf)
		  	if ($c==$softwareWhichInfluences)
	  		{$skills[] = $skill; break;}
	  if (count($skills))
	  {
		  $apps = 
		  $this->db->rawQuery("
		  select sa.*, a.* from server_apps sa
		  left outer join applications a on a.app_id = sa.app_id
		  where sa.server_id = ? and a.skill_id in (".implode(",",$skills).")
		  order by rand() limit 1",
		  array($this->user['server']));
	  	  $damage = ceil($damage/count($apps));
		  require_once ('includes/class/class.server.php');
		  $server= new Server();
		  foreach($apps as $app)
			  $server->dealAppDamage($app, $damage);
		  
	  }
	  
  }
}