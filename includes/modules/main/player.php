<?php
$smarty->caching        = 1; // lifetime is per cache

$smarty->cache_lifetime = 300;


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
