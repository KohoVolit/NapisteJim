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
			else if (isset($_GET['name']) || isset($_GET['constituency']) || isset($_GET['political_group']) || isset($_GET['committee']) || isset($_GET['commission']) || isset($_GET['delegation']) || isset($_GET['member']))
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

function search_results_advanced_page() {
  global $api_napistejim;
  $data = array();
  if (isset($_GET['member'])) $data['groups'] = explode('|',$_GET['member']);
  if (isset($_GET['constituency'])) $data['constituency'] = $_GET['constituency'];
  
  $search_mps = $api_napistejim->read('SearchMps',$data);
  $smarty = new SmartyNapisteJimCz;
  if (isset($_GET['parliament_code']))
    $smarty->assign('parliament', array('code' => $_GET['parliament_code']));
  $smarty->assign('mps',$search_mps['search_mps']);
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
	if (strlen($body) <
	$his_letters = $ad->read('Letter', array('sender_email' => $_POST['email']));
	$letters_today = 0;
	foreach ($his_letters as $letter)
		if ($letter['sent_on']
*/
	// generate a random unique reply code
	$reply_code = unique_random_code(10, 'reply_code');
	
	// store the message
	$res= $api_kohovolit->create('Letter', array(array('subject' => $subject, 'body_' => $body, 'sender_name' => $name, 'sender_email' => $email, 'is_public' => $is_public, 'reply_code' => $reply_code)));
	$letter_id = $res[0];

	// store binding between the letter and its addressees
	$mp_list = trim_list($_POST['mp'], '|', 3);
	$mps = explode('|', $mp_list);
	$unique_mps = array();
	$bindings = array();
	foreach ($mps as $mp)
	{
		if (array_key_exists($mp, $unique_mps)) continue;	// skip duplicate MPs
		$unique_mps[$mp] = true;
		$p = strrpos($mp, '/');
		$bindings[] = array('letter_id' => $letter_id, 'mp_id' => substr($mp, $p + 1), 'parliament_code' => substr($mp, 0, $p));
	}
	$api_kohovolit->create('LetterToMp', $bindings);

	// send confirmation mail to the sender
	$from = 'NapisteJim.cz <neodpovidejte@napistejim.cz>';
	$to = $email;
	$subject = 'Potvrďte prosím, že chcete odeslat správu ' . ((count($unique_mps) > 1) ? 'svým zástupcům' : 'svému zástupci');
	$mp_details = $api_napistejim->read('MpDetails', array('mp' => $mp_list));
	$smarty->assign('addressee', $mp_details['mp_details']);
	$smarty->assign('message', array('subject' => $subject, 'body' => $body, 'is_public' => $is_public, 'reply_code' => $reply_code));
	$message = $smarty->fetch('email/request_to_confirm.tpl');
	send_mail($from, $to, $subject, $message);

	// order newsletter if requested
	if ($_POST['order-newsletter'])
		order_newsletter($email);

	$smarty->display('confirm_sending.tpl');
}

function confirm_page()
{
	global $api_kohovolit, $api_napistejim;
	$smarty = new SmartyNapisteJimCz;
		
	$action = (isset($_GET['action'])) ? $_GET['action'] : null;
	$reply_code = (isset($_GET['rc'])) ? $_GET['rc'] : null;
	
	// find a letter corresponding to the given reply_code
	$res = $api_kohovolit->read('Letter', array('reply_code' => $reply_code));
	$letter = $res['letter'][0];
	if (empty($letter))
		return static_page('confirmation_result/wrong_link');

	switch ($action)
	{
		case 'send':
			if ($letter['state_'] != 'created')
				return static_page('confirmation_result/already_confirmed');
			if (is_profane($letter['subject']) || is_profane($letter['body_']))
			{
				if ($letter['is_public'] == 'yes')
					send_to_reviewer($letter);
				else
					refuse_letter($letter);
			}
			else
				send_letter($letter);
			$smarty->display('confirmation_result/processing.tpl');
			break;

		case 'approve':
		case 'refuse':
			if (!isset($_GET['ac']) || $_GET['ac'] != $letter['approval_code'])
				static_page('confirmation_result/wrong_link');
			else if ($letter['state_'] != 'waiting for approval')
				static_page('confirmation_result/reviewer/already_approved');
			else if ($action == 'approve')
			{
				send_letter($letter);
				$smarty->display('confirmation_result/reviewer/approved.tpl');
			}
			else
			{
				refuse_letter($letter);
				$smarty->display('confirmation_result/reviewer/refused.tpl');
			}
			break;
		
		default:
			static_page('confirmation_result/wrong_link');
	}
}

function send_letter($letter)
{
	global $api_kohovolit, $api_napistejim;
	$smarty = new SmartyNapisteJimCz;

	// get information about addressees of the letter
	$mp_details = addressees_of_letter($letter);

	// send the letter to all addressees one by one
	foreach ($mp_details as $mp)
	{
		$from = "{$letter['sender_name']} <reply.{$letter['reply_code']}@napistejim.cz>";
		$reply_to = ($letter['is_public'] == 'yes') ? $from : $letter['sender_email'];
		$to = $mp['email'];
		$subject = $letter['subject'];
		$smarty->assign('message', array('subject' => $letter['subject'], 'body' => $letter['body_'], 'is_public' => $letter['is_public'], 'reply_to' => $reply_to));
		$message = $smarty->fetch('email/message_to_mp.tpl');
		$to = 'jaroslav_semancik@yahoo.com';	// !!! REMOVE AFTER TESTING !!!
		send_mail($from, $to, $subject, $message, $reply_to);
	}

	// send a copy to the sender
	$from = 'NapisteJim.cz <neodpovidejte@napistejim.cz>';
	$to = $letter['sender_email'];
	$subject = 'Vaše správa byla odeslána';
	$smarty->assign('addressee', $mp_details);
	$smarty->assign('message', array('subject' => $letter['subject'], 'body' => $letter['body_'], 'is_public' => $letter['is_public']));
	$message = $smarty->fetch('email/message_sent.tpl');
	send_mail($from, $to, $subject, $message);

	// change letter state
	$api_kohovolit->update('Letter', array('id' => $letter['id']), array('state_' => 'sent', 'sent_on' => 'now'));
}

function send_to_reviewer($letter)
{
	global $api_kohovolit;
	$smarty = new SmartyNapisteJimCz;
	
	// generate a random approval code for the message
	$approval_code = random_code(10);
	
	// send the letter to a reviewer to approve
	$from = 'NapisteJim.cz <neodpovidejte@napistejim.cz>';
	$to = 'veronika.sumova@kohovolit.eu';
	$subject = 'Správa pro politiky potřebuje tvoje schválení';
	$smarty->assign('addressee', addressees_of_letter($letter));
	$smarty->assign('message', array('subject' => $letter['subject'], 'body' => $letter['body'], 'is_public' => $letter['is_public'], 'reply_code' => $letter['reply_code'], 'approval_code' => $approval_code));
	$message = $smarty->fetch('email/request_to_review.tpl');
	$to = 'jaroslav_semancik@yahoo.com';	// !!! REMOVE AFTER TESTING !!!
	send_mail($from, $to, $subject, $message);

	// change letter state
	$api_kohovolit->update('Letter', array('id' => $letter['id']), array('state_' => 'waiting for approval', 'approval_code' => $approval_code));
}

function refuse_letter($letter)
{
	global $api_kohovolit;
	$smarty = new SmartyNapisteJimCz;

	// send explanation of the refusal to the sender
	$from = 'NapisteJim.cz <neodpovidejte@napistejim.cz>';
	$to = $letter['sender_email'];
	$subject = 'Vaše správa byla vyhodnocena jako nezdvořilá a nebyla odeslána';
	$smarty->assign('addressee', addressees_of_letter($letter));
	$smarty->assign('message', array('subject' => $letter['subject'], 'body' => $letter['body'], 'is_public' => $letter['is_public']));
	$message = $smarty->fetch('email/message_refused.tpl');
	send_mail($from, $to, $subject, $message);
	
	// delete the letter
	$api_kohovolit->delete('Letter', array('id' => $letter['id']));
}

function addressees_of_letter($letter)
{
	global $api_kohovolit, $api_napistejim;

	$mps = $api_kohovolit->read('LetterToMp', array('letter_id' => $letter['id']));
	$mp_list = '';
	foreach($mps['letter_to_mp'] as $mp)
		$mp_list .= $mp['parliament_code'] . '/' . $mp['mp_id'] . '|';
	$mp_list = rtrim($mp_list, '|');
	$mp_details = $api_napistejim->read('MpDetails', array('mp' => $mp_list));
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

function unique_random_code($length, $letter_column)
{
	global $api_kohovolit;
	do
	{
		$code = random_code($length);
		$res = $api_kohovolit->read('Letter', array($letter_column => $code));
	}
	while (!empty($res['letter']));
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
	$headers = 'From: NapisteJim.cz <neodpovidejte@napistejim.cz>' . "\r\n" .
	'Reply-To: NapisteJim.cz <neodpovidejte@napistejim.cz>' . "\r\n" .
	'Content-Type: text/plain; charset="UTF-8"' . "\r\n" .
	'X-Mailer: PHP';
	mail('info@kohovolit.eu', 'Odeslání mailu selhalo', 'Zkontroluj ' . WTT_LOGS_DIR . '/error.log', $headers);
}

function order_newsletter($email)
{
	$from = 'From: NapisteJim.cz <neodpovidejte@napistejim.cz>';
	$to = 'info@kohovolit.eu';
	$subject = 'Objednání newsletteru';
	$message = $email;
	send_mail($from, $to, $subject, $message);
}

?>
