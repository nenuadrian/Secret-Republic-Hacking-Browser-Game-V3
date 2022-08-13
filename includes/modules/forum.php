<?php
	

require_once('../includes/class/class.forum.php');


	$page_title="Hacker Forums";
	
	$fclass=new Forum();
	
	if(ctype_digit($GET["fid"])){
		$forum=$fclass->get_forum_data($GET["fid"]);
		
		if(!$forum["id"]) $cardinal->show_404();
		
		if($GET["new"]=="thread" && (!$forum['locked'] || $fclass->access["forumManager"]))
		{

			$fclass->new_thread($forum);
			
			$tVars["load"]="forum_create_thread";
		}else{
		
				$threads=$fclass->get_threads($forum);
						
				$smarty->assign(array(
						"forum"=>$forum,
						"threads"=>$threads
					));
					
				$tVars["load"]="forum_threads";
		}
		
	}elseif(ctype_digit($GET["tid"])){
			
		$thread=$fclass->get_thread_data($GET["tid"]);
		if($thread["id"]){
			
			$fclass->thread_process($thread);
			$page_title = $thread['title'];
			$tVars["load"]="forum_thread";
			
		}else $cardinal->show_404();
	}elseif(ctype_digit($GET["edit"])){

		$fclass->managePostEdit($GET['edit']);
		
	}else{
			$category=$fclass->get_categories();

			$smarty->assign("category",$category);
	}
	
	$tVars['noSidebar'] = true;
	$tVars['noContainer'] = true;
	
	$tVars["load"]=$tVars["load"] ? "forum/".$tVars["load"].".tpl" : null;
	$tVars["furl"] = $fclass->furl;

	$tVars["display"] = 'forum/forum.tpl';

?>
