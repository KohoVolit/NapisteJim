{if isset($addressees.sent)}{t escape=no}Your message has been sent to your representatives:{/t}

{foreach $addressees.sent as $a}
{assign "personal_name" format_personal_name($a)}{$personal_name}
{/foreach}
{else}{t escape=no}Your message has not been sent to your representatives.{/t}
{/if}
{if isset($addressees.blocked)}

{t escape=no}The following addressees already received the same message from another
sender, thus this one has not been sent to them:{/t}

{foreach $addressees.blocked as $a}{assign "personal_name" format_personal_name($a)}{$personal_name}, {if $a.former_message.is_public == 'yes'}{t escape=no}see message{/t} http://{$smarty.const.NJ_HOST}/?message={$a.former_message.id}{else}{t escape=no}the message was sent as a private one{/t}{/if}

{/foreach}

{t escape=no 1=$smarty.const.NJ_TITLE}Intention of the project %1 is to strengthen personal
communication between citizens and politicians. Even a few originally
written messages often have a greater impact than flooding of a politician
by copies of one prearanged message. See more in:{/t}
http://{$smarty.const.NJ_HOST}/faq#q8
{/if}
{if isset($addressees.no_email)}

{t escape=no}In case of addressees:{/t}

{foreach $addressees.no_email as $a}
{assign "personal_name" format_personal_name($a)}{$personal_name}
{/foreach}

{t escape=no}we do not have an e-mail address to them hence your message cannot be
sent to them.{/t}
{/if}

{if isset($addressees.sent)}
{t escape=no}For the case you decide to contact the politicans also by another way,
a copy of your message is attached below.{/t}
{else}
{t escape=no}For the case you decide to contact the politicans by another way,
a copy of your message is attached below.{/t}
{/if}
{if isset($addressees.sent)}

{if $message.is_public == 'yes'}{t escape=no 1=$smarty.const.NJ_TITLE}You have sent a public message - it will be published on the %1
website as well as as an eventual reply of the contacted politicians.{/t}{else}{t escape=no 1=$smarty.const.NJ_TITLE}You have chosen a private message - it will not be published on the
%1 website and the contacted politicians will send their eventual reply
directly to you.{/t}{/if}{/if}


{t escape=no 1=$smarty.const.CONTACT_EMAIL}Please do not reply to this e-mail. We will really appreciate
your feedback on the project, suggestions or problems at %1{/t}


--- {t escape=no}Your message for politicians{/t} ---

{t escape=no}Subject{/t}: {$message.subject}

{$message.body}
