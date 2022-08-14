<?php


$article = $bclass->fetchArticle($GET["article"]);


if(!$article["article_id"])
  $cardinal->show_404();
else
{

    
  $page_title= $article["title"];
  // edit article
  if($GET["action"] == "edit" && $article["user_id"] == $user["id"])
  {
    
      $bclass->verify_create_article($article);
    
   
      $tVars["article"] = $article;
      $tVars["display"] = "blog/blog_add_article.tpl";        
  }
  else
  {
    $bclass->blog["blog_id"] = $article["blog_id"];
 
    if($article["user_id"]!=$user["id"])
    {
      if($logged)
      {
        //CHECK IF ARTICLE VOTED
        $voted = $db->where('article_id', $article['article_id'])->where('user_id', $user['id'])->getOne('blog_article_votes', 'vote_id');
        $article["voted"] = $voted["vote_id"] ;
    
        //VOTE ARTICLE
        if($_POST["vote"])
		{
		  if (!$article["voted"])
         	$bclass->voteUp($article);
          else
          	$bclass->voteDown($article);
		  $cardinal->redirect(URL_C);
	    }
        
        
        $article["subscribed"] = $bclass->manageSubscribtion($article);
        
        
      }
    }
    
    //ADD COMMENT
        $bclass->check_add_comment($article);
        
    //GET COMMENTS
    $bclass->fetch_article_comments($article);

  
    $article["created"]=date_fashion($article["created"]);
  
    $tVars["article"] = $article;
  
    $tVars["display"] = "blog/blog_article.tpl";
  }
}