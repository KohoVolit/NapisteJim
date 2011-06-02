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
	<div class="message-right">{$message.to}</div>
	<div class="message-left left">Předmět:</div>
	<div id="message-subject" class="message-right">{$message.subject}</div>
	<div class="message-left left">Datum:</div>
	<div class="message-right">{$message.date}</div>
	<div id="message-body" class="message-right">{$message.body_}</div>
</div>
{foreach $responses as $response}
<div class="message-response">
	<div class="message-left left">{$response.responder.name}:</div>
	<div class="message-right">{$response.body_}</div>
</div>
{/foreach}
{/block}
