<?php

require '/home/shared/napistejim.cz/config/settings.php';
require '/home/shared/napistejim.cz/setup.php';

// read a mail from standard input
$mail = '';
while (!feof(STDIN) && strlen($mail) < 4000000)	// limit to 4 MB
    $mail .= fread(STDIN, 8192);

// backup the mail
$backup_pathname = NJ_DIR . '/mail/backup/mails-' . strftime('%Y-%m-%d');
$backup_file = fopen($backup_pathname, 'a');
fwrite($backup_file, $mail . "\n\n\n");
fclose($backup_file);
chmod($backup_pathname, 0640);

// parse the mail
if (strpos($mail, "\r\n") === false)
	$mail = str_replace("\n", "\r\n", $mail);
$parsed_mail = fMailbox::parseMessage($mail);

// if the mail is a response, process its content
if (preg_match('/reply\.([a-z]{10})@/', $parsed_mail['headers']['x-original-to'], $recipient))
{
	// parse a response to a message sent to representatives
	$reply_code = strtolower($recipient[1]);
	$subject = $parsed_mail['headers']['subject'];
	$body = (isset($parsed_mail['text'])) ? $parsed_mail['text'] : ((isset($parsed_mail['html'])) ? $parsed_mail['html'] : '');

	// store the response
	$api_data = new ApiDirect('data');
	$body = preg_replace('/reply\.[a-z]{10}@/', 'reply.**********@', $body);
	$res = $api_data->update('Response', array('reply_code' => $reply_code), array('subject' => $subject, 'body' => $body, 'full_email_data' => $mail, 'received_on' => 'now'));

	// notice admin about unrecognized responses
	if (count($res) == 0)
	{
		$subject = mime_encode(sprintf(_('No corresponding message found to the received response with code %s'), $reply_code));
		$text = sprintf(_('The received response can be found in %s'), NJ_DIR . '/mail/backup/mails-' .  strftime('%Y-%m-%d'));
		notice_admin($subject, $text);
		continue;
	}

	// send the response to sender of the message
	$response = $api_data->readOne('Response', array('reply_code' => $reply_code));
	$message = $api_data->readOne('Message', array('id' => $response['message_id']));
	$mp = $api_data->readOne('Mp', array('id' => $response['mp_id']));

	$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
	$to = compose_email_address($message['sender_name'], $message['sender_email']);
	$subject = mime_encode(sprintf(_('%s %s has responded to your message'), $mp['first_name'], $mp['last_name']));
	$smarty = new SmartyNapisteJim;
	$smarty->assign('mp', $mp);
	$smarty->assign('message', array('subject' => $response['subject'], 'body' => $response['body'], 'is_public' => $message['is_public']));
	$text = $smarty->fetch('email/response_from_mp.tpl');
	$reply_to = compose_email_address($parsed_mail['headers']['from']['personal'], $parsed_mail['headers']['from']['mailbox'] . '@' . $parsed_mail['headers']['from']['host']);
	send_mail($from, $to, $subject, $text, $reply_to);

	// erase an accidental response to a private message
	if ($message['is_public'] == 'no')
		$api_data->update('Response', array('reply_code' => $reply_code), array('subject' => null, 'body' => null, 'full_email_data' => null));
}
else
{
	// notice admin about other mails than responses to sent messages
	$subject = mime_encode(sprintf(_('An e-mail received to address %s'), $parsed_mail['headers']['x-original-to']));
	$text = _('From:') . ' ' . $parsed_mail['headers']['from']['personal'] . ' <' . $parsed_mail['headers']['from']['mailbox'] . '@' . $parsed_mail['headers']['from']['host'] . ">\n";
	$text .= _('Subject:') . ' ' . $parsed_mail['headers']['subject'] . "\n\n";
	$text .= (isset($parsed_mail['text'])) ? $parsed_mail['text'] : ((isset($parsed_mail['html'])) ? $parsed_mail['html'] : '');
	$text .= "\n\n\n" . '---------- ' . _('Full e-mail data') . '----------' . "\n\n";
	$text .= $mail;
	notice_admin($subject, $text);
}

exit;


function notice_admin($subject, $body)
{
	$to = ADMIN_EMAIL;
	$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
	send_mail($from, $to, $subject, $body);
}

function send_mail($from, $to, $subject, $message, $reply_to = null, $additional_headers = null)
{
	// make standard headers
	if (empty($reply_to))
		$reply_to = $from;
	$headers = "From: $from\n" .
		"Reply-To: $reply_to\n" .
		'Content-Type: text/plain; charset="UTF-8"' . "\n" .
		'MIME-Version: 1.0' . "\n" .
		'Content-Transfer-Encoding: 8bit' . "\n" .
		'X-Mailer: PHP' . "\n" .
		'Bcc: ' . BCC_EMAIL;
	if (!empty($additional_headers))
		$headers .= "\n" . $additional_headers;

	// send a mail
	if (mail($to, $subject, $message, $headers)) return;

	// if sending of the mail failed, write to log
	$log = new Log(NJ_LOGS_DIR . '/error.log', 'a');
	$log->write("Sending of a mail failed. Mail fields:\n" .
		print_r(array('to' => $to, 'subject' => $subject, 'message' => $message, 'headers' => $headers), true), Log::ERROR);

	// and inform admin
	$headers = 'From: ' . compose_email_address(NJ_TITLE, FROM_EMAIL) . "\n" .
	'Reply-To: ' . compose_email_address(NJ_TITLE, FROM_EMAIL) . "\n" .
	'Content-Type: text/plain; charset="UTF-8"' . "\n" .
	'X-Mailer: PHP';
	mail(ADMIN_EMAIL, mime_encode(_('Sending of a mail failed')), _('Check ') . NJ_LOGS_DIR . '/error.log', $headers);
}

function mime_encode($text)
{
	return mb_encode_mimeheader($text, 'UTF-8', 'Q');
}

function compose_email_address($display_name, $address)
{
	if (empty($display_name)) return $address;

	$name = mime_encode(trim(trim($display_name), '"'));
	if (strpos($name, ',') !== false)
		$name = '"' . $name . '"';

	$addresses = explode(',', $address);
	foreach ($addresses as &$a)
		$a = $name . ' <' . trim($a) . '>';
	return implode(', ', $addresses);
}

?>
