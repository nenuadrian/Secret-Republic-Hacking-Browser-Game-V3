{include file="header_home.tpl" no_sidebar=true}

      {include file="job/job_header.tpl"}

			

				  
   
         <div class="row mb10">
 
              <div class="col-xs-4 ">
                <button disabled>JOB LEVEL: {$job.level} ({$job.exp|number_format} / {$job.expNext|number_format})</button>
              </div>
              <div class="col-xs-8 ">
                  <div class="progress  progress-well" >
                    <div class="progress-bar" role="progressbar" style="width:{if $job.expNext > 0}{$job.exp * 100 / $job.expNext}{else}0{/if}%" >
                    </div>
                </div>
              </div>
             
         
        </div>
		
		
		
		<div class="well">
			The higher you job level is the more rewarding your work will be. Freelancing keeps your wallet above the floating line and trains you for missions in the field. 
		</div>
		
		{include file="error_success.tpl"}
		{if $job.remainingSeconds}

					<div class="panel panel-glass">
					<div class="panel-body">
{include file="components/hackdown.tpl" countdownFrom=$job.remainingSeconds totalCountdown=$timeBetweenJobs
                                              textCountdown = "true" progressBarClass = "progress-info"
                                              progressBarCountdown = "true" reloadOnFinish = "true" 
                                              textLeft="Gotta wait till a new day begins to work again. "}
											  </div>
											  <div class="panel-footer">
											  Keep your code on!
											  </div>
</div>

		{else}
				  
        {foreach from = $jobs key = jobID item = job}
          <div class="row mb10">
           
              
                
                <div class="col-xs-10">
				
                  <div class="panel-glass">
				  	<div class="panel-heading">
                  		{$job.name}
					</div>
					<div class="panel-body">
						{$job.story|nl2br}
					</div>
                  </div>
                </div>
                <div class="col-xs-2  ">
                  {if !$jobLog.log_id}
                  <form method="post">
                    <input type="hidden" name="work" value="{$jobID}"/>
                    <input type="submit" value = "Work"/>
                  </form>
                 
                  {/if}
                </div>
          
                
              
           
            </div>
        {/foreach}
				
    {/if}