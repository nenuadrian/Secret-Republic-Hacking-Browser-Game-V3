		
		<div class="panel panel-glass">
			
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4">
						{if $org.id eq $user.organization}
							<a href="{$config.url}organization/show/{$org.id}/view/hackingPoints">
						{/if}
						<button {if $org.id ne $user.organization}disabled{/if}>Level {$org.level} [{$org.exp|number_format}/{$org.expNext|number_format}]</button>
						{if $org.id eq $user.organization}</a>{/if}
						
					</div>
					<div class="col-md-8">
						<button  disabled class=" nopadding" style="width:{if $org.expNext > 0}{$org.exp * 100 / $org.expNext}{else}0{/if}%;"> </button>
					</div>
				</div>
			</div>
			
		
		</div>	
		
		<br/>			

		{if $org.myOrg}
      
      <blockquote>
      	<p><strong>Members intro</strong></p>
			<p>
				
        {if $org.memb_intro}
        {$org.memb_intro}
        {else}
        No members intro set!
        {/if}
      </p>
		</blockquote>
		<br/>
    {/if}


		<blockquote>
			<p>
				{if $org.intro}
					{$org.intro}
				{else}
					No intro set
					{/if}
			</p>
		</blockquote>
		
    
    	
    
			
		<hr/>
		<div class="row">
		  
		      <div class="col-md-7 ">
			  	<div class="well black">
					organization founded {$org.created|date_fashion}
				</div>
		        
		      </div>
		      <div class="col-md-5">
			  	<input type="text" class="text-center"  data-no-voice value="{$config.url}organization/show/{$org.id}"/>
				</div>
		 
		</div>