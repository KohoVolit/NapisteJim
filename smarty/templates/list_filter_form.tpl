{* A form to filter the messages to show. Included from other templates. *}
<form id="list-filter-form" action="list" method="GET">
<table>
<tr class="ui-widget">
	<td><label for="parliament">{t}Parliament{/t}</label></td>
	<td><label for="recipient">{t}Politician{/t}</label></td>
	<td><label for="text">{t}Text{/t}</label></td>
	<td><label for="since">{t}Since{/t}</label></td>
	<td><label for="until">{t}Until{/t}</label></td>
	<td><label for="sender">{t}Sender{/t}</label></td>
	<td><label for="order">{t}Order by{/t}</label></td>
</tr>
<tr class="ui-widget">
	<td><select id="parliament" name="parliament_code" class="ui-corner-all" />
		<option value=""{if !isset($params.parliament_code) || empty($params.parliament_code)} selected="selected"{/if}>{t}any{/t}</option>
		{foreach $parliaments as $parliament}
			<option value="{$parliament.code}"{if isset($params.parliament_code) && $params.parliament_code == $parliament.code} selected="selected"{/if}>{$parliament.short_name|default:$parliament.name}</option>
		{/foreach}
		</select>
	</td>
	<td><input id="recipient" name="recipient" class="ui-corner-all" value="{if isset($params.recipient)}{$params.recipient}{/if}" /></td>
	<td><input id="text" name="text" class="ui-corner-all" value="{if isset($params.text)}{$params.text}{/if}" /></td>
	<td><input id="since" name="since" class="ui-corner-all" value="{if isset($params.since)}{$params.since}{/if}" /></td>
	<td><input id="until" name="until" class="ui-corner-all datepicker" value="{if isset($params.until)}{$params.until}{/if}" /></td>
	<td><input id="sender" name="sender" class="ui-corner-all datepicker" value="{if isset($params.sender)}{$params.sender}{/if}" /></td>
	<td><select id="order" name="order" class="ui-corner-all" />
		<option value="sent"{if !isset($params.order) || $params.order != 'sent'} selected="selected"{/if}>{t}sent date{/t}</option>
		<option value="replied"{if isset($params.order) && $params.order == 'replied'} selected="selected"{/if}>{t}replied date{/t}</option>
		</select></td>
    <td><input id="submit" type="submit" value="{t}Search{/t}" class="ui-corner-all ui-state-default" /></td>
</tr>
</table>
</form>
