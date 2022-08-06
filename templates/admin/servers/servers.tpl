{include file="header_home.tpl" no_sidebar = true}

<div class="futureNav middle ">
       <ul>
          <li><a href="{$config.url}admin/view/software">Software</a></li>
          <li><a href="{$config.url}admin/view/hardware">Hardware</a></li>
        </ul>
        
      </div>
	  
	  {foreach from = $servers item = server}
		<div class="row">
			<div class="col-md-5">
			<a href="" class="button">{$server.hostname} - {$server.ip} - Owner: {$server.username}</a>
			</div>
			<div class="col-md-2">
				<a href="{$config.url}servers/server/{$server.server_id}" class="button text-center" target="_blank">DIRECT</a>
			</div>
		</div><br/>
	{foreachelse}
	<div class="well black text-center">
		no results
	</div>
		{/foreach}
	  <div class="text-center">
	  	{$pages}
	</div>
{include file="error_success.tpl"}
