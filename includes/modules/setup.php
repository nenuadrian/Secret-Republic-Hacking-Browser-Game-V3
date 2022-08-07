<?php

if (file_exists(ABSPATH . 'includes/database_info.php')) {
    die('Must delete database_info.php first for security reasons');
}

$dbFile = ABSPATH . '/includes/install/DB.sql';

if (!file_exists($dbFile)) {
    die('DB.sql is missing - expected in: ' . $dbFile);
}

if ($_POST['DB_HOST']) {
    // create database_info.php
    $configs = file_get_contents(ABSPATH . '/includes/database_info.php.template');
    echo $configs;
    foreach($_POST as $k => $v) {
        $configs = str_replace($k, $v, $configs);
    }
    file_put_contents(ABSPATH . '/includes/database_info.php', $configs);

    // prep sql import
    $sqls = explode(";\n", file_get_contents($dbFile));

    // import database
    $db = require(ABSPATH . '/includes/database_info.php');
    $db = new Mysqlidb($db['server_name'], $db['username'], $db['password'], $db['name'], $db['port'], true);

    foreach($sqls as $sql) {
            $db->rawQuery($sql);
    }
    
    // create admin account
    require("../includes/class/registrationSystem.php");
    $cardinal = new Cardinal();
    $registrationSystem = new RegistrationSystem;
    $uid = $registrationSystem->addUser($_POST['ADMIN_USER'], $_POST['ADMIN_PASS'], $_POST['ADMIN_EMAIL'], 1, 1, false);
    $db->where('uid', $uid)->update('user_credentials', array(
        'group_id' => 1
      ));
    $cardinal->redirect(URL);
}

$tVars['display'] = "setup.tpl";
