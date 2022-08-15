{include file="header_home.tpl" no_sidebar=true}
<h1 class="text-center mb10" style="font-size:50px">ZONE {$zone.id}</h1>
<br/>
<div class="futureNav middle mb10" >
        <ul>
              <li><a href="{$config.url}rankings/zone/{$zone.id}">Rankings</a></li>
        </ul>
    </div>
    

<div class="row">
  <div class="col-md-7"> 
    <div class="well black">
      Population
    </div>
  </div>
  <div class="col-md-5">
    <button class="disabled" disabled>{$zone.nrm|number_format}</button>
  </div>
</div>
 <div class="row">
    <div class="col-md-4">
      <div class="well black">President</div>
    </div>
    <div class="col-md-8">
    {if !$zone.president} 
<button disabled class="button text-center mb10">
       No president
      </button>
    {else}
      <a href="{$config.url}profile/hacker/{$zone.president_name}" class="button text-center mb10">
        {$zone.president_name}
      </a>
      {/if}
    </div>
  </div>   
  <div class="row">
    <div class="col-md-7">
      <div class="well black">Minister of Defence</div>
    </div>
    <div class="col-md-5">
    {if !$zone.mdefence} 
<button disabled class="button text-center mb10">
       No minister
      </button>
    {else}
      <a href="{$config.url}profile/hacker/{$zone.mdefence_name}" class="button text-center mb10">
        {$zone.mdefence_name}
      </a>
      {/if}
    </div>
  </div>     
  
  {if $user.zone eq $zone.id}
  <div class="row">
    <div class="col-md-6">
      <div class="well black">Average level</div>
    </div>
    <div class="col-md-6">
      <button disabled class="disabled mb10">
        {$zone.avg_level|round:2}
        </button>
    </div>
  </div>    
  
  <div class="row">
    <div class="col-md-7">
      <div class="well black">Next elections start on</div>
    </div>
    <div class="col-md-5">
      <button disabled class="disabled mb10">
        {$zone.next_elections}
        </button>
    </div>
  </div>    
  {/if} 