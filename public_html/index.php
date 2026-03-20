<?php
require_once('../includes/vendor/autoload.php');

if(!ob_start("ob_gzhandler")) ob_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
ini_set( 'display_errors','0');
ini_set("pcre.jit", "0");

date_default_timezone_set("Europe/London");

define('cardinalSystem', true);

require_once('../includes/class/cardinal.php');

$path = dirname(__FILE__);
$path = explode('/', $path);

unset( $path[count($path) - 1]);

// ---------------------------------------------------------------
// COMPOSITION ROOT — all services are wired here via the Container
// ---------------------------------------------------------------

$container = new Container();

$smarty = new Smarty;
$smarty->setTemplateDir(implode('/', $path) . '/' . 'templates');
$smarty->setCompileDir(implode('/', $path) . '/' . 'includes/templates_c');
$smarty->setCacheDir(implode('/', $path) . '/' . 'includes/cache');
$smarty->setConfigDir(implode('/', $path) . '/' . 'includes/vendor/smarty/smarty/configs');
$container->set('smarty', $smarty);

$pageURL = array_filter(explode('/', stripslashes($_SERVER['REQUEST_URI'])));
$containsPage = array_search('page', $pageURL);
if ($containsPage) {
	unset($pageURL[$containsPage], $pageURL[$containsPage + 1]);
}
define("URL_C", stripslashes($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '/');

$pageURL =  stripslashes($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']) . '/' . implode ("/", $pageURL);
$container->set('pageURL', $pageURL);

if (isset($_SERVER['PATH_INFO'])) {
  $GETQuery = urldecode($_SERVER['PATH_INFO']);
} else if (isset($_SERVER['QUERY_STRING'])) {
  $GETQuery = urldecode($_SERVER['QUERY_STRING']);
} else {
  $GETQuery = 'main/main';
}

$GETQuery = array_values(array_filter(explode("/", $GETQuery)));
$include = 'main';
if ($GETQuery) {
	$include =  $GETQuery[0];
	unset($GETQuery[0]);
	$GETQuery = array_values($GETQuery);

	for ($i = 0; $i < count($GETQuery); $i += 2)
		$container->GET[$GETQuery[$i]] = isset( $GETQuery[$i + 1]) ? $GETQuery[$i + 1] : "" ;
}

if (!file_exists('../includes/database_info.php')) {
	$include = 'setup';
	$container->tVars['setupDefaults'] = array(
		'host' => getenv('DB_HOST') ?: 'localhost',
		'port' => getenv('DB_PORT') ?: '3306',
		'user' => getenv('DB_USER') ?: 'root',
		'pass' => getenv('DB_PASS') ?: '',
		'name' => getenv('DB_NAME') ?: '',
		'driver' => getenv('DB_DRIVER') ?: 'mysql',
	);
} else {
	$cardinal = new Cardinal($container);
	$container->set('cardinal', $cardinal);
	$container->url = $cardinal->config['url'];
}

if ($include != "404" && !file_exists("../includes/modules/" . $include . ".php"))
  $include .= is_dir("../includes/modules/" . $include) ? "/" . $include : $include = "main/main";

$container->GET["currentPage"] = $include;

$_GET = array_merge(array("GET" => $_GET), $container->GET);

// Register UserClass and Tasks as lazy singletons in the container
$container->factory('uclass', function(Container $c) {
	require_once(ABSPATH . 'includes/class/userclass.php');
	return new UserClass($c);
});
$container->factory('taskclass', function(Container $c) {
	require_once(ABSPATH . 'includes/class/taskclass.php');
	return new Tasks($c);
});

// Initialise user as empty array (LoginSystem will populate it)
$container->set('user', []);

require_once('../includes/header.php');

$include = file_exists("../includes/modules/" . $include . ".php") ? "../includes/modules/" . $include . ".php" : '404';
if ($include == "404")
  $cardinal->show_404();
else require( $include );


$container->tVars["GET"] = $container->GET;

if (!$container->tVars["json"])
{

  if ($container->tVars["show_404"])
  {
    $container->tVars["audio"] = "eve/404.mp3";

    $container->tVars["display"] = 'pages/404.tpl';
  }

  if (isset($container->tVars["display"]))
  {
	/** HANDLE NOTICES DISPLAYED AFTER REDIRECTS **/
	if ($_SESSION["success"])
		$container->success[]  = $_SESSION["success"];

	if ($_SESSION["info"])
		$container->info[]  = $_SESSION["info"];

	if ($_SESSION["error"])
		$container->errors[]  = $_SESSION["error"];

	if ($_SESSION["warning"])
		$container->warnings[]  = $_SESSION["warning"];

	if ($_SESSION["voice"])
		$container->voice = $_SESSION["voice"];

	if ($_SESSION["messenger"])
	  $container->messenger[] = $_SESSION["messenger"];

	if ($_SESSION["myModal"])
	  array_unshift($container->myModals, $_SESSION["myModal"]);

	unset($_SESSION['myModal'], $_SESSION["success"], $_SESSION["error"], $_SESSION["warning"], $_SESSION["voice"], $_SESSION['info'], $_SESSION["messenger"]);
    /** //HANDLE NOTICES DISPLAYED AFTER REDIRECTS **/

	$container->tVars['queries'] = $container->db()->trace;
	errors_success($container);
    $smarty->assign($container->tVars);
    $smarty->display($container->tVars["display"]);
    $smarty->display("footer_home.tpl");
  }
}

  $getContent = ob_get_contents();
  ob_end_clean();
  echo $getContent;
