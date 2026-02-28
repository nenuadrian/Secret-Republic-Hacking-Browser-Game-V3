<?php

if (file_exists(ABSPATH . 'includes/database_info.php')) {
    die('Must delete database_info.php first for security reasons');
}

$dbFile = ABSPATH . 'includes/install/DB.sql';

if (!file_exists($dbFile)) {
    die('DB.sql is missing - expected in: ' . $dbFile);
}

require "../includes/class/registrationSystem.php";

function buildDatabaseConfigFile(array $dbConfig)
{
    $lines = array("<?php", "");
    foreach ($dbConfig as $key => $value) {
        $lines[] = '$db[\'' . $key . '\'] = ' . var_export($value, true) . ';';
    }
    $lines[] = "";
    $lines[] = "return \$db;";
    $lines[] = "";
    $lines[] = "?>";
    return implode(PHP_EOL, $lines);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $driver = isset($_POST['DB_DRIVER']) ? strtolower(trim($_POST['DB_DRIVER'])) : 'mysql';
    if ($driver !== 'sqlite') {
        $driver = 'mysql';
    }

    if (!$_POST['ADMIN_USER'] || !$_POST['ADMIN_PASS'] || !$_POST['ADMIN_EMAIL']) {
        die('ADMIN_USER, ADMIN_PASS and ADMIN_EMAIL are required.');
    }

    $dbConfig = array(
        'driver' => $driver,
        'server_name' => '',
        'username' => '',
        'password' => '',
        'name' => '',
        'port' => 3306,
        'sqlite_path' => ''
    );

    try {
        if ($driver === 'sqlite') {
            require_once ABSPATH . 'includes/class/SqliteDb.php';
            require_once ABSPATH . 'includes/class/SqliteSchemaConverter.php';

            $sqlitePath = trim($_POST['SQLITE_PATH']);
            if (!$sqlitePath) {
                $sqlitePath = 'includes/local.sqlite';
            }

            $dbConfig['sqlite_path'] = $sqlitePath;

            $resolvedSqlitePath = $sqlitePath[0] === '/' ? $sqlitePath : ABSPATH . ltrim($sqlitePath, '/');
            if (file_exists($resolvedSqlitePath)) {
                unlink($resolvedSqlitePath);
            }

            $db = new SqliteDb($sqlitePath);
            $db->setTrace(true);

            $sqlStatements = SqliteSchemaConverter::convertMySqlDump(file_get_contents($dbFile));
            foreach ($sqlStatements as $sql) {
                $db->rawQuery($sql);
            }
        } else {
            if (!$_POST['DB_HOST'] || !$_POST['DB_USER'] || !$_POST['DB_NAME']) {
                die('DB_HOST, DB_USER and DB_NAME are required for MySQL setup.');
            }

            $dbConfig['server_name'] = trim($_POST['DB_HOST']);
            $dbConfig['username'] = trim($_POST['DB_USER']);
            $dbConfig['password'] = (string) $_POST['DB_PASS'];
            $dbConfig['name'] = trim($_POST['DB_NAME']);
            $dbConfig['port'] = (int) ($_POST['DB_PORT'] ? $_POST['DB_PORT'] : 3306);

            $db = new Mysqlidb($dbConfig['server_name'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name'], $dbConfig['port']);
            $db->rawQuery('SHOW TABLES');

            $sqls = explode(";\n", file_get_contents($dbFile));
            foreach ($sqls as $sql) {
                if ($sql) {
                    $db->rawQuery($sql);
                }
            }
        }
    } catch (Exception $ex) {
        if (file_exists(ABSPATH . 'includes/database_info.php')) {
            unlink(ABSPATH . 'includes/database_info.php');
        }
        echo $ex->getMessage();
        die();
    }

    file_put_contents(ABSPATH . 'includes/database_info.php', buildDatabaseConfigFile($dbConfig));

    // create admin account
    $cardinal = new Cardinal();
    $registrationSystem = new RegistrationSystem;
    $uid = $registrationSystem->addUser($_POST['ADMIN_USER'], $_POST['ADMIN_PASS'], $_POST['ADMIN_EMAIL'], 1, 1, false);
    $db = $cardinal->db;
    $db->where('uid', $uid)->update('user_credentials', array(
        'group_id' => 1,
        'email_confirmed' => 1
    ));
    $cardinal->redirect(URL);
}

$tVars['display'] = "setup.tpl";
