<?php
 /**
 
 */

if (!defined('cardinalSystem')) exit;	

if (isset($_GET["app"]))
{
	
	if ($_POST)
	{
		$db->where("app_id", $_GET['app'])->update("applications", $_POST, 1);
		$cardinal->redirect($url);
	}
	$app = $db->Where("app_id", $_GET["app"])->getOne("applications");
	
	$templateVariables['app'] = $app;
	$templateVariables["display"] = 'admin/servers/software/edit_software.tpl';
}
else
{
  if($_POST)
  {
    $new = $db->insert("applications", array("name" => rand(1,23423)));
	if ($new)
	{
		$cardinal->redirect(URL."admin/view/software/app/".$new);
	} else $errors[] = "Could not create";
    
  } // update group
  
  $apps = $db->get("applications");
    
  $templateVariables["apps"] = $apps;
  $templateVariables["display"] = 'admin/servers/software/software_list.tpl';
 }