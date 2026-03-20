<?php
class Forum extends Alpha{

		function __construct(Container $container, $org=false, $org_access = array()){
		  parent::__construct($container);

			$this->posts_per_page = 10;

			$this->sections=$this->posts=$this->views=$this->config['sql_prefix'];
			$this->section_url=$this->config["url"]."forum/fid/";
			$this->furl = $this->config["url"]."forum/";

			if($org){
				$this->sections.="org_";
				$this->posts.="org_";
				$this->views.="org_";
				$this->extra_check=" and org=".$org." ";
				$this->sections_extra_check=" and fs.org=".$org." ";
				$this->org=intval($org);
				$this->section_url=$this->config["url"]."organization/view/forum/fid/";
				$this->furl=$this->config["url"]."organization/view/forum/";

			}

			$this->sections.="forum_sections";
			$this->posts.="forum_posts";
			$this->views.="forum_views";

			$this->access["forumManager"] = $this->user['cardinal'] || (!$org && $this->user['forumManager']) || $org_access['forumManager'];
			$this->access['canDeleteOwnThreads'] = false;

			$this->templateVariables["forumAccess"] = $this->access;
			$this->templateVariables['furl'] = $this->furl;

		}

	    function get_categories(){
			if ($this->org)
			$sections = $this->db->rawQuery("select fs.*, fp.created last_created, fp.id last_post_id, fp.parent last_parent, u.username last_user from `{$this->sections}` fs
											 left outer join {$this->posts} fp on fp.id = (select id from {$this->posts} fpp where fpp.fid = fs.id order by created desc limit 1)
											 left outer join users u on u.id = fp.user_id
											 where fs.org = ?
											 order by fs.ord asc, fs.id asc", array($this->org));

			else
			$sections = $this->db->rawQuery("select fs.*, fp.created last_created, fp.id last_post_id, fp.parent last_parent, u.username last_user from `{$this->sections}` fs
											 left outer join {$this->posts} fp on fp.id = (select id from {$this->posts} fpp where fpp.fid = fs.id order by created desc limit 1)
											 left outer join users u on u.id = fp.user_id

											 order by fs.ord asc, fs.id asc");

			foreach($sections as &$section)
			{
					$section["url"]=$this->section_url.$section["id"];
					if ($section['last_post_id'])
					{
						$section['last_created'] = date_fashion($section['last_created']);
					}
			}
			return $sections;
		}

		function validate_thread_data($data, $validateTitle = true){

			if(!$validateTitle || strlen($data["title"])<=70 && strlen($data['title']) >= 5){

				if(strlen($data["content"])>10 && strlen($data["content"])<=$this->config["forum_post_size"] ){
					$this->content = ($data["content"]);
					$this->title = htmlentities($data["title"]);
						return false;
				}else $error="Content length must be higher than 10 and lower than ".$this->config["forum_post_size"];
			}else $error="5-70 characters in title";

			return $error;
		}
		function new_thread($forum){
			if ($_POST)
			if($error = $this->validate_thread_data($_POST))
				$this->errors [] = $error;
			else
			{
				$parser = new \JBBCode\Parser();
				$parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
				$parser->parse($this->content);
				if($_POST["preview"])
				{
					$this->templateVariables["preview"] = $parser->getAsHtml();
					return;
				}
				$postFrequencyCheck = $this->db->where('user_id', $this->user['id'])->where('created', time() - 60, '>=')->getOne($this->posts, 'id, created');

				if( $postFrequencyCheck["id"])
					$this->errors[] ="You must wait 60 seconds between posts. ".($postFrequencyCheck["created"]+60 - time())." seconds until you can post again";

				if (!count($this->errors))
				{

				  $dataInsert = array(
					"created" => time(),
					"user_id" => $this->user["id"],
					"title" => $this->title,
					"content" => $parser->getAsHtml(),
					"unparsed_content" => $this->content,
					"fid" => $forum["id"],
				  );

					if($this->org)
					  $dataInsert["org"] = $this->org;

					$xx = $this->db->insert($this->posts, $dataInsert);

					if($xx){
						$this->db->where('id', $forum['id'])->update($this->sections, array('threads' => $forum['threads'] + 1));
						$this->redirect($this->furl."tid/".$xx);

					} else $this->errors[]="An unexpected error has occured";

				}
			}

		}

		function managePostEdit($post_id)
		{

      $post=$this->get_post_data($post_id);

      if($post["id"] && ($this->user["id"]==$post["user_id"] || $this->access["forumManager"])){

        $this->edit_post($post);

        $this->templateVariables["post"] = $post;
        $this->templateVariables["load"] = "forum_create_thread";

      }else $this->redirect($this->furl);//cardinal->show_404();
		}
		function edit_post($post){

			if($_POST)
			{
			  $error = $this->validate_thread_data($_POST, !$post['parent']);

				if(!$error){
					$parser = new \JBBCode\Parser();
					$parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
					$parser->parse($this->content);
					// SHOW PREVIEW ?
					if(!$_POST["preview"]){
						$dataUpdate = array(
						  "content" =>  $parser->getAsHtml(),
						  "unparsed_content" => $this->content,
						);
						if(!$post["parent"])
						  $dataUpdate["title"] = $this->title;

						$this->db->where("id",  $post["id"])->update($this->posts, $dataUpdate);

						if($post["parent"])
						  $this->redirect($this->furl."tid/".$post["parent"]."#p".$post["id"]);
						else
						  $this->redirect($this->furl."tid/".$post["id"]);
					  }
					  else
					  {
						$this->templateVariables["preview"] =  $parser->getAsHtml();
					  } // PREVIEW

			  } else $this->errors[] = $error;

		 }

		}



		function get_thread_data($tid){

				$r=$this->db->rawQuery(
					               "select fp.title, fp.fid, fp.closed, fp.stick, fp.created, fp.replies, fp.id as id,u.username user,u.gavatar,u.level
				                    from `{$this->posts}` as fp
				                    left outer join users  u on u.id=user_id
				                    where fp.id=? and parent is null limit 1", array($tid));
			$r = $r[0];

			return $r;
		}
		function get_forum_data($fid)
		{
			return $this->db->rawQUery('select * from '.$this->sections.' where id = ? '.$this->extra_check.' limit 1', array($fid))[0];
		}
		function thread_process(&$thread){

			$forum = $this->get_forum_data($thread['fid']);


			if($this->logged)
			{
				$this->thread_management($thread);

        		if(!$thread["closed"] || $this->access["forumManager"] )
         			 $this->thread_reply($thread);
			}


			$posts= $this->get_posts($thread);


			if($_GET["page"]>$this->pages->num_pages)
				$this->redirect($this->furl."tid/".$thread["id"]);

			$this->templateVariables['forum'] = $forum;
			$this->templateVariables['thread'] = $thread;
			$this->templateVariables['posts'] = $posts;


		}
		function get_post_data($pid)
		{
			return $this->db->rawQuery("select fp.*,u.username user from ".$this->posts." as fp
			                      left outer join users u on u.id=fp.user_id
								  where fp.id=? limit 1",
								  array($pid))[0];

		}


		function get_threads($forum){
				if (!$forum['id']) return;

				$this->pages = new Paginator;
				$this->pages->items_total = $forum["threads"];
				$this->pages->items_per_page = 10;
				$this->pages->paginate();

				$this->db->where('fp.fid', $forum['id'])
				         ->where('fp.parent is null')
				         ->join($this->posts.' last_fp', 'last_fp.id = (select id from '.$this->posts.' fpp where fpp.parent = fp.id or fpp.id = fp.id order by created desc limit 1)', 'left outer')
			             ->join('users u', 'u.id = fp.user_id', 'left outer')
			             ->join('users last_u', 'last_u.id = last_fp.user_id', 'left outer')
				         ->orderBy('fp.stick', 'desc')
				         ->orderBy('last_fp.created', 'desc')
				         ->orderBy('created', 'desc');

				$threads = $this->db->get($this->posts.' fp', $this->pages->limit, 'fp.id, fp.title,fp.user_id, fp.closed, fp.replies, last_fp.created last, fp.stick,fp.created, u.username  user, last_u.username last_user');
        		foreach($threads as &$thread)
        		{
        			$thread['last'] = date_fashion($thread['last']);
        		}
				return $threads;


		}

		function get_posts($thread){



				$this->pages = new Paginator;
				$this->pages->items_total = $thread["replies"] + 1;
				$this->pages->items_per_page = $this->posts_per_page;
				$this->pages->paginate();

				$posts=$this->db->rawQuery('select fp.*,fp.id as id,u.username as user,u.gavatar as gavatar,u.level'.(!$this->org ? ', o.name, u.organization': '').'
				                          from '.$this->posts.' as fp
				                          left outer join users u on u.id=fp.user_id
										  '.(!$this->org ? 'left outer join organizations o on o.id = u.organization': '').'
				                          where parent=? or fp.id = ? order by created asc '.$this->pages->limit, array($thread["id"], $thread["id"]));




			return $posts;

		}

		function thread_management(&$thread){


				if($_POST["close"] && $this->access["forumManager"]){

					$thread["closed"] = $thread["closed"] ? 0 : 1;
					$this->db->where('id', $thread['id'])->update($this->posts, array('closed' => $thread['closed']));


				}elseif($_POST["stick"] && $this->access["forumManager"]){
				  $thread["stick"] = $thread["stick"] ? 0 : 1;
			    $this->db->where('id', $thread['id'])->update($this->posts, array('stick' => $thread['stick']));

				}elseif($_POST["del"]){
				  if ($_POST['del'] == $thread['id'])
				    $postToBeDeleted = $thread;
				  else
					  $postToBeDeleted= $this->db->where('id', $_POST['del'])->getOne($this->posts, 'user_id,id,parent');

          if($postToBeDeleted["id"]){

            if($this->access["forumManager"] || ($this->access["canDeleteOwnPosts"] && $postToBeDeleted["user_id"]==$this->user["id"]))
            {
              if ($this->db->where('id', $postToBeDeleted['id'])->delete($this->posts))
              {
                if($postToBeDeleted["parent"]==0)
                {
                  $this->db->where('parent', $postToBeDeleted['id'])->delete($this->posts);
                  $this->db->rawQuery("UPDATE {$this->sections} SET threads = threads - 1 WHERE id = ? limit 1", array($postToBeDeleted['fid']));


                  $this->redirect($this->furl."fid/".$thread["fid"]);
                }
                else $success="Post has been deleted";

				$this->db->where('id',  $postToBeDeleted["id"])->delete($this->posts, 1);
                $this->db->where('id', $thread['id'])->update($this->posts, array('replies' => $thread['replies'] - 1), 1);
                $thread["replies"]--;
              }

            }else $error="You do not have the permission to delete this post";

          }
				}

		}

		function thread_reply($thread){

			if(!$_POST["reply"]) return;

			$content = ($_POST["reply"]);
			if($content){
				$parser = new \JBBCode\Parser();
				$parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
				$parser->parse($content);

				$dataInsert = array(
				  "created" => time(),
				  "content" => $parser->getAsHtml(),
				  "unparsed_content" => $content,
				  "user_id" => $this->user["id"],
				  "parent" => $thread["id"],
				  "fid" => $thread["fid"]
				);

				$x=$this->db->insert($this->posts, $dataInsert);
				if ($x){

					$this->db->where('id', $thread['id'])->update($this->posts, array('replies' => $thread['replies'] + 1), 1);
					$p = floor($thread["replies"] / $this->posts_per_page) + 1;


					$this->redirect($this->furl."page/".$p."/tid/".$thread["id"]."#p".$x);
				}else $this->errors[]="An unexpected error has occured";
			}
		}


	}




?>
