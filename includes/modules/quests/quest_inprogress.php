<?php
if ($GET['history'])
{

    if (!$_SESSION['premium']['consoleHistory']) $errors[] = "You need to <a href='" . URL . "alpha_coins/option/consoleHistory'>activate the Console History</a> before using it. You will gain access to your full history and in case of party missions you will be able to view the history of all participants.";
    else
    {
        if ($_POST['participant']) $cardinal->redirect(URL . 'quests/history/show/participant/' . $_POST['participant']);

        $currentParticipant = $GET['participant'] ? $GET['participant'] : $user['id'];

        $db->where('user_id', $currentParticipant);

        if ($qtask['instance_id']) $db->where('instance_id', $qtask['instance_id']);
        else $db->where('qch.task_id', $qtask['id']);
        $history = $db->getOne('quest_console_history qch', 'count(*) nrh');

        $pages = new Paginator;
        $pages->items_total = $history["nrh"];
        $pages->paginate();

        $db->where('user_id', $currentParticipant);

        if ($qtask['instance_id']) $db->where('instance_id', $qtask['instance_id']);
        else $db->where('qch.task_id', $qtask['id']);

        $db->orderBy('created', 'desc');
        $db->pageLimit = $pages->items_per_page;

        $history = $db->paginate('quest_console_history qch', $pages->current_page, 'qch.*');

        $tVars['currentParticipant'] = $currentParticipant;
        $tVars['history'] = $history;
    }
    if ($qtask['instance_id'])
    {
        $participants = $db->where('in_party', $user['in_party'])->get('users', null, 'username, id');

        $tVars['participants'] = $participants;
    }
    $tVars["display"] = 'quests/quest_console_history.tpl';
}
else
{
    // has user just finished working? Give him a juicy reward
    if ($qtask["type"] == 15 && $qclass->finished)
    {

        $success[] = "Mission completed";

        $quest = $db->join('quests_user qu', 'qu.quest = q.id and qu.user_id = ' . $user['id'], 'left outer')->where("q.id", $qclass->questTask["questID"])
            ->getOne("quests q", "qu.id qu_id, type, money, experience, achievement_id, skillPoints, qu.created as done, times");

        $giveRewards = true;

        if ($quest['type'] == 2 && $quest['done']) $giveRewards = false;

        // is it repeatable? if yes => no rewards => no log of doing the quest
        if ($giveRewards)
        {
            if ($user['organization'])
            {
                // give a hacking point to org
                require ("../includes/class/oclass.php");
                $oclass = new Organization();
                $hackingPoints = 1;
                $oclass->addHackingPoints($hackingPoints, $user['organization'], $user['id'], $qclass->finished);

            } //$user['organization']
            $achievements = array();

            if (isset($qclass->questData["rewards"]["achievements"])) $achievements = $qclass->questData["rewards"]["achievements"];

            if ($quest["achievement_id"]) $achievements[] = $quest["achievement_id"];

            $reward["money"] = $quest["money"] ? $quest["money"] : 30;
            $reward["skillPoints"] = $quest["skillPoints"] ? $quest["skillPoints"] : 3;

            $reward["exp"] = $quest["experience"];
            $reward["achievements"] = $achievements;
            $reward["task"] = $qclass->questTask["type"];

            if ($user['in_party'])
            {
                $participants = $db->where('in_party', $user['in_party'])->get('users', null, 'id');
                foreach ($participants as $participant) $uclass->addReward($participant["id"], $reward, $qclass->questTask["name"]);
            } //$user['in_party']
            else $uclass->addReward($user["id"], $reward, $qclass->questTask["name"]);

        } //$giveRewards
        if ($qclass->questTask['instance_id'])
        {
            $db->where('instance_id', $qclass->questTask['instance_id'])
                ->delete('party_quest_instances');
        } //$qclass->questTask['instance_id']
        if ($quest['done'])
        {
            $db->rawQuery('update quests_user set last_done = ?, times = ? where id = ? limit 1;', array(
                time() ,
                $quest['times'] + 1,
                $quest['qu_id']
            ));
        } //$quest['done']
        else
        {
            $insertData = array(
                "quest" => $qclass->questTask["questID"],
                "user_id" => $user["id"],
                "created" => time() ,
                "last_done" => time()
            );
            if (count($participants))
            {
                foreach ($participants as $participant)
                {
                    $insertData['user_id'] = $participant['id'];
                    $quest_user_id = $db->insert("quests_user", $insertData);

                    // feedback session
                    $title = "Feedback: " . $qclass->questTask['name'];
                    $message = "Please leave us your feedback for this mission @ " . URL . "quests/feedback/" . $quest_user_id;
                    $uclass->send_msg(-1, $participant['id'], $message, $title);

                } //$participants as $participant
                
            } //count($participants)
            else
            {
                $quest_user_id = $db->insert("quests_user", $insertData);

                // feedback session
                $title = "Feedback: " . $qclass->questTask['name'];
                $message = "[URL=" . URL . "quests/feedback/" . $quest_user_id . "]Please leave us your feedback for this mission[/URL].";
                $uclass->send_msg(-1, $user['id'], $message, $title);
            }
        }

    } //$qtask["type"] == 15 && $qclass->finished
    $tVars["qtask"] = $qtask;
    $tVars['showPartyChat'] = true;
    $tVars["display"] = 'quests/quest_play.tpl';

}

