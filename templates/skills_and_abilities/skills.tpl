{include file="header_home.tpl" no_sidebar=true} {include file="skills_and_abilities/skills_header.tpl"}
<div class="row">
	<div class="col-xs-10">
		<div class="well black text-center">
			 You have <strong>{$user.skillPoints} Universal Skill Points (USP)</strong> available.
			 {if $user.skillPoints}
			 <br/>
			 After inputing the number of points you want to assign to each skill, press the update button at the bottom!
			 {/if}
		</div>
	</div>
	<div class="col-xs-2">
		<a href="{$config.url}frequently-asked-questions/open/about-skills"> <button> <span class="fa fa-question-circle"></span> </button></a>
	</div>
</div>

 {include file="error_success.tpl"}

 <style>
 	#skillsAccordion
 	{

 	}

 	#skillsAccordion .row-fluid
 	{
 		overflow:auto;
 		  border-left: 5px solid rgba(0, 87, 132, 0.55);
 	}

 	#skillsAccordion .row-fluid:hover
 	{
 		border-left-color:rgba(0, 87, 132, 0.95);
 	}

 	#skillsAccordion .skill-name
 	{
 		text-align:left;
 		padding-left:30px;
 	}
 	#skillsAccordion .skill-col
 	{
 		margin-top:5px; margin-bottom:5px;

 	}

 	.skill-progress-container{
 		height:100%; width:100%;border: 1px solid rgba(70,120,185,0.3); background-color:rgba(0, 0, 0, 0.18)
 	}
 	.skill-progress-container .skill-bar
 	{
background:rgba(0, 87, 132, 0.35); height:48px;
 	}
 	.skill-progress-container .skill-label
 	{
 		position:absolute; text-transform:uppercase; font-weight: bold;
  font-size: 11px;line-height:50px;top:0;left:0;float:left; height:100%; width:100%;text-align:center;
    text-shadow: 0px 0px 10px rgba(0, 149, 255, 0.75);
}
 </style>

 <script>
 $(document).ready(function(){
 		var wroteInFields = false;
	 $(".skill_input").focus(function(){
	 	$(".skill_submit").fadeIn();
	 });



});
 </script>
<div class="Danlor-A-trans">
	<div class="panel-group" id="skillsAccordion" role="tablist">
		<form method="post">
			{if $user.skillPoints}
		 <br/>
		 <div class="row-fluid">
		 	<div class="col-md-12">
		 <button type="submit"  name="form_identifier" value="add_points" 
		 				 title="Designate skill points as specified above" class="skill_submit mb10" style="display:none">
		 			Add skill points to skills
		 	</button>
		 		</div>
		 	</div>
		 	{/if}

	{assign var=tabindex value=0}
	{foreach from=$theskills key=skill_ID item=skillData}

		{if !$skillData.hideFromUserSkills}
			{assign var=tabindex value=$tabindex+1}
			
	
					<div class="row-fluid" >
						
						<div class="col-md-5 col-xs-6 skill-col">
							<a data-toggle="collapse" data-parent="#skillsAccordion" href="#skill_{$skill_ID}"  ><button class="skill-name">{$skillData.name}</button></a>
						</div>
						{if $user.skillPoints}
						<div class="col-md-5 col-xs-6 skill-col">
							{else}
						<div class="col-md-7 col-xs-6 skill-col">
						{/if}
							<div class="skill-progress-container">
								<div  class="skill-bar" style="width:{if $userSkills[$skill_ID].expNext > 0}{$userSkills[$skill_ID].exp * 100 / $userSkills[$skill_ID].expNext}{else}0{/if}%;">
								</div>

								<div class="skill-label">
									Level {$userSkills[$skill_ID].level} ({$userSkills[$skill_ID].exp|number_format}/{$userSkills[$skill_ID].expNext|number_format})
								</div>
							</div>
						</div>
						{if $user.skillPoints}
						<div class="col-xs-12 col-md-2 skill-col " title="Don't forget to save changes">
								<input type="text" class="glass-input text-center skill_input" value="{$smarty.post.skills[$skill_ID]}" tabindex="{$tabindex}" name="skills[{$skill_ID}]" autocomplete="off" placeholder="assign points" />
								
						</div>
						{/if}
					</div>
			
			<div id="skill_{$skill_ID}" class="panel-collapse collapse " role="tabpanel">
				<div style="padding:20px;padding-bottom:0">
					<div class="row">
						<div class="col-md-8">
							
							<blockquote><div class="well black nomargin">
								{foreach from = $skillData.commands key = command item = influence}
												<p>{$commandActions[$command].name}{if 1 eq 2} with rate of {$influence} {/if} {$commandActions[$command].verb} by {$influence*$userSkills[$skill_ID].level}%</p>
								{/foreach}

								<small>The higher the skill level the bigger the influence will become.</small>
</div>
							</blockquote>
						
						</div>
						<div class="col-md-4">
							{if $skillData.layer|count}
							<a href="{$config.url}grid/layers/analyse" class="button text-center">LAYERS INFLUENCE</a>
							{/if}
						</div>
					</div>
					
				</div>
			</div>

			{/if}
		 {/foreach}
		 {if $user.skillPoints}
		 <br/>
		 <div class="row-fluid">
		 	<div class="col-md-12">
		 <button type="submit"  name="form_identifier" tabindex="{$tabindex+1}" value="add_points" 
		 				 title="Designate skill points as specified above" class="skill_submit mb10" style="display:none">
		 			Add skill points to skills
		 	</button>
		 		</div>
		 	</div>
		 	{/if}
		</form>
	</div>
</div>