{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Public messages{/t}{/block}

{block name=head}
<script type="text/javascript">
var nj_host = "{$smarty.const.NJ_HOST}"
var lang = "{$locale.lang}";
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/i18n/jquery.ui.datepicker-{$locale.lang}.js"></script>
<script type="text/javascript" src="js/list.js"></script>
{/block}

{block name=body}
{foreach $message_sets as $message_set}

<h3>{$message_set.title}</h3>
<table id="list-table">
<thead>
	<tr><td class="list-td-replier">{t}To{/t}</td><td class="list-message" >{t}Message{/t}</td><td class="list-td-date">{t}Sent{/t}</td><td class="list-td-sender">{t}From{/t}</td></tr>
</thead>
<tbody>
{foreach $message_set.messages as $message}
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
<div class="pager"><div class="pager-link pager-next"><a href="list?{$message_set.next_params}">{t}next messages{/t}&nbsp;&raquo;</a></div></div>
{/foreach}

<h3>{t}Search messages{/t}</h3>
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
		<option value="" selected="selected">{t}any{/t}</option>
		{foreach $parliaments as $parliament}
			<option value="{$parliament.code}">{$parliament.short_name|default:$parliament.name}</option>
		{/foreach}
		</select>
	</td>
	<td><input id="recipient" name="recipient" class="ui-corner-all" /></td>
	<td><input id="text" name="text" class="ui-corner-all" /></td>
	<td><input id="since" name="since" class="ui-corner-all" /></td>
	<td><input id="until" name="until" class="ui-corner-all" /></td>
	<td><input id="sender" name="sender" class="ui-corner-all" /></td>
    <td><input id="submit" type="submit" value="{t}Search{/t}" class="ui-corner-all ui-state-default" /></td>
</tr>
</table>
</form>

<h3>{t}Favorite recipients{/t}</h3>
<div id="public-mp-statistics">
{foreach $mp_statistics as $mp}
{assign "personal_name" format_personal_name($mp, 'long')}
<a href="list?mp_id={$mp.id}">{$personal_name}</a> {if $mp@first} {t count=$mp.received_public_messages 1=$mp.received_public_messages plural="%1 messages"}%1 message{/t}{else}{$mp.received_public_messages}{/if},
{/foreach}
 <a href="statistics">{t}next politicians{/t}&hellip;</a>
</div>
{/block}
