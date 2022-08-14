<?php
//Rankings


$smarty->caching        = 1; // lifetime is per cache

/*$smarty->cache_lifetime = 2500;


if (!$_SESSION['detectDevice']['mobile']) {
  if (!$smarty->isCached('index/rankings.tpl')) {
    
    
    $rankings['topUsers'] = $db->where('rank', array(
      '>' => 0
    ))->orderBy('rank', 'asc')->get('users', 3, 'username, id,rank');
    $rankings['topOrgs']  = $db->where('orank', array(
      '>' => 0
    ))->orderBy('orank', 'asc')->get('organizations', 3, 'name, id, orank');
    $rankings['topBlogs'] = $db->where('rank', array(
      '>' => 0
    ))->orderBy('rank', 'asc')->get('blogs', 3, 'name, blog_id, rank');
    $rankings["config"]   = $config;
    $smarty->assign($rankings);
    
  }
  $tVars["rankings"] = $smarty->fetch("index/rankings.tpl");
}

*/
$smarty->cache_lifetime = 300;
/*
if (!$smarty->isCached('index/missionsSummary.tpl', $user['id'])) {
  
  $db->join('quests_user qu', 'qu.user_id = ' . $user['id'], 'left outer')->where('live_quests > 0 and hqg.type = 1')->where('hqg.level', $user['level'], '<=')->where('(hqg.qparent = 0 or (select id from quests_user qu where qu.user_id = ? and qu.quest = hqg.qparent limit 1) is not null)', array(
    $user['id']
  ))->groupBy('hqg.qgroup_id')->orderBy('gorder', 'asc');
  
  $groups   = $db->get('quest_groups hqg', 4, 'hqg.qgroup_id, hqg.name, live_quests nrQuests, (select count(distinct(quest)) from quests_user qu left outer join quests q on q.id = qu.quest where qu.user_id = ' . $user['id'] . ' and q.qgroup_id = hqg.qgroup_id and q.isLive = 1) questsDone');
  $groupIds = array();
  foreach ($groups as $key => $group) {
    $groupIds[] = $group['qgroup_id'];
    if ($group['nrQuests'] <= $group['questsDone']) {
      unset($groups[$key]);
      continue;
    }
    
  }
  
  if (count($groupIds)) {
    
    $db->join('quests_user qu', 'qu.user_id = ' . $user['id'] . ' and qu.quest = q.id', 'left outer')->join('quests_user qur', 'q.required_quest_id != 0 and qur.user_id = ' . $user['id'] . ' and qur.quest = q.required_quest_id', 'left outer')->where('qgroup_id in (' . implode(",", $groupIds) . ')')->where('isLive', 1)->where('(q.required_quest_id = 0 or qur.id is not null)')->where('q.type', 1)->where('? >= q.level ', array(
      $user['level']
    ));
    
    $db->groupBy('q.id');
    $db->orderBy('rand()');
    $dailies = $db->get('quests q', null, 'q.id, q.title, q.time, q.id, q.level, qu.last_done done, q.type ,qur.quest as qdone, party, q.qgroup_id');
    
    foreach ($dailies as $key => $daily)
      if (date('Ymd', $daily['done']) > date('Ymd', strtotime('yesterday')))
        unset($dailies[$key]);
    
    
  }
  
  $trainLog = $db->where("user_id", $user["id"])->where("created", array(
    ">" => (time() - $config['trainEvery'])
  ))->orderBy("created", "desc")->getOne("user_train_logs", "log_id, created");
  
  
  if (!$trainLog["log_id"])
    $templateVars2['can_train'] = true;
  
	$job = $uclass->getJob($user["id"], $config['timeBetweenJobs']);
             
    if (!$job["last_work"]) $templateVars2['can_work'] = true;
		
  $templateVars2['dailies'] = $dailies;
  $templateVars2['groups']  = $groups;
  $smarty->assign($templateVars2);
  
}
$tVars["missionsSummary"] = $smarty->fetch("index/missionsSummary.tpl", $user['id']);
*/


$smarty->cache_lifetime = 1;

if (!$smarty->isCached('index/latestArticlesAndForums.tpl', $user['id'])) {
  
  $latestArticlesAndForums["forums"] = $db->rawQuery('select id, title, fid, replies
                                                        from forum_posts
                                                        where parent is null and fid != 13 and fid!=7
                                                        order by created desc
                                                        limit 7');
  if ($user['organization'])
    $latestArticlesAndForums["orgForums"] = $db->rawQuery('select id, title, fid, replies
                                                        from org_forum_posts
                                                        where parent is null 
                                                        and org = ?
                                                        order by created desc
                                                        limit 7', array(
      $user['organization']
    ));

  $latestNews = $db->rawQuery('select id, title from forum_posts
                                                        where parent is null and (fid = 2)
                                                        order by created desc limit 1')[0];
  $latestEvent = $db->rawQuery('select id, title from forum_posts
                                                        where parent is null and (fid =11)
                                                        order by created desc limit 1')[0];

  $latestArticlesAndForums["articles"]   = $db->join('blogs b', 'b.blog_id = ba.blog_id', 'LEFT OUTER')->join('users u', 'u.id = b.user_id', 'LEFT OUTER')->orderBy('ba.created', 'desc')->orderBy('ba.votes', 'desc')->orderBy('ba.nrc', 'desc')->get('blog_articles ba', 7, 'title, nrc, article_id, b.blog_id, username, votes');
  $latestArticlesAndForums["latestNews"] = $latestNews;
  $latestArticlesAndForums["latestEvent"] = $latestEvent;
  $latestArticlesAndForums["user"]       = $user;
  $latestArticlesAndForums["config"]     = $config;
  $smarty->assign($latestArticlesAndForums);
}
$tVars["latestArticlesAndForums"] = $smarty->fetch("index/latestArticlesAndForums.tpl", $user['id']);

/*
$smarty->cache_lifetime = 300;

if (!$smarty->isCached('index/wars.tpl')) {
  
  $org_wars = $db->rawQuery('select ow.war_id, o1.name org1_name, o2.name org2_name 
	                           from org_wars ow
	                           left outer join organizations o1 on o1.id = org1_id
							   left outer join organizations o2 on o2.id = org2_id
							   order by rand()
							   limit 5;');
  
  $templateVars["org_wars"] = $org_wars;
  $templateVars["config"]   = $config;
  $smarty->assign($templateVars);
}
$tVars["wars"] = $smarty->fetch("index/wars.tpl");

*/
$smarty->caching = 0;

//$smarty->clearAllCache();
//TASKS
$ttypes                         = array(
  1 => 'Ability',
  2 => 'Mission',
  3 => 'Workbench',
  4 => 'Hackdown',
  5 => 'Org. hack',
  9 => 'Training',
  12 => 'Work',
  15 => 'Quest',
  18 => 'Beta Quest'
);
$tredirect                      = array(
  1 => 'abilities',
  2 => 'missions',
  3 => false,
  4 => 'hackdown',
  5 => 'organization/view/hackingPoints',
  9 => 'train',
  12 => 'job',
  15 => 'quests',
  18 => 'quests'
);
$tVars['tredirect'] = $tredirect;
if ($user['tasks']) {
  $tasks = $db->rawQuery('select id,type,name,start,totalSeconds, paused from `tasks` where uid=? order by start asc', array(
    $user['id']
  ));
  
  if (count($tasks)) {
    foreach ($tasks as &$task) {
      if (!$task['paused'])
        $taskclass->process_task_general($task);
      $task['ttype'] = $ttypes[$task['type']];
      
    } //$tasks as &$x
    
  } //count($tasks)
  else {
    $uclass->updatePlayer(array(
      "tasks" => 0
    ));
    $cardinal->redirect(URL_C);
  }
} //$user['tasks']
else
  $tasks = array();



if ($user['attacksInProgress']) {
  
  $attacks = $db->rawQuery('select attack_id, created, totalSeconds, sender, receiver, type, sender_user_id
	                          from attacks_inprogress ai 
							                where
	                          (sender = ? or receiver = ?)
							            and (type = 2 or type = 4 or ( (type = 3 or type = 1) and sender = ?))', array(
    $user['main_node'],
    $user['main_node'],
    $user['main_node'],
  ));

  foreach ($attacks as &$attack) {
    $attack['remainingSeconds'] = $attack['totalSeconds'] + $attack['created'] - time();
  }
  
  $tVars['attacks'] = $attacks;
  
} // attacksInProgress



$userNodes = $db->where('user_id', $user['id'])->orderBy('zone_id')->get('zone_grid_cluster_nodes');
$changeNode = submitted_form("change_main_node") ? true : false;
foreach($userNodes as &$node)
{
  $node['location'] = $node['zone_id'].':'.$node['cluster'].':'.$node['node'];
  if ($changeNode && $_POST['node'] == $node['zone_grid_cluster_nodes_id'])
  {
    $uclass->updatePlayer(array('main_node' => $node['location']));
    $cardinal->redirect(URL_C);
  }
}
$tVars['userNodes'] = $userNodes;
$tVars['tasks'] = $tasks;

$tVars["theTime"] = date("H:i", time());
$tVars['display'] = 'index/index.tpl';
