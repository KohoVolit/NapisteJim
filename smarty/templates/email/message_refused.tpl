{t escape=no}We are sorry, but your message for politicians{/t}

{foreach $addressees as $a}
{assign "personal_name" format_personal_name($a)}{$personal_name}
{/foreach}

{t escape=no}has been blocked by an automatic invectives-checking system and it
has not been sent.{/t}

{t escape=no}Although we are continually working on enhancing the checking system,
it may block a completely correct message exceptionally.{/t}

{t escape=no 1='$smarty.const.CONTACT_EMAIL'}If you believe, that your message has been blocked by mistake,
please contact us by e-mail to %1.{/t}


--- {t escape=no}Your message for politicians{/t} ---

{t escape=no}Subject{/t}: {$message.subject}

{$message.body}
