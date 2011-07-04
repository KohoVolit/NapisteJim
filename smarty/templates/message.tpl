{extends file="layout.tpl"}

{block name=title}
NapišteJim.cz - veřejný email
{/block}

{block name=body}
<div class="wrapper">
<div id="message-message">
	<div class="message-left left">Od:</div>
	<div class="message-right">{$message.sender_name}</div>
	<div class="message-left left">Komu:</div>
	<div class="message-right">{foreach $responses as $response}{$response.first_name}&nbsp;{$response.last_name}{if !$response@last}, {/if}{/foreach}</div>
	<div class="message-left left">Předmět:</div>
	<div id="message-subject" class="message-right">{$message.subject}</div>
	<div class="message-left left">Datum:</div>
	<div class="message-right">{$message.sent_on|date_format:$smarty.const.LOCALIZED_DATE_FORMAT}</div>
	<div id="message-body" class="message-right">{$message.body_|nl2br}</div>
</div>
{foreach $responses as $response}
<div class="message-response">
	<div class="message-left left">{$response.first_name}&nbsp;{$response.last_name}:</div>
	<div class="message-right">{$response.body_|nl2br|default:'<em>Zatím bez odpovědi&hellip;</em>'}</div>
</div>
{/foreach}
{/block}
