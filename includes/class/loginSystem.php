<?php

function session($field)
{
  return isset($_SESSION[$field]) ? $_SESSION[$field] : false;
}
class LoginSystem extends Alpha
{
  private  $lastSessionCheckDelay = 180;
  private  $maxLoginTriesPerTime = 5;
  private  $failedLoginAttemptsPer = 900;


  function __construct()
  {
    parent::__construct();

	  ini_set('session.hash_function', 'sha512');
	  ini_set('session.hash_bits_per_character', 5);
	  ini_set('session.use_only_cookies', 1);
	  session_name('_sr1');
    session_start();



    $this->checkIfUserLoggedIn();

    if ($this->user['id']) {

      $this->logged = true;

      if (session('duality'))
        $this->user['id'] = session('duality');

      $userData =
        $this->db->where('id', $this->user['id'])
                 ->getOne('users', 'id, username, gavatar, money, organization, `rank`,
                                    zone, main_node,
                                    zrank, points,
                                    energy, maxEnergy, exp, expNext, level, org_group, tasks,
                                    blogs, rewardsToReceive, skillPoints, alphaCoins, in_party, aiVoice,
									                  server, dataPoints, lastActive, dataPointsPerHour, tutorial,
                                     (select count(*) from attacks_inprogress
                                      where (sender = main_node or receiver = main_node)
                                             and (type = 2 or type = 4 or ( (type = 3 or type = 1) and sender = main_node))
                                      ) attacksInProgress');

   if (session('lastPremiumCheck') < (time() - 60))
     $this->updateUserPremiumInfoSessionCache();

      // check for new message
      if (session('lastMsgCheck') < (time() - 20))
      {
        $_SESSION['user']['newMsg']
                = $this->db->rawQuery('select count(m.message_id) newMsg from conversations m where
                                       m.parent_message_id is null and (m.sender_user_id = ? or m.receiver_user_id = ?) and m.last_reply_by_user_id != ? and m.last_reply_seen = 0',
                                       array($this->user['id'], $this->user['id'],$this->user['id']))[0]['newMsg'];

        $_SESSION['lastMsgCheck'] = time();
      }

      // check for friend requests
      if (session('lastFriendCheck') < time() - 30)
      {
        $_SESSION['user']['friend_requests'] =
          $this->db->rawQuery('select count(request_id) friend_requests from friend_requests where receiverid = ?', array($this->user['id']))[0]['friend_requests'];
        $_SESSION['lastFriendCheck'] = time();
      }

      // check for organization wars
      if ( $userData['organization'] && session('lastOrgWarsCheck') < time() - 300)
      {
        $_SESSION['user']['org_wars'] =
          $this->db->where('id', $userData['organization'])->getOne('organizations', 'wars_inprogress')['wars_inprogress'];

        if (session('user')['org_wars'])
          $_SESSION['user']['org_wars_now'] = $this->db->rawQuery('select war_id from org_wars where (org1_id = ? or org2_id = ?) and ? > start limit 1', array($userData['organization'], $userData['organization'], time()))[0]['war_id'];

        $_SESSION['lastOrgWarsCheck'] = time();
      }

      //
      if (session('lastPartyCheck') < (time() - 20))
      {
        $_SESSION['user']['partyInvites']
                = $this->db->rawQuery('select count(invitation_id) partyInvites from party_invitations pi
                                       where user_id = ?',
                                       array($this->user['id']))[0]['partyInvites'];

        $_SESSION['lastPartyCheck'] = time();
      }


      $this->user = array_merge($this->user, session('group'), $userData, session('user'));

      if ($this->user['in_party'] || session('party'))
        if (!session('party'))
          $_SESSION['party'] = $this->user['in_party'];
        elseif (!$this->user['in_party'])
           unset($_SESSION['party']);


    } // if logged in


    if (!session('detectDevice'))
  	{
        	$this->detectDevice = new Mobile_Detect;
  		    $_SESSION['detectDevice']['mobile'] = $this->detectDevice->isMobile();
          $_SESSION['detectDevice']['table'] = $this->detectDevice->isTable();
  	}
    $this->templateVariables['detectDevice'] = session('detectDevice');

  } // constructor

  function updateUserPremiumInfoSessionCache()
  {
     $_SESSION['lastPremiumCheck'] = time();
     $_SESSION['premium'] = $this->uclass->getPremiumData();

     unset($_SESSION['premium']['id'], $_SESSION['premium']['user_id']);
		$s=session('premium');
     foreach($s as &$premium)
       $premium = $premium > time() ? true : false;
  }

  function isUsernameUsedThrowAlert($username)
  {
    if ($this->isUsernameUsed($username))
    {
      add_alert($username . ' has already been used by another citizen.');
      return false;
    }
    return true;
  }
  function isUsernameUsed($username)
  {
    $checkIfUsed = $this->db->where('username', $username)->getOne('users', 'id');
    return $checkIfUsed['id'];
  } // isUsernameUsed
  function getUserPermissions($groupID)
  {
    $groupPermissions = $this->getGroupPermissions($groupID);
    if (!is_array($groupPermissions)) {
      $this->db->where('uid', $this->user['id'])->update('user_credentials', array(
        'group_id' => $this->config['defaultGroup']
      ));

      $groupPermissions = $this->getGroupPermissions($groupID);
    } //!is_array($groupPermissions)

    return $groupPermissions;
  }

  function getGroupPermissions($groupId)
  {
    $user_permissions = $this->db->where('group_id', $groupId)->getOne('groups');

    return $user_permissions;
  } // getGroupPermissions

  function validateUsernameThrowAlert($username)
  {
    if (!$this->validateUsername($username))
    {
      add_alert("Username must contain only letters/numbers and have between 4 and 15 characters.");
      return false;
    }
    else return true;
  }
  function validateUsername($username)
  {
    return ctype_alnum($username) && isset($username[3]) && !isset($username[16]);
  } // validaUsername

  function validatePassword($password)
  {
    return isset($password[3]) && !isset($password[20]);
  } // validatePassword

  function generatePasswordHash($password, $secretCode)
  {
    return password_hash($password . $secretCode, PASSWORD_DEFAULT);
  } // generatePasswordHash

  function generateSessionUniqueId($password, $secretCode)
  {
    $hash[] = md5(uniqid(rand(), true));
    $hash[] = sha1(uniqid(rand(), true)) . $hash[0] . md5($secretCode);
    $hash[] = sha1($password . $hash[0] . $hash[1] . md5(sha1($secretCode) . sha1($secretCode))) . sha1($password);
    $hash[] = md5($hash[0] . $hash[1] . $hash[2]) . sha1($hash[0] . $hash[1] . $hash[0]);
    return sha1($hash[0] . $hash[1] . $hash[2] . $hash[3] . md5($secretCode . $password));
  }


  function generateSessionUniqueValue($password, $secretCode, $unique_id, $time)
  {
    $hash[] = sha1($unique_id . $password . $secretCode) . sha1(time() * 2 + $time);
    $hash[] = md5($password . $secretCode . $hash[0] . time() . $time);
    $hash[] = sha1($hash[0] . $hash[1] . $secretCode . sha1($password));
    return sha1($hash[0] . $hash[1] . $hash[2] . sha1($password . $secretCode . $time . $hash[1]));
  }



  function changeUserPassword($uid, $newPass, $pin = false)
  {
	if (!$uid) return;

    if (!$pin)
      $pin = $this->db->where('uid', $uid)->getOne('user_credentials', 'pin')['pin'];

    $hash = $this->generatePasswordHash($newPass, $pin);

    $this->db->where('uid', $uid)->update('user_credentials', array('password' => $hash), 1);

  }

  function loginUser($socialLogin = false, $username = null, $password = null)
  {
    $ip = $this->getRealIP();

      $username = !isset($username) ? $_POST['username'] : $username;
      $password = !isset($password) ? $_POST['password'] : $password;
      $error    = null;
      $userData = $this->validateUsername($username) ? $this->db->where('username', $username)->getOne('users', 'id, tutorial') : null;

      if ($userData['id']) {

        // get user credentials
        $userCredentials = $this->db->where('uid', $userData['id'])->getOne('user_credentials', 'group_id, banned, password, pin, email_confirmed, login_count, login_days_in_row');

        if ($userCredentials['banned']) {
          $this->processBan($userCredentials['banned'], $userData['id']);
        } //$userCredentials['banned']


        if (!$this->errors)
          if ($userCredentials['group_id']) {
            if ($socialLogin || password_verify($password , $userCredentials['password'])) {
              $this->startUserSession($userData['id'], $username, $userCredentials, $ip);

              $_SESSION['voice'] = 'accessgranted';
              if (!$userCredentials['email_confirmed']) $_SESSION['unconfirmed_email'] = true;

      			  if (floor($userData['tutorial'] / 10 ) <= $this->config['tutorialSteps']) {
      					$_SESSION['showTutorial'] = true;
      				}


              return true;
            } //$socialLogin || $userCredentials['password'] == $this->generatePasswordHash($password, $userCredentials['pin'])
          } //$userCredentials['group_id']


        $message = 'Someone has tried and failed to login into your account. Log from '. date('d/F/Y H:i:s', $dataInsert['created']);
        require_once(ABSPATH . 'includes/class/userclass.php');
        $this->uclass->send_msg(-1, $userData['id'], $message, 'Failed login attempt!');

      } //$userData['id']

    $this->errors[] = sprintf('Access denied. <a href="%sregister/forgot/password">Forgot password?</a>', URL);

    return false;
  } // loginUser

  function startUserSession($user_id, $username, $userCredentials, $ip = "")
  {
    $sessionTime        = time();
    $session1    = $this->generateSessionUniqueId($password, $userCredentials['pin']);
    $session2    = $this->generateSessionUniqueValue($password, $userCredentials['pin'], $session1, $sessionTime);

    $insertData = array(
      'session' => $session2,
      'time' => time(),
	  'user_id'=> $user_id,
	  'ip' => $ip,
		'mobile' => $_SESSION['detectDevice']['mobile'],
          'tablet' => $_SESSION['detectDevice']['tablet'],
    );

    if (!$this->db->insert('user_session', $insertData))
	{
		$this->errors[] = 'Could not create your session';
		return;
	}

    unset($_SESSION['tasks']);

	setCookie('sessionhashone', $session1, time() + 60*60*24*30, '/');
	setCookie('sessionhashtwo', $session2, time() + 60*60*24*30, '/');

    $_SESSION['userId']        = $user_id;
    $_SESSION['session1']     = $session1;
    $_SESSION['session2']     = $session2;
    $_SESSION['login']         = true;

    add_alert('Welcome, ' . $username . '.<br/>All systems have been initialised successfully. Grid Link: Online.',
              'success');

    $_SESSION['group'] = $this->getUserPermissions($userCredentials['group_id']);

    $this->logged = true;

	$_SESSION['lastSessionCheck'] = time();
    $this->db->where('id', $user_id)->update('users', array('lastActive' => time()));

  }

  function processBan($ban, $uid)
  {
      $banned = $this->db->where('ban_id', $ban)->getOne('user_bans');
      if ($banned['expires'] <= time()) {
        $this->db->where('uid', $uid)->update('user_credentials', array(
          'banned' => NULL
        ));
      } //$banned['expires'] <= time()
      else {
        $this->errors[] = 'Account blocked';
        $this->errors[] = 'Reason: ' . $banned['reason'];
        $this->errors[] = 'Expires: ' . date('d/F/Y H:i:s', $banned['expires']);
      }
  }
  function checkIfSessionIsValid()
  {
	$session1 = $_COOKIE['sessionhashone'];
	$session2 = $_COOKIE['sessionhashtwo'];

    if ($session1 != session('session1')) return false;


    $userSession = $this->db->where('session', $session2)->getOne('user_session', 'id, user_id');
    if (!$userSession['id']) return false;

    if (session('userId') != $userSession['user_id']) return false;

    $_SESSION['lastSessionCheck'] = time();
    $this->db->where('id', $userSession['id'])->update('user_session', array('time' => time()), 1);

    $this->db->where('id', $userSession['user_id'])->update('users', array('lastActive' => time()));

    return $userSession['id'];

  } // checkIfSessionIsValid

  function checkIfUserLoggedIn()
  {

	  if (session('userId'))
	  {

      if ( session('lastSessionCheck') > time() - 3*12*60*60
		  &&
		  (session('lastSessionCheck') > (time() - $this->lastSessionCheckDelay) || $this->checkIfSessionIsValid()))
      {
        $this->user['id'] = session('userId');
      }
      else
      {
     	$this->errors[] = 'Your session has expired. Authentication required.';
        $this->logout();
      }
	  }

    return null;

  } // checkIfuserLoggedIn

  function logout()
  {

    $this->db->where('session', session('session2'))->delete('user_session', 1);
    $inAppIFrame= session('inAppIFrame');
    $_SESSION = array();

    session_destroy();
    session_unset();
    session_start();
    add_alert('You have been logged out.');


	  $_SESSION['showedVideo'] = true;
	  $_SESSION['inAppIFrame'] = $inAppIFrame;
    $this->redirect(URL);
  } // logout



} // class LoginSystem
