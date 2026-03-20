<?php

class ServerComponent
{
  function __construct($storage_id = false, $user_id = false, $relation_id = false)
  {
    global $container;
    $db = $container->db();
    if ($storage_id)
    {
      $db->join("components c", "c.component_id = s.component_id", "left outer");
      $db->where('storage_id', $storage_id);
    }
    if ($user_id)
    {
      $db->where('user_id', $user_id);
    }
    if ($storage_id)
    {
      $this->info = $db->getOne('storage s');
    }

    $this->info["default_sell_price"] -= ($this->info["default_sell_price"]/100) * $this->info['damage'];

  }
}

function processComponentMount($storage_id)
{

}

function fetchComponentFromStorage($user_id, $storage_id)
{
  global $container;
  $db = $container->db();
  $component = $db->join("components c", "c.component_id = s.component_id", "left outer")
                ->where('storage_id', $storage_id)
                ->where('user_id', $user_id)
                ->getOne('storage s');
  return $component['storage_id'] ? $component : false;
}
function sellComponentFromStorage($user_id, $storage_id)
{
  global $container;
  $db = $container->db();
  $component = fetchComponentFromStorage($user_id, $storage_id);

  if (!$component['storage_id']) return false;
  $component["default_sell_price"] -= ($component["default_sell_price"]/100) * $component['damage'];

  $db->where("storage_id", $component['storage_id'])->delete("storage", 1);

  $db->rawQuery('update users set money=money+? where id=?', array($component["default_sell_price"], $user_id));
  return $component;
}


function handlePickSlotForComponent($server, $component, $pickedSlot = false)
{
  global $container;
  $db = $container->db();
  $tVars = &$container->tVars;

  $slots = $db->rawQuery('select sc.*, c.* from server_components sc
                          left outer join components c on c.component_id = sc.component_id
                          where sc.server_id = ? and c.type = ?',
                array($server->server_id, $component['type']));

  if ( $component['type'] == 5)
  {
    if ($server->server['ram_slots'] > count($slots))
      $slotsAreAvailable = $server->server['ram_slots'] - count($slots);
  }
  elseif ($server->server['hdd_slots'] > count($slots))
    $slotsAreAvailable = $server->server['hdd_slots'] - count($slots);



  if (isset($pickedSlot))
  {
    $pickedSlot = intval($pickedSlot);
    if ($pickedSlot === 0 && $slotsAreAvailable)
      $componentToReplace = "freeSlot";
    else
      foreach ($slots as $componentToReplace)
        if ($componentToReplace['relation_id'] == $_POST['slot'])
        {
          if ($component['ram'])
            if ($server->server['total_ram'] - $componentToReplace['ram'] + $component['ram'] < $server->server['ram_usage'])
              add_alert("Current RAM usage is higher than available RAM after replace");

          if ($component['hdd'])
            if ($server->server['total_hdd'] - $componentToReplace['hdd'] + $component['hdd'] < $server->server['hdd_usage'])
              add_alert("Current HDD usage is higher than available HDD after replace");


          break;
        }
    if (!there_are_errors())
      return $componentToReplace;
  }

  $tVars["slots"] = $slots;
  $load = "pick_slot";
  $tVars['slotsAreAvailable'] = $slotsAreAvailable;
  return false;
}
function replaceComponentWithComponent($server, &$component, &$componentToReplace, $user_id)
{
  global $container;
  $db = $container->db();


  if (!$componentToReplace)
  {
    $componentToReplace = $db->rawQuery('select c.*, sc.* from server_components sc
                        left outer join components c on c.component_id = sc.component_id
                        where sc.server_id = ? and c.type = ? limit 1',
                      array($server->server_id, $component['type']));
    $componentToReplace = $componentToReplace[0];
  }


  $db->where('storage_id', $component['storage_id'])->delete('storage', 1);



  if ($componentToReplace['relation_id'])
  {
    $db->where('relation_id', $componentToReplace['relation_id'])
       ->delete('server_components');

    $newStorage = array(
      'component_id' => $componentToReplace['component_id'],
      'user_id' => $user_id,
      'damage' => $componentToReplace['damage'],
    );
    $db->insert('storage', $newStorage);
  }
  elseif ($componentToReplace == 'freeSlot')
  {
    $componentToReplace = array('name' => "Free slot");
  }

  $insertData = array(
    'server_id' => $server->server_id,
    'component_id' => $component['component_id'],
    'damage' => $component['damage'],
  );
  $db->insert('server_components', $insertData);

  $server->recomputeServerResources();
  return true;
}
