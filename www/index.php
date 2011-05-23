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

$page = isset($_GET['page']) ? $_GET['page'] : null;
switch ($page)
{
	case 'about':
	case 'faq':
	case 'privacy':
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
			else if (isset($_GET['name']) || isset($_GET['address']) || isset($_GET['constituency']) || isset($_GET['political_group']) || isset($_GET['committee']) || isset($_GET['commission']) || isset($_GET['delegation']))
				search_results_page();
			else if (isset($_GET['advanced']))
				static_page('advanced_search');
			else
				static_page('search');
		}
}

function static_page($page)
{
	$smarty = new SmartyNapisteJimCz;
	$smarty->assign('locale', LOCALE);
	$smarty->display($page . '.tpl');
}

function search_results_page()
{
	$smarty = new SmartyNapisteJimCz;
	$smarty->assign('locale', LOCALE);
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
	$ad = new ApiDirect('napistejim');
	$mp_details = $ad->read('MpDetails', array('mp' => $_GET['mp']));

	$smarty = new SmartyNapisteJimCz;
	$smarty->assign('locale', LOCALE);
	$smarty->assign('mps', $_GET['mp']);
	$smarty->assign('mp', $mp_details);
	$smarty->display('write.tpl');
}

function send_page()
{
	$adk = new ApiDirect('kohovolit');
	$adn = new ApiDirect('napistejim');
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
	// generate a random unique reply code for the message
	do
	{
		$reply_code = random_code(8);
		$res = $adk->read('Letter', array('reply_code' => $reply_code));
	}
	while (!empty($res['letter']));

	// store the message
	$res= $adk->create('Letter', array(array(
		'subject' => $subject,
		'body_' => $body,
		'sender_name' => $name,
		'sender_email' => $email,
		'is_public' => $is_public,
		'reply_code' => $reply_code
	)));
	$letter_id = $res[0];

	// store binding between the letter and its addressees
	$mps = explode('|', $_POST['mp']);
	$unique_mps = array();
	$bindings = array();
	foreach ($mps as $mp)
	{
		if (array_key_exists($mp, $unique_mps)) continue;	// skip duplicate MPs
		$unique_mps[$mp] = true;
		$p = strrpos($mp, '/');
		$bindings[] = array('letter_id' => $letter_id, 'mp_id' => substr($mp, $p + 1), 'parliament_code' => substr($mp, 0, $p));
	}
	$adk->create('LetterToMp', $bindings);

	// send mail
	$to = $email;
	$subject = _('Please confirm that you want to send a message to ') . _((count($unique_mps)) > 1 ? 'your representatives' : 'your representative');
	$smarty->assign('message', array('subject' => $subject, 'body' => $body, 'is_public' => $is_public, 'reply_code' => $reply_code));
	$mp_details = $adn->read('MpDetails', array('mp' => $_POST['mp_details']));
	$smarty->assign('addressee', $mp_details['mp']);
	$message = $smarty->fetch('email/confirm_sending.tpl');
	$headers = 'From: NapisteJim.cz <neodpovidejte@napistejim.cz>' . "\r\n" .
		'Reply-To: NapisteJim.cz <neodpovidejte@napistejim.cz>' . "\r\n" .
		'Content-Type: text/plain; charset="UTF-8"' . "\r\n" .
		'X-Mailer: PHP';
	$ok = mail($to, $subject, $message, $headers);
	if (!$ok)
	{
		// write to log and inform admin
		$log = new Log(LOGS_DIR . '/error.log', 'a');
		$log->write("Sending of a confirmation mail failed for letter with id=$letter_id. Mail fields:\n" .
			print_r(array('to' => $to, 'subject' => $subject, 'message' => $message, 'headers' => $headers), true), Log::ERROR);
		mail('admin@napistejim.cz', 'Sending of a confirmation mail failed', 'Check ' . LOGS_DIR . '/error.log', $headers);
	}

	$smarty->clearAllAssign();
	$smarty->display('confirm_sending.tpl');
}

function random_code($length)
{
	$code = '';
	for ($i = 0; $i < $length; $i++)
		$code .= chr(mt_rand(ord('a'), ord('z')));
	return $code;
}

function confirm_page()
{
	// ...
}

function messages_page()
{
	// ...
}

function escape_header_fields($text)
{
	$escape_tokens = array('To:', 'Cc:', 'Bcc:', 'From:', 'Sender:', 'Reply-To:', 'Subject:');
	foreach($escape_tokens as $token)
		$text = str_ireplace($token, strtr($token, ':', ';'), $text);
	return $text;
}

?>
