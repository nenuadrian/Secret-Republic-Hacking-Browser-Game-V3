{include file="header_home.tpl"}

{include file="admin/debug/debug_header.tpl"}

	
    {foreach from=$crons item=p}
      <div class="row mb10">
        <div class="col-md-12">
          <div class="row-fluid">
            <div class="col-md-3 nopadding">
              <button disabled class="mb10">
                {$p.type}
              </button>
              <button class="disabled mb10" disabled">
                {$p.created}
              </button>
              
            </div>
            <div class="col-md-9">
              <div class="well black">
                {$p.data|nl2br}
              </div>
            </div>
           
          </div>
        </div>
      </div>
    {/foreach}
					
					
    <div class="text-center">
      {$pages}
    </div>
	
		
