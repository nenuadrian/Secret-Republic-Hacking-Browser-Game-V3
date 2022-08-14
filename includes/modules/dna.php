<?php



$cardinal->mustLogin();

$page_title = "DNA";

if ($GET['sessions'])
{
	$tVars['load'] = 'sessions';

	if ($_POST['cancel'])
	{
		$db->where('id', $_POST['cancel'])->where('user_id', $user['id'])->delete('user_session');
		$success[] = "Session has been canceled";
		$cardinal->redirect(URL_C);

	}
	$sessions = $db->where('user_id', $user['id'])->orderBy('time', 'desc')
		           ->get('user_session', null, 'id, time, user_id, ip, mobile, tablet');

	foreach($sessions as &$entry)
	{
		$entry['time'] = date("d/F/Y H:i", $entry['time']);
	}

	$tVars['sessions'] = $sessions;
}
else
{

	$credentials = $db->where('uid', $user['id'])->getOne('user_credentials', 'email, password, pin, youtube');
	$no_pass = !$credentials['password'];

	if ($_POST['username'] && $_POST['username'] != $user['username'] && $user['alphaCoins'] >= 50)
	{
		if($cardinal->loginSystem->validateUsernameThrowAlert($_POST['username']))
			$cardinal->loginSystem->isUsernameUsedThrowAlert($_POST['username']);

		if (!there_are_errors())
		{
			$uclass->updatePlayer(array("username" => $_POST['username']));

			$uclass->spendAlphaCoins(50, "Username change to ".$_POST['username']);

			$success [] = "Username has been changed. Hi there, ".$_POST['username']."!";
			$cardinal->redirect(URL_C);
		}
	}
    elseif ($_POST['email'] && strtolower($_POST['email']) != $credentials['email'])
	{
		require("../includes/class/registrationSystem.php");
		$registrationSystem = new RegistrationSystem();

		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			$errors[] = "Invalid email";

		if ($registrationSystem->isEmailUsed($_POST['email']))
			$errors[] = "Email is already connected to another account";

		if (!count($errors))
		{


			$email = strtolower($_POST['email']);
			$uclass->updatePlayer(array("gavatar" => md5($email)));
			$updateData = array("email" => $email, "email_confirmed" => 0);
			$db->where("uid", $user['id'])->update("user_credentials", $updateData, 1);
			$_SESSION['unconfirmed_email'] = true;

			if ($registrationSystem->sendEmailConfirmation())
				add_alert("Email has been changed and a confirmation link has been sent","success");
		}

		$cardinal->redirect(URL_C);
	}
	elseif ($youtube = $_POST['youtube'])
	{
		if (strlen($youtube) < 3 || strlen($youtube) > 20)
			$errors[] = "Invalid video code";

		if (!count($errors))
		{
			$youtube = htmlentities(strip_tags($youtube));
			$updateData = array("youtube" => $youtube);
			$db->where("uid", $user['id'])->update("user_credentials", $updateData, 1);
			$success[] = "Updated. You can check your profile now.";
		}
		$cardinal->redirect(URL_C);
	}
	elseif ($_POST['aiVoice'])
	{
		$success = "Updated";
	  $uclass->updatePlayer(array('aiVoice' => $user['aiVoice'] ? 0 : 1));
		$cardinal->redirect(URL_C);
	}
	elseif ($_POST["change"])
	{
	  if ($cardinal->loginSystem->validatePassword($_POST["new"]))
	  {
	    if ($_POST["old"] != $_POST["new"])
      {
        if (!$no_pass)
        $oldPass = $cardinal->loginSystem->generatePasswordHash($_POST["old"], $credentials["pin"]);

        if (!$credentials["password"] || $credentials["password"] == $oldPass)
        {
          $_SESSION["failedChangeAttempts"] = 0;


          $cardinal->loginSystem->changeUserPassword($user["id"], $_POST["new"], $credentials["pin"]);
          $no_pass = false;
          $success [] = "Password combo changed";


        }
        else
        {
          $errors[] = "ACCESS DENIED";
          $_SESSION["failedChangeAttempts"] ++;
          if ($_SESSION["failedChangeAttempts"] > 2)
            $cardinal->loginSystem->logout();
        }

      } else $errors[] = "You entered same password twice";

	  } else $errors[] = "ACCESS DENIED";
	  $cardinal->redirect(URL_C);
	}


  $tVars["youtube"] = $credentials['youtube'];
  $tVars["email"] = $credentials['email'];
  $tVars["no_pass"] = $no_pass;
}

  $tVars["display"] = 'dna/dna.tpl';



?>
