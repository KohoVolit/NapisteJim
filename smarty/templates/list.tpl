{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}List of public messages{/t}{/block}

{block name=body}
<table id="list-table">
<thead>
	<tr><td class="list-td-response-status">{t}Status{/t}</td><td class="list-td-responder">{t}To{/t}</td><td class="list-message" >{t}Message{/t}</td><td class="list-td-date">{t}Date{/t}</td><td class="list-td-sender">{t}From{/t}</td></tr>
</thead>
<tbody>
{foreach $messages as $message}
	<tr>
		<td class="list-td-response-status">
{foreach $message.response_exists as $re}
			<img src="/images/1x1.png" {if $re == 'yes'}class="list-response-status list-answered" title="{t}Message answered{/t}"{elseif $message.age_days >14}class="list-response-status list-not-answered-long" title="{t days='14'}Message answered (more than %1 days){/t}"{else}class="list-response-status list-not-answered-short" title="{t days='14'}Message answered (less than %1 days){/t}"{/if} alt=""/>
{/foreach}
		</td>
		<td class="list-td-responder">{$message.recipients}</td>
		<td class="list-message" title="{$message.body|truncate:150}"><a href="/?message={$message.id}"><span class="list-subject">{$message.subject}</span>&nbsp;<span class="list-body">{$message.body|truncate:150}</span></a></td>
		<td class="list-td-date">{$message.sent_on|date_format:$locale.date_format}</td>
		<td class="list-td-sender">{$message.sender_name}</td>
	</tr>
{/foreach}
</tbody>
</table>
{/block}
