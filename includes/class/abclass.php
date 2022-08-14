<?php
class Abilities extends Alpha {

  function __construct() {

    parent::__construct();
    global $userData;


    $userData["level"]     = $this->user["level"];
    $userData["maxEnergy"] = $this->user["maxEnergy"];


    if ($this->user['id']) {


      $uab = $this->uclass->getUserAbilities($this->user["id"], range(1, 10));

      foreach ($uab as $ability)
        $userAbilities[$ability["ability_id"]] = $ability["level"];

      $this->userAbilities = $userAbilities;


    }
    require_once('../includes/constants/abilities.php');
    $this->abilities = abilities($userAbilities, $userData);


    if ($this->user['id']) {
      $this->processAbilitiesData();
    }



  }

  function upgrade_ability($id, $user_id = false) {

    if (!$user_id)
      $user_id = $this->user['id'];
    if (!$user_id || !$id)
      return;

    $this->uclass->addAbilityLevel($user_id, $id, 1);


    $ability          = $this->abilities[$id];
    $reward["skills"] = $ability["rates"]["skills"];
    $this->uclass->addReward($user_id, $reward, "Ability " . $ability["name"] . " upgrade");

    $_SESSION["success"] = "Ability " . $ability["name"] . " upgrade complete";
  }

  function processAbilitiesData($decideIfCanLearn = true) {
    global $user, $tasks, $error, $lerrors, $config, $abtask;

    // calculate abilities properties
    foreach ($this->abilities as $abilityKey => &$ability) {
      if ($decideIfCanLearn && $tasks < $config["max_tasks"] && !$abtask) {
        // can user learn ability?


        if ($ability["maxLevel"] <= $this->userAbilities[$abilityKey])
          $ability["cant"] = "maxLevel"; // max leve achieved
        elseif ($ability["rates"]["userLevel"] > $user["level"])
          $ability["cant"] = "userLevel"; // user level requirement not met
        elseif ($user["money"] < $ability["rates"]["price"])
          $ability["cant"] = "userMoney"; // not enough money
        elseif ($user["energy"] < $ability["rates"]["energy"])
          $ability["cant"] = "userEnergy"; // not enough energy
        elseif ($user["dataPoints"] < $ability["rates"]["dataPoints"])
          $ability["cant"] = "dataPoints"; // not enough energy


        if (!$this->userAbilities[$abilityKey]) {

          if (is_array($ability["requirements"])) {

            foreach ($ability["requirements"] as $requiredAbility => $requiredLevel) {
              if ($this->userAbilities[$requiredAbility] < $requiredLevel) {
                $ability["cant"] = "requirements";
                break;
              } //$this->userAbilities[$requiredAbility] < $requiredLevel
            } // foreach
          } // if reqyurements


        } // if

      } // decide if can learn

    } // foreach

  } // processAbilitiesData
  function add_ability_task($ability_id) {
    $ability = $this->abilities[$ability_id];
    $lvl     = $this->userAbilities[$_POST["a"]] + 1;

    //    $abtask=$task;
    $takes = $ability["rates"]["time"];

    $ability["rates"]["money"] = $ability["rates"]["price"];


    $abtask = $this->taskclass->add_task_session($this->user["id"], 1, $takes, $data, $_POST["a"], $ability["name"]);


    $this->uclass->substractResources($ability["rates"], $this->user['id']);
    $this->redirect(URL_C);

  }


}
