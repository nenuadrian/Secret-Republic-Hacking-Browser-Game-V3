<?php
/**
 */

$cardinal->mustLogin();

if ($GET["duality"] == "deactivate")
{
    unset($_SESSION["duality"]);
    $hackerCredentials = $db->where("uid", $_SESSION['userId'])->getOne("user_credentials", "group_id");
    $_SESSION["group"] = $cardinal
        ->loginSystem
        ->getUserPermissions($hackerCredentials["group_id"]);
    $cardinal->redirect(URL);
}

if ($_SESSION['premium']['questManager'] && !$user["globalQuestManager"] && !$user["questManager"])
{
    $user['miniQuestManager'] = true;
    $user['questManager'] = true;
}

require_once ('../includes/class/class.admin.php');

if ($GET['view'] == 'tests' && $user['cardinal'])
{
    require("testsManagement.php");
}
elseif ($GET["view"] == "groups" && $user["cardinal"])
{
    require("groupManagement.php");
}
// abilities
elseif ($GET["view"] == "data" && $user["dataManager"])
{
    if ($GET["load"] == "levels")
    {
        for ($i = 1;$i <= 400;$i++)
        {
            $levels[$i]["exp"] = $uclass->levelExperience($i);
            $levels[$i]["energy"] = $uclass->levelEnergy($i);
        }
        $tVars["levels"] = $levels;
        $tVars["display"] = "admin/data/levels.tpl";
    }
    elseif ($GET["load"] == "abilities")
    {
        require ("abilities.php");
        $tVars["display"] = "admin/data/abilities.tpl";
    }

    else
    {
        $toLevel = intval($GET["toLevel"]) ? intval($GET["toLevel"]) : 30;
        foreach ($theskills as $key => & $skill) for ($i = 1;$i <= $toLevel;$i++)
        {
            $skill["level"][$i]["exp"] = $uclass->computeSkillExperience($key, $i);
            $simulationTotal[$i] += $skill["level"][$i]["simulation"];
            $skill["level"][$i]["ranking"] = $i * $skill["rankingRate"];
            $rankingTotal[$i] += $skill["level"][$i]["ranking"];

            if (isset($skill["spy"])) if ($skill["spy"] > 0)
            {
                $skill["level"][$i]["spyProtection"] = $i * $skill["spy"];
                $spyTotal[$i]["protection"] += $skill["level"][$i]["spyProtection"];
            }
            else
            {
                $skill["level"][$i]["spyAttack"] = $i * (-$skill["spy"]);
                $spyTotal[$i]["attack"] += $skill["level"][$i]["spyAttack"];
            }

            if (isset($skill["layer"])) foreach ($skill["layer"] as $layer => $layerRate) if ($layer > 0)
            {
                $skill["level"][$i]["layer"][$layer]["protection"] = $i * $layerRate;
                $layers[$i][$layer]["protection"] += $skill["level"][$i]["layer"][$layer]["protection"];
            }
            else
            {
                $skill["level"][$i]["layer"][-$layer]["attack"] = $i * ($layerRate);
                $layers[$i][-$layer]["attack"] += $skill["level"][$i]["layer"][-$layer]["attack"];
            }

        }

        $tVars["parameters"] = array(
            "name",
            "expRate",
            "layer",
            "spy",
            "rankingRate"
        );
        $tVars["layers"] = $layers;
        $tVars["spyTotal"] = $spyTotal;
        $tVars["skills"] = $theskills;
        $tVars["simulationTotal"] = $simulationTotal;
        $tVars["rankingTotal"] = $rankingTotal;
        $tVars["display"] = "admin/data/skills.tpl";

    }
}

elseif ($GET["view"] == "emailTemplates" && $user["emailTemplatesManager"])
{
    require ("emailTemplatesManagement.php");
}
elseif ($GET["view"] == "attacks" && $user["cardinal"])
{
    require ("attacksManagement.php");
}
elseif ($GET["view"] == "servers" && $user["cardinal"])
{

    if ($GET['hacker']) $db->where('s.user_id', $GET['hacker']);
    $servers = $db->getOne('servers s', 'count(*) nrs');

    $pages = new Paginator;
    $pages->items_total = $servers["nrs"];
    $pages->items_per_page = 20;
    $pages->mid_range = 5;
    $pages->paginate();
    $db->pageLimit = $pages->items_per_page;

    $db->join('users u', 'u.id = s.user_id');
    if ($GET['hacker']) $db->where('s.user_id', $GET['hacker']);

    $servers = $db->paginate('servers s', $pages->current_page, 's.*, u.username');

    $tVars['servers'] = $servers;
    $tVars['display'] = "admin/servers/servers.tpl";
}
elseif ($GET["view"] == "software" && $user["cardinal"])
{
    require ("softwareManagement.php");
}
elseif ($GET["view"] == "hardware" && $user["cardinal"])
{
    require ("hardwareManagement.php");
}
else if ($GET["view"] == "conversations" && $user["cardinal"])
{

    if ($GET['convo'])
    {
        $db->where('message_id = ? or parent_message_id = ? ', array(
            $GET['convo'],
            $GET['convo']
        ));
        $messages = $db->getOne('conversations c', 'count(*) nrm');

        $pages = new Paginator;
        $pages->items_total = $messages['nrm'];
        $pages->paginate();

        $db->where('message_id = ? or parent_message_id = ? ', array(
            $GET['convo'],
            $GET['convo']
        ));
        $db->pageLimit = $pages->items_per_page;
        $db->join('users u', 'u.id = sender_user_id', 'left outer');
        $messages = $db->orderBy('created', 'asc')
            ->paginate('conversations c', $pages->current_page, 'c.*, u.username sender_username');
        $tVars['messages'] = $messages;
    }
    else
    {
        if ($GET['hacker']) $db->where('sender_user_id = ? or receiver_user_id = ?', array(
            $GET['hacker'],
            $GET['hacker']
        ));
        $convos = $db->where('parent_message_id is null')
            ->getOne('conversations c', 'count(*) nrc');

        $pages = new Paginator;
        $pages->items_total = $convos['nrc'];
        $pages->paginate();
        $db->pageLimit = $pages->items_per_page;
        if ($GET['hacker']) $db->where('sender_user_id = ? or receiver_user_id = ?', array(
            $GET['hacker'],
            $GET['hacker']
        ));

        $db->join('users u', 'u.id = sender_user_id', 'left outer');
        $db->join('users uu', 'uu.id = receiver_user_id', 'left outer');
        $convos = $db->where('parent_message_id is null')
            ->orderBy('created', 'desc')
            ->paginate('conversations c', $pages->current_page, 'message_id, c.title, created, u.username sender_username, uu.username receiver_username');

        $tVars['convos'] = $convos;
    }
    $tVars["display"] = 'admin/messages.tpl';

}
else

if ($GET["view"] == "manageQuest" && $user["questManager"])
{
    require("questManagement.php");

}
elseif ($user["cardinal"] && $GET["view"] == "crons")
{

    $crons = $db->getOne("debug_cron_logs", "count(*) as nrl");
    $pages = new Paginator;
    $pages->items_total = $crons["nrl"];
    $pages->items_per_page = 40;
    $pages->mid_range = 5;
    $pages->paginate();
    $db->pageLimit = $pages->items_per_page;

    $crons = $db->orderBy("created", "desc")
        ->paginate("debug_cron_logs", $pages->current_page);
    foreach ($crons as & $cron) $cron["created"] = date("d/F/Y H:i:s", $cron["created"]);

    $tVars["crons"] = $crons;

    $tVars["display"] = 'admin/crons.tpl';

}
elseif ($user["cardinal"] && $GET["view"] == "errors")
{

    $debug_errors = $db->getOne("debug_404_errors", "count(*) as nrl");
    $pages = new Paginator;
    $pages->items_total = $debug_errors["nrl"];
    $pages->items_per_page = 40;
    $pages->mid_range = 5;
    $pages->paginate();
    $db->pageLimit = $pages->items_per_page;

    $debug_errors = $db->join("users", "users.id = debug_404_errors.user_id", "LEFT OUTER")
        ->orderBy("created", "desc")
        ->paginate("debug_404_errors", $pages->current_page, "debug_404_errors.*, users.username");
    foreach ($debug_errors as & $debug_error) $debug_error["created"] = date("d/F/Y H:i:s", $debug_error["created"]);

    $tVars["debug_errors"] = $debug_errors;

    $tVars["display"] = 'admin/debug/errors.tpl';

}
elseif ($user["cardinal"] && $GET["view"] == "errors404")
{

    $debug_errors = $db->getOne("debug_404_errors", "count(*) as nrl");
    $pages = new Paginator;
    $pages->items_total = $debug_errors["nrl"];
    $pages->items_per_page = 40;
    $pages->mid_range = 5;
    $pages->paginate();
    $db->pageLimit = $pages->items_per_page;

    $debug_errors = $db->join("users", "users.id = debug_404_errors.user_id", "LEFT OUTER")
        ->orderBy("created", "desc")
        ->paginate("debug_404_errors", $pages->current_page, "debug_404_errors.*, users.username");

    foreach ($debug_errors as & $debug_error) $debug_error["created"] = date("d/F/Y H:i:s", $debug_error["created"]);

    $tVars["debug_errors"] = $debug_errors;

    $tVars["display"] = 'admin/debug/404s.tpl';

}
elseif ($GET["view"] == "levelRewards" && $user["levelManager"])
{

    require("manageLevelRewards.php");

}
elseif ($GET["view"] == "hacker" && $user["manageUsers"] && ctype_digit($hacker = $GET["hid"]))
{

    require("manageUsers.php");

}
elseif ($GET['view'] == 'tasks' && $user["manageUsers"])
{
    require("tasksManagement.php");
}
elseif ($GET["view"] == "achievements" && $user["manageAchievements"])
{

    require("achievementManagement.php");

}
elseif ($user["auth_admin"] && $GET["view"] == "mesall")
{

    $aclass->mess_all();

    $smarty->assign("groups", $t);

    $tVars["display"] = 'admin/message_all.tpl';

}
elseif ($user["userList"] && $GET["view"] == "registered")
{

    $smarty->assign("players", $aclass->get_registered());

    $tVars["display"] = "admin/online_players.tpl";

}
elseif ($GET["view"] == "stats" && ($user["view_stats"] || $user["auth_admin"]))
{

    $aclass->getStatistics();

    $smarty->assign("data", $data);
    $smarty->assign("dd", $dd);

    $tVars["display"] = 'admin/stats/stats.tpl';

}
elseif ($user["admin_bar"])
{

    $tVars["display"] = "admin/dashboard.tpl";
}
else $cardinal->show_404();

?>
