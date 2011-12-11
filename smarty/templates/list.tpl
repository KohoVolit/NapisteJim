{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}List of public messages{/t}{/block}

{block name=head}
<script type="text/javascript">
var nj_host = "{$smarty.const.NJ_HOST}"
var lang = "{$locale.lang}";
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/i18n/jquery.ui.datepicker-{$locale.lang}.js"></script>
<script type="text/javascript" src="js/list.js"></script>
{/block}

{block name=body}
<form id="list-filter-form" action="list" method="GET">
<table>
<tr class="ui-widget">
	<td><label for="parliament">{t}Parliament{/t}</label></td>
	<td><label for="recipient">{t}Politician{/t}</label></td>
	<td><label for="text">{t}Text{/t}</label></td>
	<td><label for="since">{t}Since{/t}</label></td>
	<td><label for="until">{t}Until{/t}</label></td>
	<td><label for="sender">{t}Sender{/t}</label></td>
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
    <td><input id="submit" type="submit" value="{t}Search{/t}" class="ui-corner-all ui-state-default" /></td>
</tr>
</table>
</form>

<table id="list-table">
<thead>
	<tr><td class="list-td-replier">{t}To{/t}</td><td class="list-message" >{t}Message{/t}</td><td class="list-td-date">{t}Sent{/t}</td><td class="list-td-sender">{t}From{/t}</td></tr>
</thead>
<tbody>
{foreach $messages as $message}
	<tr>
		<td class="list-td-replier">
{foreach $message.recipients as $recipient}
{assign "personal_name" format_personal_name($recipient, 'surname')}
{if !empty($recipient.first_reply_on)}<a href="/?message={$message.id}#mp-{$recipient.mp_id}" title="{$recipient.reply_body|escape:html}">{$personal_name}</a>{else}{$personal_name}{/if}{if !$recipient@last}, {/if}
{/foreach}
		</td>
		<td class="list-message"><a href="/?message={$message.id}" title="{$message.body|escape:html}"><span class="list-subject">{$message.subject}</span></a></td>
		<td class="list-td-date">{$message.sent_on|date_format:$locale.date_format}</td>
		<td class="list-td-sender">{$message.sender_name}</td>
	</tr>
{/foreach}
</tbody>
</table>

<div id="list-pager" class="pager">
{if isset($pager.prev_url_query)}
<div class="pager-link pager-prev"><a href="http://{$smarty.const.NJ_HOST}/list?{$pager.prev_url_query}">&laquo; {t}previous messages{/t}</a></div>
{/if}
{if isset($pager.next_url_query)}
<div class="pager-link pager-next"><a href="http://{$smarty.const.NJ_HOST}/list?{$pager.next_url_query}">{t}next messages{/t} &raquo;</a></div>
{/if}
</div>
{/block}
