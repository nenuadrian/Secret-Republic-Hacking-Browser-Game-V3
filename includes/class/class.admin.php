<?php

class Admin extends Alpha {



  private $objectiveTypes = array('ping', 'crack', 'connect', 'transfer', 'decrypt_file', 'delete_logs', 'run_file', 'delete_file', 'kill_file', 'nmap', 'cat', 'delete_email', 'read_email', 'forward_email', 'crash_service', 'sql_delete', 'sql_drop');

  private $serviceTypes = array('ssh', 'sql', 'smtp', 'http', 'unknown');

  function __construct(Container $container) {
    parent::__construct($container);
    $this->templateVariables['objectiveTypes'] = $this->objectiveTypes;
    $this->templateVariables['serviceTypes']   = $this->serviceTypes;
  }


  function mess_all() {


  }

  function get_registered() {

    if ($this->GET['online']) {

      $nrMembers = $this->db->rawQuery('select count(hu.id) as nrMembers from users as hu
                                        where lastActive > ?', array(
        time() - 10 * 60
      ));

      $filter = "where lastActive >= " . (time() - 10 * 60);
    } //$this->GET['online']
    elseif (ctype_digit($this->GET['group'])) {
      $filter    = 'where hg.group_id = ' . $this->GET['group'];
      $nrMembers = $this->db->rawQuery('select count(hu.id) as nrMembers from users as hu
                                        left outer join user_credentials as uc on uc.uid = hu.id
                                        where uc.group_id = ?', array(
        $this->GET['group']
      ));
    } //ctype_digit($this->GET['group'])
    else
      $nrMembers = $this->db->rawQuery('select count(id) as nrMembers from users as hu');

    $nrMembers = $nrMembers[0];

    $this->pages                 = new Paginator;
    $this->pages->items_total    = $nrMembers['nrMembers'];
    $this->pages->items_per_page = 40;
    $this->pages->paginate();

    $members = $this->db->rawQuery('select hu.*, hg.name, lastActive, o.name org_name, login_count from users hu
                                      left outer join user_credentials as uc on uc.uid = hu.id
                                      left outer join groups as  hg on hg.group_id = uc.group_id
                                      left outer join organizations o on o.id = hu.organization
                                      ' . $filter . '
                                      order by id desc ' . $this->pages->limit);
    foreach ($members as &$member)
      if ($member['lastActive'] >= time() - 10 * 60)
        $member['online'] = true;
    return $members;

  }


  function objectives(&$quest) {

    if ($_POST['new_objective']) {
      $lastOrder    = $this->db->where('qid', $quest['id'])->orderBy('oorder', 'desc')->getOne('quest_objectives', 'oorder');
      $newObjective = $this->db->insert('quest_objectives', array(
        'qid' => $quest['id'],
        'oorder' => $lastOrder['oorder'] + 1
      ));

      $this->db->insert('quest_objectives', array(
        'qid' => $quest['id'],
        'side' => $newObjective
      ));

      $this->redirect(URL_C . "#objective_" . $newObjective);
    } //$_POST['new_objective']

    if ($obj = $_POST['objective']) {
      if ($_POST['deleteObjective']) {
        $this->db->where('id', $obj)->where('qid', $quest['id'])->delete('quest_objectives');
        $this->db->where('side', $obj)->where('qid', $quest['id'])->delete('quest_objectives');
      } //$_POST['deleteObjective']
      if ($_POST['objectiveUpdate']) {
        $data['type']           = in_array($_POST['type'], $this->objectiveTypes) ? $_POST['type'] : 'ping';
        $data['data']           = ($_POST['data']);
        $data['story']          = ($_POST['story']);
        $data['achievement_id'] = intval($_POST['achievement']);
        $data['oorder']         = intval($_POST['oorder']);
        $data['extraTime']      = intval($_POST['extraTime']);

        $this->db->where('id', $obj)->where('qid', $quest['id'])->update('quest_objectives', $data);
        /* if ($_POST['json'])
        {
        echo json_encode(array('saved' => true));
        $this->templateVariables['json'] = true;
        return;
        }*/
      } //$_POST['objectiveUpdate']
    } //$obj = $_POST['objective']

    $quest['objectives'] = $this->db->rawQuery('select * from quest_objectives
                                                where qid = ? and side is null
                                                order by oorder asc', array(
      $quest['id']
    ));
  }

  function sideObjectives(&$quest) {
    if ($obj = $_POST['objective']) {
      if ($_POST['newSideObjective'])
        $this->db->insert('quest_objectives', array(
          'qid' => $quest['id'],
          'side' => $obj
        ));

      if ($sideObj = $_POST['sideObjective']) {
        if ($_POST['deleteSide'])
          $this->db->where('id', $sideObj)->where('qid', $quest['id'])->where('side', $obj)->delete('quest_objectives');

        if ($_POST['updateSide']) {
          $data['type']           = in_array($_POST['type'], $this->objectiveTypes) ? $_POST['type'] : $this->objectiveTypes[0];
          $data['data']           = $_POST['data'];
          $data['achievement_id'] = intval($_POST['achievement']);
          $data['extraTime']      = intval($_POST['extraTime']);
          $data['compulsory']     = ($_POST['compulsory']) ? 1 : 0;
          $data['oorder']         = $_POST['oorder'] ? $_POST['oorder'] : null;
          $this->db->where('id', $sideObj)->where('qid', $quest['id'])->where('side', $obj)->update('quest_objectives', $data);
        } //$_POST['updateSide']
      } //$sideObj = $_POST['sideObjective']
    } //$obj = $_POST['objective']
    foreach ($quest['objectives'] as &$objective) {
      $objective['sideObjectives'] = $this->db->where('side', $objective['id'])->get('quest_objectives');
      //print_r($objective);
    } //$quest['objectives'] as &$objective
  }


  function hosts(&$quest) {

    if ($_POST['new_host']) {
      $this->db->insert('quest_hosts', array(
        'qid' => $quest['id'],
        'hostname' => 'server' . rand(1, 999)
      ));


    } //$_POST['new_host']

    if ($host = $_POST['host']) {

      if ($_POST['deleteHost']) {
        $this->db->where('id', $host)->where('qid', $quest['id'])->delete('quest_hosts');

      } //$_POST['deleteHost']
      if ($_POST['updateHost']) {

        $updateData = array(
          'hostname' => $_POST['hostname'],
          'discovered' => intval($_POST['discovered']),
          'maxBounces' => intval($_POST['maxBounces'])
        );
        $this->db->where('id', $host)->where('qid', $quest['id'])->update('quest_hosts', $updateData);
      } //$_POST['updateHost']
    } //$host = $_POST['host']
    $quest['hosts'] = $this->db->where('qid', $quest['id'])->get('quest_hosts');

  }

  function host_services(&$quest) {

    if ($_POST['new_service'] && $_POST['host'])
      $this->db->insert('quest_services', array(
        'hid' => $_POST['host'],
        'type' => $_POST['type']
      ));

    if ($service = $_POST['service']) {

      if ($_POST['deleteservice']) {
        $this->db->where('service_id', $service)->delete('quest_services');
        $this->db->where('requiredObjective', $service)->update('quest_files', array(
          'requiredObjective' => NULL
        ));
      } //$_POST['deleteService']
      elseif ($_POST['updateService']) {
        $data['port']       = ($_POST['port']);
        $data['encryption'] = ($_POST['encryption']);
        $data['welcome']    = htmlentities($_POST['welcome']);

        $this->db->where('service_id', $service)->update('quest_services', $data);
      } //$_POST['updateService']
    } //$service = $_POST['service']

    foreach ($quest['hosts'] as &$host)
      $host['services'] = $this->db->where('hid', $host['id'])->orderBy('port', 'asc')->get('quest_services');


    $this->templateVariables['objectives'] = $this->db->rawQuery('select type, id, side, data,oorder from quest_objectives where qid = ? order by oorder asc', array(
      $quest['id']
    ));
  }

  function host_services_manage(&$quest) {
    if ($service = $_POST['service']) {
      if ($_POST['new_file'])
        $this->db->insert('quest_files', array(
          'service_id' => $service,
          'title' => 'file' . rand(1, 99999999)
        ));

      if ($file = $_POST['file']) {
        if ($_POST['deleteFile']) {
          $this->db->where('service_id', $service)->where('file_id', $file)->delete('quest_files');
        } //$_POST['deleteFile']
        if ($_POST['updateFile']) {
          $data['title']  = $_POST['title'];
          $data['sender'] = $_POST['sender'];

          $data['content']           = htmlentities($_POST['content']);
          $data['encryption']        = ($_POST['encryption']);
          $data['size']              = intval($_POST['size']);
          $data['executionTime']     = intval($_POST['executionTime']);
          $data['canRun']            = $_POST['canRun'] ? 1 : 0;
          $data['cantKill']          = $_POST['cantKill'] ? 1 : 0;
          $data['burst']             = $_POST['burst'] ? 1 : 0;
          $data['requiredObjective'] = $_POST['requiredObjective'];

          $data['running']             = $data['canRun'] && $_POST['running'] ? 1 : 0;
          $data['requiredToRun']       = $data['canRun'] ? $_POST['requiredToRun'] : '';
          $data['requiredOnMainToRun'] = $data['canRun'] ? $_POST['requiredOnMainToRun'] : '';
          $data['parameters']          = $data['canRun'] ? $_POST['parameters'] : '';
          $this->db->where('file_id', $file)->where('service_id', $service)->update('quest_files', $data);
        } //$_POST['updateFile']
      } // file
    } // service

    foreach ($quest['hosts'] as &$host)
      foreach ($host['services'] as &$service)
        if ($service['type'] == 'ssh')
          $service['files'] = $this->db->where('service_id', $service['service_id'])->get('quest_files');
        elseif ($service['type'] == 'smtp')
          $service['emails'] = $this->db->where('service_id', $service['service_id'])->get('quest_files');
        elseif ($service['type'] == 'sql')
          $service['tables'] = $this->db->where('service_id', $service['service_id'])->get('quest_files');

  }






}

$aclass = new Admin($container);
