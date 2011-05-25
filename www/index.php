<?php

require '../config/settings.php';
require '../setup.php';

//Language
// Set language to LOCALE
putenv('LC_ALL='. LOCALE);
setlocale(LC_ALL, LOCALE);
// Specify location of translation tables
bindtextdomain(LOCALIZED_DOMAIN, LOCALE_DIR);
// Choose domain
textdomain(LOCALIZED_DOMAIN);

$api_kohovolit = new ApiDirect('kohovolit');
$api_napistejim = new ApiDirect('napistejim');

$page = isset($_GET['page']) ? $_GET['page'] : null;
switch ($page)
{
	case 'about':
	case 'faq':
	case 'privacy':
	case 'video':
	case 'support':
	case 'contact':
		static_page($page);
		break;

	case 'confirm':
		confirm_page();
		break;

	case 'list':
		messages_page();
		break;

	default:
		if (!empty($_POST))
			send_page();
		else
		{
			if (isset($_GET['mp']))
				write_page();
			else if (isset($_GET['address']))
			  	search_results_page();
			else if (isset($_GET['name']) || isset($_GET['constituency']) || isset($_GET['groups']))
				search_results_advanced_page();
			else if (isset($_GET['advanced']))
				static_page('advanced_search');
			else
				static_page('search');
		}
}

function static_page($page)
{
	$smarty = new SmartyNapisteJimCz;
	//$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
	$smarty->display($page . '.tpl');
}

function search_results_advanced_page()
{
	global $api_napistejim;
	$smarty = new SmartyNapisteJimCz;

	$data = array();
	if (isset($_GET['groups']) and ($_GET['groups'] != ''))
		$data['groups'] = explode('|', $_GET['groups']);
	if (isset($_GET['constituency']) and ($_GET['constituency'] != ''))
		$data['constituency'] = $_GET['constituency'];
	$search_mps = $api_napistejim->read('SearchMps', $data);

	if (isset($_GET['parliament_code']))
		$smarty->assign('parliament', array('code' => $_GET['parliament_code']));
	$smarty->assign('mps', $search_mps['search_mps']);
	$smarty->display('search_results_advanced.tpl');
}

function search_results_page()
{
	$smarty = new SmartyNapisteJimCz;
	$smarty->assign('lang', SEARCH_LANGUAGE);
	$smarty->assign('reg', SEARCH_REGION);
	$smarty->assign('parent_region', SEARCH_PARENT_REGION);
	$smarty->assign('parent_region_type', SEARCH_PARENT_REGION_TYPE);
	$smarty->assign('region_check', SEARCH_REGION_CHECK);
	$smarty->assign('lat', CENTER_LAT);
	$smarty->assign('lng', CENTER_LNG);
	$smarty->assign('zoom', ZOOM);
	$smarty->assign('address', $_GET['address']);
	$smarty->display('search_results.tpl');
}

function write_page()
{
	global $api_napistejim;
	$mp_list = trim_list($_GET['mp'], '|', 3);
	$mp_details = $api_napistejim->read('MpDetails', array('mp' => $mp_list));

	$smarty = new SmartyNapisteJimCz;
	$smarty->assign('mps', $mp_list);
	$smarty->assign('mp_details', $mp_details['mp_details']);
	$smarty->assign('img_url', IMG_URL);
	$smarty->display('write.tpl');
}

function send_page()
{
	global $api_kohovolit, $api_napistejim;
	$smarty = new SmartyNapisteJimCz;

	// prevent mail header injection
	$subject = escape_header_fields($_POST['subject']);
	$body = $_POST['body'];
	$name = escape_header_fields($_POST['name']);
	$email = escape_header_fields($_POST['email']);
	$is_public = $_POST['is_public'];

/*
	// prevent abuse
	$his_messages = $ad->read('Message', array('sender_email' => $_POST['email']));
	$messages_today = 0;
	foreach ($his_messages as $message)
		if ($message['sent_on']
*/
	// generate a random unique confirmation code
	$confirmation_code = unique_random_code(10, 'Message', 'confirmation_code');

	// store the message
	$res= $api_kohovolit->create('Message', array(array('subject' => $subject, 'body_' => $body, 'sender_name' => $name, 'sender_email' => $email, 'is_public' => $is_public, 'confirmation_code' => $confirmation_code)));
	$message_id = $res[0];

	// prepare records for responses from all addressees of the message
	$mp_list = trim_list($_POST['mp'], '|', 3);
	$mps = explode('|', $mp_list);
	$unique_mps = array();
	$responses = array();
	foreach ($mps as $mp)
	{
		if (array_key_exists($mp, $unique_mps)) continue;	// skip duplicate MPs
		$unique_mps[$mp] = true;
		$reply_code = unique_random_code(10, 'Response', 'reply_code');
		$p = strrpos($mp, '/');
		$responses[] = array('message_id' => $message_id, 'mp_id' => substr($mp, $p + 1), 'parliament_code' => substr($mp, 0, $p), 'reply_code' => $reply_code);
	}
	$api_kohovolit->create('Response', $responses);

	// send confirmation mail to the sender
	$from = mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>';
	$to = $email;
	$subject = mime_encode('Potvrďte prosím, že chcete odeslat zprávu přes NapišteJim.cz');
	$mp_details = $api_napistejim->read('MpDetails', array('mp' => $mp_list));
	$smarty->assign('addressee', $mp_details['mp_details']);
	$smarty->assign('message', array('subject' => $subject, 'body' => $body, 'is_public' => $is_public, 'confirmation_code' => $confirmation_code));
	$text = $smarty->fetch('email/request_to_confirm.tpl');
	send_mail($from, $to, $subject, $text);

	// order newsletter if requested
	if (isset($_POST['newsletter']))
		order_newsletter($email);

	$smarty->display('confirm_sending.tpl');
}

function confirm_page()
{
	global $api_kohovolit;

	$action = (isset($_GET['action'])) ? $_GET['action'] : null;
	$confirmation_code = (isset($_GET['cc'])) ? $_GET['cc'] : null;

	// find a message corresponding to the given confirmation_code
	$res = $api_kohovolit->read('Message', array('confirmation_code' => $confirmation_code));
	$message = $res['message'][0];
	if (empty($message))
		return static_page('confirmation_result/wrong_link');

	switch ($action)
	{
		case 'send':
			if ($message['state_'] != 'created')
				return static_page('confirmation_result/already_confirmed');
			if (is_profane($message['subject']) || is_profane($message['body_']))
			{
				if ($message['is_public'] == 'yes')
					send_to_reviewer($message);
				else
					refuse_message($message);
			}
			else
				send_message($message);
			static_page('confirmation_result/processing');
			break;

		case 'approve':
		case 'refuse':
			if (!isset($_GET['ac']) || $_GET['ac'] != $message['approval_code'])
				static_page('confirmation_result/wrong_link');
			else if ($message['state_'] != 'waiting for approval')
				static_page('confirmation_result/reviewer/already_approved');
			else if ($action == 'approve')
			{
				send_message($message);
				static_page('confirmation_result/reviewer/approved.tpl');
			}
			else
			{
				refuse_message($message);
				static_page('confirmation_result/reviewer/refused.tpl');
			}
			break;

		default:
			static_page('confirmation_result/wrong_link');
	}

	// erase private message after sending or refusal
	if ($message['is_public'] == 'no')
		$api_kohovolit->update('Message', array('id' => $message['id']), array('subject' => '', 'body_' => ''));
}

function send_message($message)
{
	global $api_kohovolit;
	$smarty = new SmartyNapisteJimCz;

	// get information about addressees of the message
	$mp_details = addressees_of_message($message);

	// send the message to all addressees one by one
	foreach ($mp_details as $mp)
	{
		$from = mime_encode($message['sender_name']) . " <reply.{$mp['reply_code']}@napistejim.cz>";
		$reply_to = ($message['is_public'] == 'yes') ? $from : $message['sender_email'];
		$to = $mp['email'];
		$subject = mime_encode($message['subject']);
		$smarty->assign('message', array('subject' => $message['subject'], 'body' => $message['body_'], 'is_public' => $message['is_public'], 'reply_to' => $reply_to));
		$text = $smarty->fetch('email/message_to_mp.tpl');
		$to = 'jaroslav_semancik@yahoo.com';	// !!! REMOVE AFTER TESTING !!!
		send_mail($from, $to, $subject, $text, $reply_to);
	}

	// send a copy to the sender
	$from = mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>';
	$to = $message['sender_email'];
	$subject = mime_encode('Vaše zpráva byla odeslána');
	$smarty->assign('addressee', $mp_details);
	$smarty->assign('message', array('subject' => $message['subject'], 'body' => $message['body_'], 'is_public' => $message['is_public']));
	$text = $smarty->fetch('email/message_sent.tpl');
	send_mail($from, $to, $subject, $text);

	// change message state
	$api_kohovolit->update('Message', array('id' => $message['id']), array('state_' => 'sent', 'sent_on' => 'now'));
}

function send_to_reviewer($message)
{
	global $api_kohovolit;
	$smarty = new SmartyNapisteJimCz;

	// generate a random approval code for the message
	$approval_code = random_code(10);

	// send the message to a reviewer to approve
	$from = mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>';
	$to = 'veronika.sumova@kohovolit.eu';
	$subject = mime_encode('Zpráva pro politiky potřebuje tvoje schválení');
	$smarty->assign('addressee', addressees_of_message($message));
	$smarty->assign('message', array('subject' => $message['subject'], 'body' => $message['body'], 'is_public' => $message['is_public'], 'confirmation_code' => $message['confirmation_code'], 'approval_code' => $approval_code));
	$text = $smarty->fetch('email/request_to_review.tpl');
	$to = 'jaroslav_semancik@yahoo.com';	// !!! REMOVE AFTER TESTING !!!
	send_mail($from, $to, $subject, $text);

	// change message state
	$api_kohovolit->update('Message', array('id' => $message['id']), array('state_' => 'waiting for approval', 'approval_code' => $approval_code));
}

function refuse_message($message)
{
	global $api_kohovolit;
	$smarty = new SmartyNapisteJimCz;

	// send explanation of the refusal to the sender
	$from = mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>';
	$to = $message['sender_email'];
	$subject = mime_encode('Vaše zpráva byla vyhodnocena jako nezdvořilá a nebyla odeslána');
	$smarty->assign('addressee', addressees_of_message($message));
	$smarty->assign('message', array('subject' => $message['subject'], 'body' => $message['body'], 'is_public' => $message['is_public']));
	$text = $smarty->fetch('email/message_refused.tpl');
	send_mail($from, $to, $subject, $text);

	// change message state
	$api_kohovolit->update('Message', array('id' => $message['id']), array('state_' => 'refused'));
}

function addressees_of_message($message)
{
	global $api_kohovolit, $api_napistejim;

	// get list of MPs' id-s the message is addressed to
	$mps = $api_kohovolit->read('Response', array('message_id' => $message['id']));
	$mp_list = '';
	foreach($mps['response'] as $mp)
		$mp_list .= $mp['parliament_code'] . '/' . $mp['mp_id'] . '|';

	// get details of those MPs
	$mp_list = rtrim($mp_list, '|');
	$mp_details = $api_napistejim->read('MpDetails', array('mp' => $mp_list));

	// add a reply_code for each addressee to the returned details
	$i = 0;
	foreach ($mp_details['mp_details'] as &$mp)
		$mp['reply_code'] = $mps['response'][$i++]['reply_code'];
	return $mp_details['mp_details'];
}

function is_profane($text)
{
	return false;
}

function messages_page()
{
	// ...
}

function random_code($length)
{
	$code = '';
	for ($i = 0; $i < $length; $i++)
		$code .= chr(mt_rand(ord('a'), ord('z')));
	return $code;
}

function unique_random_code($length, $resource, $field)
{
	global $api_kohovolit;
	do
	{
		$code = random_code($length);
		$res = $api_kohovolit->read($resource, array($field => $code));
	}
	while (!empty($res[strtolower($resource)]));
	return $code;
}

function escape_header_fields($text)
{
	$escape_tokens = array('To:', 'Cc:', 'Bcc:', 'From:', 'Sender:', 'Reply-To:', 'Subject:');
	foreach($escape_tokens as $token)
		$text = str_ireplace($token, strtr($token, ':', ';'), $text);
	return $text;
}

function trim_list($text, $delimiter, $count)
{
	$i = $c = 0;
	while ($i < strlen($text) && $c < $count)
		if ($text[$i++] == $delimiter)
			$c++;
	return rtrim(substr($text, 0, $i), '|');
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
	mail('info@kohovolit.eu', mime_encode('Odeslání mailu selhalo'), 'Zkontroluj ' . WTT_LOGS_DIR . '/error.log', $headers);
}

function order_newsletter($email)
{
	$from = mime_encode('NapišteJim.cz') . ' <neodpovidejte@napistejim.cz>';
	$to = 'info@kohovolit.eu';
	$subject = mime_encode('Objednání newsletteru');
	$message = $email;
	send_mail($from, $to, $subject, $message);
}

function mime_encode($text)
{
	return mb_encode_mimeheader($text, 'UTF-8');
}

?>
