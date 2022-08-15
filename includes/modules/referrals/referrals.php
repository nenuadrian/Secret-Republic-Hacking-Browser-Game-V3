<?php

	

$cardinal->mustLogin();


$referrals = $db->where('master_user_id', $user['id'])->getOne('user_referrals', 'count(*) nrr');
$tVars["referrals_count"] = $referrals['nrr'];

$pages                 = new Paginator;
$pages->items_total    = $referrals['nrr'];
$pages->paginate();
$db->pageLimit = $pages->items_per_page;

$referrals = $db->join('users u', 'u.id = ur.slave_user_id', 'left outer')
	            ->where('master_user_id', $user['id'])
	            ->orderBy('created', 'desc')
	            ->paginate('user_referrals ur', $pages->current_page, 'ur.*, u.username, u.level');

$tVars['referrals'] = $referrals;
$tVars['display'] = "referrals/referrals.tpl";