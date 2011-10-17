<div class='wrapper'>
{foreach $representatives as $parliament}
<div class="parliament ui-widget" id="parliament-{$parliament.code}">
  <div class="parliament-head ui-accordion ui-accordion-icons ui-helper-reset" id="parliament-head-{$parliament.code}" > 
    <h3 class="parliament-head-name ui-accordion-header" id="parliament-head-name-{$parliament.code}" >
      <span class="ui-icon ui-icon-triangle-1-s"></span>
      <a href="#" class="ui-state-active"> {$parliament.name}</a>
    </h3>
    <div class="parliament-head-description" id="parliament-head-description-{$parliament.code}">
      {$parliament.description}
    </div>
  </div>
  <div id="parliament-body-{$parliament.code}" class="parliament-body">
	{if count($parliament.constituency) > 1}
    <div class="constituencies-message">{t}Several constituencies has been found to your address. Choose the right one or try to specify your address more precisely.{/t}</div>
	{/if}
    {foreach $parliament.constituency as $ckey => $constituency}
      <div id="constituency-{$ckey}" class="constituency">
		{if $constituency@total > 1}
		<div class="constituency-description">{$constituency.name}: {$constituency.description}</div>
		{/if}
        {foreach $constituency.group as $gkey => $group}
          <div id="group-{$gkey}" class="group">
          	<div class="wrapper">
          	  	<div class="group-logo left">
		          <img src="{$smarty.const.API_FILES_URL}/{$group.logo}" class="party-logo" title="{$group.name}" alt="{$group.short_name}" />
		        </div>
		        {foreach $group.mp as $mp}
		          <div class="group-mps">
		            <div id="mp-{$parliament.code}/{$mp.id}" class="mp">
		              <span class="mp-name">
		                <span id="mp-name-name-{$parliament.code}/{$mp.id}" class="mp-name-name mp-clicked-off mp-clicked-{$mp.id} draggable">{$mp.last_name}</span>&nbsp;<span	class="mp-name-info dimmed small-text">{$mp.additional_info}</span>
		              </span>
		            </div>
		          </div>
		        {/foreach}
		    </div>
          </div>
        {/foreach}
      </div>
    {/foreach}
  </div>
</div>
{/foreach}
</div>
