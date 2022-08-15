<?php

	


  
  if ($_POST)
  {
  

    if (!$cardinal->verify_captcha_response()) {
      $errors [] = "Invalid captcha. Please try again.";
    } else {
      
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			$errors[] = "The provided email is not valid";
		
      if (!(strlen($_POST["title"]) >= 5 && strlen($_POST["title"]) <=200))
        $errors[] = "Please make sure the title has between 5 and 200 characters";
		
      
      if (!(strlen($_POST["content"]) >= 50 && strlen($_POST["content"]) <=1010))
        $errors[] = "Please check the content has between 50 and 1000 characters";
        
      if (!$errors)
      {
        $insertData = array(
          "title" => htmlentities($_POST["title"]),
          "email" => ($_POST["email"]),
          "content" => htmlentities($_POST["content"]),
          "created" => time()
        );
        if ($logged) $insertData["user_id"] = $user["id"];
        
        if ($db->insert("user_support", $insertData))
		{
			
			$email['recipients'] = array($_POST['email'], $config['contact_email']);
	       $email['subject'] = "Support: ".$_POST['title'];
			$email['message'] = $_POST['content'];
			
		  $cardinal->sendEmail($email);

      add_alert("Message has been received. Cardinal Administrators will get back to you as soon as possible.", 'success');
			$cardinal->redirect(URL);
		}
        else $errors [] = "An unknown error took place";
      }
    }
  
  }
  $tVars["captcha"] = $cardinal->generate_captcha_box();
	
  $tVars["display"] = "support/support.tpl";
	

?>
