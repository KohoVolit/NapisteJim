{t 1=$smarty.const.WTT_TITLE 2=$message.sender_name}%2 sent this message to you using the %1 website.{/t}

{if $message.is_public == 'yes'}{t 1=$smarty.const.WTT_TITLE}The message has been sent as a public one and it is published on
%1 website. Your response will be published on the same place.{/t}{else}{t 1=$message.sender_email}The message has been sent as a private one. Please send your response
directly to the e-mail address of the sender: %1{/t}{/if}


--- {t}A message for you{/t} ---

{t}Subject{/t}: {$message.subject}
{t}From{/t}: {$message.sender_name}

{$message.body}
