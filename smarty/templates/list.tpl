{extends file="layout.tpl"}

{block name=title}{$smarty.const.WTT_TITLE} – Seznam veřejným emailů{/block}

{block name=body}
<table id="list-table">
<thead>
	<tr><td class="list-td-response-status">Stav</td><td class="list-td-responder">Komu</td><td class="list-message" >Zpráva</td><td class="list-td-date">Datum</td><td class="list-td-sender">Od</td></tr>
</thead>
<tbody>
{foreach $messages as $message}
	<tr>
		<td class="list-td-response-status">
{foreach $message.response_exists as $re}
			<img src="/images/1x1.png" {if $re == 'yes'}class="list-response-status list-answered" title="Email zodpovězen"{elseif $message.age_days >14}class="list-response-status list-not-answered-long" title="Email nezodpovězen (více jak 14 dní)"{else}class="list-response-status list-not-answered-short" title="Email nezodpovězen (méně jak 14 dní)"{/if} alt=""/>
{/foreach}
		</td>
		<td class="list-td-responder">{$message.recipients}</td>
		<td class="list-message" title="{$message.body_|truncate:150}"><a href="/?message={$message.id}"><span class="list-subject">{$message.subject}</span>&nbsp;<span class="list-body">{$message.body_|truncate:150}</span></a></td>
		<td class="list-td-date">{$message.sent_on|date_format:$smarty.const.LOCALIZED_DATE_FORMAT}</td>
		<td class="list-td-sender">{$message.sender_name}</td>
	</tr>
{/foreach}
</tbody>
</table>
{/block}
