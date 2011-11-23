<div class='wrapper'>
{foreach $representatives as $parliament}
<div class="parliament ui-widget" id="parliament-{$parliament.code}">
  <div class="parliament-head ui-accordion ui-accordion-icons ui-helper-reset" id="parliament-head-{$parliament.code}" > 
    <h3 class="parliament-head-name ui-accordion-header" id="parliament-head-name-{$parliament.code}" >
      <span class="ui-icon ui-icon-triangle-1-s"></span>
      <a href="#" class="ui-state-active">{$parliament.name}</a>
    </h3>
  </div>
  <div id="parliament-body-{$parliament.code}" class="parliament-body">
    <div class="parliament-head-description" id="parliament-head-description-{$parliament.code}">
      {$parliament.competence}
    </div>
	{if count($parliament.constituency) > 1}
    <div class="constituencies-message">{t}Several constituencies has been found to your address. Choose the right one or try to specify your address more precisely.{/t}</div>
	{/if}
    {foreach $parliament.constituency as $ckey => $constituency}
      <div id="constituency-{$ckey}" class="constituency">
		{if $constituency@total > 1}
		<div class="constituency-description"><span class="name">{$constituency.name}:</span> {$constituency.description}</div>
		{/if}
		{if isset($constituency.group)}
			{foreach $constituency.group as $gkey => $group}
			  <div id="group-{$gkey}" class="group">
				<div class="wrapper">
					<div class="group-logo left">
					  {if !empty($group.logo)}<img src="{$smarty.const.API_FILES_URL}/{$group.logo}" class="party-logo" title="{$group.name}" alt="{$group.short_name}" />{else}{$group.short_name}{/if}
					</div>
					{foreach $group.mp as $mp}
					  <div class="group-mps">
						<div id="mp-{$parliament.code}/{$mp.id}" class="mp">
						  <span class="mp-name">
							<span id="mp-name-name-{$parliament.code}/{$mp.id}" class="mp-name-name mp-clicked-off mp-clicked-{$mp.id} draggable">{assign "personal_name" format_personal_name($mp, 'surname')}{$personal_name}</span>&nbsp;<span	class="mp-name-info dimmed small-text">{$mp.additional_info}</span>
						  </span>
						</div>
					  </div>
					{/foreach}
				</div>
			  </div>
			{/foreach}
		{else}
			<div id="group-0" class="group">
				<div class="wrapper">
					{foreach $constituency.mp as $mp}
					  <div class="group-mps">
						<div id="mp-{$parliament.code}/{$mp.id}" class="mp">
						  <span class="mp-name">
							<span id="mp-name-name-{$parliament.code}/{$mp.id}" class="mp-name-name mp-clicked-off mp-clicked-{$mp.id} draggable">{assign "personal_name" format_personal_name($mp, 'surname')}{$personal_name}</span>&nbsp;<span	class="mp-name-info dimmed small-text">{$mp.additional_info}</span>
						  </span>
						</div>
					  </div>
					{/foreach}
				</div>
			</div>
		{/if}
      </div>
    {/foreach}
  </div>
</div>
{/foreach}
</div>
