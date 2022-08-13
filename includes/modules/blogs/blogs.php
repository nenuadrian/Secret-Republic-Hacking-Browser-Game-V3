<?php
if ($GET["latestArticles"])
  require("latestArticles.php");
else {
  require_once('../includes/class/blogclass.php');

  $page_title = "Blog";

  if ($GET["article"])
    require("articles.php");
  elseif ($GET["create"] && $logged) {

      if ($user["blogs"] >= $user["maxBlogs"]) $cardinal->redirect(URL);

      $bclass->verify_create_blog();

      $tVars["display"] = 'blog/blog_create.tpl';

    } //$GET["create"] && $user["blogs"] < $user["maxBlogs"]
  elseif ($GET["myown"] && $logged) {
    //CREATE BLOG



    $blogs                        = $db->where('user_id', $user['id'])->get('blogs', null, 'blog_id,name,nra,nrs');
    $tVars["blogs"]   = $blogs;
    $tVars["display"] = 'blog/blog_main_list.tpl';




  } //!$GET["blog"] && $logged
    elseif ($GET["blog"]) {

    $select = "b.blog_id,name,user_id,nra,created,nrs,u.username user";

    if (ctype_digit($GET["blog"]))
      $blog = $db->where("blog_id", $GET['blog'])->join("users u", "u.id = b.user_id", "LEFT OUTER")->getOne("blogs b", $select);

    if (!$blog["blog_id"])
      $cardinal->show_404();
    else {
      $bclass->blog =& $blog;



      if ($user["id"] == $blog["user_id"]) {


        $bclass->verify_change_name();

        // CREATE ARTICLE
        if ($GET["add"] == "article") {

          $bclass->verify_create_article();


          $tVars["display"] = "blog/blog_add_article.tpl";
        } //$GET["add"] == "article"


      } // of blog owner

      if (!$tVars["display"]) {

        $blog["created"] = date_fashion($blog["created"]);

        if($blog["nra"]){

          $pages = new Paginator;
          $pages->items_total = $blog["nra"];
          $pages->mid_range = 5;
          $pages->items_per_page = $config["nra_page"];
          $pages->paginate();
          $articles=$db->rawQuery("select article_id,title,created,votes,content,nrc from blog_articles where blog_id=? order by created desc ".$pages->limit,
                                array($blog["blog_id"]));


          foreach($articles as &$x) $x["created"]=date_fashion($x["created"]);
        }

        if ($logged && $user["id"] != $blog["user_id"])
          $bclass->manageSubscribtion($blog);


        $page_title = "Blog " . $blog["name"] . " created by " . $blog["user"];


        $smarty->assign("articles", $articles);

        $tVars["display"] = "blog/blog_show.tpl";
      } //!$tVars["display"]
      $tVars["blog"] = $blog;
    }
  } //$GET["blog"]
  else
  {
    $orders = array('nra', 'name', 'nrs',  'created');
    $orderBy = in_array($GET['order'], $orders) ? $GET['order'] : $orders[0];

    $order = $GET['asc'] ?  'asc' : 'desc';

    $blogs = $db->getOne('blogs', 'count(*) nrb');
    $pages = new Paginator;
    $pages->items_total = $blogs["nrb"];
    $pages->items_per_page = 30;
    $pages->paginate();

    $blogs = $db->rawQuery('select * from blogs order by ' . $orderBy . ' ' . $order . ' ' . $pages->limit);

    $tVars['blogs'] = $blogs;
    $tVars["display"] = 'blog/blogs.tpl';
  }
}
?>
