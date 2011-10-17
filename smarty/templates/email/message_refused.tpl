{t}We are sorry, but your message for politicians{/t}

{foreach $addressee as $a}{$a.first_name} {$a.last_name}
{/foreach}

{t}has been blocked by an automatic invectives-checking system and it
has not been sent.{/t}

{t}Although we are continually working on enhancing the checking system,
it may block a completely correct message exceptionally.{/t}

{t 1='$smarty.const.CONTACT_EMAIL'}If you believe, that your message has been blocked by mistake,
please contact us by e-mail to %1.{/t}


--- {t}Your message for politicians{/t} ---

{t}Subject{/t}: {$message.subject}

{$message.body}
