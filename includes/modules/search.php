<?php

	
$cardinal->mustLogin();

	if ($_POST["query"])
	  $cardinal->redirect(URL."search/type/".$_POST["type"]."/query/".urlencode($_POST["query"]));

	if($search=$GET["query"])
	{
	  if (strlen($search) > 100)
	    $errors[] = "Please use less than 100 chars in your search";
	  else
	  {
        if($GET["type"]=="user"){

          if ($cardinal->loginSystem->validateUsername($search))
          {

              $results = $db->where("username", array("like" => sprintf("%%%s%%",$search)))->getOne("users", "count(id) nrUsers");
              $tVars["count"] = $results["nrUsers"];

                $pages = new Paginator;
                $pages->items_total = $results["nrUsers"];
                $pages->mid_range = 5;
                $pages->paginate();

                $db->pageLimit = $pages->items_per_page;
              $results=$db->where("username", array("like" => sprintf("%%%s%%",$search)))
                          ->orderBy("username", "asc")
                          ->paginate("users", $pages->current_page, "username, id, zone, zrank, `rank`");
          } else $errors[] = "Invalid username provided. You don't need the exact username, but you need to write a valid one.";


        }
        elseif($GET["type"]=="org")
        {


              require_once('../includes/class/oclass.php');

              $oclass = new Organization();
              if (!($nameError = $oclass->validataOrgName($search, false)))
              {
                $results = $db->where("name", array("like" => sprintf("%%%s%%",$search)))->getOne("organizations", "count(id) nrOrgs");
              $tVars["count"] = $results["nrOrgs"];
                  $pages = new Paginator;
                  $pages->items_total = $results["nrOrgs"];
                  $pages->mid_range = 5;
                  $pages->paginate();
                  $db->pageLimit = $pages->items_per_page;

                $results=$db->where("name", array("like" => sprintf("%%%s%%",$search)))
                            ->orderBy("name" ,"asc")
                            ->get("organizations", $pages->current_page, "id, name, nrm, orank");
              } else $errors[] = $nameError;


        }
        elseif($GET["type"]=="blog")
        {

          require_once('../includes/class/blogclass.php');

          if ($bclass->validateBlogTitle($search))
          {
            $results = $db->where("name", array("like" => sprintf("%%%s%%",$search)))->getOne("blogs", "count(blog_id) nrBlogs");
           $tVars["count"] = $results["nrBlogs"];

              $pages = new Paginator;
              $pages->items_total = $results["nrBlogs"];
              $pages->mid_range = 5;
              $pages->paginate();
              $db->pageLimit = $pages->items_per_page;

            $results=$db->where("name", array("like" => sprintf("%%%s%%",$search)))
                        ->orderBy("nrs", "desc")
                        ->orderBy("name", "asc")
                        ->paginate("blogs", $pages->current_page, "blog_id, name, nrs, nra");
          }

        }
        elseif($GET["type"]=="article")
        {

          require_once('../includes/class/blogclass.php');

          if ($bclass->validateBlogTitle($search))
          {
            $results = $db->where("title", array("like" => sprintf("%%%s%%",$search)))->getOne("blog_articles", "count(article_id) nrArticles");
           $tVars["count"] = $results["nrArticles"];

              $pages = new Paginator;
              $pages->items_total = $results["nrArticles"];
              $pages->mid_range = 5;
              $pages->paginate();
              $db->pageLimit = $pages->items_per_page;

            $results=$db->where("title", array("like" => sprintf("%%%s%%",$search)))
                        ->orderBy("votes", "desc")
                        ->orderBy("title", "asc")
                        ->paginate("blog_articles", $pages->current_page, "article_id, title, votes, nrc");
          }

        }

    }
	}
	$tVars["results"] = $results;
	$tVars["display"] = 'search/search.tpl';

?>
