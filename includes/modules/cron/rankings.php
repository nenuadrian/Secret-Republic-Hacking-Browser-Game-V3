<?php




$type = 'rankings';

$report = 'Rankings Cron '.date('d/F/Y H:i:s', $runTime);


// ORGANIZATIONS

$orgRankingsData = array();

$organizations = $db->join('org_zone_beginners ozb', 'ozb.org_id = o.id', 'left outer')
                    ->where('ozb.id is null')
                    ->orderBy('level', 'desc')
                    ->orderBy('exp', 'desc')
                    ->get('organizations o', null, 'level, exp, o.id');

foreach ($organizations as $key => $org)
{
  $orgRankingsData[$org['id']]['l'] = $org['level'];
  $orgRankingsData[$org['id']]['r'] = $key + 1;
}


$db->update('organizations', array('orank' => 0, 'points' => 0));


foreach ($orgRankingsData as $org_id => $o)
{
  $total = $o['l'];
  $db->where('id', $org_id)->update('organizations', array('points' => $total, 'orank' => $o['r']));
}

// USERS

$rankingsData = array();


// ACHIEVEMENTS
$achievements_data = $db->get('achievements');
$achievements = array();

foreach($achievements_data as $achievement)
  $achievements[$achievement['achievement_id']] = $achievement;

$user_achievements = $db->orderBy('user_id', 'asc')->get('user_achievements', null, 'user_id, times, achievement_id');
foreach($user_achievements as $ach)
  $rankingsData[$ach['user_id']]['a'] += $ach['times'] * $achievements[$ach['achievement_id']]['points'];

unset($user_achievements, $achievements);

// SKILLS
$skills = $db->where('level', array('>=' => 1))
             ->orderBy('uid', 'asc')
             ->get('skills', null, 'uid,skill, level');

foreach ($skills as $skill)
{
   $rankingsData[$ach['uid']]['s'] += ($theskills[$skill['skill']]['rankingRate'] * $skill['level'] * 2);
}

// users data
$users = $db->rawQuery('select
                        users.id,level,blogs, rep, zone, organization,
                        (select count(distinct(quests_user.quest)) from quests_user where user_id = users.id) nrQuestsDistinct,
                        (select count(quests_user.quest) from quests_user where user_id = users.id) nrQuests
                        from users
                        where username is not null
                        order by users.id asc;
                        ');
foreach ($users as $u)
{
    $levelPoints = $u['level'] * 4;
    $levelPoints += intval($u['level'] / 10) * 10;

    $questPoints = $u['nrQuestsDistinct'] * 4;
    $questPoints += (($u['nrQuests'] - $u['nrQuestsDistinct']) * 4) / 10;

    $repExtrasPoints = $u['rep'];
    $repExtrasPoints += $u['blogs'];


    if ($u['organization'])
    {
      $orgPoints = $orgRankingsData[$u['organization']]['l'] * 2;
      $rankingsData[$u['id']]['o'] = ($orgPoints);

    }

    $rankingsData[$u['id']]['l'] = ($orgPoints);
    $rankingsData[$u['id']]['l'] = ($levelPoints);
    $rankingsData[$u['id']]['q'] = ($questPoints);
    $rankingsData[$u['id']]['r'] = ($repExtrasPoints);
    $rankingsData[$u['id']]['z'] = $u['zone'];
}

$db->delete('rankings_stats');

// UPDATE USERS QUERY
  $insertRows = array();
  foreach ($rankingsData as $user_id => $u)
  {
    if (!$user_id) continue;

    $total = intval($u['a']) + intval($u['s']) + intval($u['q']) + intval($u['l']) + intval($u['r']) + intval($u['o']);
    $insertRows[] = '('.implode(",", array(intval($user_id), time(), intval($u['z']), intval($u['a']), intval($u['s']),
                                intval($u['q']), intval($u['l']), intval($u['r']),intval($u['o']), $total)).')';
  }
  $insertRows = 'INSERT INTO rankings_stats(user_id, created, zone, achievement_points, skill_points, quest_points, level_points, rep_extras_points, org_points, total_points) VALUES ' . implode(',', $insertRows);

  $db->rawQuery($insertRows);

  // users points update
  $users = $db->orderBy('total_points', 'desc')->get('rankings_stats', null, 'user_id, total_points, zone');
  $col1 = 'points = case id ';
  $col2 = '`rank` = case id ';
  $col3 = 'zrank = case id ';
  $perZoneRank = array();
  foreach($users as $rank => $u)
  {
    $rank++;

    $perZoneRank[$u['zone']]++;

      $col1 .= ' when '.$u['user_id'].' then '.$u['total_points'];
      $col2 .= ' when '.$u['user_id'].' then '.$rank;
      $col3 .= ' when '.$u['user_id'].' then '.$perZoneRank[$u['zone']];


  }

  $query = 'update users set '.$col1.' end, '.$col2.' end, '.$col3.' else 0 end';
  $db->rawQuery($query);

  $report .= sprintf('\nUpdated rankings of %s users', count($users));

$db->rawQuery('update zones set zones.points = (select sum(users.points) from users where users.zone = zones.id and users.level >= 3)');


/******
  HANDLE NO RANK GROUPS
*******/
$noRankGroups = $db->where('noRank', 1)->get('groups', null, 'group_id');
$noRankGroupsIds = array();
foreach ($noRankGroups as $g) $noRankGroupsIds[] = $g['group_id'];

$users = $db->where('group_id', $noRankGroupsIds, 'IN')
            ->get('user_credentials u',null,'uid');

foreach($users as $u)
  $db->where('id', $u['uid'])
     ->orWhere('username is null')
     ->update('users', array('zrank' => -1, 'rank' => -1));

  $report .= sprintf('\nUpdated %s no rank users', count($users));


$finish = array_sum(explode(' ', microtime()));
$report .= '\nGeneration time: '.  round(($finish - $cardinal->page_start), 6);

echo nl2br($report);
