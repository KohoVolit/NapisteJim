{t escape=no 1=$smarty.const.NJ_TITLE}A message written on %1 website seems to be offensive and it
needs your review and approval to be sent to politicians. The message
is attached below.{/t}

{t escape=no}If the message is all right and it SHOULD BE sent to addressees,
click on this link:{/t}
http://{$smarty.const.NJ_HOST}/confirm?action=approve&cc={$message.confirmation_code}&ac={$message.approval_code}

{t escape=no}If the message is offensive and SHOULD NOT be sent to addressees,
click on this link:{/t}
http://{$smarty.const.NJ_HOST}/confirm?action=refuse&cc={$message.confirmation_code}&ac={$message.approval_code}


--- {t escape=no}The message for politicians{/t} ---

{t escape=no}Subject{/t}: {$message.subject}

{$message.body}
