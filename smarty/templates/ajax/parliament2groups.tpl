<div id="new">
<label for="constituency" class="left">Volební obvod: </label>
<select name="constituency" id="constituency">
<option value="0" selected="selected">Nezáleží</option>
{foreach $constit as $c}
<option value="{$c.id}">{$c.name}</option>
{/foreach}
</select>

{foreach $groups as $group_kind}
  <label for="{$group_kind.0.group_kind_code|escape:'url'}" class="left">{$group_kind.0.group_kind_name}: </label>
  <select name="{$group_kind.0.group_kind_code|escape:'url'}" id="{$group_kind.0.group_kind_code|escape:'url'}" class="advanced_search-select-2" >
  <option value="0" selected="selected">Nezáleží</option>
  {foreach $group_kind as $group}
    <option value="{$group.id}">{$group.name}</option>
  {/foreach}
  </select>
{/foreach}
</div>
<input id="advanced_search-hidden-value" value="page" type="hidden" />
<input id="advanced_search-submit" value="Psát vybraným politikům >>" type="submit" />


<div id="advanced_search-note" class="ui-widget">
 <div class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
  <span class="ui-icon ui-icon-info" style="float:left; margin-right: .3em;"></span>
Pozn.: Je třeba vybrat alespoň jedno kritérium uvnitř zastupitelského sboru
 </div>
</div>
