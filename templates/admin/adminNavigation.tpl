

{if   ($smarty.session.premium.questManager || $user.adminNav )}
  
  <div class="adminIcon" >
  <h1>
  		<span class="glyphicon glyphicon-cog cursor"></span> 
		</h1>
  
    
  </div>
  


            <ul class="sidebar-nav " id="adminNavigation">
           		

				  {if $user.userList}
					<li>  <a href="{$config.url}admin/view/registered">Hackers</a></li>
					<li>  <a href="{$config.url}admin/view/registered/online/true">Online</a></li>
				  {/if}
				  
				  {if $user.questManager || $smarty.session.premium.questManager}
					<li>  <a href="{$config.url}admin/view/manageQuest">Missions</a></li>
				  {/if}

				  {if $user.manageAchievements}
					<li><a href="{$config.url}admin/view/achievements">Achievs</a></li>
				  {/if}
				  {if $user.levelManager}
					<li>  <a href="{$config.url}admin/view/levelRewards">Lewards</a></li>
				  {/if}
				  {if $user.emailTemplatesManager}
					<li>  <a href="{$config.url}admin/view/emailTemplates">Email templates</a></li>
				  {/if}
				  {if $user.dataManager}
					<li>  <a href="{$config.url}admin/view/data">Data</a></li>
				  {/if}

				  {if $user.cardinal}

					 
					
					<li>  <a href="{$config.url}admin/view/attacks">Attacks</a></li>
					<li>  <a href="{$config.url}admin/view/errors">Debug</a></li>
				  {/if}

				

            
            </ul>
		

{/if}
