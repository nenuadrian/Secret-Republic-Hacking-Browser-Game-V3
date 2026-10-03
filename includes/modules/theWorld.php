<?php



$page_title = "World Timeline";

$smarty->caching = 1; // lifetime is per cache
$smarty->cache_lifetime = 1800;

if(!$smarty->isCached('theWorld/worldGrid.tpl')) {

  $timeSinceBorn = time() - $config["worldBirth"];

  $stats = $db->rawQuery('select
            (select count(*) from users)  nrHackers,
            (select count(*) from organizations)  nrOrgs,
            (select count(*) from blogs)  nrBlogs,
            (select count(*) from blog_articles)  nrArticles,
            (select count(*) from attack_logs )  nrAttackLogs,
            (select count(*) from conversations)  nrEmails,
            (select count(*) from forum_posts)  nrForumPosts,
            (select sum(lifelongDataPoints) from users)  nrDataPoints,
            (select count(*) from friendships)  nrFriends,
            (select count(*) from org_ended_wars)  endedOrgWars,
            (select count(*) from org_wars)  inprogressOrgWars,
            (select count(*) from quests where isLive = 1)  liveQuests ,
            (select sum(level) from users)  levelSum,
            (select sum(level) from skills)  skillSum,
            (select sum(times) from user_achievements)  nrAchievements,
            (select count(*) from friendships)  nrFriends,
            (select count(*) from servers)  nrServers,
            (select count(*) from quests_user)  nrCompletedQuests,
            (select count(*) from user_social_connect)  nrSocialAccounts,
            (select count(*) from users where createdAt >= ?)  nr24hRegistered,
            (select count(*) from tasks where (start + totalSeconds) >= ?)  nrTasks,
            (select count(*) from users where lastActive >= ?)  nrOnlineLately,
            (select sum(login_count) from user_credentials )  nrLogins
            ', array(time()-24*60*60, time(), time()-48*60*60))[0];
  $leftSide = $rightSide = array();

  $leftSide [] = array('value' => number_format($stats['nrHackers']) . " && " . number_format($stats['nrOrgs']), 'title' => 'Hackers && Organizations', 'description' => 'are fighting for Grid supremacy.');
  $leftSide [] = array('value' => number_format($stats['nrSocialAccounts']), 'title' => 'Accounts', 'description' => 'connected via Social Networks.');
  $leftSide [] = array('value' => number_format($stats['nrAchievements']), 'title' => 'Achievements', 'description' => 'have been earned by hackers.');
  $leftSide [] = array('value' => number_format($stats['liveQuests']), 'title' => 'Missions', 'description' => 'are publicly available.');
  $leftSide [] = array('value' => number_format($stats['nrBlogs']), 'title' => 'Blogs', 'description' => 'have been created.');
  $leftSide [] = array('value' => number_format($stats['nrArticles']) . " && " . number_format($stats['nrForumPosts']), 'title' => 'Articles && Forum Posts', 'description' => 'published.');
  $leftSide [] = array('value' => number_format($stats['levelSum']), 'title' => 'Level Sum', 'description' => 'of all hackers.');
  $leftSide [] = array('value' => number_format($stats['nrAttackLogs']), 'title' => 'Spy/Attack/Scavenge logs', 'description' => 'stored in database.');
  $leftSide [] = array('value' => number_format($stats['skillSum']), 'title' => 'Level Sum', 'description' => 'of everyones skills.');

	  $rightSide [] = array('value' => number_format($stats['nr24hRegistered']) . " && ".number_format($stats['nrOnlineLately']), 'title' => 'Hackers', 'description' => 'joined && online in the last 24h.');
  $rightSide [] = array('value' => number_format($stats['nrLogins']), 'title' => 'Authentications', 'description' => 'by hackers since the competition has begun.');

  $rightSide [] = array('value' => number_format($stats['nrEmails']), 'title' => 'Messages', 'description' => 'stored in our the Alpha database.');
  $rightSide [] = array('value' => number_format($stats['nrFriends']), 'title' => 'Friendships', 'description' => 'made amongst a sea of enemies.');
  $rightSide [] = array('value' => number_format($stats['nrDataPoints'], 2), 'title' => 'Data Points', 'description' => 'mined by all hackers.');
  $rightSide [] = array('value' => number_format($stats['nrServers']), 'title' => 'Servers', 'description' => 'owned by hackers.');
  $rightSide [] = array('value' => number_format($stats['nrCompletedQuests']), 'title' => 'Finished Missions', 'description' => 'logs for normal, daily and repeatable missions.');
  $rightSide [] = array('value' => number_format($stats['nrTasks']), 'title' => 'Tasks', 'description' => 'in progress.');
  $rightSide [] = array('value' => number_format($stats['endedOrgWars']) . " && ". number_format($stats['inprogressOrgWars']), 'title' => 'Organization Wars', 'description' => 'Ended && in progress.');

  $tVars2['stats'] = $stats;
  $tVars2['leftSide'] = $leftSide;
  $tVars2['rightSide'] = $rightSide;
  $tVars2['config'] = $config;

	$skills = array();
	foreach ($theskills as $skill => $data)
	{
		$skills[] = array('skill_id' => $skill,
					   	  "name" => $data['name'],
						  'avg' => $db->rawQuery('select avg(s.level) level from skills s
						                          left outer join users u on u.id = uid
												  where skill = ? and u.level >= 3', array($skill))
					   );
	}
	$tVars2['skills'] = $skills;
  $smarty->assign($tVars2);
}
$tVars["theTime"]    = date("H:i", time());
$tVars["worldGrid"] = $smarty->fetch("theWorld/worldGrid.tpl");
$smarty->caching = 0;
$tVars["display"] = "theWorld/theWorld.tpl";


?>
