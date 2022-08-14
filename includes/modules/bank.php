<?php

$cardinal->mustLogin();

$bankLimit = 1000 * (intval($user['level']/5) + 1);
if ($_SESSION['premium']['bankLimit1'])
	$bankLimit += 10000;

if ($_SESSION['premium']['bankLimit2'])
	$bankLimit += 30000;


$account = $db->where('user_id', $user['id'])->getOne('user_bank');
if (!$account['account_id'])
{
	$account = array('user_id' => $user['id']);
	$account['account_id'] = $db->insert('user_bank', $account);
}

if ($amount = intval($_POST['amount']))
{
	if($_POST['deposit'])
	{
		
		if ($amount > $user['money'])
			$errors[] = "You are not that rich";
		elseif ($amount > $bankLimit - $account['amount'])
			$errors[] = "Your account in its current state cannot store that much. <a href='".URL."alpha_coins/option/bankLimit1'>Upgrade?</a>";
		
		if (!count($errors))
		{
			
			$db->where('account_id', $account['account_id'])->update('user_bank', array('amount' => $account['amount'] + $amount));
			$uclass->updatePlayer(array('money' => $user['money'] - $amount));
			$success[] = "Transaction completed";
			$voice = 'transaction_done';
		}
		
	}
	else
	{
		if ($amount > $account['amount'])
			$errors[] = "Your account is not that rich";
		
		if (!count($errors))
		{
			$db->where('account_id', $account['account_id'])->update('user_bank', array('amount' => $account['amount'] - $amount));
			$uclass->updatePlayer(array('money' => $user['money'] + $amount));
			$success[] = "Transaction completed";
			$voice = 'transaction_done';
		}
		
	}
	$cardinal->redirect(URL_C);
}

$tVars['bankLimit'] = $bankLimit;
$tVars['account'] = $account;
$tVars['display'] = 'bank/bank.tpl';