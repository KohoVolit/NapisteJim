
{foreach $data as $parliament}
  <div class="parliament-head" id="parliament-head-{$parliament.code}" > 
    <div class="parliament-head-name" id="parliament-head-name-{$parliament.code}" >
      {$parliament.name}
    </div>
    <div class="parliament-head-description" id="parliament-head-description-{$parliament.code}">
      {$parliament.description}
    </div>
  </div>
  <div id="parliament-body-{$parliament.code}" class="parliament-body">
    <div class="constituencies-message">
      {$parliament.message}
    </div>
    {foreach $parliament.constituency as $ckey => $constituency}
      <div id="constituency-{$constituency.ckey}" class="constituency">
        {foreach $constituency.group as $group}
          <div id="group-{$group.friendly_name}" class="group">
            <img src="images/1x1.png" class="party-logo party-logo-{$group.friendly_name}" title="{$group.name}" alt="{$group.name}" />
            {foreach $group.mp as $mp}
              <div class="group-mps">
                <div id="mp-whole-{$parliament.code}/{$mp.id}" class="mp">
                  <img src="images/1x1.png" class="mp-toggle mp-toggle-off mp-toggle-{$parliament.code}/{$mp.id}" alt="" />
                  <span class="mp-name">
                    <span id="{$parliament.code}/{$mp.id}" class="mp-name-name draggable mp-{$parliament.code}/{$mp.id}">{$mp.last_name}</span>
                    <span class="mp-name-info dimmed small-text">{$mp.info}</span>
                  </span>
                </div>
              </div>
            {/foreach}
          </div>
        {/foreach}
      </div>
    {/foreach}
  </div>
{/foreach}
