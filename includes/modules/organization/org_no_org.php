<?php
  $canCreateOrganization = true;
  if ($user['money'] < $oclass->organizationCost)
    $canCreateOrganization = false;
  
  $mission = $db->where('q.id', $oclass->organizationQuest)
                ->join('quest_groups qg', 'qg.qgroup_id = q.qgroup_id', 'left outer')
                ->join('quests_user qu', 'q.id = qu.quest and qu.user_id = '.$user['id'], 'left outer')
                ->getOne('quests q', 'q.title, qu.created done, q.level, qg.name');
                
  if (!$mission['done'])
    $canCreateOrganization = false;
    
  if ($canCreateOrganization && $GET['view'] == 'create') 
  {
    $tVars['load'] = 'create';
    
    if ($_POST['name']) {
      
      $oclass->validate_and_create_org($_POST);
      
    } //$_POST['name']
        
  } //$GET['view'] == 'create'
  else
  {
	$availableOrgs = $db->where("allow_app", 1)->where('nrm < max_nrm')->getOne('organizations', 'count(*) nro');
	
	  $pages = new Paginator;
		$pages->items_total = $availableOrgs["nro"];
		$pages->paginate();
	  $db->pageLimit = $pages->items_per_page;

	$availableOrgs = $db->where("allow_app", 1)->where('nrm < max_nrm')->orderBy('nrm', 'asc')
    ->paginate('organizations', $pages->current_page, 'name, id, nrm, max_nrm, level');
	
	  
    $tVars['organizationMission'] = sprintf('[%s - %s (level %s)]%s', $mission['name'], $mission['title'], $mission['level'], $mission['done']?' (done)':''); 
    $tVars['canCreateOrganization'] = $canCreateOrganization; 
    $tVars['organizationCost'] = $oclass->organizationCost; 
    $tVars['availableOrgs'] = $availableOrgs; 
  }