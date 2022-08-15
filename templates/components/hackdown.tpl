{if !$hackdownScriptsAlreadyIncluded}
	{assign "hackdownScriptsAlreadyIncluded" true}
	<script type="text/javascript" src="{$config.url}layout/js/hackdown.js"></script>
{/if}
<div id="theHackdown{$id}">
  {if $textNormal}
    <p id="hackdown{$id}" class="{$textElementClass} nomargin">{$finish_time}</p>
  {else}
  <div class="row nomargin">
    <div class="col-md-7">
      {$textLeft}
    </div>
    <div class="col-md-5 text-right">
      <p id="hackdown{$id}" class="{$textElementClass} ">{$finish_time}</p>
    </div>
  </div>
  {/if}
 {if $progressBarCountdown}
 
  <div class="progress {$progressBarClass}" style="margin-bottom: 0px;">
        <div class="progress-bar" id="hackdownProgressBar{$id}" role="progressbar" 
          aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
        </div>
  </div>       
  {/if}
  </div>
<script >
  

   $("#theHackdown{$id}").hackdown({
  
                  "countdownFrom"        : {$countdownFrom},
                  "totalCountdown"       : {$totalCountdown},
                  "textCountdown"        : {$textCountdown},
                  "textElement"          : "#hackdown{$id}",
                  {if $progressBarCountdown}
                  "progressBarCountdown" : true,
                  {/if}
                  "progressBarElement"   : "#hackdownProgressBar{$id}",
                  "textFinish"           : "{$textFinish}",
                  "reloadOnFinish"       : "{$reloadOnFinish}",
                  "reloadAfterXSeconds"  : {if $reloadAfterXSeconds}{$reloadAfterXSeconds}{else}5{/if},
                 });
        

  
</script>
