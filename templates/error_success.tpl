<div class="alert-stack">
		{if $errors}							
		
				{foreach from=$errors item=e}
					<div class="alert alert-error">
						
					{$e}
					</div>
				{/foreach}
		{/if}
		
		{if $success}
			
					{foreach from=$success item=e}
						<div class="alert alert-success">
							{$e}
						</div>
					{/foreach}
		{/if}
	
		{if $warnings}
			
				{if $warnings|is_array}
					{foreach from=$warnings item=e}
						<div class="alert alert-warning">
				
						{$e}</div>
					{/foreach}
					{else}
						<div class="alert alert-warning">
				
						{$warnings}
						</div>
					{/if}
		{/if}
		
		{if $info}
			
				{if $info|is_array}
					{foreach from=$info item=e}
						<div class="alert alert-info">
				
						{$e}</div>
					{/foreach}
					{else}
						<div class="alert alert-info">
				
						{$info}
						</div>
					{/if}
		{/if}
</div>
 