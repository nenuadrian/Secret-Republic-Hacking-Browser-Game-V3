{include file="header_home.tpl"}

<div class="row mb10">
	<div class="col-xs-4">
		<a href="{$config.url}conversations" ><button><span class="glyphicon glyphicon-arrow-left"></span></button></a>
	</div>
</div>
<div class="text-center">
	<h3>{$message.title}</h3>
	<p>
		conversation with {$message.username} started {$message.created|date_fashion}
	</p>
	<p>
		{$message.replies|number_format} messages exchanged
	</p>

</div>
</h3>

<br/>

{foreach from=$replies item=reply}
<div class="row">
	{if $reply.sender_user_id eq $user.id}
	<div class="col-md-2"></div>
	<div class="col-md-10">
		<blockquote class="pull-right">
			<p>
			{$reply.message}
		</p>
			<small>
				{if $smarty.session.premium.seenConv}
					{if $reply.last_reply_seen} 
						SEEN 
					{else}
						UNSEEN 
					{/if}
					by {$message.username} - 
				{/if}
				{$reply.created|date_fashion}</small>
		</blockquote>
	</div>
	<!--
	<div class="col-md-2">
	</div>
	<div class="col-md-10">
		<div class="panel panel-future panel-message">
	
			<div class="panel-body">
				{$reply.message}

					<div class="text-right">
						<em>{$reply.created|date_fashion}</em>
					</div>
			</div>

		</div>
	</div>-->
	{else}
	<div class="col-md-10">
	<blockquote>
		<p>
		{$reply.message}
	</p>
		<small>said {$reply.username} {$reply.created|date_fashion}</small>
	</blockquote>
	</div>
	<!--
	<div class="col-md-10">
		<div class="panel panel-future panel-message">
			
			<div class="panel-body">
				{$reply.message}

				<div class="text-right">
						{$reply.username} said
				<em>{$reply.created|date_fashion}</em>
					</div>

			</div>

		</div>


	</div>
	<div class="col-md-2">

	</div>
-->
	{/if}

</div>

{/foreach}

<div class="text-center">
	{$pages}
</div>

{if !$replyNotAllowed}
<div class="alert alert-info">
	<strong>It costs {$config.newMessageReplyDataPoints|number_format} Data Points to reply</strong>
</div>

<div id="quick_reply">
	{include file="error_success.tpl"}
	<form method="post" action="#quick_reply">
		<textarea name="message" style="min-height:90px" maxlength="4000">{$smarty.post.message}</textarea><br/>


		<button type="submit"><span class="glyphicon glyphicon-send"></span></button>
	</form>

</div>
{else}
<div class="alert alert-danger">
	Replying to his user has been disabled by the Cardinal mainframe.
</div>{/if}
