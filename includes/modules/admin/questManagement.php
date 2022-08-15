<?php
/**

*/

if ($GET["qid"])
  if ($user["globalQuestManager"])
    $quest = $db->where("id", $GET["qid"])->getOne("quests");
  else
    $quest = $db->where("id", $GET["qid"])->where("creatorid", $user["id"])->where("isLocked", 0)->getOne("quests");


function validateGroupPost($creator_user_id = false)
{
	global $errors, $user;
	if (strlen($_POST['name']) < 3 || strlen($_POST['name']) > 50)
		$errors[] = "Name must have between 3 and 50 characters";


	if (!count($errors))
	{
		$data = array(
			"name" => htmlentities($_POST['name']),
			"level" => intval($_POST['level']),
			"qparent" => $_POST['qparent'],
			"gorder" => $_POST['gorder'],

		);
		if ($creator_user_id) $data['creator_user_id'] = $creator_user_id;

		return $data;
	}

	return false;
}
function validateQuestPost()
{
	return $quest;
}
if ($quest["id"]) {


  if ($_POST['creatorsNotepad'])
  {
	  $db->where('id', $quest['id'])->update('quests', array('creatorsNotepad' => $_POST['creatorsNotepad']));
	  $cardinal->redirect(URL_C);
  }

  switch ($GET["load"]) {
    case 'stats':
      $stats = $db->where('quest', $quest['id'])
                  ->getOne('quests_user qu', 'sum(times) finished, count(id) uniq');

	  $feedback = $db->where('quest_id', $quest['id'])->getOne('quests_feedback', 'count(*) nrf');

	  $pages                 = new Paginator;
      $pages->items_total    = $feedback['nrf'];
      $pages->paginate();
      $db->pageLimit = $pages->items_per_page;

	  $feedback = $db->join('users u', 'u.id = qf.user_id', 'left outer')
		             ->where('quest_id', $quest['id'])
		             ->paginate('quests_feedback qf', $pages->current_page, 'qf.*, u.username');

	  $tVars['feedback'] = $feedback;
      $tVars['stats'] = $stats;
    break;
    case "objectives":
      $tVars["achievements"] = $db->get("achievements");
      $aclass->objectives($quest);

      $aclass->sideObjectives($quest);
    break;
    case "hosts":
      $aclass->hosts($quest);

      $aclass->host_services($quest);

      $aclass->host_services_manage($quest);
      break;
    default:

      // update quest main data
      if ($_POST["updateQuest"]) {
        $dbColumns = array_keys($quest);
        foreach ($_POST as $key => $value)
          if (in_array($key, $dbColumns))
            $data[$key] = $value;

        $db->where("id", $quest["id"])->update("quests", $data);


        $cardinal->redirect(URL_C);
      } //$_POST["updateQuest"]
      $tVars["achievements"] = $db->get("achievements");

      $tVars["quests"] = $db->where('id', $quest['id'], '!=')->get("quests", null, 'title, id');
      $tVars["groups"] = $db->get("quest_groups", null, 'name, qgroup_id');
  } //$GET["load"]

  //$aclass->files($quest);


  $tVars["quest"] = $quest;


  $tVars["display"] = 'admin/quests/quest_manage.tpl';

  // no specific quest
} //$quest["id"]
elseif ($GET['tree'])
{
	function displayTree($tree)
	{
		foreach($tree as $group)
		{
			if (count($group['quests'])){
			echo sprintf('
			<div class="panel panel-glass">
		<div class="panel-heading"><a href="'.URL.'admin/view/manageQuest/group/'.$group['qgroup_id'].'" target="_blank">%s</a></div>
	<div class="panel-body">', $group['name']);

		foreach ($group['quests'] as $quest)
		{
			echo '
		<a href="'.URL.'admin/view/manageQuest/qid/'.$quest['id'].'" target="_blank"><button class="mb10">'.$quest['title'].'</button></a>';
			if (count($quest['groups']))
			{
				echo'
		<div style="padding:20px">';

			displayTree($quest['groups']);
			echo '
		</div>';
			}
		}

			echo'
	</div>
	</div>';
		}
		}
	}
	function createTree(&$tree)
	{
		global $db;

		foreach ($tree as &$node)
		{
			$node['quests'] = $db->rawQuery('select * from quests where qgroup_id = ? order by qgroup_order asc', array($node['qgroup_id']));

			foreach($node['quests'] as &$quest)
			{
				$quest['groups'] =  $db->rawQuery('select * from quest_groups where type =1 and qparent = ? order by gorder asc', array($quest['id']));
				//echo $quest['id']."<br/>";
				createTree($quest['groups']);
			}
		}
	}
	$tree = $db->rawQuery('select * from quest_groups where qparent = 0 and type = 1 order by gorder asc');
	createTree($tree);

	$tVars['tree'] = $tree;
	$tVars['display'] = 'admin/quests/questsTree.tpl';
}
elseif ($group_id = $GET['group'])
  {
	  if ($group_id == "create")
	  {
		  if ($_POST) {

			$dataInsert = validateGroupPost();
			  $dataInsert['creator_user_id'] = $user['id'];
			if ($group_id = $db->insert("quest_groups", $dataInsert))
			{
				$_SESSION["success"] = "Group has been created";
				$cardinal->redirect(URL."admin/view/manageQuest/group/" . $group_id);
			}
		  } // create group
	  }
	  else
	  {
		  $db->join('quests q', 'q.qgroup_id = qg.qgroup_id', 'left outer');
		  $db->where('qg.qgroup_id', $group_id);

		  if (!$user['globalQuestManager']) $db->where('qg.creator_user_id', $user['id']);

		  $group = $db->getOne('quest_groups qg', 'qg.*, q.id quest_id');

		  if (!$group['qgroup_id']) $cardinal->redirect(URL."view/admin/view/manageQuest");

		  if (!$group['quest_id'])
			  $group['can_delete'] = true;

		  if ($_POST["delete"] &&  $group['can_delete']) {
				$db->where("qgroup_id", $group_id)->delete("quest_groups");
				$success = "Group has been deleted";

			  	$cardinal->redirect(URL.'admin/view/manageQuest');
			} //$_POST["delete"]
			else if ($_POST)
			  if ($updateData = validateGroupPost())
			  {
			  	$db->where("qgroup_id", $group_id)->update("quest_groups", $updateData);
			  	$success = "Group has been updated";
			  	$cardinal->redirect(URL_C);
			  }

	  }
	  $tVars['quests'] = $db->where('qgroup_id != ?',array($group_id))->get('quests', null, 'title, id');
	  $tVars['group'] = $group;
	  $tVars['display'] = "admin/quests/questGroupCreate.tpl";
}
else
{

  if ($group = $_POST["qgroup_id"]) {

    if ($_POST["title"]) {
      $qID = $db->insert("quests", array(
        "title" => htmlentities($_POST["title"]),
        "creatorid" => $user["id"],
        "creator_name" => $user["username"],
        "qgroup_id" => $group
      ));
      if ($qID) {
        $_SESSION["success"] = "Added";
        $hostID              = $db->insert("quest_hosts", array(
          "qid" => $qID
        ));
        $serviceID           = $db->insert("quest_services", array(
          "hid" => $hostID
        ));

        $cardinal->redirect(URL . "admin/view/manageQuest/qid/" . $qID);
      } //$qID
      else
        $errors[] = "Something went wrong";
    } // add quest
  } // group input sent


  if ($quest = $_POST["quest"]) {
    $quest = $db->where("id", $quest)->getOne("quests", "isLocked, title, isLive, id,creatorid");
    if ($quest["id"]) {
      if ($_POST["del"] && ($user["globalQuestManager"] || ($user["id"] == $quest["creatorid"] && !$quest["isLocked"]))) {
        $db->where("id", $quest["id"])->delete("quests");
        $_SESSION["success"] = "Deleted";
        $cardinal->redirect(URL_C);
      } //$_POST["del"] && ($user["globalQuestManager"] || ($user["id"] == $quest["creatorid"] && !$quest["isLocked"]))
      elseif ($user["globalQuestManager"]) {
        $success = "Done";
        if ($_POST["isLive"]) {
		  $quest["isLive"] = $quest["isLive"] ? 0 : 1;
          $db->where("id", $quest["id"])->update("quests", array(
            "isLive" => $quest["isLive"]
          ));

          if ($user["id"] != $quest["creatorid"])
          {
            if ($quest["isLive"])
            {
              $title = 'Quest made live';
              $message = "Hello,\n\nI have added to the live mission list your quest: " . $quest["title"] . "\n\nAll regards," . $user["username"];
            }
            else
            {
              $title = 'Quest unlive';
              $message = "Hello,\n\nI have removed from the live missions your quest: " . $quest["title"] . "\n\nAll regards," . $user["username"];
            }
            $uclass->send_msg($user["id"], $quest["creatorid"], $message, $title);
          }
        } //$_POST["isLive"]
        elseif ($_POST["isLocked"]) {
          $db->where("id", $quest["id"])->update("quests", array(
            "isLocked" => $quest["isLocked"] ? 0 : 1
          ));

        } //$_POST["isLocked"]
      } //$user["globalQuestManager"]
    } //$quest["id"]
  } // quest input

$groups = $db->rawQuery(sprintf(
	                      "select hqg.*,
                          (select count(*) from quests q where q.qgroup_id = hqg.qgroup_id) nrQuests ,
                          (select count(*) from quests qq where qq.qgroup_id = hqg.qgroup_id and isLive = 1) nrQuestsLive
                          from quest_groups as hqg
						  %s
                          group by hqg.qgroup_id order by type desc, gorder asc",
  						  $user['miniQuestManager'] ? "where hqg.creator_user_id = ".$user['id'] : ""));

  if ($user['miniQuestManager'])
  	$db->where("creatorid", $user['id']);

  $db->orderBy("qgroup_order", "asc");
  $quests                      = $db->get("quests q", null, "q.*");
  $tVars["quests"] = $quests;

  $tVars["groups"] = $groups;


  $tVars["display"] = 'admin/quests/questList.tpl';
}
