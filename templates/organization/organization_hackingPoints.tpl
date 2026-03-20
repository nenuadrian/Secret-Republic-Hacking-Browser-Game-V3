<div class="panel panel-glass">
	
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4">
						
						<button disabled>Level {$org.level} [{$org.exp|number_format}/{$org.expNext|number_format}]</button>
						
					</div>
					<div class="col-md-8">
						<button  disabled class=" nopadding" style="width:{if $org.expNext > 0}{$org.exp * 100 / $org.expNext}{else}0{/if}%;"> </button>
					</div>
				</div>
			</div>
		
		</div>	
<div class="panel panel-glass">
	<div class="panel-heading">
		Daily Organization Mission - 2 hacking points reward
	</div>
	{if $lastHack.created}
			<div class="panel-body">
				{include file="components/hackdown.tpl" countdownFrom=$lastHack.created + 24*60*60 - time() totalCountdown=24*60*60
                                              textCountdown = "true" progressBarClass = "progress-info"
                                              progressBarCountdown = "true" reloadOnFinish = "true" 
                                              textLeft="You can go on the field again in"}
				
				
			</div>
		{else}
		<form method="post">
			<button type="submit" name="hack" value="true"><span class="glyphicon glyphicon-play"></span></button>
		</form>
		{/if}
		</div>	
		
		
		
		<div class="row mb10">
  <div class="col-md-3 text-center">
    <button disabled class="disabled">hacking points</button>
    <h1>{$org.hacking_points|number_format}</h1>
  </div>
  <div class="col-md-9">
  <div class="well">
  <p>
  Hacking points are a valuable resource for organizations. These can be used and earned in various ways. Members need only complete missions and be active in the competition in order to reward their organization with hacking points.
  </p>
  Hacking Points also represent the experience the organization earns and need to level up. One hacking points is equivalent to one experience point. Upgrades and features change at times depending on the organization's level.
  <hr/>
  {$org.name} can use these credits to force wars on other organizations or to upgrade itself.
  </div>
  {if $access.manageHackingPoints}
  <form method="post">
    <input type="submit" name="upgradeNRM" value="Increase maximum number of members by 1 for {$nrmUpgradeCost} HP"/>
  </form>
  {/if}
  </div>
</div>
<br/>
<div class="row mb10" id="showFrame">
	<div class="col-xs-6">
		<a href="{$config.url}organization/show/{$org.id}/view/hackingPoints/rankings/go#showFrame">
			<button {if $GET.rankings}disabled{/if}>HP Rankings</button>
		</a>
	</div>
	<div class="col-xs-6">
		<a href="{$config.url}organization/show/{$org.id}/view/hackingPoints/history/go#showFrame">
			<button {if $GET.history}disabled{/if}>History</button>
		</a>
	</div>
</div>
<br/>
{if $GET.rankings}

{foreach $rankings as $key => $member}
<div class="row mb10">
	<div class="col-xs-2">
		<button disabled>
			#{$key+1}
		</button>
	</div>
	<div class="col-xs-6">
		
		<a href="{$config.url}profile/hacker/{$member.username}"><button class="text-left">{$member.username}</button></a>
		

	</div>
	<div class="col-xs-4">
		<button disabled >
			{$member.hackingPoints|number_format} HP's
		</button>
	</div>
</div>
{/foreach}

{elseif $GET.history}

<div class="alert alert-info">
Ancient records are deleted by the Cardinal Mainframe.
</div>
{foreach $history as $entry}
<div class="row mb10">
	<div class="col-md-5 col-xs-12">
		{if $entry.source_type eq 1}
		<a href="{$config.url}profile/hacker/{$entry.username}"><button class="text-left">{$entry.username}</button></a>
		{elseif $entry.source_type eq 2}
			<button disabled class="text-left">HACKDOWN</button>
		{/if}
	</div>
	<div class="col-xs-6 col-md-2">
		<button disabled>{$entry.hackingPoints|number_format} HP</button>
	</div>
	<div class="col-xs-6 col-md-5 ">
		<button disabled class="cut-text text-right">{$entry.created|date_fashion}
	</div>
</div>
{foreachelse}
<div class="well">
No hacking points earnings logs.
</div>
{/foreach}
{/if}

<div class="text-center">
{$pages}
</div>