<?php

class organizationWars extends Alpha
{
  function __construct(Container $container)
  {
    parent::__construct($container);
  }

  function fetchOrganizationWars($org_id)
  {
    $wars = 
      $this->db->rawQuery('select ow.*, o.name, o.id from org_wars ow 
                           left outer join organizations o on
                           case org1_id
                             when ? then org2_id = o.id
                             else org1_id = o.id
                           end
                           where (org1_id = ? or org2_id = ?)
						   order by created desc',
                          array($org_id, $org_id, $org_id));
    foreach ($wars as $k => &$war)
    {
      $this->processWar($war);
      if (!$war) unset($wars[$k]);
    }
    
    return $wars;
  }
  
  function processWar(&$war)
  {
    if ($war['status'] == 1)
    {
      if ($war['start'] > time())
      {
        $war['start_date'] = date('d/F/Y H:i', $war['start']);
      }
      else // war begins
      {
        $updateWar = array('status' => 2);
        $war = array_merge($war, $updateWar);
        $this->db->where('war_id', $war['war_id'])->update('org_wars', $updateWar);
      }
      
    }
    
    if ($war['status'] == 2)
    {
      if ($war['ends'] > time())
      {
        $war['ends_date'] = date('d/F/Y H:i', $war['ends']);
      }
      else // war has ended
      {
        $endedWar = $war;
        $endedWar = array(
          'org1_id' => $war['org1_id'],
          'org2_id' => $war['org2_id'],
          'org1_points' => $war['org1_points'],
          'org2_points' => $war['org2_points'],
          'finished' => $war['ends'],
          'created' => time(),
          'winner_org_id' => $war['org1_points'] > $war['org2_points'] ? $war['org1_id'] : $war['org2_id'],
        );  
        if ($this->db->insert('org_ended_wars', $endedWar))
        {
          $this->db->where('war_id', $war['war_id'])->delete('org_wars');
          $war = null;
        }
      }
    }
  }
} 