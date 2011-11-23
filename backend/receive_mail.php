<?php

require '/home/shared/napistejim.cz/config/settings.php';
require '/home/shared/napistejim.cz/setup.php';
require '/home/shared/napistejim.cz/utils.php';

// read a mail from standard input
$mail = '';
while (!feof(STDIN) && strlen($mail) < 20000000)	// limit to 20 MB
    $mail .= fread(STDIN, 8192);

// backup the mail
$backup_filename = NJ_DIR . '/backend/mails/mails-' . strftime('%Y-%m-%d');
file_put_contents($backup_filename, $mail . "\n\n\n", FILE_APPEND);
chmod($backup_filename, 0640);

// parse the mail
if (strpos($mail, "\r\n") === false)
	$mail = str_replace("\n", "\r\n", $mail);
$parsed_mail = fMailbox::parseMessage($mail);

$subject = $parsed_mail['headers']['subject'];
$body = (isset($parsed_mail['text'])) ? $parsed_mail['text'] : ((isset($parsed_mail['html'])) ? $parsed_mail['html'] : '');

// in case of a mail other than a reply to a sent message, just notice admin
if (!preg_match('/reply\.([a-z]{10})@/', $parsed_mail['headers']['x-original-to'], $recipient))
{
	$subject = mime_encode(sprintf(_('An e-mail received to address %s'), $parsed_mail['headers']['x-original-to']));
	$text = _('From:') . ' ' . $parsed_mail['headers']['from']['personal'] . ' <' . $parsed_mail['headers']['from']['mailbox'] . '@' . $parsed_mail['headers']['from']['host'] . ">\n";
	$text .= _('Subject:') . ' ' . $subject . "\n\n";
	$text .= $body . "\n\n\n";
	$text .= '---------- ' . _('Full e-mail data') . '----------' . "\n\n";
	$text .= $mail;
	notice_admin($subject, $text);
	return;
}

// check the reply code
$reply_code = strtolower($recipient[1]);
$api_data = new ApiDirect('data');
$message_to_mp = $api_data->readOne('MessageToMp', array('reply_code' => $reply_code));

// in case of an unrecognized reply just notice admin
if (empty($message_to_mp))
{
	$subject = mime_encode(sprintf(_('No corresponding message found to the received reply with code %s'), $reply_code));
	$text = sprintf(_('The received reply can be found in %s'), NJ_DIR . '/mail/backup/mails-' .  strftime('%Y-%m-%d'));
	notice_admin($subject, $text);
	return;
}

// store a reply to a public message only
$message = $api_data->readOne('Message', array('id' => $message_to_mp['message_id']));
if ($message['is_public'] == 'yes')
{
	$body = preg_replace('/reply\.[a-z]{10}@/', 'reply.**********@', $body);
	$api_data->create('Reply', array('reply_code' => $reply_code, 'subject' => $subject, 'body' => $body, 'full_email_data' => $mail));
}
else
	$api_data->update('MessageToMp', array('reply_code' => $reply_code), array('private_reply_received' => 'yes'));

// send the reply to sender of the message
$mp = $api_data->readOne('Mp', array('id' => $message_to_mp['mp_id']));
$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
$reply_to = compose_email_address($parsed_mail['headers']['from']['personal'], $parsed_mail['headers']['from']['mailbox'] . '@' . $parsed_mail['headers']['from']['host']);
$to = compose_email_address($message['sender_name'], $message['sender_email']);
$subject = mime_encode(sprintf(_('%s has replied to your message'), format_personal_name($mp['first_name'], $mp['middle_names'], $mp['last_name'])));
$smarty = new SmartyNapisteJim;
$smarty->assign('mp', $mp);
$smarty->assign('reply', array('subject' => $subject, 'body' => $body, 'is_public' => $message['is_public']));
$text = $smarty->fetch('email/reply_from_mp.tpl');
send_mail($from, $to, $subject, $text, $reply_to);

?>
