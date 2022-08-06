{include file="header_home.tpl" no_sidebar=true}


 
<div class="row">
  <div class="col-md-12">
    <div class="row-fluid">
      <div class="col-md-8 nopadding">
        {include file="error_success.tpl"}	
        {if !count($success)}
          <form method="post">
            <input type="email" name="email" placeholder="Your email" class="mb10" value="{$smarty.post.email}" required/>
            <input type="text" maxlength="200" name="title" placeholder="Inquiry subject" class="mb10" value="{$smarty.post.title}" required/>
            <textarea name="content" class="mb10" placeholder="Inquiry description" maxlength="1000" style="height:300px" required>{$smarty.post.content}</textarea>
            <div class="text-center mb10">
              {$captcha}
            </div>
            <button type="submit">Send inquiry</button>
          </form>
        {/if}
      </div>
      <div class="col-md-4 text-right">
        <h3>contact()</h3>
        <p>return <strong>{$config.contact_email}</strong>;</p>
        <h3>feedback && bugs</h3>
        <p>we are really keen on finding out what <strong>YOU</strong> think about the republic of hackers</p>
        <p>echo "so let us know!";</p>
        <h3>waiting time</h3>
        <p>printf("we'll try to get back to you within %d hours", 48);</p>
      </div>
    </div>
  </div>
</div>
