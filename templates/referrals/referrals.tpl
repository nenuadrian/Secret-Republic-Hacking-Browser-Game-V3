{include file="header_home.tpl" } 


{include file="error_success.tpl"}

<div class="row">
	<div class="col-md-5">
		<div class="panel panel-glass">

			<div class="panel-body text-center">
				<strong>
					<small>
					<p><a href="{$config.url}main/i/{$user.id|base64_encode}">{$config.url}main/i/{$user.id|base64_encode}</a></p>
					<a href="{$config.url}register/i/{$user.id|base64_encode}">{$config.url}register/i/{$user.id|base64_encode}</a>
					</small></strong>
			</div>
			<div class="panel-footer text-center">
				{$user.username}'s referral links
			</div>			
		</div>
		<div class="panel panel-future">
			
			<div class="panel-body text-center">
			<p>
					As long as the link is accessed, the guests can navigate freely and they will be counted as referral even if they sign up at a slightly later time.
					</p>
					<a href="{$config.url}quests#program">
					The more participants are in this hacking competition the more missions will become available (check it out)</a>.
			</div>
			
			
		</div>
	</div>
	<div class="col-md-7">

				<div class="panel panel-future">
					<img src="{$config.url}layout/img/modules/referrals.jpg" />
					<div class="panel-body text-center">
						<p>When a referral reaches level 10 you receive <strong>5 Alpha Coins</strong>.</p>
			
						<p>For every 5 referrals who reach level 10 you receive <strong>5 extra Alpha Coins</strong>.</p>
					
						<p>You receive an amount equal to <strong>20% of any Alpha Coin purchase</strong> of your referrals.</p>
						
						<p>On top of that, you receive <strong>5% of Alpha Coin purchases</strong> of any referral of your referrals.</p>
						
						The last two apply only to referrals over level 4. The A-C's will be delivered as <a href="{$config.url}rewards">rewards</a>.
					</div>
					<div class="panel-footer text-center">
				You have referred {$referrals_count|number_format} hackers
			</div>
				</div>
			
		
	</div>
	
</div>
<br/>
{foreach from = $referrals item = referral}
<div class="mb10 row">
	<div class="col-md-5">
		<button disabled>{$referral.referral_id|md5}</button>
	</div>
	
	<div class="col-md-3">
		<button disabled>Level {$referral.level}</button>
	</div>
	<div class="col-md-4">
		<button disabled>{$referral.created|date_fashion}</button>
	</div>
</div>
{foreachelse}
<div class="well black text-center">
	You don't have any referrals. All hail {$user.username|substr:0:3}.. nevermind.
</div>
{/foreach}
<div class="text-center">
{$pages}
</div>
