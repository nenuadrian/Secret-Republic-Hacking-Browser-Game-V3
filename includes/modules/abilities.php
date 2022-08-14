<?php
 /**
 */



$cardinal->mustLogin();


require_once('../includes/class/abclass.php');

	$page_title="Abilities";

  /* /ABILITIES TASK  */




	//ABILITIES TASK?

	$abtask = $taskclass->check_fetch_task($user, 1);



	//ABILITY TASK IN PROGRESS?


	if($abtask){

		$taskclass->process_task_general($abtask);
		if($abtask["remainingSeconds"]<=0 || ($GET["alpha"] && $user["cardinal"])){
		  $abclass = new Abilities();
			$abclass->upgrade_ability($abtask["dataid"]);
			$taskclass->delete_task_session($user["id"],1);
			unset($abtask);
			$_SESSION['voice'] = "ability_learned";

			$cardinal->redirect(URL_C);
	  }

	  if ($abtask["remainingSeconds"]>60*60)
	  {
		  if ($_POST["alpha_coins"])
		  {
			  if ($user['alphaCoins']<1)
			  {
				  $errors[] = "Not enough Alpha Coins available";
				  $cardinal->redirect(URL . "alpha_coins");
			  }

			  $uclass->spendAlphaCoins(1, "Reduce ability waiting");
			  $db->where('id', $abtask['id'])->update('tasks', array('totalSeconds' => $abtask['totalSeconds'] - 60*60));
			  $success = "Time reduction applied";
			  $cardinal->redirect(URL_C);
		  }
	  }



		$tVars["abtask"] = $abtask;

	} // if ability task
  else
  {




    $abclass=new Abilities();

    if(ctype_digit($_POST["a"]) && !$abtask["id"] && !$a['cant'])
		if ($uclass->canDoTask())
        {
			$abtask = $abclass->add_ability_task($_POST["a"]);
			$_SESSION['voice'] = "ability_in_progress";
            $cardinal->redirect(URL_C);

        }

	  $tVars["theskills"] = $theskills;
	  $tVars["userAbilities"] = $abclass->userAbilities;
	  $tVars["abilities"] = $abclass->abilities;
	}

  $tVars["display"] = "skills_and_abilities/abilities.tpl";


?>
