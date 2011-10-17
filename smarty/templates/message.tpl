{extends file="layout.tpl"}

{block name=title}{$smarty.const.WTT_TITLE} – $message.subject{/block}

{block name=body}
<div class="wrapper">
<div id="message-message">
	<div class="message-left left">{t}From{/t}:</div>
	<div class="message-right">{$message.sender_name}{if !empty($message.sender_address)}, {$message.sender_address}{/if}</div>
	<div class="message-left left">{t}To{/t}:</div>
	<div class="message-right">{foreach $responses as $response}{$response.first_name}&nbsp;{if !empty($response.middle_names)}{$response.middle_names}&nbsp;{/if}{$response.last_name}{if !$response@last}, {/if}{/foreach}</div>
	<div class="message-left left">{t}Subject{/t}:</div>
	<div id="message-subject" class="message-right">{$message.subject}</div>
	<div class="message-left left">{t}Date{/t}:</div>
	<div class="message-right">{$message.sent_on|date_format:$locale.date_format}</div>
	<div id="message-body" class="message-right">{$message.body|nl2br}</div>
</div>
{foreach $responses as $response}
<div class="message-response">
	<div class="message-left left">{$response.first_name}&nbsp;{$response.last_name}:</div>
	<div class="message-right">{$response.body|nl2br|default:'<em>{t}Not answered yet{/t}&hellip;</em>'}</div>
</div>
{/foreach}
{/block}
