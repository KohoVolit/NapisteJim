{assign "personal_name" format_personal_name($mp)}
{t escape=no 1=$smarty.const.NJ_TITLE 2=$personal_name}%2 responded to your message sent through
%1 website. You can find the reply below.{/t}

{if $reply.is_public == 'yes'}{t escape=no 1=$smarty.const.NJ_TITLE}Because your message was sent as a public one, the reply is published
on the %1 website as well. If you will go on in discussion by
replying to this e-mail, your reply will be sent to the addressee, aside
from %1 website.{/t}{/if}


--- {t escape=no}Reply to your message{/t} ---

{t escape=no}From{/t}: {$personal_name}
{t escape=no}Subject{/t}: {$reply.subject}

{$reply.body}
