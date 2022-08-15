<?php

$cardinal->mustLogin();

$page_title = "Alpha Coins";

if ($GET['history'])
{
    $user_id = $user['manageUsers'] && $GET['hacker'] ? $GET['hacker'] : $user['id'];

    $counts = $db->rawQuery('select (select count(*) from alpha_coin_transactions where user_id = ?) nrACT, (select count(*) from alpha_coins_logs where user_id = ?) nrACS', array(
        $user_id,
        $user_id
    ));
    $counts = $counts[0];

    $nrItems = $counts['nrACT'] > $counts['nrACS'] ? $counts['nrACT'] : $counts['nrACS'];

    $pages = new Paginator;
    $pages->items_total = $nrItems;
    $pages->items_per_page = 10;
    $pages->paginate();
	$db->pageLimit = $pages->items_per_page;

    $shop_logs = $db->join("alpha_coins_shop acs", "acs.item_id = acsl.item_id", "left outer")
        ->where('user_id', $user_id)->orderBy("acsl.created", 'desc')
        ->paginate("alpha_coins_logs acsl", $pages->current_page, "acs.name, acsl.*");
    $transactions_logs = $db->where('user_id', $user_id)->orderBy("act.created", 'desc')
        ->paginate("alpha_coin_transactions act", $pages->current_page, " fortumo, created, paypal, alphaCoins, kongregate, alphaCoinsGiven, kongregate_user_id");

    $tVars['shop_logs'] = $shop_logs;
    $tVars['transactions_logs'] = $transactions_logs;
    $tVars['display'] = 'alpha_coins/alpha_coins_history.tpl';
}
else
{

    function addTimeToColumn(&$dataUserPremiumUpdate, $premium, $item, $time)
    {
        if ($premium[$item['user_premium_col']] < time()) $premium[$item['user_premium_col']] = time();
        $until = $premium[$item['user_premium_col']] + $time;
        $dataUserPremiumUpdate[$item['user_premium_col']] = $until;
    }
    function addTimeToPremiumService($user_id, $item_id, $time = 2592000)
    {
        global $db, $uclass;

        $item = $db->where('available', 1)
            ->where('item_id', $item_id)->getOne("alpha_coins_shop");

        if (!$item['item_id']) return false;

        if (!$uclass->spendAlphaCoins($item['monthly_cost'], $item['name'], $user_id))
        {
            add_alert('Not enough A-Coins available in your balance');
            return false;
        }

        $premium = $uclass->getPremiumData($user_id);

        $dataUserPremiumUpdate = array();
        if ($item['type'] == 1)
        {
            addTimeToColumn($dataUserPremiumUpdate, $premium, $item, $time);
        }
        elseif ($item['type'] == 2)
        {
            $items = $db->where('available', 1)
                ->where('type', 1)
                ->get('alpha_coins_shop');
            foreach ($items as $anItem) addTimeToColumn($dataUserPremiumUpdate, $premium, $anItem, $item['extraData']);

        }

        $db->where('user_id', $user_id)->update('user_premium', $dataUserPremiumUpdate);

        return true;
    }

    $premium = $uclass->getPremiumData();

    if ($_POST["addMonth"])
    {

        if (addTimeToPremiumService($user['id'], $_POST['addMonth']))
        {
            add_alert("Option activation complete.", 'success');
            $voice = 'transaction_done';
            unset($_SESSION['lastPremiumCheck']);
        }
        $cardinal->redirect(URL_C);
    }

    if ($_POST["coupon"])
    {
        require ('coupon_handler.php');
    }

    $check = $db->where('user_id', $user['id'])->getOne('alpha_coin_transactions', 'transaction_id');
    $firstBuyNotice = "You have not purchased any A-Coins so far. <strong>With your first transaction you receive 25% extra on top of any other promotional offers!</strong>";
    if (!$check['transaction_id']) $info[] = $firstBuyNotice;

    if (!$_SESSION['alphaSpecialOffers'])
    {
        $myModal['title'] = "Alpha Coins Special Offers";
        $myModal['content'] = '<div class="well ">
								A special offer is in effect! For all orders over 99 Alpha Coins you receive 20% extra! (e.g. for 100AC, 20AC extra)
		                       </div>
							   ';
        if (!$check['transaction_id']) $myModal['content'] .= "<div class='well'>" . $firstBuyNotice . "</div>";

        $myModal['id'] = 'alphacoins';
        $myModal['show'] = true;
        $myModals[] = $myModal;
        $_SESSION['alphaSpecialOffers'] = true;
    }

    $items = $db->where('available', 1)
        ->orderBy('shopOrder', 'asc')
        ->get("alpha_coins_shop");

    foreach ($items as & $item)
    {
        if ($premium[$item['user_premium_col']] > time()) $item['alreadyActive'] = date('d/F/Y H:i', $premium[$item['user_premium_col']]);
    }

    $tVars['items'] = $items;

    $tVars['display'] = 'alpha_coins/alpha_coins_options.tpl';
}

