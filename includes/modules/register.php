<?php
 /**
 */

require("../includes/class/registrationSystem.php");
$registrationSystem = new RegistrationSystem;

if(!$logged && $_GET['reset'])
{
	$checkCode = $db->where("hash_code", $_GET['reset'])->where('used', 0)->where('created', time()-48*60*60, '>')->getOne("user_reset_password", "user_id, reset_id");

	if (!$checkCode['reset_id'])
	{
		$_SESSION['error'] = "Invalid reset code";
		$cardinal->redirect(URL);
	}

	if ($_POST)
	{
		if (!$cardinal->loginSystem->validatePassword($_POST['password']))
			$errors[] = "Password needs to have between 4 and 20 characters";

		if ($_POST['password'] != $_POST['confirm_password'])
			$errors[] = "The two passwords did not match";

		if (!count($errors))
		{
			$credentials = $db->join('users u', 'u.id = uid', 'left outer')
							  ->where('uid', $checkCode['user_id'])
							  ->getOne('user_credentials', 'email, password, pin, username');

			$cardinal->loginSystem->changeUserPassword($checkCode["user_id"], $_POST['password'], $credentials["pin"]);

			$db->where('reset_id', $checkCode['reset_id'])->update('user_reset_password', array('used' => time()), 1);
			$_SESSION['success'] = "Password reset to new value";

			if ($cardinal->loginSystem->loginUser(false, $credentials['username'], $_POST['password']))
				$cardinal->redirect(URL.'dna');
		}

	}
	$tVars['display']= 'forgot_password/change_password.tpl';



}
elseif ($logged && $_SESSION['unconfirmed_email'] && $_GET['resend'] == "confirmation")
{
	if ($registrationSystem->sendEmailConfirmation())
		add_alert("A confirmation email valid for 48 hours has been sent your way. Please wait up to an hour to receive it before requestin again.", "success");

	$cardinal->redirect(URL);

}
elseif ( ($hash_code = $_GET['confirm']) && (!$logged || $_SESSION['unconfirmed_email']))
{
	$confirm = $db->where("hash_code", $hash_code)->where('used', 0)->where('created', time() - 2 * 24 * 60 * 60, ">=")->getOne("user_email_confirmation", 'confirm_id, user_id');

	if ($confirm['confirm_id'])
	{
		$db->where("confirm_id", $confirm['confirm_id'])->update("user_email_confirmation", array("used" => time()), 1);
		$db->where("uid", $confir['user_id'])->update("user_credentials", array("email_confirmed"=>1), 1);
		unset($_SESSION['unconfirmed_email']);
		$_SESSION['success'] = "Your email has been confirmed";
	}
	else $_SESSION['error'] = "Invalid email confirmation code";

	$cardinal->redirect(URL);
}
elseif (!$logged && $GET["forgot"])
{
  if ($_POST['email'])
  {
  	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
  		$errors[] = "Invalid email format";
  	if (!count($errors))
  	{
  		$checkCredentials = $db->join('users u', 'u.id = uc.uid', 'left outer')
  		                       ->where("email", $_POST['email'])->getOne("user_credentials uc", "uid, u.username, email, pin");
  		if ($checkCredentials["uid"])
  		{
  			$check = $db->where("user_id", $checkCredentials["uid"])
  			            ->where('created', time() - 12 * 60 * 60, ">=")
  			            ->getOne("user_reset_password", 'count(*) nrc');

  			if ($check['nrc'] >= 1)
  				$errors[] = "You can request your details only once over a 12 hours period.";
  			else
  			{
				$hash_code = $checkCredentials["uid"].rand(-1000000,1000000).time().$checkCredentials["username"].md5(rand(-12323,234234).$checkCredentials["pin"]);
				$hash_code = $cardinal->loginSystem->generatePasswordHash($hash_code, time().rand(-23423,234234));

				$dataInsert = array(
					'created' => time(),
					'user_id' => $checkCredentials["uid"],
					'hash_code' => $hash_code
				);
				$db->insert('user_reset_password', $dataInsert);

				$resetUrl = URL."register/reset/".$hash_code;
				$replace = array("USERNAME", "RESET_URL");
				$with 	 = array($checkCredentials['username'], $resetUrl);
				$email 	 = $cardinal->getEmailTemplate("forgot_password", $replace, $with);

				$email['recipients'] = array($checkCredentials['email']);

				$cardinal->sendEmail($email);

				$_SESSION['success'] = "We've sent your details. Please wait up to an hour to receive them.";

				$cardinal->redirect(URL_C);
			}
  		}
  		else $errors[] = "Could not find ".$_POST['email'].' in our records. <a href="'.URL.'register">Create an account?</a>';
  	}
  }
  $tVars["display"] = 'forgot_password/request_email.tpl';
}
elseif (!$logged)
{
  if (isset($_POST['process'])) {
    $registrationSystem->registerUser();

    if ($cardinal->logged)
	{

      $cardinal->redirect(URL);
	}

  }
  $tVars["display"] = 'home/reg_form.tpl';

}else $cardinal->redirect(URL);

			$tVars["no_footer_bar"] = true;
?>
