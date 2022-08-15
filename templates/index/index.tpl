{include file="header_home.tpl" no_sidebar = true}

{include file="error_success.tpl"}

<div class="row">
  <div class="col-md-9">
    <div class="row">
      <div class="col-md-3  text-center nopadding"><br/>
        {if $smarty.session.premium.ai}
        <script type="text/javascript">
        function playEveIntro()
        {
          if (!$('#ai-voice').length)
            $('body').append('<audio class="nodisplay" id = "ai-voice"><source src="'+main_url+'mp3/eve/ogg/ai_intro.ogg" type="audio/ogg"> <source src="'+main_url+'mp3/eve/ai_intro.mp3" type="audio/mpeg"></audio>');
          $('#ai-voice')[0].play();
        }
        </script>
        <a href="#" onclick="playEveIntro();">
          <img src="{$config.url}layout/img/characters/eve.png" class="mb10" style="max-width:{if $detectDevice.mobile}40%{else}100%{/if}" title="eVe"/>
        </a>
        {else}
        <a href="{$config.url}alpha_coins">
          <img src="{$config.url}layout/img/characters/eve.png" class="mb10" style="max-width:{if $detectDevice.mobile}40%{else}100%{/if}" title="eVe"/>
        </a>
        {/if}



      </div>
      <div class="col-md-9">


        <div class="panel panel-glass">
          <div class="panel-heading">
            <small data-hacker-text='Hello, <a href="{$config.url}profile" title="{$user.name}">{$user.username}</a>. You are level {$user.level}'>

            </small>
          </div>
          <div class="panel-body">
            <div class="row">

              <div class="col-xs-4 text-center">
                <a href="{$config.url}dna" title="DNA">
                <img src="https://www.gravatar.com/avatar/{$user.gavatar}?s=100" class="user-avatar" />
              </a>
              </div>
              <div class="col-xs-8">

                <p title="{($user.expNext-$user.exp)|number_format} to level up" ><span class="glyphicon glyphicon-fire"></span>  <small>{$user.exp|number_format} / {$user.expNext|number_format} exp</small></p>
                <div class="progress progress-small">
                  <div class="progress-bar" role="progressbar" style="width: {($user.exp/($user.expNext/100))|intval}%;">
                  </div>
                </div>

                <br/>



                <p ><span class="glyphicon glyphicon-flash"></span> <small><span title="Hourly recovery rate: 20%{if $smarty.session.premium.recoveryRateDouble} (+20% A-C bonus){/if}">{$user.energy|number_format} / {$user.maxEnergy|number_format} energy</span>
                  {if !$smarty.session.premium.recoveryRateDouble && !$smarty.session.premium.removeAds} (<a href="{$config.url}alpha_coins/option/recoveryRateDouble" title="Increase recovery rate?">+rec. rate</a>){/if}
                </small></p>
                <div class="progress progress-small">
                  <div class="progress-bar" role="progressbar"  style="width: {($user.energy/($user.maxEnergy/100))|intval}%;">
                  </div>
                </div>




              </div>
            </div>

          </div>

          <div class="panel-footer text-right">

            <small data-hacker-text='You own <strong><a href="{$config.url}alpha_coins">{$user.alphaCoins|number_format} Alpha coins{if !$smarty.session.premium.removeAds} <em><strong>GET MORE</strong></em>
              {/if}'>
            </a></small></strong>


          </div>

        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12">

        {include file="index/tasks.tpl"}


      </div>

    </div>
    <div class="panel panel-glass">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-10">
            Connected to {$user.main_node}
          </div>
          <div class="col-xs-2 text-right">
            <a href="{$config.url}frequently-asked-questions/open/about-nodes">
              <span class="fa fa-question-circle"></span>
            </a>
          </div>
        </div>
      </div>

      <div class="panel-body">
        {if $user.attacksInProgress}



        {include file = "index/attacks.tpl"}

        {else}
        <button disabled class="button-clear">Nothing to report</button>


        {/if}
      </div>
     </div>

    <div class="row mb10" >
      <Div class="col-md-12">

        <form method="post">
          <input type="hidden" name="form_identifier" value="change_main_node"/>
          {foreach $userNodes as $node}
          {if $node.location ne $user.main_node}
          <div class="row ">
            <div class="col-md-9 mb10">
              <button disabled>
                [Zone {$node.zone_id} : Cluster {$node.cluster} : Node {$node.node}]
              </button>
            </div>

            <div class="col-md-3 mb10">
              <button name="node"  type="submit" value="{$node.zone_grid_cluster_nodes_id}">
                <span class="glyphicon glyphicon-link"></span>
              </button>
            </div>

          </div>
          {/if}
          {/foreach}
        </form>
      </div>
    </div>


     {if !$hackdownRemaining}
  <a href="{$config.url}hackdown">
        <div class="panel panel-future mb10">
          <div class="panel-body">


            {include file="components/hackdown.tpl" countdownFrom=$nextSaturdayRemaining totalCountdown=6*24*60*60
            id='hackdown' textCountdown = "true"
            progressBarCountdown = "true" reloadOnFinish = true
            textFinish = "Hackdown in progress"
            progressBarClass = "progress-small"
            textLeft="Next Hackdown in"}




          </div>
          <a href="{$config.url}hackdown"><img src="{$config.url}layout/img/events/hackdown_main.jpg" class="  imageOpacity" style="width:100%" title="Hackdown"/></a>

        </div></a>

      {/if}


  </div>

  <div class="col-md-3 ">

    <div class="row">
      {if $hackdownRemaining}

      <div class="col-md-12"><a href="{$config.url}hackdown">
        <div class="panel panel-future">
          <div class="panel-body">
            {include file="components/hackdown.tpl" countdownFrom=$hackdownRemaining totalCountdown=24*60*60
            id='hackdown' textCountdown = "true"
            progressBarCountdown = "true" reloadOnFinish = true
            textFinish = "Hackdown ended"
            progressBarClass = "progress" textLeft="HACKDOWN in progress"}
          </div>
          <a href="{$config.url}hackdown"><img src="{$config.url}layout/img/events/hackdown_main.jpg" class="  imageOpacity" title="Hackdown"/></a>

        </div></a>
      </div>
      {/if}


      <div class="col-md-12">



        <div class="row mb10">

          <div class="col-md-4 col-xs-4 mb10">
            <a href="{$config.url}theWorld" class="button button-clear text-center" title="World timeline"> <span class="glyphicon glyphicon-sunglasses"></span></a>
          </div>


          <div class="col-xs-4 mb10">
            <a href="{$config.url}referrals" class="button button-clear text-center" title="Referrals">
              <span class="fa fa-users"></span>
            </a>
          </div>
          <div class="col-xs-4  mb10">
            <a href="{$config.url}search" class="button button-clear text-center" title="Search">
              <span class="glyphicon glyphicon-search"></span>
            </a>
          </div>
        </div>

        {$missionsSummary}



      </div>
     


    </div>

  </div>
</div>

{$latestArticlesAndForums}


