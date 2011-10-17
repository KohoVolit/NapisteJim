{extends file="layout.tpl"}

{block name=title}{$smarty.const.WTT_TITLE} – {t}Support us{/t}{/block}

{block name=body}
<h1>{t}Support us{/t}</h1>
{t escape=no 1=$smarty.const.WTT_TITLE}MSGID_SUPPORT_US_SECTION{/t}
{/block}
