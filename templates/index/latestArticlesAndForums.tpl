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




<style>
  .articles-holder
  {
   /* background-color:rgba(53, 129, 195, 0.09); 
                  border:1px solid rgba(53, 129, 195, 0.23);

                  box-shadow: inset 0 0 10px rgba(0,161,250,0.1), 0 3px 5px rgba(0,0,0,0.3);
                    background-color: rgba(53, 129, 195, 0.02);
                    */
                  text-shadow: 0px 0px 10px rgba(0, 149, 255, 0.75);
                    
  }

  .articles-column
  {
    padding:20px;
    opacity:.9;
    transition-property: opacity;
    transition-duration: .3s;
    transition-timing-function: ease-in;

    -webkit-transition-property: opacity;
    -webkit-transition-duration: .3s;
    -webkit-transition-timing-function: ease-in;

    -moz-transition-property: opacity;
    -moz-transition-duration: .3s;
    -moz-transition-timing-function: ease-in;

    -o-transition-property: opacity;
    -o-transition-duration: .3s;
    -o-transition-timing-function: ease-in;

  }

  .articles-column .bottom-line
  {
    height:15px;
     
      text-align:center;
     
  }
  .articles-column .bottom-line .line{
 margin-bottom: 7px;
  width: 20%;
  border-bottom: 2px solid rgba(66, 139, 202, 0.3);
  padding: 0;
  display: inline-block;
  }
  .articles-column:hover{
    opacity:1;
  }
  .articles-column p{
    font-size:15px; 

      border-top: 2px solid rgba(66, 139, 202, 0.3);
  padding: 12px;
  border-radius: 5px;
    background-color: rgba(39, 123, 216, 0.05);
    margin:0;

padding-left:20px;
padding-right:20px;
font-weight:bold;
letter-spacing: 2px;
  }

  .articles-list
  {
      background-color: rgba(39, 123, 216, 0.05);
     font-size:13px;
       line-height: 35px;
  padding: 20px;
  border-left: 2px solid rgba(66, 139, 202, 0.3);
  border-right: 2px solid rgba(66, 139, 202, 0.3);
  border-radius: 5px;
  margin: 0;
  padding-top: 5px;
  padding-bottom: 5px;

  }


  .articles-list a{
    
      text-overflow: ellipsis;
  white-space: nowrap;
  overflow: hidden;
  text-transform:uppercase;
  }

  .articles-column .articles-list
  {
    padding-bottom:0px;
    border-top-left-radius:0;
    border-top-right-radius:0;
  }
  .articles-column .articles-list a{
    display:block;
  }

  .articles-column .articles-column-content
  {
      -moz-box-shadow: 0 0 70px rgba(79, 182, 255, 0.1);
  -webkit-box-shadow: 0 0 40px rgba(79, 182, 255, 0.1);
  box-shadow: 0 0 40px rgba(79, 182, 255, 0.1);
  -ms-filter: "progid:DXImageTransform.Microsoft.Shadow(Strength=3, Direction=0, Color='rgba(79, 182, 255, 0.1)')";
  filter: progid:DXImageTransform.Microsoft.Shadow(Strength=3,Direction=0,Color='rgba(79, 182, 255, 0.1)');
  }
</style>
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
		    {if empty($articles)}
                      No posts yet!
                    {/if}
                    {foreach from=$forums item=post}   
                      <a href="{$config.url}forum/tid/{$post.id}" title="{$post.replies|number_format} replies">
                        ({$post.replies|number_format}) {$post.title}
                      </a>
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
