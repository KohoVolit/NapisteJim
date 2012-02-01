{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Your IP address is blocked{/t}{/block}

{block name=main}
<h2>{t}Your IP address is blocked{/t}</h2>
<p>{t}IP address of your computer has been blocked because of sending spam or obtrusive messages.{/t}</p>
<p>{t escape=no}In case you feel that it must be a mistake, please <a href="/contact">contact us</a>.{/t}</p>
{/block}
