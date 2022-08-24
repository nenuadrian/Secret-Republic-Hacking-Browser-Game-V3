<?php


if (GET('details'))
{
  $cardinal->mustLogin();

  $details = $db->where('user_id', $user['id'])->getOne('rankings_stats');
  $tVars['details'] = $details;
  $tVars['display'] = 'rankings/details.tpl';
}	
else
{
	$page_title="Rankings database";

	$smarty->caching = 1; // lifetime is per cache
  $smarty->cache_lifetime = 60*60;
  
  $GET["type"] = in_array($GET["type"], array("blogs", "orgs")) ? $GET["type"] : "users";
  $cache_id = $GET["type"]."-".intval($GET["page"])."-".($GET["zone"] >= 1 && $GET["zone"] <= 6 ? $GET["zone"] : "");

  if(!$smarty->isCached('rankings/rankingsGrid.tpl', $cache_id) )
  {
       
    if($GET["type"]=="orgs"){
     
      $orgs = $db->getOne("organizations", "count(*) nro");

      $pages = new Paginator;
      $pages->items_total = $orgs["nro"];
      $pages->mid_range = 5; 
		$pages->items_per_page = 20; 
      $pages->paginate();
    
      $orgs = $db->rawQuery('select id, name, orank, nrm, points from organizations where orank >0 order by orank asc '. $pages->limit);
    
  
      $rankings["orgs"] = $orgs;
  
    }else{

      $rankSelect = ",`rank`";
      if(ctype_digit($GET["zone"]) && $GET["zone"] >0 && $GET["zone"]<7)
      {
        $zone = intval($GET["zone"]);
        $db->where("zone", $zone);
        $rankSelect = ",zrank as `rank`";
      }
    
      $rankings["topUsers"] = $db->where("`rank` > 0")
                                 ->orderBy("`rank`", "asc")->get("users", 3, "username,gavatar, id ".$rankSelect);
    
      if ($zone) $db->where("zone", $zone);
    
      $users = $db->where("`rank` > 0")->getOne("users", "count(*) nru");
      $pages = new Paginator;
      $pages->items_total = $users["nru"];
		  $pages->items_per_page = 20; 
      $pages->paginate();
      $db->pageLimit = $pages->items_per_page;

      $db->orderBy("`rank`", "asc");
      if ($zone)
        $db->where("zone", $zone);
        
      $users = $db->where("`rank` > 0")->paginate("users", $pages->current_page, "id, username, level, zone, points, gavatar".$rankSelect);
    
      $rankings["zone"] = $zone;
      $rankings["users"] = $users;
    }
    $rankings["config"] = $config;
    $rankings["pages"] = $pages->display_pages();
    $smarty->assign($rankings);
	}
  $tVars["rankingsGrid"] = $smarty->fetch("rankings/rankingsGrid.tpl", $cache_id);
  $smarty->caching = 0;
	$tVars["display"] = 'rankings/rankings.tpl';
}

?>
