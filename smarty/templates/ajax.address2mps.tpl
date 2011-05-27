<div class='wrapper'>
{foreach $data as $parliament}
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
    <div class="constituencies-message">
      {$parliament.message}
    </div>
    {foreach $parliament.constituency as $ckey => $constituency}
      <div id="constituency-{$ckey}" class="constituency">
        {foreach $constituency.group as $group}
          <div id="group-{$group.friendly_name}" class="group">
          	<div class="wrapper">
          	  	<div class="group-logo left">
		          <img src="images/1x1.png" class="party-logo party-logo-{$group.friendly_name}" title="{$group.name}" alt="{$group.name}" />
		        </div>
		        {foreach $group.mp as $mp}
		          <div class="group-mps">
		            <div id="mp-{$parliament.code}/{$mp.id}" class="mp">
		              <span class="mp-name">
		                <span id="mp-name-name-{$parliament.code}/{$mp.id}" class="mp-name-name mp-clicked-off mp-clicked-{$mp.id} draggable">{$mp.last_name}</span><span
							class="mp-name-info dimmed small-text">{$mp.info}</span>
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
