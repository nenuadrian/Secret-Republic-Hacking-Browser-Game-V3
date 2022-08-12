<?php


require_once('../includes/class/abclass.php');


require("../includes/constants/abilities.php");
$abclass= new Abilities($abilities);

$GET["toLevel"] = $GET["toLevel"]  >= 1 && $GET["toLevel"]  <= 200 ? intval($GET["toLevel"]) : 10;
$userLevel =  $GET["userLevel"]  >= 1 && $GET["userLevel"]  <= 400 ? intval($GET["userLevel"]) : 100;

for ($level = 1; $level <= $GET["toLevel"]; $level ++)
{
  for ($i=1; $i<= count($abilities); $i++)
    $userAbilities[$i] = $level;

  $userData["level"] = $userLevel;

  require("../includes/constants/abilities.php");

  foreach($abilities as $ability => $data){
   foreach($data["rates"]["skills"] as $skill => $amount)
   {
    $totalSkills[$skill]+=$amount;

   }
   $totalMoney += $data["rates"]["price"];
  }




}
ksort($totalSkills);

$tVars["abilities"] = $abilities;
$tVars["theskills"] = $theskills;
$tVars["totalSkills"] = $totalSkills;
$tVars["totalMoney"] = $totalMoney;
