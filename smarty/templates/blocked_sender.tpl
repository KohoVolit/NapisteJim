{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Your e-mail address is blocked{/t}{/block}

{block name=main}
<h2>{t}Your e-mail address is blocked{/t}</h2>
<p>{t}Your e-mail address has been blocked because of sending spam or obtrusive messages. The message has not been sent.{/t}</p>
<p>{t escape=no}In case you feel that it must be a mistake, please <a href="/contact">contact us</a>.{/t}</p>
{/block}
