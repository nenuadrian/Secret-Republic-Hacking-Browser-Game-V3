<?php

if ($_POST['coupon'] == "iLOVEtutorials")
  $success [] = "Tutorial coupon accepted. No rewards attached. You can now continue with the tutorial.";
else
{
  $faileds = $db->where('user_id', $user['id']) 
          ->where('created > ? ', array(time() - 24*60*60))
          ->getOne('coupon_logs', 'count(*) nrf');
  if ($faileds['nrf'] >= 3)
  {
    $errors[] = "One too many failed attempts in the last 24 hours. We hope you're not trying something funky!";
  }
  else
  {
    $couponLog = array('created'=> time(), 'user_id' => $user['id']);
    $coupon = $db->where("code", $_POST["coupon"])->getOne("coupons");
    if ($couponLog['coupon_id'] = $coupon['coupon_id'])
    {
      if ($coupon['limitedUse'] && !$coupon['uses'])
        $errors[] = "Coupon has expired";
      if ($coupon['expires'] && $coupon['expirationDate'] <= time())
        $errors[] = "Coupon has expired";
      if (!count($errors))
      {
        if ($coupon['limitedUse'])
            $db->where("coupon_id", $coupon['coupon_id'])->update("coupons",array("uses" => $coupon['uses'] - 1));
  
        $db->where("id", $user['id'])->update("users", array("alphaCoins" => $user['alphaCoins'] + $coupon['alphaCoins']));
        $_SESSION['success'] = $coupon['alphaCoins']." Alpha-C have been added to your balance.";
        $voice = 'transaction_done';
      }
    }
    else
    {
      $coupon['failed'] = 1;
      $errors[] = "Invalid or terminated coupon";
    }
    $db->insert('coupon_logs', $couponLog);
  }
  $cardinal->redirect(URL_C);
}