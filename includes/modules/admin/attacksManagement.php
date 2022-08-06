<?php

if ($GET['logs'])
{
  $db->join("users sender", "sender.id = a.sender_user_id", "left outer");
  $db->join("users receiver", "receiver.id = a.receiver_user_id", "left outer");
  if ($GET['hacker']) $db->where('a.sender_user_id = ? or a.receiver_user_id = ?', array($GET['hacker'], $GET['hacker']));
	
  $attacks = $db->get('attack_logs a', null, "a.*, sender.username sender_username, receiver.username receiver_username");

 
  $tVars["attacks"] = $attacks;
	
  $tVars["display"] = 'admin/attacks/attacks_logs_list.tpl';
}
else
{
  
  $db->join("users sender", "sender.id = a.sender_user_id", "left outer");
  $db->join("users receiver", "receiver.id = a.receiver_user_id", "left outer");
  if ($GET['hacker']) $db->where('a.sender_user_id = ? or a.receiver_user_id = ?', array($GET['hacker'], $GET['hacker']));
	
  $attacks = $db->get('attacks_inprogress a', null, "a.*, sender.username sender_username, receiver.username receiver_username");

  $tVars["attacks"] = $attacks;

  $tVars["display"] = 'admin/attacks/attacks_inprogress_list.tpl';
}
