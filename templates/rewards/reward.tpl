{include file="header_home.tpl" no_sidebar = true}

{include file="error_success.tpl"}

<div class="row">
  <div class="col-md-12">
    <div class="row-fluid">
      <div class="hidden-xs hidden-sm col-md-4 text-center">
        <img src="{$config.url}layout/img/characters/Irene-A.I.png" style="max-width:100%;"/>
      </div><!-etta_medium-->
      <div class="col-md-8">
        <h1 class="text-center" style="text-transform:uppercase; color:rgb(199, 199, 199);font-size:30px;">
          <span class="glyphicon glyphicon-gift" style="font-size:100px"></span><br/><br/>
          {$reward.title}</h1><br/>

	  	
      <div class="panel panel-white panel-white-card" style="text-transform:uppercase">
          {if $reward.received}
       <div class="panel-heading">Claimed {$reward.received|date_fashion}</div>
      {/if}

          <div class="panel-body">
      	  	{if $reward.alphaCoins}
      			<div class="row">
      				<div class="col-md-7">
      					Alpha Coins
      				</div>
      				<div class="col-md-5">
      					{$reward.alphaCoins|number_format} AC
      				</div>
      			</div>
      		  {/if}
            {if $reward.dataPoints}
              <div class="row">
                <div class="col-md-7">
                  Data Points
                </div>
                <div class="col-md-5">
                  {$reward.dataPoints|number_format:2}
                </div>
              </div>
            {/if}
            {if $reward.money}
              <div class="row">
         
                    <div class="col-md-7 ">
                        Money
                    </div>
                    <div class="col-md-5 ">
                        {$reward.money|number_format}$
                    </div>
                  
               
              </div>
            {/if}
            {if $reward.exp}
              <div class="row">
               
                    <div class="col-md-7 ">
                        Experience
                    </div>
                    <div class="col-md-5 ">
                        {$reward.exp|number_format} points
                    </div>
                  
                
              </div>
            {/if}
            
            {if $reward.skillPoints}
              <div class="row">
              
                    <div class="col-md-7 ">
                        Universal Skill Points
                    </div>
                    <div class="col-md-5 ">
                        {$reward.skillPoints|number_format} points
                    </div>
                
              </div>
            {/if}

        
            {if $reward.energy}
              <div class="row">
            
                    <div class="col-md-7 ">
                        Energy
                    </div>
                    <div class="col-md-5 ">
                        +{$reward.energy|number_format}
                    </div>
                  
                 
              </div>
            {/if}
            
             {if $reward.jobExp}
              <div class="row">
              
                    <div class="col-md-7 ">
                        Job Experience
                    </div>
                    <div class="col-md-5 ">
                        {$reward.jobExp|number_format} points
                    </div>
                  
             
              </div>
            {/if}

              
              {if $reward.skills and $reward.skills|count}
                <h2 class="white-holder">skills</h2>

                    {foreach from=$reward.skills key=skill item=amount}
                      <div class="row ">
                            <div class="col-xs-9 text-left">
                                 {$theskills[$skill].name}
                            </div>
                            <div class="col-xs-3  text-right">
                               {$amount|number_format} points
                            </div>
                      </div>
                   {/foreach}

                {/if}

                {if $reward.achievements|is_array and $reward.achievements|count}
     
                <h2 class="white-holder">achievements</h2>
                {include file='profile/achievements.tpl' achievements = $reward.achievements panelClass='panel-white'}
            
                
              {/if}

              {if $reward.applications and $reward.applications|is_Array}
                <h2 class="white-holder">Applications</h2>

                {foreach $reward.applications as $app}
                      <div class="row ">
                            <div class="col-xs-9 text-left">
                                 {$app.name}
                            </div>
                            <div class="col-xs-3  text-right">
                               {$app.damage}% damaged
                            </div>
                      </div>
                   {/foreach}

                   {if !$reward.received}
                   <div class="alert alert-info" style="text-transform:none; line-height:initial">
                     To claim applications you must have space on your main server or a set as main a server which has.
                   </div>
                   {/if}
              {/if}

              {if $reward.components and $reward.components|is_Array}
                <h2 class="white-holder">components</h2>

                {foreach $reward.components as $comp}

                      <div class="row ">
                            <div class="col-xs-9 text-left">
                                 {$comp.name}
                            </div>
                            <div class="col-xs-3  text-right">

                               {$comp.damage}% damaged
                            </div>
                      </div>
                   {/foreach}
                   {if !$reward.received}
                   <div class="alert alert-info" style="text-transform:none; line-height:initial">
                     To claim components make sure to have enough space in storage.
                   </div>
                   {/if}
              {/if}

           </div>

           {if !$reward.received}
              <form method="post">
                <input type="submit" name="receive" class="button-white" value="Claim reward" style="height:70px;font-size:20px; border-left:0!important; border-right:0!important;border-bottom:0!important"/>
              </form>
              
            {/if}

         </div>
	
        
        
        <!--
		
		{if $reward.components|is_array and $reward.components|count}
			{foreach $reward.components as $item}
				<div class="panel panel-glass">
					<div class="panel-heading">{$item.name}</div>
					<div class="panel-body">
						{include file="storage/item_description.tpl"}
					</div>
				</div>
			{/foreach}
		{/if}-->
        
      </div>
    </div>
  </div>
</div>
