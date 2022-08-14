{include file="header_home.tpl" }

<div class="well">
This is just a sample page.
</div>

{if $logged}
	<div class="row">
		<div class="col-xs-7">
			<div class="well">
			This is just a logged in page content.
			</div>	
		</div>
		<div class="col-xs-5">
			<a href="{$config.url}register"><button>JOIN THE HACKVOLUTION</button></a>
		</div>
	</div>
{/if}