{extends file="layout.tpl"}

{block name=title}{t}Confirmation of sending of the message{/t}{/block}

{block name=head}
	{if isset($css) && !empty($css)}<link rel="stylesheet" href="{$css}" type="text/css" />{/if}
{/block}

{block name=main}
<h3>{t}Please confirm that you want to send the message{/t}</h3>

<p>{t}The message must be confirmed to send by clicking on the confirmation link sent to you by e-mail yet. Check your mailbox. Sometimes it can take a while to be delivered. If you cannot find the e-mail, check also the spam folder.{/t}<p>

<p>{t 1=$smarty.const.CONTACT_EMAIL}In the case you cannot find that confirmation e-mail for more than 24 hours and you wish to confirm your message to be sent, please contact us on %1 from the same address as used in your message.{/t}<p>

<p><a href="public"{if isset($css) && !empty($css)} target="_blank"{/if}>{t}List of public messages{/t}</a></p>
{/block}
