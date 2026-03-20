<?php
class Item 
{
  var $data;
  var $item_type;

  function __construct($data = false)
  {  
    if ($data)
    {
      $this->data = array(
        "app_id" => isset($data['app_id']) ? $data['app_id'] : null,
        "component_id" => isset($data['component_id']) ? $data['component_id'] : null,
        "damage" => isset($data['damage']) ? $data['damage'] : 0,
        );
    }
  }
  function loadApp($app_id, $damage = 0)
  {
    global $container;
    $db = $container->db();
    $db->where('app_id', $app_id);
    $this->data = $db->getOne('applications a', 'a.*');
    $this->data['damage'] = $damage;
  }
  function loadComponent($component_id, $damage = 0)
  {
    global $container;
    $db = $container->db();
    $db->where('component_id', $component_id);
    $this->data = $db->getOne('components c', 'c.*');
    $this->data['damage'] = $damage;
  }
  function loadFromStorage($storage_id, $user_id = false)
  {
    global $container;
    $db = $container->db();
    $db->where('storage_id', $storage_id);
    if ($user_id) $db->where('user_id', $user_id);
    $db->join('components c', 'c.component_id = s.component_id', 'left outer');
    $this->data = $db->getOne('storage s', 's.*, c.*');
  }
  function loadFromServerApps($process_id, $user_id = false, $server_id = false)
  {
    global $container;
    $db = $container->db();
    $db->where('process_id', $process_id);
    if ($user_id) $db->where('s.user_id', $user_id);
    if ($server_id) $db->where('sa.server_id', $server_id);
    $db->join('servers s', 's.server_id = sa.server_id', 'left outer');
    $db->join('applications a', 'a.app_id = sa.app_id', 'left outer');
    $this->data = $db->getOne('server_apps sa', 'sa.*, a.*');
  }
  function loadFromServerComponents()
  {
    
  }
  
  function fetchItemSpecificData()
  {
    global $container;
    $db = $container->db();
    if ($this->isApp())
    {
       $db->where('app_id', $this->data['app_id']);
       $specific = $db->getOne('applications a', 'a.*');
    }
    else
    {
      $db->where('component_id', $this->data['component_id']);
      $specific = $db->getOne('components c', 'c.*');
    }
    $this->data = serialize($specific, $this->data);
  }

  function removeFromStorage()
  {
    global $container;
    $db = $container->db();
    if (!$this->data['storage_id']) return false;
    $db->where("storage_id", $this->data['storage_id'])->delete("storage");
    return true;
  }

  function removeFromServer()
  {
    global $container;
    $db = $container->db();
    require_once ("class/class.server.php");
    if (!$this->data['process_id'] || !$this->data['server_id']) return false;
    $db->where('process_id', $this->data['process_id'])->delete('server_apps');
    $server = new Server($container);
    $server->recomputeServerResources($this->data['server_id']);
    return true;
  }
  function isComponent()
  {
    return $this->data['component_id'] ? true : false;
  }
  function isApp()
  {
    return $this->data['app_id'] ? true : false;
  }

  function isRunning()
  {
    return $this->data['running'] ? true : false;
  }
  function isDamaged()
  {
    return $this->data['damage'] ? true : false;
  }

  function getItemBasicData()
  {
    $basic = array('damage' => $this->data['damage']);
    if ($this->isApp())
      $basic['app_id'] = $this->data['app_id'];
    elseif ($this->isComponent())
      $basic['component_id'] = $this->data['component_id'];
    return $basic;
  }

  
}