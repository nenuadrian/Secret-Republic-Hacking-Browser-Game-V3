{include file="header_home.tpl" no_sidebar=true} {if !$org.id} {if !$load}


{include file="error_success.tpl"} 
<div class="row">
<div class="col-md-4">
<div class="text-center">
<img src="{$config.url}layout/img/characters/Irene-A.I.png" style=""/>
</div>
</div>
<div class="col-md-8">
   <div class="well text-center">
   <p>You're not part of any organization. An organization is a social group which distributes tasks for a collective goal.</p>
   <p>
    Might be exactly what you need to become the best hacker out there. 
   </p>
   <p>When you're in an organization you contribute to its ranking and the organization contributes to yours. Organization wars will stir up the adrenaline in your blood while the private forum will help you chill out and find more "friends".</p>
   <p><strong>None of us are as strong as all of us.</strong></p>

  </div>

<hr/>
<div class="row">
	<div class="col-md-6">
        <a href="{$config.url}rankings/type/orgs"><button>BEST ORGANIZATIONS</button></a>
	</div>
	<div class="col-md-6">
		<a href="{$config.url}search/type/organization"><button>FIND ORGANIZATIONS</button></a>
	</div>
</div>
        <hr/>
		  <div class="well text-center">
    In order to create an organization you need {$organizationCost|number_format}$ and you must have completed the {$organizationMission} mission.
  </div>
        {if $canCreateOrganization}
        <a href="{$config.url}organization/view/create">
         <button>Create an organization</button>
        </a>
        {else}
        <button class="disabled" disabled>Requirements for creating an organization not met.</button>
        {/if}
     
        <h2>consider joining</h2>
		<hr/>
		<div class="text-center">
			{$pages}

		{if $availableOrgs}
			{else}No organizations created.{/if}
		</div>
		{foreach $availableOrgs as $org}
		
		<div class="row mb10">
			<div class="col-md-6">
				<a href="{$config.url}organization/show/{$org.id}"><button>{$org.name}</button></a>
			</div>
			<div class="col-md-2">
			<button disabled>LEV {$org.level}  </button>
			</div>
			<div class="col-md-4">
				<button disabled>{$org.nrm}/{$org.max_nrm} members</button>
			</div>
		</div>	
		{/foreach}
		<div class="text-center">
			{$pages}
		</div>
</div>
</div>

{elseif $load eq "create"}
{include file="organization/organization_creation_form.tpl"}
{/if}
{else}
{include file="organization/organization_view.tpl"}
{/if}
