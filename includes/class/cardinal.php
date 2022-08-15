<?php

/***********
CARDINAL - ONE OF THE MAIN CLASSES OF THE SYSTEM - N.A.M.
************/

/**
 * Contains everything needed to run the system
 */

require('alpha.class.php');
$path = dirname(__FILE__);
$path = explode('/', $path);

unset($path[count($path) - 1], $path[count($path) - 1]);

define('ABSPATH', implode('/', $path) . '/');

class Cardinal extends Alpha {
  function __construct() {
    global $page, $url;

    parent::__construct();

    // find absolute path for future inclusions
  

    $sek     = md5(time() . time() . time());

    $db = require(ABSPATH . 'includes/database_info.php');
    $this->db = new Mysqlidb($db['server_name'], $db['username'], $db['password'], $db['name'], $db['port'], true);
    $this->db->setTrace (true);

    // get current page | not very secure method
    $page = basename($_SERVER['PHP_SELF']);

    // debug statistics
    memory_get_usage(true);
    $this->beg_used_memory = memory_get_usage(true) / 1024;

    $this->page_start = array_sum(explode(' ', microtime()));



    $this->config = require(ABSPATH . 'includes/constants/constants.php');

    define('URL', $this->config['url']);
  }

  function loginSystem() {
    global $logged;
    require_once(ABSPATH . 'includes/class/loginSystem.php');

    $this->loginSystem = new LoginSystem($this);

    $logged = $this->loginSystem->logged;


    if (isset($_SESSION['post_data'])) {
      $_POST = $_SESSION['post_data'];
      unset($_SESSION['post_data']);
    }
  } // loginSystem

  function mustLogin() {
    if (!$this->loginSystem->logged) {
      //$_SESSION['messenger'] = array('message' => 'Access denied. Authentication required', 'type'=>'error');

      $_SESSION['afterLoginRedirect'] = $this->url;

      $this->errors[] = "Access denied. Authentication required";

      $this->redirect(URL);
    }
  }

}
