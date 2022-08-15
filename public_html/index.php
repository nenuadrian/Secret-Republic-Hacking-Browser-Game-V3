<?php
require_once('../includes/vendor/autoload.php');

if(!ob_start("ob_gzhandler")) ob_start();
error_reporting(E_ALL ^E_NOTICE);
ini_set( 'display_errors','1');
ini_set("pcre.jit", "0");

date_default_timezone_set("Europe/London");

define('cardinalSystem', true);

require_once('../includes/class/cardinal.php');

$path = dirname(__FILE__);
$path = explode('/', $path);

unset( $path[count($path) - 1]);


$smarty = new Smarty;
$smarty->setTemplateDir(implode('/', $path) . '/' . 'templates');
$smarty->setCompileDir(implode('/', $path) . '/' . 'includes/templates_c');
$smarty->setCacheDir(implode('/', $path) . '/' . 'includes/cache');
$smarty->setConfigDir(implode('/', $path) . '/' . 'includes/vendor/smarty/smarty/configs');

$pageURL = array_filter(explode('/', stripslashes($_SERVER['REQUEST_URI'])));
$containsPage = array_search('page', $pageURL);
if ($containsPage) {
	unset($pageURL[$containsPage], $pageURL[$containsPage + 1]);
}
define("URL_C", stripslashes($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) . '/');

$pageURL =  stripslashes($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']) . '/' . implode ("/", $pageURL);

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
	//$include =  str_replace(array('-','_'), '', $GETQuery[0]);
	$include =  $GETQuery[0];
	unset($GETQuery[0]);
	$GETQuery = array_values($GETQuery);

	for ($i = 0; $i < count($GETQuery); $i += 2)
		$GET[$GETQuery[$i]] = isset( $GETQuery[$i + 1]) ? $GETQuery[$i + 1] : "" ;
}

if (!file_exists('../includes/database_info.php')) {
	$include = 'setup';
} else {
	$cardinal = new Cardinal();
	$url = $cardinal->config['url'];
}

if ($include != "404" && !file_exists("../includes/modules/" . $include . ".php"))
  $include .= is_dir("../includes/modules/" . $include) ? "/" . $include : $include = "main/main";

$GET["currentPage"] = $include;


$_GET = array_merge(array("GET" => $_GET), $GET);


require_once('../includes/header.php');

$include = file_exists("../includes/modules/" . $include . ".php") ? "../includes/modules/" . $include . ".php" : '404';
if ($include == "404")
  $cardinal->show_404();
else require( $include );


$tVars["GET"] = $GET;

if (!$tVars["json"])
{

  if ($tVars["show_404"])
  {
    $tVars["audio"] = "eve/404.mp3";

    $tVars["display"] = 'pages/404.tpl';
  }

  if (isset($tVars["display"]))
  {
	/** HANDLE NOTICES DISPLAYED AFTER REDIRECTS **/
	if ($_SESSION["success"])
		$success[]  = $_SESSION["success"];

	if ($_SESSION["info"])
		$info[]  = $_SESSION["info"];

	if ($_SESSION["error"])
		$errors[]  = $_SESSION["error"];

	if ($_SESSION["warning"])
		$warnings[]  = $_SESSION["warning"];

	if ($_SESSION["voice"])
		$voice = $_SESSION["voice"];

	if ($_SESSION["messenger"])
	  $messenger[] = $_SESSION["messenger"];

	if ($_SESSION["myModal"])
	  array_unshift($myModals, $_SESSION["myModal"]);

	unset($_SESSION['myModal'], $_SESSION["success"], $_SESSION["error"], $_SESSION["warning"], $_SESSION["voice"], $_SESSION['info'], $_SESSION["messenger"]);
    /** //HANDLE NOTICES DISPLAYED AFTER REDIRECTS **/

	$tVars['queries'] = $db->trace;
	errors_success();
    $smarty->assign($tVars);
    $smarty->display($tVars["display"]);
    $smarty->display("footer_home.tpl");
  }
}

  $getContent = ob_get_contents();
  ob_end_clean();
  echo $getContent;
