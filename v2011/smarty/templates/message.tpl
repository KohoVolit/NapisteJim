{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {$message.subject}{/block}

{block name=main}
<div class="wrapper">
<h2 id="message-title">{$message.subject}</h2>
<div id="message-from">{t}From{/t}: {$message.sender_name}{if !empty($message.sender_address)}, {$message.sender_address}{/if}</div>
<div id="message-date">{t}Date{/t}: {$message.sent_on|date_format:$locale.date_format}</div>
<div id="message-body">{$message.body|nl2br}</div>
{foreach $replies.mp as $mp}
<a id="mp-{$mp.mp_id}"></a><div class="message-mp-replies">
	<div class="message-mp">
		{assign "personal_name" format_personal_name($mp)}
		<img src="{if !empty($mp.mp_image)}{$smarty.const.API_FILES_URL}/{$mp.mp_image}{else}http://{$smarty.const.NJ_HOST}/images/head_{if $mp.sex == 'f'}female{else}male{/if}_small.png{/if}" title="{$personal_name}" alt="{$personal_name}"  />
		<span class="name">{$personal_name},</span><br />
		{if !empty($mp.political_group)}{$mp.political_group},<br />{/if}
		{$mp.parliament}
		<div><a href="list?mp_id={$mp.mp_id}">{t count=$mp.received_public_messages 1=$mp.received_public_messages plural="%1 messages"}%1 message{/t}</a></div>
		<div><a href="?mp={$mp.parliament_code}/{$mp.mp_id}">{if $mp.sex == 'f'}{t}Write to her{/t}{else}{t}Write to him{/t}{/if}</a></div>
	</div>
{foreach $mp.reply as $reply}
{if !empty($reply.received_on)}<div class="message-reply-date">{$reply.received_on|date_format:$locale.date_format}</div>{/if}
	<div class="message-reply">{if !empty($reply.received_on)}{$reply.body|nl2br}{else}<span class="dimmed">{t}Not answered yet{/t}&hellip;</span>{/if}</div>
{/foreach}
</div>
<div class="clearfix"></div>
{/foreach}
{/block}
