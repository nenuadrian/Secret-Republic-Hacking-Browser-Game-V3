<?php

$achievements = $db->where("visibleInList = 1")->getOne("achievements", "count(*) nra");
$pages = new Paginator;
$pages->items_total = $achievements['nra'];
$pages->items_per_page = 20;
$pages->paginate();

if ($user['id'])
	$db->join("user_achievements ua", "ua.user_id = ".$user['id']." and ua.achievement_id = a.achievement_id", "left outer");
	$db->pageLimit = $pages->items_per_page;

$achievements = $db->where("visibleInList", 1)
	               ->orderBy("a.points", "desc")
	               ->paginate("achievements a", $pages->current_page);

$tVars['achievements'] = $achievements;
$tVars['display'] = "achievements/achievements.tpl";