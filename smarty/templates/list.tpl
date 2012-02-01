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

{block name=main}
<h3>{t}Public messages and answers{/t}</h3>
{include './list_filter_form.tpl'}

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
