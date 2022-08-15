<?php

class OrganizationEntity extends Alpha
{
  var $data;
  var $perms;
  var $permissions = array('viewMembers', 'manageMembers', 'manageRanks', 'manageOrganization', 'messageAll', 'manageApplications', 'manageWars', 'forumManager', 'manageHackingPoints');

  function __construct($organizationID)
  {
     parent::__construct();
     $this->data = $this->db->join('users hu', 'hu.id = ho.owner', 'LEFT OUTER')
                            ->where('ho.id', $organizationID)
                            ->getOne('organizations ho', 'ho.* ,hu.username ownern,hu.zone ownerz');

    $this->processOrganizationData();
  }

  function processOrganizationData()
  {
    if (logged_in())
    {
      // is the organization the user's organization or is the user a cardinal administrator?
      if ($this->user['organization'] == $this->data['id'] || $this->user['cardinal']) {
        $this->data['myOrg'] = true;

        $this->generateMemberPermissions();
      } //$this->user['organization'] == $this->organization['id']
    }
  }

  //GENERATE PERMISSIONS
  function generateMemberPermissions()
  {

    $owner = $this->data['owner'] == $this->user['id'] || $this->user['cardinal'];

    if (!$owner)
      $this->db->where('rank_id', $this->user['org_group']);
    else
      $this->db->where('owner_rank', 1);

    $this->perms = $this->db->where('org_id', $this->data['id'])->getOne('org_ranks');
    $this->perms['owner'] = $owner;

    foreach ($this->permissions as $p)
      $this->perms[$p] = $this->perms['owner'] ? true : $this->perms[$p];

  } // generateMemberPermissions
}
class Organization extends Alpha
{

  var $organization;
  var $perms;
  var $permissions = array('viewMembers', 'manageMembers', 'manageRanks', 'manageOrganization', 'messageAll', 'manageApplications', 'manageWars', 'forumManager', 'manageHackingPoints');
  var $permissionNames = array('View members', 'Manage members', 'Manage ranks', 'Edit organization', 'Message all', 'Manage Applications', 'Manage wars', 'Manage forum', 'Manage Hacking Points (upgrade org.)');
  var $requestExpireTime = 1;
  var $organizationQuest = 39;
  var $forced_request_hp_cost = 100;
  var $nameChangeHpCost = 2;
  var $organizationCost = 100;

  function Organization($organizationID = null)
  {

    parent::__construct();

    if (isset($organizationID)) {
      // get organization data from database

      $org = new OrganizationEntity($organizationID);
      $this->perms = $org->perms;
      $this->organization = $org->data;
    } //isset($organizationID)
  }

  function validataOrgName($orgName, $checkExistance = true) {
    if (!isset($orgName[3]) || isset($orgName[50])) add_alert('Name must have between 4 and 50 characters');
    if ($checkExistance) {
      $checkIfNameTaken = $this->db->where('name', $orgName)->getOne('organizations', 'id')['id'];
      if ($checkIfNameTaken) add_alert('The name you have picked is already in use');
    }
  }

  function validate_and_create_org($org)
  {
    $this->validataOrgName($org['name']);
    $this->validateTag($_POST['tag']);

    if (there_are_errors()) return;

    $insertData = array(
      'name' => $org['name'],
      'tag' => $_POST['tag'],
      'created' => time(),
      'owner' => $this->user['id'],
	    'expNext' => $this->levelExperience(1)
    );
    $org_id = $this->db->insert('organizations', $insertData);
    if (!$org_id)
    {
      $this->errors[] = "An error took place";
      return;
    }

    $insertData    = array(
      'name' => 'Owner',
      'created' => time(),
      'owner_rank' => 1,
      'org_id' => $org_id
    );
    $owner_rank_id = $this->db->insert('org_ranks', $insertData);

    $insertData = array(
      'name' => 'Members',
      'created' => time(),
      'default_rank' => 1,
      'org_id' => $org_id
    );
    $this->db->insert('org_ranks', $insertData);

    $this->uclass->updatePlayer(array("org_group" => $owner_rank_id, "organization" => $org_id, "money" => $this->user['money'] - $this->organizationCost));
    $this->deletePastApplications($this->user['id']);

    $this->redirect(URL . 'organization');



  }

  function get_members($page = null, $notMyself = false)
  {
    $this->db->join('org_ranks', 'org_ranks.rank_id = u.org_group', 'left outer')
             ->where('u.organization', $this->organization['id'])
		     ->orderBy('org_ranks.owner_rank', 'desc')
		     ->orderBy('org_ranks.rank_order', 'asc')
             ->orderBy('u.level', 'desc');
    if ($notMyself)
      $this->db->where('u.id', $this->user['id'], '!=');

    if ($page) {
      $db->pageLimit = 15;
      $members = $this->db->paginate('users u', $page, 
        'id,username, gavatar, lastActive, org_group,zone,level,rank, zrank, org_ranks.name, org_ranks.owner_rank owner');
    } else {
      $members = $this->db->get('users u', null, 
        'id,username, gavatar, lastActive, org_group,zone,level,rank, zrank, org_ranks.name, org_ranks.owner_rank owner');
    }
    return $members;
  }


  function post_intros()
  {
    global $success, $error;

    $checkPost = array(
      'intro',
      'memb_intro',
      'app_intro'
    );

    $parser = new \JBBCode\Parser();
    $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());


	  $updateOrg = array();
    foreach ($checkPost as $check)
      if ($_POST[$check]) {
        if (($length = strlen($_POST[$check])) <= 1000) {
          $parser->parse($_POST[$check]);

          $this->organization[$check] = $updateOrg[$check] = $parser->getAsHtml();
          $updateOrg[$check . '_unparsed'] = $_POST[$check];

          $success = $lang['modifications_saved'];
        } //($length = strlen($_POST[$check])) <= 1000
        else
          $error = 'Content must have less than 1000 characters. You have used ' . $length . ' chars';
      } //$_POST[$check]

    if (count($updateOrg))
      $this->updateOrganization($updateOrg);
  }

  function validateTag($tag)
  {
    if (strlen($tag) < 1 || strlen($tag) > 4 || !ctype_alnum($tag))
      $this->errors[] = "TAG must be Alphanumeric and have between 1 and 4 characters";
  }
  function post_cname()
  {

    $this->validataOrgName($_POST['name']);
    $this->validateTag($_POST['tag']);

    if ($_POST['name'] == $this->organization['name'] && $_POST['tag'] == $this->organization['tag'])
      $this->errors[] = "No changes made";

    if(there_are_errors()) return;

    $updateData = array( 'name' => htmlentities($_POST['name']),
					               'tag' => ($_POST['tag']),
                         'hacking_points' => $this->organization['hacking_points'] - $this->nameChangeHpCost
                      );
    $this->updateOrganization($updateData);

    $this->success = 'Details have been updated';
    $this->redirect($this->url);

  }

  function isRankNameInvalid($rankName)
  {
    if (strlen($rankName) <= 15 && strlen($rankName) >= 3) {
      return false;
    } //strlen($rankName) <= 15 && strlen($rankName) >= 3
    else
      return 'Rank name must have between 3 and 15 chars.';
  }


  function updateMemberRank($user_id, $newRank)
  {
    $this->db->where('id', $user_id)->where('organization', $this->organization['id'])->update('users', array(
      'org_group' => $newRank
    ));
  }

  function disband_org()
  {
    $this->db->where('id', $this->user['organization'])->delete('organizations', 1);

    $this->uclass->update_user('org_group=0,organization=0', $this->user['id'], false);
    $this->redirect(URL . 'organization');
  }






  function update_org($update, $id)
  {
    $this->db->rawQuery('update organizations set '.$update.' where id=? limit 1;', array($id));

  }

  function updateOrganization($updateData, $org_id = false)
  {
	if (!$org_id) $org_id = $this->organization['id'];
	if (!$org_id) return false;
    $this->db->where('id', $org_id)->update('organizations', $updateData);
    $this->organization = array_merge($this->organization, $updateData);
  }



  function validate_send_app($content = false, $sendNotification = true, $user_id)
  {
    if (strlen($content) >= 20 && strlen($content) <= $this->config['org_application_size']) {
      $parser = new \JBBCode\Parser();
      $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
      $parser->parse($content);
      $content = $parser->getAsHtml();
      $insertData = array(
        'user_id' => $user_id,
        'created' => time(),
        'content' => $content,
        'org_id' => $this->organization['id']
      );

      if ($appID = $this->db->insert('org_applications', $insertData)) {

        if ($sendNotification)
        {
          // fetch ranks whitch can administrate applications and send users a notice
          $ranks = $this->db->rawQuery('select rank_id from org_ranks where
                                            org_id = ? and (owner_rank = 1 or manageApplications = 1)', array(
            $this->organization['id']
          ));

          $ranksArray = array();
          foreach ($ranks as $rank)
            $ranksArray[] = $rank['rank_id'];

          $message = 'New application to join ' . $this->organization['name'] . ' received.';
          $title   = 'New org. application';
          $this->sendMessageToRanks($ranksArray, $message, $title);
        }
        return $appID;
      } //$this->db->insert('org_applications', $insertData)

    } //strlen($_POST['content']) >= 20 && strlen($_POST['content']) <= $this->config['org_application_size']
    else
      add_alert('Content have between 20 and ' . $this->config['org_application_size'] . ' chars');

    return false;
  }


  function manageApplications()
  {
     if ($this->organization['max_nrm'] <= $this->organization['nrm'])
     {
      $this->warnings[] = 'Current maximum number of members reached. You can only decline applications.';
      $onlyDecline = true;
     }
    if ($this->organization['applications']) {
      if ($_POST['answer']) {

        $app = $this->db->join('users', 'users.id = user_id', 'left outer')
                        ->where('op.id', $_POST['answer'])
                        ->where('org_id', $this->organization['id'])->getOne('org_applications op', 'op.*, username');

        if ($app['id'])
        {
          if ($_POST['accept'] && !$onlyDecline) {
            $this->accept_application($app);
            $this->success[] = 'Application accepted';
          } //$_POST['accept']
          else {
            $this->decline_application($app);
            $this->success[] = 'Application declined';
          } //$app['id']

        }
      } //$_POST['answer'] == $app['id']
        $apps = $this->db->where('org_id', $this->organization['id'])->getOne('org_applications', 'count(*) nra');

        $this->pages = new Paginator;
        $this->pages->items_total = $apps["nra"];
        $this->pages->items_per_page = 20;
        $this->pages->paginate();

        $apps = $this->db->rawQuery('select oa.*, u.username, u.zone userz, u.rank wrank, u.gavatar
                                     from org_applications oa
                                     left outer join users u on u.id = oa.user_id
                                     where org_id = ? order by created desc ' . $this->pages->limit,
                                     array($this->organization['id']));


        foreach ($apps as $k => &$app) {
          $app['created']    = date_fashion($app['created']);
        } // foreach

      $this->templateVariables['onlyDecline'] = $onlyDecline;
      $this->templateVariables['apps'] = $apps;
    } // if apps
  }
  function accept_application(&$app, $sendNoticeToEveryone = true)
  {
    //ADD NEW MEMBER
    $default_rank = $this->db->where('org_id', $this->organization['id'])->where('default_rank', 1)->getOne('org_ranks', 'rank_id');
    if (!$default_rank['rank_id']) { $this->errors[] = "Could not find organization default rank"; return false;}


	$this->uclass->updatePlayer(array('organization' => $this->organization['id'], 'org_group' => $default_rank['rank_id']), $app['user_id']);


    $this->updateOrganization(array(
      'nrm' => $this->organization['nrm'] + 1
    ));
	// members logs
	$memberLog = array('joined_date' => time(), 'user_id' => $app['user_id'], 'org_id' => $this->organization['id']);
    $this->db->insert('organization_members_logs', $memberLog);

    $this->deletePastApplications($app['user_id']);

	$msg = 'Congratulations are in order, ' . $app['username'] . ",\n\nYou have met the required criteria and your request to join " . $this->organization['name'] . ' has been approved! If you applied for any other organization, your applications have been deleted by the Cardinal Mainframe.';

    $this->uclass->send_msg(-2, $app['user_id'], $msg, 'Application accepted');

	//SEND ACCEPTANCE MSG TO ALL MEMBERS
    if ($sendNoticeToEveryone)
    {
      $msg = $app['username'] . ' has joined our organization. Welcome to ' . $this->organization['name'] . '!';

      $this->sendMessageToEveryone($msg, 'New member: ' . $app['username']);
    }


  }

  function decline_application(&$app)
  {
    //SEND DECLINEMENT MSG
    $msg = 'We bear bad news, ' . $app['username'] . ',\n\nYour application to join ' . $this->organization['name'] . ' has been mercilessly declined.';

    $this->uclass->send_msg(-2, $app['user_id'], $msg, 'Application rejected');
    $this->deletePastApplications($app['user_id'], true);
  }

  function deletePastApplications($user_id, $onlyForThisOrg = false)
  {
	  if ($onlyForThisOrg) $this->db->where('org_id', $this->organization['id']);
	  $this->db->where('user_id', $user_id);
      $this->db->delete('org_applications');
      $this->organization['applications']--;
  }


  function kickMember($member, $quit = false, $reason = false, $sendNoticeToEveryone = true)
  {

    $this->uclass->updatePlayer(array(
      'organization' => 0,
      'org_group' => 0
    ), $member['id']);

	$memberLog = $this->db->where('user_id', $member['id'])
		                  ->where('org_id', $this->organization['id'])
		                  ->where('left_date is null')
						  ->getOne('organization_members_logs', 'log_id');
	$memberLog['left_date'] = time();

    if (!$quit)
    {
      $msg = 'Sorry ' . $member['username'] . ', but you have been expelled from ' . $this->organization['name'] . ".\n\nReason:\n" . ($reason ? $reason : "No specific reason given by managers.");

      $this->uclass->send_msg(-2, $member['id'], $msg, 'Kicked from organization');
	  $memberLog['kicked'] = 1;
    }

    $this->updateOrganization(array(
      'nrm' => $this->organization['nrm'] - 1
    ));

	if ($memberLog['log_id'])
		$this->db->where('log_id', $memberLog['log_id'])->update('organization_members_logs', $memberLog);

    //SEND QUIT MESSAGE TO ALL MEMBERS
	if ($sendNoticeToEveryone)
	{
		if ($quit)
		  $msg = 'Hacker ' . $member['username'] . " has left our organization.\nHe has left by his own will.";
		else
		  $msg = 'Hacker ' . $member['username'] . " has left our organization.\nHe was dismissed by managers.";

		$this->sendMessageToEveryone($msg, $member['username'] . ' has left our organization');
	}


  }

  //MESALL
  function mes_all()
  {
    global $success, $errors;

    if ($_POST) {
      $content = $_POST['content'];
      if ($content && strlen($content) <= 1000 && strlen($content) >= 10) {

        $ranks = array();
        foreach ($_POST['ranks'] as $rank)
          $ranks[] = intval($rank);

        if ($count = $this->sendMessageToRanks($ranks, $content, 'Organization Message from ' . $this->user['username'])) {
          $success = 'Messages sent to ' . $count . ' members from selected groups.';
        } //$count = $this->sendMessageToRanks($ranks, $content, 'Organization Message from ' . $this->user['username'])
        else
          $errors[] = 'No hackers found using selected filters';
      } //$content && strlen($content) <= 1000 && strlen($content) >= 10
      else
        $errors[] = 'Content must be between 10 and 1000 chars.';

    } //$_POST
  }

  function sendMessageToRanks($ranks = array(), $message, $title, $org_id = false)
  {
    if (count($ranks)) {
	  if (!$org_id) $org_id = $this->organization['id'];
	  if (!$org_id) return false;

      $ranks = implode(',', $ranks);

      $users = $this->db->rawQuery('select id from users where organization = ? and org_group in (' . $ranks . ')', array(
        $org_id
      ));
      if ($count = count($users)) {
		$receivers = array();
        foreach ($users as $member) $receivers[] = $member['id'];

        $this->uclass->send_msg(-2, $receivers, $message, $title);
      } //$count = count($users)
    } //count($ranks)

    return $count;
  }

  function sendMessageToEveryone($message, $title, $org_id = false)
  {
    if (!$org_id) $org_id = $this->organization['id'];

    $everyone = $this->db->where('organization', $org_id)->get('users', null, 'id');
	$receivers = array();
    foreach ($everyone as $one) $receivers[] = $one['id'];

    $this->uclass->send_msg(-2, $receivers, $message, $title);
  }

  function editRanks()
  {

    if ($_POST['newRank'])
      $this->addNewRank($_POST['newRank']);

    elseif ($_POST['deleteRank'])
      $this->deleteRank($_POST['deleteRank']);
    elseif ($_POST['setDefault'])
      $this->setDefaultRank($_POST['default']);
    elseif ($_POST['name'])
      if (!($this->errors = $this->isRankNameInvalid($name = $_POST['name']))) {
        $rank = array(
          'name' => $name,
          'rank_order' => intval($_POST['rank_order']) ? intval($_POST['rank_order']) : null
        );
        foreach ($this->permissions as $perm)
          $rank[$perm] = isset($_POST[$perm]) ? 1 : 0;

        $this->db->where('org_id', $this->organization['id'])->where('rank_id', $_POST['rank'])->update('org_ranks', $rank, 1);

        $this->success = 'Rank updated';
      } //!($this->errors = $this->isRankNameInvalid($name = $_POST['name']))

    $ranks = $this->db->where('org_id', $this->organization['id'])
		              ->orderBy('owner_rank', 'desc')
		               ->orderBy('rank_order', 'asc')
		              ->get('org_ranks');

    $this->templateVariables['ranks']           = $ranks;
    $this->templateVariables['permissions']     = $this->permissions;
    $this->templateVariables['permissionNames'] = $this->permissionNames;
  }

  function addNewRank($rankName)
  {
    global $errors;

    //	if(count($this->organization['perm']) < 10){
    if (!($errors = $this->isRankNameInvalid($rankName))) {
      $rank = array(
        'name' => $rankName,
        'created' => time(),
        'org_id' => $this->organization['id']
      );
      $this->db->insert('org_ranks', $rank);
    } //!($errors = $this->isRankNameInvalid($rankName))
    //	}else $errors[] = 'Organization has reached the maximum allowed number of ranks';
  }

  function deleteRank($rank_id)
  {
    $deleted = $this->db->where('org_id', $this->organization['id'])->where('rank_id', $rank_id)->delete('org_ranks', 1);
    if ($deleted) {
      $default_rank = $this->db->where('org_id', $this->organization['id'])->where('default_rank', 1)->getOne('org_ranks', 'rank_id');

      $this->db->where('organization', $this->organization['id'])->where('org_group', $rank_id)->update('users', array(
        'org_group' => $default_rank['rank_id']
      ));

      $this->success = 'Rank deleted';
    } //$deleted
    else
      $this->errors = 'An error took place';
  }

  function setDefaultRank($rank_id)
  {
    $updated = $this->db->where('org_id', $this->organization['id'])->where('owner_rank', array(
      '!=' => 1
    ))->update('org_ranks', array(
      'default_rank' => 1
    ), 1);

    if ($updated) {
      $this->db->where('org_id', $this->organization['id'])->where('default_rank', 1)->update('org_ranks', array(
        'default_rank' => 0
      ), 1);
    } //$updated
  }

  /**********************
  	FORUMS
   **********************/
  function manageForums($fclass)
  {
    global $error;

    if ($_POST)
      if ($id = $_POST['del_section']) {
        $this->db->where('id', $id)->where('org', $this->organization['id'])->delete($fclass->sections);
      } //$id = $_POST['del_section']
      else {
        if (($title = $_POST['name']) && !isset($title[70])) {

          $description = $_POST['description'];
          if ($description)
            if (isset($description[300]))
              $errors[] = 'Description can have maximum 300 characters';

          if (!$errors) {
            $data = array(
              'name' => htmlentities($title),
              'ord' => intval($_POST['order']),
              'org' => $this->organization['id']
            );

            if ($_POST['new_section']) {
              $data['type'] = 2;
              $this->db->insert($fclass->sections, $data);

            } //$_POST['new_section']
            elseif ($_POST['edit_section'] && ($sid = $_POST['section'])) {
              $this->db->where('id', $sid)->where('org', $this->organization['id'])->update($fclass->sections, $data);

            } //$_POST['edit_section'] && ($sid = $_POST['section'])
              elseif ($_POST['new_forum'] && ($sid = $_POST['section'])) {
              $data['parent'] = $sid;
              $this->db->insert($fclass->sections, $data);
            } //$_POST['new_forum'] && ($sid = $_POST['section'])
          } //!$errors
        } //($title = $_POST['name']) && !isset($title[70])
        else
          $error = 'Title must use under 100 characters';
      } //$_POST
  }

  function organizationForum()
  {
    require_once('../includes/class/class.forum.php');

    $fclass = new Forum($this->organization['id'], $this->access);

    if (ctype_digit($fid = $this->GET['fid'])) {
      $forum = $fclass->get_forum_data($fid);
      $this->templateVariables['forum'] =& $forum;
      if (!$forum['id'])
      {
        $this->show_404();return;
      }

      if ($this->GET['new'] == 'thread' && (!$forum['locked'] || $this->access['forumManager'])) {

        $fclass->new_thread($forum);

        $this->templateVariables['load'] = 'forum_create_thread';
      } //$GET['new'] == 'thread' && (($cardinal->loginSystem->logged && !$forum['locked']) || $fclass->forumPermissions['manageForum'])
      else {

        $this->templateVariables['threads'] = $fclass->get_threads($forum);

        $this->templateVariables['load'] = 'forum_threads';
      }

    } //ctype_digit($GET['fid'])
    elseif (ctype_digit($tid = $this->GET['tid'])) {

      $thread = $fclass->get_thread_data($tid);

      if ($thread['id']) {

        $fclass->thread_process($thread);

        $this->templateVariables['load'] = 'forum_thread';

      } //$thread['id']
      else
        show_404();
    } //ctype_digit($GET['tid'])
    elseif (ctype_digit($edit = $this->GET['edit'])) {

      $fclass->managePostEdit($edit);

    } //ctype_digit($GET['edit'])
    else {
      $category = $fclass->get_categories();

      $this->templateVariables['category'] = $category;
    }

    $this->templateVariables['load'] = $this->templateVariables['load'] ? 'forum/' . $this->templateVariables['load'] . '.tpl' : null;

    $this->templateVariables['furl'] = $fclass->furl;
    $this->templateVariables['display'] = 'forum/forum.tpl';
  }

  function validateAndSendWarRequest()
  {
    global $error;
    if ($_POST['type'] == 2 && $this->organization['hacking_points'] < $this->forced_request_hp_cost)
      $error = 'Not enough hacking points. Nice try tho!';
    elseif (!($error = $this->validataOrgName($name = $_POST['organization'], false))) {
      $org = $this->db->where('name', $name)->getOne('organizations', 'id, name');

      if (!$org['id'])
        $error = 'Could not find organization';
      elseif ($org['id'] == $this->organization['id'])
        $error = 'Uhm, really?';
      else {
        $otherWarRequest = $this->db->rawQuery('select request_id from org_war_requests where
                                                status = 1 and ((from_org_id = ? and to_org_id = ?) or (from_org_id = ? and to_org_id = ?))
												and created > ?
                                                limit 1', array(
          $this->organization['id'],
          $org['id'],
          $org['id'],
          $this->organization['id'],
		  time() -  $this->requestExpireTime*24*60*60
        ));

        if ($otherWarRequest[0]['request_id'])
          $error = 'A war request already exists between you and ' . $org['name'] . '.';
      }
      // check if in war
      if (!$error) {
        $war = $this->db->rawQuery('select war_id from org_wars where
                                  ((org1_id = ? and org2_id = ?) or (org1_id = ? and org2_id = ?))
                                  limit 1', array(
                                    $this->organization['id'],
                                    $org['id'],
                                    $org['id'],
                                    $this->organization['id']
                                  ));
        if ($war[0]['war_id'])
          $error = 'A war is already taking place between you and ' . $org['name'] . '.';
      } //!$error

      if (!$error) {
        if ($_POST['type'] == 2)
        {
          $this->updateOrganization(array('hacking_points' => $this->organization['hacking_points'] - $this->forced_request_hp_cost));
          $_SESSION['success'] = 'Hacking points removed. Force war initiated. Good luck, ' . $org['name'] . '!';
          $warRequest = array(
            'from_org_id' => $this->organization['id'],
            'to_org_id' => $org['id'],
          );
          $this->startWar($warRequest, $org['id']);
        }
        else
        {

          $this->sendWarRequestTo($org);
          $_SESSION['success'] = 'War request sent.';

        }
        $this->redirect(URL . 'organization/view/wars/requests/emilia');


      } //!$error

    } //!($error = $this->validataOrgName($name = $_POST['organization'], false))
  }

  function sendWarRequestTo($org)
  {

    $warRequest = array(
      'from_org_id' => $this->organization['id'],
      'to_org_id' => $org['id'],
      'created' => time()
    );

    if($this->db->insert('org_war_requests', $warRequest))
	{

    // send notifications to concerned parties
    $ranks = $this->db->rawQuery('select rank_id from org_ranks where
                                    org_id = ? and (owner_rank = 1 or manageWars = 1)', array(
      $org['id']
    ));

    $ranksArray = array();
    foreach ($ranks as $rank)
      $ranksArray[] = $rank['rank_id'];

    $message = "[url=".URL."organization/show/".$this->organization['id']."]".$this->organization['name'] . '[/url] has sent a war request.';
    $title   = 'RECEIVED WAR REQUEST from ' . $this->organization['name'];

    $this->sendMessageToRanks($ranksArray, $message, $title, $org['id']);
	}
  }

  function fetchWarRequests()
  {
    $this->requestExpireTime = $this->requestExpireTime * 24 * 60 * 60;
    $sentRequests            = $this->db->rawQuery('select owr.*, o.name from org_war_requests owr
                                     left outer join organizations o on to_org_id = o.id
                                     where from_org_id = ? order by created desc', array(
      $this->organization['id']
    ));

    $receivedRequests = $this->db->rawQuery('select owr.*, o.name from org_war_requests owr
                                     left outer join organizations o on from_org_id = o.id
                                     where to_org_id = ? order by created desc', array(
      $this->organization['id']
    ));


    foreach ($sentRequests as &$sentRequest) {

      $expires = $sentRequest['created'] + $this->requestExpireTime;

      if ($expires <= time())
        $sentRequest['expired'] = true;
      else
        $sentRequest['expires'] = date('d/M/Y H:i:s', $expires);


      $sentRequest['created']     = date('d/M/Y H:i:s', $sentRequest['created']);
      $sentRequest['answer_date'] = date('d/M/Y H:i:s', $sentRequest['answer_date']);

    } //$sentRequests as &$sentRequest

    foreach ($receivedRequests as &$receivedRequest) {
      $expires = $receivedRequest['created'] + $this->requestExpireTime;
      if ($expires <= time())
        $receivedRequest['expired'] = true;
      else
        $receivedRequest['expires'] = date('d/M/Y H:i:s', $expires);
      $receivedRequest['created']     = date('d/M/Y H:i:s', $receivedRequest['created']);
      $receivedRequest['answer_date'] = date('d/M/Y H:i:s', $receivedRequest['answer_date']);
    } //$receivedRequests as &$receivedRequest
	   // print_R($receivedRequests);
    $this->templateVariables['sentRequests']     = $sentRequests;
    $this->templateVariables['receivedRequests'] = $receivedRequests;
  }

  function startWar(&$warRequest, $org_id = false)
  {

    $date = date('d F Y', time());
    $midnightToday = strtotime($date);

    $war = array(
      'created' => time(),
      'org1_id' => $warRequest['from_org_id'],
      'org2_id' => $warRequest['to_org_id'],
      'start' => $midnightToday + 3 * 24 * 60 * 60,
      'duration' => 2 * 24 * 60 * 60,
    );
    $war['ends'] = $war['start'] + $war['duration'];

    // add war entry
    if($this->db->insert('org_wars', $war))
    {
      // update war request
      $warRequestUpdate['status'] = 2;

      // set a notifications to members of both organizations
      $warStartDate = date('d F Y H:i:s', $war['start']);
      $message      = "This is an automatic notification!\nOur organization has accepted a war request and will start fighting on " . $warStartDate . '.';
      if ($org_id)
      $message      = "This is an automatic notification!\nOur organization has been forced to accept a war request and will start fighting on " . $warStartDate . '.';
      $title = 'Organization @ WAR';

      $this->sendMessageToEveryone($message, $title, $org_id);
    }
  }

  function fetchOrganizationEndedWars()
  {
    $org_id = $this->organization['id'];

    $wars =
      $this->db->rawQuery('select oew.*, o.name, o.id from org_ended_wars oew
                           left outer join organizations o on
                           case org1_id
                             when ? then org2_id = o.id
                             else org1_id = o.id
                           end
                           where (org1_id = ? or org2_id = ?)
						   order by created desc',
                          array($org_id, $org_id, $org_id));
    foreach ($wars as &$war)
    {
      $war['finished_date'] = date('d/F/Y', $war['finished']);
    }

    return $wars;
  }

  function manageOrganization()
  {
    if ($this->GET['manage'] == 'forum') {
      $this->templateVariables['loadd'] = 'manage_forum';

      require_once('../includes/class/class.forum.php');
      $fclass = new Forum($this->organization['id']);

      $this->manageForums($fclass);

      $sections = $fclass->get_categories();

      $this->templateVariables['sections'] = $sections;
    } //$GET['manage'] == 'forum'
    elseif ($this->GET['manage'] == 'intros')
	{
		$this->templateVariables['loadd'] = 'manage_intros';
		if ($_POST['form'] == 'intros') {

       		$this->post_intros($this->organization);
			$_SESSION['success'] = "Intros updated";
      		$this->redirect($this->url);
      	} //$_POST['form'] == 'intros'

	}
	  else
    {
      if ($_POST['allow_app'])
      {
        $this->updateOrganization(array('allow_app' => $this->organization['allow_app'] ? 0 : 1));
        $this->success = "New configuration saved";
      }

      elseif ($_POST['form'] == 'cname') {
        if ($this->nameChangeHpCost <= $this->organization['hacking_points']) {

          $this->post_cname();

        } //$config['org_name_change_cost'] <= $this->organization['vault']['money']
        else
          $this->errors = 'Not enough hacking points available';

      } //$_POST['form'] == 'cname'


    }
    $this->templateVariables['nameChangeHpCost'] = $this->nameChangeHpCost;
  }

  function addHackingPoints($hackingPoints, $org_id = false, $user_id = null, $task_log_id = null, $source_type = 1)
  {
	  if (!$org_id) $org_id = $this->organization['id'];
	  if (!$org_id) return false;
	  $log = array(
	  	'created' => time(),
		'user_id' => $user_id,
		'hackingPoints' => $hackingPoints,
		'org_id' => $org_id,
		'task_log_id' => $task_log_id,
		'source_type' => $source_type

	  );
	  $this->db->insert('org_hacking_points_logs', $log);

	   $this->db->rawQuery('update organizations set hacking_points = hacking_points + ? where id = ? limit 1', array(
            $hackingPoints,
            $org_id
          ));
	  $this->addExp($hackingPoints, $org_id);
  }

  function levelExperience($level)
  {
	  return $level * 20;
  }
  function addExp($exp, $org_id = false)
  {
    if (!$org_id)
		$org_id = $this->organization['id'];
	else $this->organization = $this->db->where('id', $org_id)->getOne('organizations', 'exp, level, id, expNext');

	if (!$this->organization['id']) return false;

    $this->organization['exp'] += $exp;
    while ($this->organization['exp'] >= $this->organization['expNext']) {
      $this->organization['level']++;
      $this->organization['exp']     = $this->organization['exp'] - $this->organization['expNext'];
      $this->organization['expNext'] = $this->levelExperience($this->organization['level'] + 1);

	} //$this->user['exp'] >= $this->user['expNext']
    $updateData = array(
      'exp' => $this->organization['exp'],
      'expNext' => $this->organization['expNext'],
      'level' => $this->organization['level'],
    );
	$this->updateOrganization($updateData);
  }
}



?>
