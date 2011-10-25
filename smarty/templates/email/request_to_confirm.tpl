{t escape=no 1=$smarty.const.WTT_TITLE}You have written a message attached below using %1 website
addressed to your representatives:{/t}

{foreach $addressee as $a}{$a.first_name} {$a.last_name}
{/foreach}

{t escape=no}Please confirm that you want to send the message by clicking the
following link.{/t}

	http://{$smarty.const.WTT_HOST}/confirm?action=send&cc={$message.confirmation_code}

{t escape=no}If the link is not clickable, copy&paste it to the address bar of
your web browser.{/t}

{if $message.is_public == 'yes'}{t escape=no 1=$smarty.const.WTT_TITLE}You have chosen a public message - it will be published on %1
website after it is confirmed and sent to the representatives.
Their eventual answer will be published on the same place.{/t}{else}{t escape=no}You have chosen a private message - it will not be published anywhere
and the addressed politicians will send their eventual anwser directly
to you.{/t}{/if}


{t escape=no}If you have changed your mind and you don't want to send the message,
you don't need to do anything. Unless you click the confirmation link
above, the message will be deleted automatically some time later without
sending.{/t}

{t escape=no 1=$smarty.const.CONTACT_EMAIL}If you have not written this message, please let us know to
%1{/t}

{t escape=no 1=$smarty.const.CONTACT_EMAIL}Please do not reply to this e-mail. We will really appreciate
your feedback on the project, suggestions or problems at %1{/t}


--- {t escape=no}Your message for politicians{/t} ---

{t escape=no}Subject{/t}: {$message.subject}

{$message.body}
