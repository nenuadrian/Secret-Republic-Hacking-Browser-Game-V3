{include file="header_home.tpl"}
    
    {if $article.article_id}
            <a href="{$config.url}blogs/article/{$article.article_id}" >
          {else}
            <a href="{$config.url}blogs/{$blog.blog_id}">
          {/if}

<h3 class="text-center" title="Back">{$article.title}<br/>@ {if $blog.name}{$blog.name}{else}{$article.blogName}{/if}</h3>
</a>
<br/>

{include file="error_success.tpl"}

{if $preview}
  <div class="well">
    {$preview}
  </div>
{/if}


<form method="post" >
  <input type="text" maxlength="45" data-maxlength-position="top" class="mb10 glass-input" name="title"  value="{if $smarty.post.title}{$smarty.post.title|htmlentities}{else}{$article.title}{/if}" placeholder="Title"/>
  <textarea name="content" style="min-height:500px;" maxlength="{$config.blog_article_size}" class="glass-input" placeholder="Article content">{if $smarty.post.content}{$smarty.post.content|htmlentities}{else}{$article.content_unparsed}{/if}</textarea>
  <br/><br/>
  <div class="row">
    <div class="col-md-12">
      <div class="row-fluid">
        <div class="col-md-4 nopadding">
		  <button name="preview" value="true" title="Preview"><span class="glyphicon glyphicon-eye-open"></span></button>
          
        </div>
        <div class="col-md-8 nopadding">
          
          {include file="text_decorations.tpl"}
        </div>
        
      </div>
    </div>
  </div>
  <button type="submit"><span class="glyphicon glyphicon-send"></span></button>
</form>



