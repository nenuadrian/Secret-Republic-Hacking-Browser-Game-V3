<?php

if ($_POST['addTemplate'])
{
	$dataInsert = array(
		'shortcut' => rand(1,9999),
		'name' => rand(1,9999)
	);
	$db->insert('email_templates', $dataInsert);
	$_SESSION['success'] = "Template added";
	$cardinal->redirect(URL_C);
}
if ($_POST['updateTemplate'])
{
	$template_id = $_POST['updateTemplate'];
	$dataUpdate = array(
		"shortcut" => $_POST['shortcut'],
		"name" => $_POST['name'],
		"subject" => $_POST['subject'],
		"message" => $_POST["message"]
	);
	$db->where("template_id", $template_id)->update("email_templates", $dataUpdate, 1);
	$_SESSION['success'] = "Template updated";
	$cardinal->redirect(URL_C);
	
}
$templates = $db->get('email_templates');


$tVars['templates'] = $templates;
$tVars['display'] = 'admin/emailTemplates.tpl';