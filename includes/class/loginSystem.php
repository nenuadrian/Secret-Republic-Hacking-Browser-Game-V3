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


  function __construct(Container $container)
  {
    parent::__construct($container);

	  ini_set('session.hash_function', 'sha512');
	  ini_set('session.hash_bits_per_character', 5);
	  ini_set('session.use_only_cookies', 1);
	  session_name('_sr1');
    session_start();

    $this->checkIfUserLoggedIn();

    $user = $this->container->has('user') ? $this->container->get('user') : [];

    if (isset($user['id']) && $user['id']) {

      $this->container->logged = true;

      if (session('duality'))
        $user['id'] = session('duality');

      $db = $this->container->db();

      $userData =
        $db->where('id', $user['id'])
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
                = $db->rawQuery('select count(m.message_id) newMsg from conversations m where
                                       m.parent_message_id is null and (m.sender_user_id = ? or m.receiver_user_id = ?) and m.last_reply_by_user_id != ? and m.last_reply_seen = 0',
                                       array($user['id'], $user['id'],$user['id']))[0]['newMsg'];

        $_SESSION['lastMsgCheck'] = time();
      }

      // check for friend requests
      if (session('lastFriendCheck') < time() - 30)
      {
        $_SESSION['user']['friend_requests'] =
          $db->rawQuery('select count(request_id) friend_requests from friend_requests where receiverid = ?', array($user['id']))[0]['friend_requests'];
        $_SESSION['lastFriendCheck'] = time();
      }

      // check for organization wars
      if ( $userData['organization'] && session('lastOrgWarsCheck') < time() - 300)
      {
        $_SESSION['user']['org_wars'] =
          $db->where('id', $userData['organization'])->getOne('organizations', 'wars_inprogress')['wars_inprogress'];

        if (session('user')['org_wars'])
          $_SESSION['user']['org_wars_now'] = $db->rawQuery('select war_id from org_wars where (org1_id = ? or org2_id = ?) and ? > start limit 1', array($userData['organization'], $userData['organization'], time()))[0]['war_id'];

        $_SESSION['lastOrgWarsCheck'] = time();
      }

      //
      if (session('lastPartyCheck') < (time() - 20))
      {
        $_SESSION['user']['partyInvites']
                = $db->rawQuery('select count(invitation_id) partyInvites from party_invitations pi
                                       where user_id = ?',
                                       array($user['id']))[0]['partyInvites'];

        $_SESSION['lastPartyCheck'] = time();
      }


      $user = array_merge($user, session('group') ?: [], $userData ?: [], session('user') ?: []);
      $this->container->set('user', $user);

      if ($user['in_party'] || session('party'))
        if (!session('party'))
          $_SESSION['party'] = $user['in_party'];
        elseif (!$user['in_party'])
           unset($_SESSION['party']);


    } // if logged in


    if (!session('detectDevice'))
	{
        	$this->_dynamicProps['detectDevice'] = new Mobile_Detect;
		    $_SESSION['detectDevice']['mobile'] = $this->_dynamicProps['detectDevice']->isMobile();
          $_SESSION['detectDevice']['table'] = $this->_dynamicProps['detectDevice']->isTable();
	}
    $this->container->tVars['detectDevice'] = session('detectDevice');

  } // constructor

  function isLogged()
  {
    return $this->container->logged;
  }

  function updateUserPremiumInfoSessionCache()
  {
     $_SESSION['lastPremiumCheck'] = time();
     $_SESSION['premium'] = $this->container->uclass()->getPremiumData();

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
    $checkIfUsed = $this->container->db()->where('username', $username)->getOne('users', 'id');
    return $checkIfUsed['id'];
  } // isUsernameUsed
  function getUserPermissions($groupID)
  {
    $groupPermissions = $this->getGroupPermissions($groupID);
    $config = $this->container->config();
    if (!is_array($groupPermissions)) {
      $user = $this->container->get('user');
      $this->container->db()->where('uid', $user['id'])->update('user_credentials', array(
        'group_id' => $config['defaultGroup']
      ));

      $groupPermissions = $this->getGroupPermissions($groupID);
    } //!is_array($groupPermissions)

    return $groupPermissions;
  }

  function getGroupPermissions($groupId)
  {
    $user_permissions = $this->container->db()->where('group_id', $groupId)->getOne('user_groups');

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
    return bin2hex(random_bytes(32));
  }


  function generateSessionUniqueValue($password, $secretCode, $unique_id, $time)
  {
    return bin2hex(random_bytes(32));
  }



  function changeUserPassword($uid, $newPass, $pin = false)
  {
	if (!$uid) return;

    $db = $this->container->db();
    if (!$pin)
      $pin = $db->where('uid', $uid)->getOne('user_credentials', 'pin')['pin'];

    $hash = $this->generatePasswordHash($newPass, $pin);

    $db->where('uid', $uid)->update('user_credentials', array('password' => $hash), 1);

  }

  function loginUser($socialLogin = false, $username = null, $password = null)
  {
    $ip = $this->getRealIP();
    $db = $this->container->db();
    $config = $this->container->config();

      $username = !isset($username) ? $_POST['username'] : $username;
      $password = !isset($password) ? $_POST['password'] : $password;
      $error    = null;
      $userData = $this->validateUsername($username) ? $db->where('username', $username)->getOne('users', 'id, tutorial') : null;

      if ($userData['id']) {

        // get user credentials
        $userCredentials = $db->where('uid', $userData['id'])->getOne('user_credentials', 'group_id, banned, password, pin, email_confirmed, login_count, login_days_in_row');

        if ($userCredentials['banned']) {
          $this->processBan($userCredentials['banned'], $userData['id']);
        } //$userCredentials['banned']


        if (!$this->container->errors)
          if ($userCredentials['group_id']) {
            if ($socialLogin || password_verify($password , $userCredentials['password'])) {
              $this->startUserSession($userData['id'], $username, $userCredentials, $ip);

              $_SESSION['voice'] = 'accessgranted';
              if (!$userCredentials['email_confirmed']) $_SESSION['unconfirmed_email'] = true;

    			  if (floor($userData['tutorial'] / 10 ) <= $config['tutorialSteps']) {
    					$_SESSION['showTutorial'] = true;
    				}


              return true;
            } //$socialLogin || $userCredentials['password'] == $this->generatePasswordHash($password, $userCredentials['pin'])
          } //$userCredentials['group_id']


        $message = 'Someone has tried and failed to login into your account. Log from '. date('d/F/Y H:i:s', $dataInsert['created']);
        require_once(ABSPATH . 'includes/class/userclass.php');
        $this->container->uclass()->send_msg(-1, $userData['id'], $message, 'Failed login attempt!');

      } //$userData['id']

    $this->container->errors[] = sprintf('Access denied. <a href="%sregister/forgot/password">Forgot password?</a>', URL);

    return false;
  } // loginUser

  function startUserSession($user_id, $username, $userCredentials, $ip = "")
  {
    $db = $this->container->db();
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

    if (!$db->insert('user_session', $insertData))
	{
		$this->container->errors[] = 'Could not create your session';
		return;
	}

    unset($_SESSION['tasks']);

	$cookieOptions = array(
		'expires' => time() + 60*60*24*30,
		'path' => '/',
		'httponly' => true,
		'samesite' => 'Lax',
		'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
	);
	setcookie('sessionhashone', $session1, $cookieOptions);
	setcookie('sessionhashtwo', $session2, $cookieOptions);

    $_SESSION['userId']        = $user_id;
    $_SESSION['session1']     = $session1;
    $_SESSION['session2']     = $session2;
    $_SESSION['login']         = true;

    add_alert('Welcome, ' . $username . '.<br/>All systems have been initialised successfully. Grid Link: Online.',
              'success');

    $_SESSION['group'] = $this->getUserPermissions($userCredentials['group_id']);

    $this->container->logged = true;

	$_SESSION['lastSessionCheck'] = time();
    $db->where('id', $user_id)->update('users', array('lastActive' => time()));

  }

  function processBan($ban, $uid)
  {
      $db = $this->container->db();
      $banned = $db->where('ban_id', $ban)->getOne('user_bans');
      if ($banned['expires'] <= time()) {
        $db->where('uid', $uid)->update('user_credentials', array(
          'banned' => NULL
        ));
      } //$banned['expires'] <= time()
      else {
        $this->container->errors[] = 'Account blocked';
        $this->container->errors[] = 'Reason: ' . $banned['reason'];
        $this->container->errors[] = 'Expires: ' . date('d/F/Y H:i:s', $banned['expires']);
      }
  }
  function checkIfSessionIsValid()
  {
	$session1 = $_COOKIE['sessionhashone'];
	$session2 = $_COOKIE['sessionhashtwo'];

    if ($session1 != session('session1')) return false;

    $db = $this->container->db();
    $userSession = $db->where('session', $session2)->getOne('user_session', 'id, user_id');
    if (!$userSession['id']) return false;

    if (session('userId') != $userSession['user_id']) return false;

    $_SESSION['lastSessionCheck'] = time();
    $db->where('id', $userSession['id'])->update('user_session', array('time' => time()), 1);

    $db->where('id', $userSession['user_id'])->update('users', array('lastActive' => time()));

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
        $user = $this->container->has('user') ? $this->container->get('user') : [];
        $user['id'] = session('userId');
        $this->container->set('user', $user);
      }
      else
      {
     	$this->container->errors[] = 'Your session has expired. Authentication required.';
        $this->logout();
      }
	  }

    return null;

  } // checkIfuserLoggedIn

  function logout()
  {
    $db = $this->container->db();
    $db->where('session', session('session2'))->delete('user_session', 1);
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
