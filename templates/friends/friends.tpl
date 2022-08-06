{include file="header_home.tpl"}

{include file="profile/profile_header.tpl"}

{include file="friends/friends_header.tpl"}

<div class="friends-module">

<div class="well black text-center">
<p>
  "Friends may come and go, but enemies accumulate." ~ Thomas Jones - You have {$nrf|number_format} friends. How many of them are your enemies?
  </p>
</div>	

{include file="error_success.tpl"}

{foreach from=$friends item=friend}
  <div class="row mb10">
  
        <div class="col-md-2 col-xs-3">
          {if $friend.online}
            <a href="#" class="button text-center">ON</a>
          {else}
            <button disabled>OFF</button>
            
          {/if}
        </div>
        <div class="col-md-3 col-xs-5">
          <div class="well black text-center ">
            {$friend.username|profile_link}
          </div>
        </div>
        <div class="col-md-3 hidden-xs hidden-sm">
          
          <a href="{$config.url}zones/zone/{$friend.zone}" class="button text-center">ZONE {$friend.zone}</a>
        </div>
        
        
       
        <div class="col-xs-2">
          <a href="{$config.url}conversations/new/emilia/to/{$friend.username}" class="button text-center"><span class="glyphicon glyphicon-envelope"></span></a>
        </div>
        
        <div class="col-xs-2">
          <form method="post">

			<button type="submit" name="unfriend" value="{$friend.id}"><span class="glyphicon glyphicon-remove-circle"></span></button>
          </form>
        </div>
      
  </div>

{foreachelse}
  <button disabled>No friends. Forever alone.</button>
{/foreach}
</div>

<div class="text-center">
  {$pages}
</div>


								
	
		
