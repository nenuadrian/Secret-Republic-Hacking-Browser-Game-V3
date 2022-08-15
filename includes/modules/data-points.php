<?php

if (logged_in())
{
  $spin1Costs = $db->rawQuery('select avg(dataPoints) avgDataPoints from (select dataPoints from users u where u.lastActive > ? and level >= 2) dp',
                               array(time() - 24*60*60*7))[0];

  $spin1Costs = ($spin1Costs['avgDataPoints'] / 100) * 6;
  $spin1Costs = $spin1Costs ? $spin1Costs : 1;
  $spin1SuccessRate = 35;

  $spin1comps = $db->rawQuery('select c.name, c.component_id 
                               from data_points_spin s
                               left outer join components c on c.component_id = s.component_id
                               where s.component_id is not null');

  $spin1apps = $db->rawQuery('select a.name, a.app_id 
                              from data_points_spin s
                              left outer join applications a on a.app_id = s.app_id
                              where s.app_id is not null');
  
  if (!$spin1comps || !$spin1apps) {
    echo 'Please define at least one app and one component in the data_points_spin table';
    die();
  }
  if (submitted_form('spin1') && $user['dataPoints'] >= $spin1Costs)
  {
     $uclass->substractResources(array('dataPoints' => $spin1Costs), $user['id']);
     
     $r = rand(1,100); 
     if ($r <= $spin1SuccessRate)
     {
       $log = array('created' => time(), 'user_id' => $user['id']);
       $r = rand(1,100);
       if ($r <= 50)
       {
         shuffle($spin1apps);
         $reward = array("applications" => array(array("app_id" => $spin1apps[0]['app_id'])));
         $log['app_id'] = $spin1apps[0]['app_id'];
       }
       else
       {
         shuffle($spin1comps);
         $reward = array("components" => array(array("component_id" => $spin1comps[0]['component_id'])));
         $log['component_id'] = $spin1comps[0]['component_id'];
       }
       $uclass->addReward($user['id'], $reward, "Data Points Spin");
       $message = "Coincidence by design! Reward has been delivered";
       add_alert($message, "success");

       $db->insert('data_points_spin_logs', $log);
     }
     else
     {
       add_alert("Sadly you have not received anything from this spin.");
     }
     $cardinal->redirect(URL_C);

  }

}
$spin1compNames = $spin1appNames = array();
foreach($spin1comps as $item)
  $spin1compNames[] = $item['name'];

foreach($spin1apps as $item)
  $spin1appNames[] = $item['name'];

$tVars['spin1comps'] = implode(", ", $spin1compNames);
$tVars['spin1apps'] = implode(", ", $spin1appNames);
$tVars['spin1Costs'] = $spin1Costs;
$tVars['spin1SuccessRate'] = $spin1SuccessRate;
$tVars['display'] = 'data-points/data-points.tpl';