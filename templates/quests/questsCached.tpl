<div class="row">
  <div class="col-md-3">
    {if $group}
    <div class="panel panel-future">
      <div class="panel-heading">
        {$group.name|strtoupper}
      </div>
      <div class="panel-body text-center">
        {if $myQuest}
        {if $myQuest.type eq 1 or $myQuest.type eq 2}
        You've finished <em>{$myQuest.title}</em> {$myQuest.times|number_format} times
        {else}
        {$myQuest.title}
        {/if}
        {else}
        {if !$user.in_party}
        {$group.questsDone|number_format} missions done from {$quests|count} currently available out of {$group.nrQuests} total in <strong>{$group.name}</strong>.
        {else}
        <div class="text-center">PARTY</div>
        {/if}
        {/if}
      </div>
      <a href="{$config.url}quests{if $myQuest}/group/{$group.qgroup_id}{/if}" class="button text-center">
      <span class="glyphicon glyphicon-arrow-left"></span>
      </a>
    </div>
    {else}
    <div class="button-stack mb10">
      {foreach from = $groups item = g} 
      {if $g.story}
      <a href="{$config.url}quests/group/{$g.qgroup_id}" class="button cut-text text-center">
      {$g.name|strtoupper} ({$g.questsDone}/{$g.nrQuests})
      </a>
      {/if}
      {/foreach}
    </div>
    <br/>
    <div class="button-stack mb10">
      {foreach from = $groups item = g} 
      {if !$g.story && !$g.premium}
      <a href="{$config.url}quests/group/{$g.qgroup_id}" class="button cut-text text-center">
      {$g.name|strtoupper} ({$g.questsDone}/{$g.nrQuests})
      </a>
      {/if}
      {/foreach}
    </div>
    <br/>
    <div class="button-stack">
      {foreach from = $groups item = g} 
      {if $g.premium}
      <a href="{$config.url}quests/group/{$g.qgroup_id}" class="button cut-text text-center">
      {$g.name|strtoupper} ({$g.questsDone}/{$g.nrQuests})
      </a>
      {/if}
      {/foreach}
    </div>
    {/if}
  </div>
  <div class="col-md-9">
    <div class="missions-container">
      {if $myQuest}
      {include file="quests/quest_available.tpl"}    
      {elseif $quests}
      {include file="quests/quests_available_list.tpl"}
      {elseif $group}
      <div class="alert alert-warning">
        You have not fulfilled the requirements for any missions in this group. Complete all other available missions and work towards increasing your level to uncover hidden missions of {$group.name}.
      </div>
      {else}
      <div class=" well black">
        <p>
          Groups become available as their <strong>requirements</strong> (such as level, completing other missions, being part of a certain zone or even only at a certain time) are met.
        </p>
        <p>
          Selected few missions are available to parties only and will reward you more upon completion with friends.
        </p>
        <p>
          Some can be redone <strong>daily</strong> and others repeated at any time with no rewards to refresh your memory regarding certain facts.
        </p>
        <p>
          <strong>Every mission reward will be delivered through <a href="{$config.url}rewards">the Rewards Interface</a>.</strong>
        </p>
        Finishing missions will earn <a href="{$config.url}organization/view/hackingPoints">Hacking Points</a> for <a href="{$config.url}organization">your Organization</a>.
      </div>
      <div class="panel panel-glass" id="program">
        <a href="{$config.url}referrals">
        <img src="http://secretrepublic.net/layout/img/modules/referrals.jpg" style="width:100%" class="imageOpacity"/>
        </a>
        <div class="panel-body">
          <div class="well">
            <p>This hacking competition is powered by its competitors. The more participants reach level 5 and higher the more well thought story and puzzle missions Alpha team will make available.</p>
            <p>For every 100 hackers who reach level 5 we will add missions on top of those created on an irregular schedule. 
            </p>
            <p>These extra missions will be a special reward for your devotement.</p>
            <p>Use <a href="{$config.url}referrals">your referral link</a> to gain rewards.</p>
            <p>Consider <a href="{$config.url}alpha_coins/option/questManager">joining the Intern Mission Engineering team</a> and doing it yourself today.</p>
            <p>We have part of the story writen out and some amazing ideas to surprise you but we need <strong>your support</strong>!</p>
          </div>
          <br/>
          <div class="panel panel-glass nomargin">
            <div class="panel-body">
              <p>Hackers to reach level 5 before the next mission pack gets developed</p>
              <div class="progress progress-well">
                <div class="progress-bar" role="progressbar" style="width: {($usersCount/(100/100))|intval}%;">
                </div>
              </div>
            </div>
            <div class="panel-footer text-right">
              [{$usersCount} / 100]
            </div>
          </div>
        </div>
      </div>
    </div>
    {/if}
  </div>
</div>
