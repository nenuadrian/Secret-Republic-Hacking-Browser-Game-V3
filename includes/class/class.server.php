<?php

class Server extends Alpha {
  var $componentNonStackable = array(1 => 'cpu', 2 => 'motherboard', 3 => 'case', 4 => 'power_source');
  function __construct($server_id = false, $server = false) {
    parent::__construct();

    if ($server)
      $this->server = $server;
    elseif ($server_id)
      $this->server = $this->db->where('server_id', $server_id)->getOne('servers');

    if ($this->server) {
      $this->server_id = $server_id;
    }
  }

  function isIPUnique($ip) {
    $check = $this->db->where('ip', $ip)->getOne('servers', 'server_id');
    return $check['server_id'] ? false : true;
  }

  function generateIP() {
    return mt_rand(193, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255);
  }

  function generateUniqueIP() {
    $ip = $this->generateIP();
    while (!$this->isIPUnique($ip))
      $ip = $this->generateIP();
    return $ip;
  }

  function getComponent($relation_id) {
    $component = $this->db->join('components c', 'c.component_id = sc.component_id', 'left outer')->where("server_id", $server->server_id)->where('relation_id', $relation_id)->getOne('server_components sc');

    return $component['component_id'] ? $component : false;
  }

  function processComponent(&$component) {

  }

  function processComponents(&$components) {
    foreach ($components as &$component)
      $this->processComponent($component);
  }

  function installApp($app) {
    $this->db->insert("server_apps", array(
      "app_id" => $app['app_id'],
      'server_id' => $this->server_id,
      'damage' => $app['damage']
    ));
    $this->recomputeServerResources();
  }
  function processApp(&$app) {
    if ($app['damage']) {

      $app['ram'] -= floor(($app['damage'] / 2) * ($app['ram'] / 100));
      $app['cpu'] -= floor(($app['damage'] / 2) * ($app['cpu'] / 100));
      $app['skill_value'] -= floor($app['damage'] * ($app['skill_value'] / 100));
    }
  }

  function processApps(&$apps) {
    foreach ($apps as &$app)
      $this->processApp($app);

  }
  function fetchApps() {

    $apps = $this->db->rawQuery('select sapps.*, apps.* from server_apps sapps
                                        left outer join applications apps on apps.app_id = sapps.app_id
                                     where server_id = ?', array(
      $this->server_id
    ));

    $this->processApps($apps);

    return $this->apps = $apps;

  }

  function fetchComponents() {
    $components = $this->db->rawQuery('select sc.*, c.* from server_components sc
                                            left outer join components c on c.component_id = sc.component_id
                                           where sc.server_id = ?', array(
      $this->server_id
    ));


    $this->components = array(
      'rams' => array(),
      'hdds' => array()
    );

    $nonStackableTypes = array_keys($this->componentNonStackable);

    foreach ($components as $component) {
      if (in_array($component['type'], $nonStackableTypes)) {
        $this->components[$this->componentNonStackable[$component['type']]] = $component;
      } elseif ($component['type'] == 5) {
        if (count($this->components['rams']) == $this->server['ram_slots']) {
          $component['disabled'] = true;
        }

        $this->components['rams'][] = $component;

      } elseif ($component['type'] == 6) {

        if (count($this->components['hdds']) == $this->server['hdd_slots']) {
          $component['disabled'] = true;
        }

        $this->components['hdds'][] = $component;

      }
    }

  }
  function computeSkillsCommandsInfluence() {
    global $theskills;
    if (!$this->skills)
      $this->fetchSkills();
    $commandsInfluence = array();


    foreach ($this->skills as $skill => $data)
      if (is_array($theskills[$skill]['commands']))
        foreach ($theskills[$skill]['commands'] as $command => $influenceRate)
          $commandsInfluence[$command] += $influenceRate * $data['level'];

    return $commandsInfluence;
  }
  function fetchSkills() {
    if (!$this->apps) {
      $this->fetchApps();
    }
    $this->skills = array();

    foreach ($this->apps as $app)
      if ($app['running'])
        $this->skills[$app['skill_id']]["exp"] += $app['skill_value'];
    foreach ($this->skills as $skill => &$data) {
      $lvl = $exp = 0;
      while ($data["exp"] >= $exp) {
        $lvl++;
        $exp = $this->uclass->computeSkillExperience($skill, $lvl);
      }
      $data['expNext'] = $exp;
      $data['level']   = $lvl;
    }
  }

  function recomputeServerResources($server_id = null) {
    if (!$server_id)
      $server_id = $this->server_id;
    if (!$server_id)
      return;
    $this->server_id = $server_id;
    /*******************
    HARDWARE
    *******************/
    $components      = $this->db->rawQuery('select sc.*, c.* from server_components sc
                                            left outer join components c on c.component_id = sc.component_id
                                           where sc.server_id = ?', array(
      $server_id
    ));

    $this->total_ram = $this->total_hdd = $this->power_usage = 0;

    $this->components = array(
      'rams' => array(),
      'hdds' => array()
    );

    $nonStackableTypes = array_keys($this->componentNonStackable);

    foreach ($components as $component) {

      switch ($component['type']) {
        case 1:
          $component['cpu_lost'] = ceil(($component['cpu'] / 100) * $component['damage']);
          $component['cpu'] -= $component['cpu_lost'];
          $this->total_cpu = $component['cpu'];
          break;
        case 2:
          $component['slots_lost'] = floor(($component['slots'] / 100) * $component['damage']);
          $component['slots'] -= $component['slots_lost'];
          $this->ram_slots = $component['slots'];
          break;
        case 3:
          $component['slots_lost'] = floor(($component['slots'] / 100) * $component['damage']);
          $component['slots'] -= $component['slots_lost'];
          $this->hdd_slots = $component['slots'];
          break;
        case 4:
          $component['power_lost'] = floor(($component['power'] / 100) * $component['damage']);
          $component['power'] -= $component['power_lost'];
          break;
        case 5:
          $component['ram_lost'] = floor(($component['ram'] / 100) * $component['damage']);
          $component['ram'] -= $component['ram_lost'];
          break;
        case 6:
          $component['hdd_lost'] = floor(($component['hdd'] / 100) * $component['damage']);

          $component['hdd'] -= $component['hdd_lost'];

          break;

        default:

      }


      if (in_array($component['type'], $nonStackableTypes)) {
        $this->components[$this->componentNonStackable[$component['type']]] = $component;
        $this->power_usage += $component['power_usage'];
      } elseif ($component['type'] == 5) {
        if ($this->active_ram_slots < $this->ram_slots) {
          $this->total_ram += $component['ram'];
          $this->active_ram_slots++;
        }
        $this->used_ram_slots++;

      } elseif ($component['type'] == 6) {
        if ($this->active_hdd_slots < $this->hdd_slots) {
          $this->total_hdd += $component['hdd'];
          $this->active_hdd_slots++;
        }

        $this->used_hdd_slots++;
      }
    }


    if ($this->power_usage > $this->components['power_source']['power']) {
      $this->disabled = true;
      $this->db->where('server_id', $server_id)->update('server_apps', array(
        'running' => 0
      ));
      //$this->errors[] = "";
    }

    /*******************
    SOFTWARE
    *******************/

    $apps = $this->fetchApps();


    $this->cpu_usage = $this->ram_usage = $this->hdd_usage = 0;
    $runningApps     = array();
    foreach ($apps as $key => $app) {
      if ($app['running']) {
        $this->cpu_usage += $app['cpu'];
        $this->ram_usage += $app['ram'];
        $app['key']    = $key;
        $runningApps[] = $app;
      }
      $this->hdd_usage += $app['hdd'];
    }

    while (count($runningApps) && (($this->cpu_usage > $this->total_cpu) || ($this->ram_usage > $this->total_ram))) {
      shuffle($runningApps);

      $this->db->rawQuery('update server_apps set running = 0 where process_id = ? limit 1', array(
        $runningApps[0]['process_id']
      ));
      $this->cpu_usage -= $runningApps[0]['cpu'];
      $this->ram_usage -= $runningApps[0]['ram'];
      unset($apps[$runningApps[0]['key']], $runningApps[0]);
    }

    // corrupted hard disks?
    $deletedApps = array();
    while (count($apps) && $this->hdd_usage > $this->total_hdd) {
      shuffle($apps);
      $deletedApps[] = $apps[0];
      $this->db->rawQuery('delete from server_apps where process_id = ? limit 1', array(
        $apps[0]['process_id']
      ));



      //$this->db->rawQuery('delete from tasks where user = ? limit 1', array($apps[0]['process_id']));
      $this->hdd_usage -= $apps[0]['hdd'];
      if ($apps[0]['running']) {
        $this->cpu_usage -= $apps[0]['cpu'];
        $this->ram_usage -= $apps[0]['ram'];
      }
      unset($apps[0]);
    }
    if (count($deletedApps)) {
      $lostApps = array();
      foreach ($deletedApps as $app)
        $lostApps[] = $app['name'];

      $message = "RED ALERT: Damaged hard disks caused data corruption! The following apps have been corrupted and lost: " . implode(",", $lostApps) . ". If any of them were under repair, the process has been stopped.";
      $this->uclass->send_msg(-1, $this->server['user_id'], $message, $this->server['hostname'] . " Report");
    }

    $this->ram_usage_percent = $this->cpu_usage_percent = $this->hdd_usage_percent = 0;

    if ($this->ram_usage && $this->total_ram)
      $this->ram_usage_percent = intval($this->ram_usage / ($this->total_ram / 100));

    if ($this->hdd_usage && $this->total_hdd)
      $this->hdd_usage_percent = intval($this->hdd_usage / ($this->total_hdd / 100));

    if ($this->cpu_usage && $this->total_cpu)
      $this->cpu_usage_percent = intval($this->cpu_usage / ($this->total_cpu / 100));

    $updateData = array(
      "total_cpu" => $this->total_cpu,
      "total_ram" => $this->total_ram,
      "total_hdd" => $this->total_hdd,
      "cpu_usage" => $this->cpu_usage,
      "ram_usage" => $this->ram_usage,
      "hdd_usage" => $this->hdd_usage,
      "cpu_usage_percent" => $this->cpu_usage_percent,
      "hdd_usage_percent" => $this->hdd_usage_percent,
      "ram_usage_percent" => $this->ram_usage_percent,
      "power_usage" => $this->power_usage,
      "ram_slots" => $this->ram_slots,
      "hdd_slots" => $this->hdd_slots,
      "used_ram_slots" => $this->used_ram_slots,
      "active_ram_slots" => $this->active_ram_slots,
      "used_hdd_slots" => $this->used_hdd_slots,
      "active_hdd_slots" => $this->active_hdd_slots,
      "disabled" => $this->disabled ? 1 : null


    );


    $this->db->where("server_id", $server_id)->update("servers", $updateData, 1);

  }
  function dealComponentDamage($component, $damage) {
    if (!$component['relation_id'])
      $component = $this->db->join('servers s', 's.server_id = sc.server_id', 'left outer')->where('relation_id', $component)->getOne('server_components sc', 'sc.*, s.user_id');
    else
      $component = array_merge($component, $this->db->where('server_id', $component['server_id'])->getOne('servers', 'user_id'));
    if (!$component['server_id'])
      return;

    $component['damage'] += $damage;
    $component['damage'] = $component['damage'] > 100 ? 100 : $component['damage'];
    $this->db->where('relation_id', $component['relation_id'])->update('server_components', array(
      'damage' => $component['damage']
    ));

    $this->recomputeServerResources($component['server_id']);


    $this->uclass->recomputeDataPointsStats($component['user_id']);

  }

  function dealAppDamage($app, $damage) {
    if (!$app['process_id'])
      $app = $this->db->join('servers s', 's.server_id = sa.server_id', 'left outer')->where('process_id', $app)->getOne('server_apps sa', 'sa.server_id, damage, process_id, s.user_id, running');
    else
      $app = array_merge($app, $this->db->where('server_id', $component['server_id'])->getOne('servers', 'user_id'));

    if (!$app['server_id'])
      return;

    $app['damage'] = $app['damage'] + $damage > 100 ? 100 : $app['damage'] + $damage;

    $this->db->where('process_id', $app['process_id'])->update('server_apps', array(
      'damage' => $app['damage']
    ));

    $this->recomputeServerResources($app['server_id']);

    if ($app['running'])
      $this->uclass->recomputeDataPointsStats($app['user_id']);
  }
}
