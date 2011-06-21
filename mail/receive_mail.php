<?php

require '/home/shared/napistejim.cz/config/settings.php';
require '/home/shared/napistejim.cz/setup.php';

// read a mail from standard input
$mail = '';
while (!feof(STDIN) && strlen($mail) < 4000000)	// limit to 4 MB
    $mail .= fread(STDIN, 8192);

// backup the mail
$backup = fopen(WTT_DIR . '/mail/backup/mails-' . strftime('%Y-%m-%d'), 'a');
fwrite($backup, $mail . "\n\n\n");
fclose($backup);

// parse the mail
if (strpos($mail, "\r\n") === false)
	$mail = str_replace("\n", "\r\n", $mail);
$parsed_mail = fMailbox::parseMessage($mail);

// notice admin about other mails than responses to sent messages
$to = $parsed_mail['headers']['to'][0];
if (substr($to['mailbox'], 0, 6) != 'reply.')
{
	$subject = mime_encode('Dorazil e-mail na adresu:') . ' ' . $to['mailbox'] . '@' . $to['host'];
	$text = 'Nájdeš ho v ' . WTT_DIR . '/mail/backup/mails-' .  strftime('%Y-%m-%d');
	return notice_admin($subject, $text);
}

// parse a response to a message sent to representatives
$reply_code = strtolower(substr($to['mailbox'], strpos($to['mailbox'], '.') + 1));
$subject = $parsed_mail['headers']['subject'];
$body = (isset($parsed_mail['text'])) ? $parsed_mail['text'] : ((isset($parsed_mail['html'])) ? $parsed_mail['html'] : '');

// store the response
$api_kohovolit = new ApiDirect('kohovolit');
$res = $api_kohovolit->update('Response', array('reply_code' => $reply_code), array('subject' => $subject, 'body_' => $body, 'full_email_data' => $mail, 'received_on' => 'now'));

// notice admin about unrecognized responses
if ($res == 0)
{
	$subject = mime_encode('K došlej odpovedi s kódom ') .  $reply_code . mime_encode(' sa nenašla príslušná správa');
	$text = 'Došlú odpoveď nájdeš v ' . WTT_DIR . '/mail/backup/mails-' .  strftime('%Y-%m-%d');
	return notice_admin($subject, $text);
}

// send the response to sender of the message
$response = $api_kohovolit->read('Response', array('reply_code' => $reply_code));
$response = $response['response'][0];
$message_id = $response['message_id'];
$message = $api_kohovolit->read('Message', array('id' => $message_id));
$message = $message['message'][0];
$mp = $api_kohovolit->read('Mp', array('id' => $response['mp_id']));
$mp = $mp['mp'][0];

$from = mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>';
$to = $message['sender_email'];
$subject = mime_encode($mp['first_name'] . ' ' . $mp['last_name'] . ' odpověděl' . (($mp['sex'] == 'f') ? 'a' : '') . ' na vaši zprávu');
$smarty = new SmartyNapisteJimCz;
$smarty->assign('mp', $mp);
$smarty->assign('message', array('subject' => $response['subject'], 'body' => $response['body_'], 'is_public' => $message['is_public']));
$text = $smarty->fetch('email/response_from_mp.tpl');
$reply_to = mime_encode($parsed_mail['headers']['from']['personal']) . ' <' . $parsed_mail['headers']['from']['mailbox'] . '@' . $parsed_mail['headers']['from']['host'] . '>';
send_mail($from, $to, $subject, $text, $reply_to);

// erase an accidental response to a private message
if ($message['is_public'] == 'no')
	$api_kohovolit->update('Response', array('reply_code' => $reply_code), array('subject' => null, 'body_' => null, 'full_email_data' => null));

exit;


function notice_admin($subject, $body)
{
	$to = 'jaroslav_semancik@yahoo.com';
	$from = mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>';
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
		'X-Mailer: PHP';
	if (!empty($additional_headers))
		$headers .= "\r\n" . $additional_headers;

	// send a mail
	if (mail($to, $subject, $message, $headers)) return;

	// if sending of the mail failed, write to log
	$log = new Log(WTT_LOGS_DIR . '/error.log', 'a');
	$log->write("Sending of a mail failed. Mail fields:\n" .
		print_r(array('to' => $to, 'subject' => $subject, 'message' => $message, 'headers' => $headers), true), Log::ERROR);

	// and inform admin
	$headers = 'From: ' . mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>' . "\r\n" .
	'Reply-To: ' . mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>' . "\r\n" .
	'Content-Type: text/plain; charset="UTF-8"' . "\r\n" .
	'X-Mailer: PHP';
	mail('jaroslav_semancik@yahoo.com', mime_encode('Odeslání mailu selhalo'), 'Zkontroluj ' . WTT_LOGS_DIR . '/error.log', $headers);
}

function mime_encode($text)
{
	return mb_encode_mimeheader($text, 'UTF-8', 'Q');
}

?>
