<?php

/***********
CARDINAL - ONE OF THE MAIN CLASSES OF THE SYSTEM - N.A.M.
************/

/**
 * Contains everything needed to run the system.
 * Receives its Container from the composition root (index.php).
 */

require('Container.php');
require('alpha.class.php');
$path = dirname(__FILE__);
$path = explode('/', $path);

unset($path[count($path) - 1], $path[count($path) - 1]);

define('ABSPATH', implode('/', $path) . '/');

class Cardinal extends Alpha {
  function __construct(Container $container) {
    parent::__construct($container);

    $sek     = md5(time() . time() . time());

    $dbConfig = require(ABSPATH . 'includes/database_info.php');
    $driver = isset($dbConfig['driver']) ? strtolower($dbConfig['driver']) : 'mysql';

    if ($driver === 'sqlite') {
      require_once(ABSPATH . 'includes/class/SqliteDb.php');
      $sqlitePath = isset($dbConfig['sqlite_path']) && $dbConfig['sqlite_path'] ? $dbConfig['sqlite_path'] : 'includes/local.sqlite';
      $db = new SqliteDb($sqlitePath);
    } else {
      $db = new Mysqlidb(
        $dbConfig['server_name'],
        $dbConfig['username'],
        $dbConfig['password'],
        $dbConfig['name'],
        isset($dbConfig['port']) ? $dbConfig['port'] : 3306
      );
    }
    $db->setTrace(true);
    $this->container->set('db', $db);

    // get current page | not very secure method
    $page = basename($_SERVER['PHP_SELF']);

    // debug statistics
    memory_get_usage(true);
    $this->_dynamicProps['beg_used_memory'] = memory_get_usage(true) / 1024;
    $this->_dynamicProps['page_start'] = array_sum(explode(' ', microtime()));

    $config = require(ABSPATH . 'includes/constants/constants.php');
    $this->container->set('config', $config);

    define('URL', $config['url']);
  }

  function loginSystem() {
    require_once(ABSPATH . 'includes/class/loginSystem.php');

    $this->_dynamicProps['loginSystem'] = new LoginSystem($this->container);

    $this->container->logged = $this->_dynamicProps['loginSystem']->isLogged();

    if (isset($_SESSION['post_data'])) {
      $_POST = $_SESSION['post_data'];
      unset($_SESSION['post_data']);
    }
  } // loginSystem

  function mustLogin() {
    if (!$this->_dynamicProps['loginSystem']->isLogged()) {
      $_SESSION['afterLoginRedirect'] = $this->container->url;

      $this->container->errors[] = "Access denied. Authentication required";

      $this->redirect(URL);
    }
  }

}
