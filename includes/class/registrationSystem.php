<?php

class RegistrationSystem extends Alpha
{


  function __construct(Container $container)
  {
    parent::__construct($container);
  }

  function isEmailUsed($email)
  {
    $checkIfUsed = $this->db->where("email", $email)->getOne("user_credentials", "uid");
    return $checkIfUsed['uid'];
  } // isUsernameUsed


  function validateRegisterDataForAllRegisterForms(&$username, &$zone, &$email)
  {
    $cardinal = $this->container->get('cardinal');
    $username    = $_POST['username'];
    $zone        = intval($_POST['zone']);
    $email       = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : false;

    if($cardinal->loginSystem->validateUsernameThrowAlert($username))
      $cardinal->loginSystem->isUsernameUsedThrowAlert($username);

    if ($email === false) {
      add_alert('The email you have provided is not valid');
    } //$email === false
    elseif ($this->isEmailUsed($email))
      add_alert($email . ' has already been used by another citizen.');
    elseif (!checkdnsrr($domain = array_pop(explode("@", $email)), "MX")) {
      add_alert('Cardinal System: I could not validate your email domain ['.$domain.']. This might be an error on my part. However, make sure you have not misspelled your address.', "warning");
    }

    if ($zone < 1 || $zone > 6) {
      add_alert('Invalid zone selected');
    }

    if (!$_POST['terms'])
      add_alert('You must agree to our Privacy Policy and Terms of Service');
  }
  function registerUser()
  {
    $cardinal = $this->container->get('cardinal');
	  $this->validateRegisterDataForAllRegisterForms($username, $zone, $email);

    if (!there_are_errors())
    {
      $password = $cardinal->loginSystem->validatePassword($_POST['password']) ? $_POST['password'] : false;


      $pin = rand(1000, 9999);


      if ($username == $password)
        add_alert('Why are your username and password the same?');

      if ($password === false)
        add_alert('Password must be between 4 and 20 characters.');

      if (!there_are_errors()) {
        $uid = $this->addUser($username, $password, $email, $pin, $zone);

        if (!$uid)
          add_alert('Something went terribly wrong');
      }
    }

  } // registerUser

  function addUserToGridNode($user_id, $location)
  {
    $location = explode(":", $location);
    $data = array(
      'user_id' => $user_id,
      'zone_id' => $location[0],
      'cluster' => $location[1],
      'node' => $location[2],
      'created' => time()
      );
    return $this->db->insert('zone_grid_cluster_nodes', $data);
  }
  function findAvailableGridNode($zone)
  {
    $gridCluster = $this->db->rawQuery('select cluster
                                     from zone_grid_clusters zgc
                                     where zgc.zone_id = ? and 10 > (select count(*) from zone_grid_cluster_nodes zgcn where zgcn.cluster = zgc.cluster and zgcn.zone_id = ? and zgcn.user_id is not null limit 1)
                                     order by zgc.cluster asc limit 1',
                                     array($zone,$zone))[0]['cluster'];

    $gridCluster += rand(0,2);

    $node = $this->db->rawQuery('select node from zone_grid_cluster_nodes where zone_id = ? and cluster = ? and user_id is not null', array($zone, $gridCluster));

    $usedNodes = array();
    foreach($node as $n) $usedNodes[] = $n['node'];
    $nodes = range(1,10);
    $nodes = array_diff($nodes, $usedNodes);
    shuffle($nodes);


    return $zone.':'.$gridCluster.':'.$nodes[0];
  }

  function sendEmailConfirmation($uid = false, $credentials = false, $username = false)
  {
  	$cardinal = $this->container->get('cardinal');

  	if (!$uid) $uid = $this->user['id'];
  	if (!$uid) return false;
  	if (!$credentials)
  	{
  		$credentials = $this->db->where("uid", $uid)->getOne("user_credentials", "email");

  	}
  	if (!$username) $username = $this->user['username'];
  	if (!$username)
  	{
  		$username = $this->db->where("id", $uid)->getOne("users", "username");
  		$username = $username['username'];
  	}
  	if (!$username) return false;

    $checkEmailLimit = $this->db->where("user_id", $uid)->where('created', time() - 24 * 60 * 60, ">=")->getOne("user_email_confirmation", "count(*) nrc");
    if ($checkEmailLimit['nrc'] >= 2)
    {
       add_alert("You can request a new confirmation email 2 times over a 24 hours period.");
       return false;
    }
  	$hash_code = $cardinal->loginSystem->generatePasswordHash($credentials['email'].rand(-1000000,1000000).time(), $username.time().$uid);

  	$dataInsert = array(
  		'created' => time(),
  		'user_id' => $uid,
  		'hash_code' => $hash_code,
  	);

  	if ($confirm_id = $this->db->insert("user_email_confirmation", $dataInsert))
    {


      	$confirmationUrl = URL."register/confirm/".$hash_code;

    	$replace = array("USERNAME", "CONFIRMATION_URL");
    	$with 	 = array($username, $confirmationUrl);
    	$email 	 = $this->getEmailTemplate("email_confirmation", $replace, $with);

    	$email['recipients'] = array($credentials['email']);


    	$this->sendEmail($email);
    }
    else
    {
      add_alert("Unknow error took place. Please try again later!");
      return false;
    }
	  return true;
  }

  function addUser($username, $password, $email, $pin, $zone, $sendEmail = true)
  {
    $cardinal = $this->container->get('cardinal');
    $pin = md5($pin);

    $gridNode = $this->findAvailableGridNode($zone);
    require_once(ABSPATH . 'includes/class/userclass.php');
    
    $insertData = array(
      'username' => $username,
      'zone' => $zone,
      'main_node' => $gridNode,
      'expNext' => UserClass::levelExperience(2),
      'maxEnergy' => UserClass::levelEnergy(1),
      'energy' => UserClass::levelEnergy(1),
      'gavatar' => md5(strtolower($email)),
      'createdAt' => time()
    );

    $uid = $this->db->insert('users', $insertData);
    if ($uid) {
      $this->addUserToGridNode($uid, $gridNode);

      $insertData = array(

        'password' => password_hash($password, PASSWORD_DEFAULT),
        'group_id' => $this->config['defaultGroup'],
        'email' => $email,
        'pin' => $pin,
        'uid' => $uid
      );
     
      if (!$this->db->insert('user_credentials', $insertData)) {
        die($this->db->getLastError());
      }

	  $this->logUserRegistration($uid);


      	$this->sendWelcomeStuffAndBonuses($username, $email, $uid, $password, $zone, $sendEmail);
        if ($cardinal->loginSystem)
      	$cardinal->loginSystem->loginUser(false, $username, $password);

      	return $uid;



    }  else {
      die($this->db->getLastError());
    }


  } // addUser

  function logUserRegistration($uid, $provider = false)
  {
	  $cardinal = $this->container->get('cardinal');

	  if ($_SESSION['referrer'])
	  {
		  $findReferrer = $this->db->where('id', $_SESSION['referrer'])->getOne('users', 'id');
		  if ($findReferrer['id'])
		  {
			  $referral = array(
				"master_user_id" => $findReferrer['id'],
				"slave_user_id" => $uid,
			  	"created" => time(),
			  );
			  $this->db->insert("user_referrals", $referral);
		  }

	  }


  }

  /**************************************************
    AFTER REGISTRATION STUFF
   *************************************************/
  function sendWelcomeStuffAndBonuses($username, $user_email, $user_id, $password, $zone, $sendEmail = true)
  {
     $this->giveZoneBonus($user_id, $username, $zone);

     $request = array('created' => time(), 'senderid' => 1564, 'receiverid' => $user_id);
     $this->db->insert('friend_requests', $request);

      $message = "Welcome $username,\n\nYou seem to be the one we were waiting for. \n\nEnter the Grid and discover the missions and jobs that await you. \n\nYour skills are needed and desired, so AlphaCo advises you to join an organization in order to unlock your true potential.\n\nOur team invites you to [url=".URL."forum/fid/7]introduce yourself on the competition community forums Introductory section[/url].\n\nThe first thing you should consider is fully completing [url=".URL."quests/group/15]our Computer Science Course[/url].\n\nEfficiency is the key and remember: None of us is as powerful as all of us. \n\nYou have thrown the dice. Now it's time for you to step into the realm of The Secret Republic.";
      $this->uclass->send_msg(-1, $user_id, $message, "Welcome ".$username);

      /* GIVE PREMIUM START BONUS EVE */
      $premium = $this->uclass->getPremiumData($user_id);
      $until = time() + 4 * 24 * 60 * 60;
	  $premiumBonus = array('ai' => $until, 'missionNotepad' => $until,'attackSimulator' => $until, 'removeAds' => $until, "consoleHistory" => $until);
      $this->db->where("user_id", $user_id)->update('user_premium', $premiumBonus, 1);

	    // WELCOME EMAIL

    $replace = array("USERNAME");
		$with 	 = array($username);

		$email 	 = $this->getEmailTemplate("welcome", $replace, $with);

		$email['recipients'] = array($user_email);

		$this->sendEmail($email);

		// EMAIL CONFIRM
    if ($sendEmail) $this->sendEmailConfirmation($user_id);
  }
  function giveZoneBonus($user_id, $username, $zone)
  {
		$reward = RewardsManager::zone_bonus($zone);

	$this->uclass->addReward($user_id, $reward, $reward['title']);

    // beginner organization
    $org = $this->db->join('organizations o', 'o.id = ozb.org_id', 'INNER')
                    ->where('o.nrm < o.max_nrm')
                    ->where('ozb.zone', $zone)->orderBy('rand()')
                    ->getOne('org_zone_beginners ozb', 'ozb.org_id, o.name, o.nrm');

    if ($org && $org['org_id'])
    {
      require('oclass.php');
      $oclass = new Organization($this->container, $org['org_id']);

      $content = 'Beginner Hacker in Alpha Competition';

      $ID = $oclass->validate_send_app($content, false, $user_id);

      $app['id'] = $ID;
      $app['username'] = $username;
      $app['user_id'] = $user_id;

      $oclass->accept_application($app, false);
    }
  }

}
