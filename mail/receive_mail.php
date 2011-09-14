<?php

require '/home/shared/napistejim.cz/config/settings.php';
require '/home/shared/napistejim.cz/setup.php';

// read a mail from standard input
$mail = '';
while (!feof(STDIN) && strlen($mail) < 4000000)	// limit to 4 MB
    $mail .= fread(STDIN, 8192);

// backup the mail
$backup_pathname = WTT_DIR . '/mail/backup/mails-' . strftime('%Y-%m-%d');
$backup_file = fopen($backup_pathname, 'a');
fwrite($backup_file, $mail . "\n\n\n");
fclose($backup_file);
chmod($backup_pathname, 0640);

// parse the mail
if (strpos($mail, "\r\n") === false)
	$mail = str_replace("\n", "\r\n", $mail);
$parsed_mail = fMailbox::parseMessage($mail);

// process all recipients in To: field
$to_list = $parsed_mail['headers']['to'];
foreach ($to_list as $to)
{
	// notice admin about other mails than responses to sent messages
	if (substr($to['mailbox'], 0, 6) != 'reply.')
	{
		$subject = mime_encode('Dorazil e-mail na adresu:') . ' ' . $to['mailbox'] . '@' . $to['host'];
		$text = 'From: ' . $parsed_mail['headers']['from']['personal'] . ' <' . $parsed_mail['headers']['from']['mailbox'] . '@' . $parsed_mail['headers']['from']['host'] . ">\n";
		$text .= 'Subject: ' . $parsed_mail['headers']['subject'] . "\n\n";
		$text .= (isset($parsed_mail['text'])) ? $parsed_mail['text'] : ((isset($parsed_mail['html'])) ? $parsed_mail['html'] : '');
		$text .= "\n\n\n---------- Úplné data e-mailu ----------\n\n";
		$text .= $mail;
		notice_admin($subject, $text);
		continue;
	}

	// parse a response to a message sent to representatives
	$reply_code = strtolower(substr($to['mailbox'], strpos($to['mailbox'], '.') + 1));
	$subject = $parsed_mail['headers']['subject'];
	$body = (isset($parsed_mail['text'])) ? $parsed_mail['text'] : ((isset($parsed_mail['html'])) ? $parsed_mail['html'] : '');

	// store the response
	$api_data = new ApiDirect('data');
	$body = preg_replace('/reply\.[a-z]{10}@/', 'reply.**********@', $body);
	$res = $api_data->update('Response', array('reply_code' => $reply_code), array('subject' => $subject, 'body' => $body, 'full_email_data' => $mail, 'received_on' => 'now'));

	// notice admin about unrecognized responses
	if (count($res) == 0)
	{
		$subject = mime_encode('K došlej odpovedi s kódom ') .  $reply_code . mime_encode(' sa nenašla príslušná správa');
		$text = 'Došlú odpoveď nájdeš v ' . WTT_DIR . '/mail/backup/mails-' .  strftime('%Y-%m-%d');
		notice_admin($subject, $text);
		continue;
	}

	// send the response to sender of the message
	$response = $api_data->readOne('Response', array('reply_code' => $reply_code));
	$message = $api_data->readOne('Message', array('id' => $response['message_id']));
	$mp = $api_data->readOne('Mp', array('id' => $response['mp_id']));

	$from = compose_email_address(WTT_TITLE, FROM_EMAIL);
	$to = compose_email_address($message['sender_name'], $message['sender_email']);
	$subject = mime_encode($mp['first_name'] . ' ' . $mp['last_name'] . ' odpověděl' . (($mp['sex'] == 'f') ? 'a' : '') . ' na vaši zprávu');
	$smarty = new SmartyWtt;
	$smarty->assign('mp', $mp);
	$smarty->assign('message', array('subject' => $response['subject'], 'body' => $response['body'], 'is_public' => $message['is_public']));
	$text = $smarty->fetch('email/response_from_mp.tpl');
	$reply_to = compose_email_address($parsed_mail['headers']['from']['personal'], $parsed_mail['headers']['from']['mailbox'] . '@' . $parsed_mail['headers']['from']['host']);
	send_mail($from, $to, $subject, $text, $reply_to);

	// erase an accidental response to a private message
	if ($message['is_public'] == 'no')
		$api_data->update('Response', array('reply_code' => $reply_code), array('subject' => null, 'body' => null, 'full_email_data' => null));
}

exit;


function notice_admin($subject, $body)
{
	$to = ADMIN_EMAIL;
	$from = compose_email_address(WTT_TITLE, FROM_EMAIL);
	send_mail($from, $to, $subject, $body);
}

function send_mail($from, $to, $subject, $message, $reply_to = null, $additional_headers = null)
{
	// make standard headers
	if (empty($reply_to))
		$reply_to = $from;
	$headers = "From: $from\r\n" .
		"Reply-To: $reply_to\r\n" .
		'Content-Type: text/plain; charset="UTF-8"' . "\r\n" .
		'MIME-Version: 1.0' . "\r\n" .
		'Content-Transfer-Encoding: 8bit' . "\r\n" .
		'X-Mailer: PHP' . "\r\n" .
		'Bcc: ' . BCC_EMAIL;
	if (!empty($additional_headers))
		$headers .= "\r\n" . $additional_headers;

	// send a mail
	if (mail($to, $subject, $message, $headers)) return;

	// if sending of the mail failed, write to log
	$log = new Log(WTT_LOGS_DIR . '/error.log', 'a');
	$log->write("Sending of a mail failed. Mail fields:\n" .
		print_r(array('to' => $to, 'subject' => $subject, 'message' => $message, 'headers' => $headers), true), Log::ERROR);

	// and inform admin
	$headers = 'From: ' . compose_email_address(WTT_TITLE, FROM_EMAIL) . "\r\n" .
	'Reply-To: ' . compose_email_address(WTT_TITLE, FROM_EMAIL) . "\r\n" .
	'Content-Type: text/plain; charset="UTF-8"' . "\r\n" .
	'X-Mailer: PHP';
	mail(ADMIN_EMAIL, mime_encode('Odeslání mailu selhalo'), 'Zkontroluj ' . WTT_LOGS_DIR . '/error.log', $headers);
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
