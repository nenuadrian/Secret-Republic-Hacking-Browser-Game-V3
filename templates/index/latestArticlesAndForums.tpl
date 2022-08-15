<div class="articles-list">
  <div class="row">
     <div class="col-xs-6 cut-text">
        latest news | <strong>{if !$latestNews.title}none{else}<a href="{$config.url}forum/tid/{$latestNews.id}">{$latestNews.title}</a>{/if} </strong>
     </div>
     <div class="col-xs-6 text-right cut-text">
       <strong>{if !$latestEvent.title}none{else}<a href="{$config.url}forum/tid/{$latestEvent.id}">{$latestEvent.title}</a>{/if} </strong> | latest event
     </div>
   </div>
</div>



  <div class="row">
    <div class="col-md-12">

      <div class="articles-holder">
        <div class="row">
          <div class="col-md-4 articles-column">
            <div class="articles-column-content">
              <p>
                <a href="{$config.url}blogs/latestArticles/emilia">
                  LATEST ARTICLES
                </a>
              </p>
              <div class="articles-list">
	      	  {if empty($articles)}
                      No articles yet!
                  {/if}
                  {foreach from=$articles item=article}
                      <a href="{$config.url}blogs/article/{$article.article_id}" title="{$article.nrc|number_format} comments / {$article.votes|number_format} votes">
                        {$article.title} ({$article.nrc|number_format}/{$article.votes|number_format})
                      </a>
                  {/foreach}
                  <div class="bottom-line">
                    <div class="line"></div>
                  </div>
              </div>

             </div>
          </div>
          <div class="col-md-4 articles-column text-center">
            <div class="articles-column-content">
              <p>
                <a href="{$config.url}organization/view/forum/">
                  ORG <small><span class="glyphicon glyphicon-tower"></span></small> FORUM
                </a>
              </p>
              <div class="articles-list">
                 {if !$user.organization}
                   <a href="{$config.url}organization">
                     JOIN AN ORGANIZATION
                   </a>
                 {else}
                   {foreach from=$orgForums item=post}
                   <a href="{$config.url}organization/view/forum/tid/{$post.id}" title="{$post.replies|number_format} replies">
                     {$post.title} ({$post.replies|number_format})
                   </a>
                  {foreachelse}
                    <a href="{$config.url}organization">
                      no posts
                    </a>
                  {/foreach}
                 {/if}
                 <div class="bottom-line">
                    <div class="line"></div>
                  </div>
               
              </div>
            </div>
          </div>
          <div class="col-md-4 articles-column text-right">
            <div class="articles-column-content">
              <p>
                <a href="{$config.url}forum">
                  PUBLIC FORUM <small><span class="glyphicon glyphicon-comment"></span></small>
                </a>
              </p>
              <div class="articles-list">
                    {foreach from=$forums item=post}   
                      <a href="{$config.url}forum/tid/{$post.id}" title="{$post.replies|number_format} replies">
                        ({$post.replies|number_format}) {$post.title}
                      </a>
                    {foreachelse}
                      No posts yet!

                    {/foreach}
                    <div class="bottom-line">
                    <div class="line"></div>
                  </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {if $user.cardinal and false}




<style>
.mb1010 .mb10{
margin-bottom:5px!important;
}</style>
<div class="row mb10 mb1010">
  <div class="col-md-4">
    <a href="{$config.url}blogs/latestArticles/emilia" class="button mb10">ARTICLES</a>
    <div class="row">
     
        {foreach from=$articles item=article}
          	<div class="col-md-12 ">
              <div class="well black  nomargin mb10 cut-text"  title="{$article.nrc|number_format} comments">
               <a href="{$config.url}blogs/article/{$article.article_id}" >{$article.title} ({$article.nrc|number_format})</a>
              </div> 
            </div>
        {/foreach}
      
    </div>
  </div>
 
  
    <div class="col-md-4 mb10">
      <a href="{$config.url}organization/view/forum/">
      <button  class="mb10" title="Organization forum"><span class="glyphicon glyphicon-tower"></span> forum</button>
      </a>
		{if $user.organization}
		 <div class="row">
        
      {foreach from=$orgForums item=post}
	  <div class="col-md-12 ">
        <div class="well text-center black mb10 cut-text" title="{$post.replies|number_format} replies">


        <a href="{$config.url}organization/view/forum/tid/{$post.id}">
          {$post.title}</a>
      </div>
       </div>
      {foreachelse}
	  <div class="col-md-12 ">
      <button disabled class="disabled">empty forum</button>
	  </div>
      {/foreach}
	  
      </div>
	  {else}
	  <a class="button text-center" href="{$config.url}organization">JOIN AN ORGANIZATION</a>
	   {/if}
        
    </div>
  
  
 
  <div class="col-md-4  text-right">
    <a href="{$config.url}forum" class="button mb10" >FORUMS</a>
    <div class="row">
      
    {foreach from=$forums item=post}
   <div class="col-md-12 ">
          <div class="well black nomargin mb10 cut-text" title="{$post.replies|number_format} replies">
           <a href="{$config.url}forum/tid/{$post.id}" >{$post.title} ({$post.replies|number_format})</a>
          </div>
    
         </div>
    {/foreach}
     
    </div>
  </div>
</div>
{/if}
