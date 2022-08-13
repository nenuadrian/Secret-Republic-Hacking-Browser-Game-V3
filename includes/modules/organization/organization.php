<?php



require_once('../includes/class/oclass.php');

$page_title = 'Organization';


$oclass = new Organization($GET['show'] ? $GET['show'] : $user['organization']);

//$organization = new OrganizationEntity($GET['show'] ? $GET['show'] : $user['organization']);

if ($oclass->organization['id']) {
  
  $page_title = $oclass->organization['name'] . ' organization';
   
  if ($oclass->organization['myOrg']) {
    
    require("org_my_org.php");
    
    
  } //$oclass->organization['myOrg']
  else {
    
    //If user visits foreign organization page
    
    if ($GET['apply'] && $oclass->organization['allow_app'] && !$user['organization'] && $logged) {
      require('org_apply.php');
      
    } //$GET['view'] == 'apply' && $oclass->organization['allow_app'] && !$user['organization'] && $logged
    
  }
  
  
  if ($GET['view'] == 'wars') {
    $tVars['load'] = 'wars';
  
    if ($GET['requests'] && $oclass->perms['manageWars']) {
      $tVars['loadd'] = 'requests';
    
      if ($GET['start']) {
        $tVars['loadd'] = 'send_request';
      
        if ($_POST)
          $oclass->validateAndSendWarRequest();
        
        $tVars['forced_request_hp_cost'] = $oclass->forced_request_hp_cost;
      } //$GET['start']
      else
      {          
        $requestExpireTime = $oclass->requestExpireTime*24*60*60;
      
        if ($warRequestId = $_POST['warRequestAnswer']) {
        
          $warRequest = $db->where('request_id', $warRequestId)
                           ->where('to_org_id', $oclass->organization['id'])
                           ->where('created', array('>' => time() - $requestExpireTime))
                           ->getOne('org_war_requests');
       
          if ($warRequest['request_id'])
          {
            $warRequestUpdate = array('answer_date' => time());
          
            if ($_POST['accept']) {
              $oclass->startWar($warRequest);
          
            } //$_POST['accept']
            else 
            {
              $warRequestUpdate['status'] = 3;
            } //$warRequest['id']
          
            $db->where('request_id', $warRequest['request_id'])->update('org_war_requests', $warRequestUpdate);
            $cardinal->redirect($config['url'].'organization/view/wars');
          }
        
        
        } //ctype_digit($warRequestId = $_POST['warRequestAnswer'])
      
        $oclass->fetchWarRequests();
      
      } //!$tVars['loadd']
    } //$GET['requests'] && $oclass->perms['manageWars']
    else
    {
      if ($oclass->organization['wars_inprogress'])
      {
        require('../includes/class/organizationWars.php');
        $owars = new organizationWars;
      
        $wars = $owars->fetchOrganizationWars($oclass->organization['id']);
      
      
        $tVars['wars'] = $wars;
      
      }
      $endedWars = $oclass->fetchOrganizationEndedWars();
      $tVars['endedWars'] = $endedWars;
    
    }
  
  } //$GET['view'] == 'wars'
  
  

  $tVars['org'] = $oclass->organization;
} //$oclass->organization['id']
else
if ($logged) {
  
  require("org_no_org.php");
  
} //!$oclass->organization['id'] && $logged
else  $cardinal->redirect(URL);


if (!isset($tVars['display']))
  $tVars['display'] = 'organization/organization.tpl';



?>
