<?php
class Blog extends Alpha {

  function __construct() {
    parent::__construct();
  }

  function validateBlogTitle($title) {
    global $errors;


    if (strlen($title) <= 50 && strlen($title) >= 5) {

      return true;

    } else
      $errors[] = "Title must be between 5 and " . $this->config["blog_title_size"] . " characters";


    return false;
  }

  function fetchArticle($id) {

    $select = "ba.*,b.blog_id,b.user_id,b.name as blogName, u.username as user,u.zone as uzone";

    $article = $this->db->join('blogs b', 'b.blog_id = ba.blog_id', 'left outer')->join('users u', 'u.id=b.user_id ', 'left outer')->where('ba.article_id = ?', array(
      $id
    ))->getOne('blog_articles ba', $select);


    return $article;
  }



  function voteUp(&$article) {
    $this->db->insert("blog_article_votes", array(
      "article_id" => $article['article_id'],
      "user_id" => $this->user['id'],
      'created' => time()
    ));
    $_SESSION['success'] = "Thumbs up received";
  }

  function voteDown(&$article) {

    $this->db->where('article_id', $article['article_id'])->where('user_id', $this->user['id'])->delete('blog_article_votes', 1);
    $_SESSION['success'] = "Thumbs up removed";
  }

  function verify_create_blog() {
    global $uclass, $errors;

    if ($_POST) {
      $title = $_POST["title"];
      if ($this->validateBlogTitle($title)) {

        $dataInsert = array(
          "name" => htmlentities($title),
          "created" => time(),
          "user_id" => $this->user["id"]
        );
        $blog_id    = $this->db->insert("blogs", $dataInsert);

        if ($blog_id) {

          $uclass->update_user("blogs=blogs+1", $this->user["id"], false);

          $this->redirect($this->config["url"] . 'blogs/blog/' . $blog_id);
        } else
          $errors[] = "Something went wrong";
      }
    }
  }

  function verify_create_article($article = null) {
    global $user, $errors;

    if ($_POST) {
      // check last time an article has been posted by user
      $lastArticle = $this->db->where('blog_id', $this->blog['blog_id'])->where('created >= ' .  (time() - 60))->getOne('blog_articles', 'article_id');
      if ($latestArticle['article_id'])
        $errors[] = 'You can only publish one article every 60 seconds.';
      else if ($this->validateBlogTitle($title = $_POST["title"]) && $this->validateArticleContent($content = $_POST["content"])) {
        $parser = new \JBBCode\Parser();
        $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
        $parser->parse($content);
        $content_parsed = $parser->getAsHtml();

        if ($_POST["preview"])
          $this->templateVariables["preview"] = $content_parsed;
        else {
          if (!isset($article)) {


            $dataInsert = array(
              "title" => htmlentities($title),
              "content" => $content_parsed,
              "content_unparsed" => $content,
              "created" => time(),
              "blog_id" => $this->blog["blog_id"]
            );
            $artid      = $this->db->insert("blog_articles", $dataInsert);
            $this->db->rawQuery("update blogs set nra = nra+1 where blog_id=?  ",
              array($this->blog["blog_id"]));
            
            $url = $this->config["url"] . 'blogs/article/' . $artid;

            //SEND TO ALL SUBSCRIBERS
            $this->send_notice_subscribers($url, $title, $this->blog["blog_id"]);

           
            $this->redirect($url);
          } else {
            $dataUpdate = array(
              "title" => htmlentities($title),
              "content" => $content_parsed,
              "content_unparsed" => $content,
              "edited" => time()
            );

            $this->db->where("article_id", $article["article_id"])->update("blog_articles", $dataUpdate);

           

            $this->redirect($this->config["url"] . 'blogs/article/' . $article["article_id"]);

          }
        } // not preview

      } // title and content valid
    }
  }

  function send_notice_subscribers($url, $aname, $blog) {
    global $user;

    $content = "I have published a new article in my blog (" . $blog["name"] . ") to which you have subscribed!
            Article title: " . $aname . "
            Article link: [url]" . $url . "[/url]

      ";
    $subs    = $this->db->where('blog_id', $blog)->get('blog_subscriptions', null, 'user_id');


    foreach ($subs as $sub)
      $this->uclass->send_msg($user["id"], $sub["user_id"], $content, 'New article @ ' . $blog['name']);
  }

  function validateArticleContent($content) {
    global $errors;

    if (strlen($content) >= 10 && strlen($content) <= $this->config["blog_article_size"]) {

      return true;

    } else
      $errors[] = "Content must have between 100 and " . $this->config["blog_article_size"] . " chars";
  }

  function check_add_comment(&$article) {
    global $url;

    if ($_POST["comment"]) {
      $content = $_POST["comment"];

      if (strlen($content) <= 500 && strlen($content) >= 3) {
        $parser = new \JBBCode\Parser();
        $parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
        $parser->parse($content);
        $content = $parser->getAsHtml();

        $comment = array(
          'content' => $content,
          'created' => time(),
          'user_id' => $this->user['id'],
          'article_id' => $article['article_id']
        );
        $this->db->insert('blog_comments', $comment);

        $this->db->rawQuery('update blog_articles set nrc=nrc+1 where article_id = ?', array(
          $article['article_id']
        ));

        $_SESSION["success"] = "Comment added";
        $this->redirect(URL_C);

      } else
        $errors[] = "Content must have between 3 and 500 characters";
    }
  }

  function fetch_article_comments($article) {

    if ($article["nrc"]) {
      $this->pages                 = new Paginator;
      $this->pages->items_total    = $article["nrc"];
      $this->pages->mid_range      = 5;
      $this->pages->items_per_page = $this->config["nrc_page"];
      $this->pages->paginate();
      $this->db->pageLimit = $this->pages->items_per_page;

      $comments = $this->db->join('users u', 'u.id=bc.user_id', 'left outer')
        ->where('article_id', $article['article_id'])
        ->paginate('blog_comments bc', $this->pages->current_page, 'bc.comment_id,content,created,u.username as user');

      foreach ($comments as &$x) {
        $x["created"] = date_fashion($x["created"]);
      }

      $this->templateVariables["comments"] = $comments;
    }

  }

  function manageSubscribtion($blog) {

    $hasSubscribed = $this->db->where('blog_id', $blog["blog_id"])->where('user_id', $this->user['id'])->getOne('blog_subscriptions', 'subscription_id');


    if (submitted_form("subscribe")) {
      if (!$hasSubscribed['subscription_id']) {
        $dataInsert = array(
          'blog_id' => $blog['blog_id'],
          'user_id' => $this->user['id'],
          'created' => time()
        );
        $this->db->insert('blog_subscriptions', $dataInsert);
        $blog['nrs']++;
      } else {
        $this->db->where('subscription_id', $hasSubscribed["subscription_id"])->delete('blog_subscriptions');
        $blog["nrs"]--;
      }

      $this->db->where('blog_id', $blog['blog_id'])->update('blogs', array(
        'nrs' => $blog['nrs']
      ));
      $this->redirect(URL_C);
    }

    return $hasSubscribed["subscription_id"];
  }


  function fetch_subscribers($blog) {
    global $subscribers;

    $this->pages                 = new Paginator;
    $this->pages->items_total    = $blog["nrs"];
    $this->pages->mid_range      = 5;
    $this->pages->items_per_page = 15;
    $this->pages->paginate();
    $subscribers = $this->db->where("bs.blog_id", $blog["blog_id"])->join("users u", "u.id = bs.user_id", "LEFT OUTER")->orderBy("created", "desc")->get("blog_subscriptions bs", $this->limit, "created,u.username  user");

    $tVars["subscribers"] = $subscribers;
  }

  function verify_change_name() {

    if ($_POST["edit"]) {
      if ($this->validateBlogTitle($title = $_POST["title"])) {
        $updateData = array(
          "name" => htmlentities($title)
        );
        $this->db->where("blog_id", $this->blog["blog_id"])->update("blogs", $updateData);
        $this->redirect(URL_C);

      }

    }

  }
}
$bclass = new Blog;
