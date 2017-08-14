{extends file="layout.tpl"}

{block name=title}
{t}You have already sent the same message{/t}
{/block}

{block name=main}
<h3>{t}You have already sent the same message{/t}</h3>

<p>{t}You have already sent a message with this text to your representatives and the same message cannot be sent twice.{/t}</p>

{t escape=no 1=$smarty.const.NJ_TITLE}MSGID_ALREADY_SENT_EXPLANATION{/t}

<p class="small-text">{t}You can close this window now.{/t}</p>
{/block}
