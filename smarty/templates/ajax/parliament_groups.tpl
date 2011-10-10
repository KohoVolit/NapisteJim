<div id="new">
<label for="constituency" class="left">{t}Constituency: {/t}</label>
<select name="constituency" id="constituency">
<option value="0" selected="selected">{t}any{/t}</option>
{foreach $constituencies as $c}
<option value="{$c.id}">{$c.name}</option>
{/foreach}
</select>

{foreach $groups as $group_kind}
  <label for="{$group_kind.code|escape:'url'}" class="left">{$group_kind.name}: </label>
  <select name="{$group_kind.code|escape:'url'}" id="{$group_kind.code|escape:'url'}" class="advanced_search-select-2" >
  <option value="0" selected="selected">{t}any{/t}</option>
  {foreach $group_kind.group as $group}
    <option value="{$group.id}">{$group.name} {if !empty($group.short_name)} ({$group.short_name}){/if}</option>
  {/foreach}
  </select>
{/foreach}
</div>
<input id="advanced_search-hidden-value" value="page" type="hidden" />
<input id="advanced_search-submit" value="{t}Write to chosen politicians >>{/t}" type="submit" />


<div id="advanced_search-note" class="ui-widget">
 <div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
  <span class="ui-icon ui-icon-info" style="float:left; margin-right: .3em;"></span>
{t}Note. At least one criterion must be set within a parliament.{/t}
 </div>
</div>
