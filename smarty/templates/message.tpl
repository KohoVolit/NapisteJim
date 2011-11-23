{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {$message.subject}{/block}

{block name=body}
<div class="wrapper">
<div id="message-message">
	<div class="message-left left">{t}From{/t}:</div>
	<div class="message-right">{$message.sender_name}{if !empty($message.sender_address)}, {$message.sender_address}{/if}</div>
	<div class="message-left left">{t}To{/t}:</div>
	<div class="message-right">{foreach $replies.mp as $mp}{assign "personal_name" format_personal_name($mp)}{$personal_name}{if !$mp@last}, {/if}{/foreach}</div>
	<div class="message-left left">{t}Subject{/t}:</div>
	<div id="message-subject" class="message-right">{$message.subject}</div>
	<div class="message-left left">{t}Date{/t}:</div>
	<div class="message-right">{$message.sent_on|date_format:$locale.date_format}</div>
	<div id="message-body" class="message-right">{$message.body|nl2br}</div>
</div>
{foreach $replies.mp as $mp}
<div class="message-reply">
	<div class="message-left left">{assign "personal_name" format_personal_name($mp)}{$personal_name}:</div>
	{foreach $mp.reply as $reply}
	<div class="message-right">{if !empty($reply.received_on)}{$reply.body|nl2br}{else}<em>{t}Not answered yet{/t}&hellip;</em>{/if}</div>
	{/foreach}
</div>
{/foreach}
{/block}
