{extends file="layout.tpl"}

{block name=title}
{t}Confirmation of sending of the message{/t}
{/block}

{block name=body}
<h3>{t}Please confirm that you want to send the message{/t}</h3>

<p>{t}The message must be confirmed to send by clicking on the confirmation link sent to you by e-mail yet. Check your mailbox. Sometimes it can take a while to be delivered. If you still cannot find the e-mail check also a spam folder.{/t}<p>

<p><a href="list">{t}List of public messages{/t}</a></p>
{/block}
