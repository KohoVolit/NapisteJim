<div id="new">
<label for="constituency" class="left">Volební obvod: </label>
<select name="constituency" id="constituency">
<option value="0" selected="selected">Nezáleží</option>
{foreach $constit as $c}
<option value="{$c.id}">{$c.name_}</option>
{/foreach}
</select>

{foreach $groups as $group_kind}
  <label for="{$group_kind.0.group_kind_code|escape:'url'}" class="left">{$group_kind.0.group_kind_code}: </label>
  <select name="{$group_kind.0.group_kind_code|escape:'url'}" id="{$group_kind.0.group_kind_code|escape:'url'}" class="advanced_search-select-2" >
  <option value="0" selected="selected">Nezáleží</option>
  {foreach $group_kind as $group}
    <option value="{$group.id}">{$group.name_}</option>
  {/foreach}
  </select>
{/foreach}
</div>
<input id="advanced_search-submit" value="Zobrazit seznam vybraných politiků >>" type="submit" />
