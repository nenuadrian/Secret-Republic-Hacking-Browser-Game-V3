<?php
/* Functions - functions includes in all files which include header.php ~ developed by Nenu Adrian in 2012

*/
use PrettyDateTime\PrettyDateTime;


function page_url($page) {
  return URL . $page;
}
function redirect_to_page($page) {
  global $container;
  $container->get('cardinal')->redirect(page_url($page));
}
function logged_in() {
  global $container;
  return $container->logged ? true : false;
}
function GET($field) {
  global $container;
  return isset($container->GET[$field]) ? $container->GET[$field] : false;
}
function ordinal($number) {
  $ends = array(
    'th',
    'st',
    'nd',
    'rd',
    'th',
    'th',
    'th',
    'th',
    'th',
    'th'
  );
  if ((($number % 100) >= 11) && (($number % 100) <= 13))
    return $number . 'th';
  else
    return $number . $ends[$number % 10];
}

function there_are_errors() {
  global $container;
  return count($container->errors) > 0 ? true : false;
}
function add_alert($message, $type = "error") {
  global $container;
  if ($type == "error")
    $container->errors[] = $message;
  elseif ($type == "success")
    $container->success[] = $message;
}

function submitted_form($identifier) {
  if (isset($_POST["form_identifier"]) && $_POST['form_identifier'] == $identifier) {
    unset($_POST["form_identifier"]);
    return true;
  }
  return false;
}
function configs($field) {
  global $container;
  $config = $container->config();
  if (isset($config[$field]))
    return $config[$field];
  return false;
}

function date_fashion($date) {
  if (!$date)
    return 'never';
  $dateTime = new DateTime();
  $dateTime->setTimestamp($date);
  return PrettyDateTime::parse($dateTime);
}

function ordinalSuffix($number) {
  $ends = array(
    'th',
    'st',
    'nd',
    'rd',
    'th',
    'th',
    'th',
    'th',
    'th',
    'th'
  );
  if (($number % 100) >= 11 && ($number % 100) <= 13)
    $abbreviation = $number . 'th';
  else
    $abbreviation = $number . $ends[$number % 10];

  return $abbreviation;

}

function myErrorHandler($errno, $errstr, $errfile, $errline) {
  global $container;
  $report = array(
    E_USER_ERROR,
    E_ERROR,
    E_PARSE,
    E_CORE_ERROR,
    256
  );
  ;

  if (in_array($errno, $report) && isset($errstr)) {
    $smarty = $container->has('smarty') ? $container->smarty() : null;
    $tVars = &$container->tVars;
    $GET = &$container->GET;
    $config = $container->has('config') ? $container->config() : [];
    $user = $container->has('user') ? $container->get('user') : [];
    $backtrace  = debug_backtrace();
    $backtrace  = 0;
    $insertData = array(
      'errline' => $errline,
      'errfile' => $errfile,
      'page' => $GET['currentPage'],
      'url' => URL_C,
      'errno' => $errno,
      'errstr' => htmlentities($errstr, ENT_QUOTES),
      'user_id' => isset($user['id']) ? $user['id'] : 0,
      'backtrace' => var_export($backtrace, true)
    );

    if ($smarty) {
      $tVars['insertData'] = var_export($insertData, true);

      errors_success($container);

      $smarty->assign($tVars);
      $smarty->display('pages/error.tpl');
      $smarty->display('footer_home.tpl');
      unset($smarty);

    } else {
      echo '<h3>Cardinal notice: An unexpected error took place. Error recorded. Crazy people are going to look into it soon!</h3>';
      if (isset($user['view_debug']))
        print_R($insertData);
    }

    exit();

  } //in_Array($errno, $report) && isset($errstr)
  return true;


}
function fatalErrorShutdownHandler() {
  $last_error = error_get_last();
  // Only handle genuine fatal errors — not deprecations/notices/warnings
  // that PHP records as "last error" but are not actually fatal.
  $fatal_types = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];
  if ($last_error && in_array($last_error['type'], $fatal_types, true))
    myErrorHandler($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
}

set_error_handler('myErrorHandler');
register_shutdown_function('fatalErrorShutdownHandler');


function is_ip($ip) {
  return filter_var($ip, FILTER_VALIDATE_IP);
}




function errors_success(Container $container) {

  $errors    = &$container->errors;
  $success   = &$container->success;
  $info      = &$container->info;
  $warnings  = &$container->warnings;
  $messenger = &$container->messenger;
  $myModals  = &$container->myModals;
  $tVars     = &$container->tVars;
  $voice     = &$container->voice;
  $pages     = &$container->pages;
  $logged    = $container->logged;
  $user      = $container->get('user');
  $config    = $container->has('config') ? $container->config() : [];
  $cardinal  = $container->has('cardinal') ? $container->get('cardinal') : null;

  $no_warning_voice = false;

  if (isset($user['aiVoice']) && $user['aiVoice'] && ($_SESSION['premium']['ai'])) {
    if (!$voice)
      if ($errors)
        $voice = 'error';
      elseif ($success)
        $voice = 'notice';
      elseif ($warnings && !$no_warning_voice)
        $voice = 'warning';
  } else
    $voice = '';

  if ($cardinal && isset($cardinal->loginSystem) && $cardinal->loginSystem->isLogged()) {

    if ($user['friend_requests'] + $user['rewardsToReceive'])
      $user['profileNotification'] = true;
    $tVars['logged'] = true;
    $tVars['user']   = $user;

  }




  if ($pages && $pages->num_pages) {

    $tVars['pages'] = $pages->display_pages();

  }

  $error = null;
  if ($error)
    $errors[] = $error;
  if (isset($success) && !is_array($success))
    $success = array(
      $success
    );

  if (is_array($errors))
    foreach ($errors as $error)
      $messenger[] = array(
        'type' => 'error',
        'message' => $error
      );

  if (is_array($success))
    foreach ($success as $s)
      $messenger[] = array(
        'type' => 'success',
        'message' => $s
      );

  $page = null;
  $page_title = null;
  $alert = null;
  $moreTemplateVariables = array(
    'errors' => $errors,
    'success' => $success,
    'info' => $info,
    'myModals' => $myModals,
    'messenger' => $messenger,
    'alert' => $alert,
    'warnings' => $warnings,
    'page_title' => $page_title,
    'page' => $page,
    'config' => $config,
    'url' => URL_C,
    'voice' => $voice
  );

  $tVars = array_merge($tVars, $moreTemplateVariables);


}

function sec2hms($sec, $padHours = true) {
  $hms   = '';
  $hours = intval(intval($sec) / 3600);
  $hms .= ($padHours) ? str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' : $hours . ':';
  $minutes = intval(($sec / 60) % 60);
  $hms .= str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':';
  $seconds = intval($sec % 60);
  $hms .= str_pad($seconds, 2, '0', STR_PAD_LEFT);
  return $hms;

}



function convert($size) {
  $unit = array(
    'b',
    'kb',
    'mb',
    'gb',
    'tb',
    'pb'
  );
  return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
}


function generate_ips($nr, $blackList = array()) {
  $ips = array();
  while (count($ips) < $nr) {
    $ip = mt_rand(1, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);

    if (filter_var($ip, FILTER_VALIDATE_IP))
      if (!in_array($ip, $blackList) && !in_array($ip, $ips))
        array_push($ips, $ip);

  } // while

  return $ips;

}


function array_orderby() {
  $args = func_get_args();
  $data = array_shift($args);
  foreach ($args as $n => $field) {
    if (is_string($field)) {
      $tmp = array();
      foreach ($data as $key => $row)
        $tmp[$key] = $row[$field];
      $args[$n] = $tmp;
    } //is_string($field)
  } //$args as $n => $field
  $args[] =& $data;
  call_user_func_array('array_multisort', $args);
  return array_pop($args);
}

function double_rand($x, $y) {
  $x = $x * 100;
  $y = $y * 100;
  $k = rand($x, $y);
  return $k / 100;
}

function profile_link($username, $color = '') {
  global $container;
  $config = $container->config();
  $color = $color ? sprintf('style="color:%s"', $color) : '';

  return '<a class="tiptip" href="' . $config['url'] . 'profile/hacker/' . $username . '" title="' . $username . '\'s profile" ' . $color . ' >' . $username . '</a>';

}



function sizeofvar($var) {
  $start_memory = memory_get_usage();
  $tmp          = unserialize(serialize($var));
  return memory_get_usage() - $start_memory;
}


function romanic_number($integer, $upcase = true) {
  $table  = array(
    'M' => 1000,
    'CM' => 900,
    'D' => 500,
    'CD' => 400,
    'C' => 100,
    'XC' => 90,
    'L' => 50,
    'XL' => 40,
    'X' => 10,
    'IX' => 9,
    'V' => 5,
    'IV' => 4,
    'I' => 1
  );
  $return = '';
  while ($integer > 0) {
    foreach ($table as $rom => $arb) {
      if ($integer >= $arb) {
        $integer -= $arb;
        $return .= $rom;
        break;
      }
    }
  }

  return $return;
}

function shuffle_assoc($list) {
  if (!is_array($list))
    return $list;

  $keys = array_keys($list);
  shuffle($keys);
  $random = array();
  foreach ($keys as $key) {
    $random[$key] = $list[$key];
  } //$keys as $key
  return $random;
}
