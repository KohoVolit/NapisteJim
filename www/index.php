<?php

require '../config/settings.php';
require '../setup.php';

$api_data = new ApiDirect('data');
$api_wtt = new ApiDirect('wtt');

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
		public_messages_page();
		break;

	default:
		if (!empty($_POST))
			send_page();
		else
		{
			if (isset($_GET['mp']))
				write_page();
			else if (isset($_GET['address']))
			  	choose_page();
			else if (isset($_GET['name']) || isset($_GET['constituency']) || isset($_GET['groups']))
				choose_advanced_page();
			else if (isset($_GET['advanced']))
				search_advanced_page();
			else if (isset($_GET['message']))
				public_message_page($_GET['message']);
			else
				static_page('search');
		}
}

function static_page($page)
{
	$smarty = new SmartyWtt;
	//$smarty->setCaching(Smarty::CACHING_LIFETIME_CURRENT);
	$smarty->display($page . '.tpl');
}

function search_advanced_page()
{
	global $api_data, $api_wtt, $locale;
	$smarty = new SmartyWtt;

	// get all parliaments in this country
	$parliaments = $api_data->read('Parliament', array('country_code' => COUNTRY_CODE));
	$parl_codes = array();
	foreach ($parliaments as $p)
		$parl_codes[] = $p['code'];
	$parliament_details = $api_wtt->read('ParliamentDetails', array('parliament' => implode('|', $parl_codes), 'lang' => $locale['lang']));
	usort($parliament_details, 'cmp_by_weight_name');

	$smarty->assign('parliaments', $parliament_details);
	$smarty->display('search_advanced.tpl');
}

function cmp_by_weight_name($a, $b)
{
	return ($a['weight'] < $b['weight']) ? -1 : (($a['weight'] > $b['weight']) ? 1 : strcoll($a['name'], $b['name']));
}

function public_message_page($message_id)
{
	global $api_data, $api_wtt;
	$smarty = new SmartyWtt;

	// get message
	$message = $api_data->readOne('Message', array('id' => $message_id));
	if ($message['is_public'] == 'no')
		return $smarty->display('message_private.tpl');
	$smarty->assign('message', $message);

	// get responses to the message
	$responses = $api_wtt->read('ResponseToMessage', array('message_id' => $message_id));
	$smarty->assign('responses', $responses);

	$smarty->display('message.tpl');
}

function choose_advanced_page()
{
	global $api_wtt;
	$smarty = new SmartyWtt;

	$params = array();
	if (isset($_GET['groups']) && !empty($_GET['groups']))
		$params['groups'] = $_GET['groups'];
	if (isset($_GET['constituency']) && !empty($_GET['constituency']))
		$params['constituency'] = $_GET['constituency'];
	if (isset($_GET['_datetime']) && !empty($_GET['_datetime']))
		$params['_datetime'] = $_GET['_datetime'];
	$search_mps = $api_wtt->read('FindMp', $params);

	if (isset($_GET['parliament_code']))
		$smarty->assign('parliament', array('code' => $_GET['parliament_code']));
	$smarty->assign('mps', $search_mps);
	$smarty->display('choose_advanced.tpl');
}

function choose_page()
{
	$smarty = new SmartyWtt;
	$smarty->assign('address', $_GET['address']);
	$smarty->display('choose.tpl');
}

function write_page()
{
	global $api_wtt;
	$mp_list = implode('|', array_slice(array_unique(explode('|', $_GET['mp'])), 0, 3));
	$mp_details = $api_wtt->read('MpDetails', array('mp' => $mp_list));
	$locality = isset($_SESSION['locality']) ? $_SESSION['locality'] : '';

	$smarty = new SmartyWtt;
	$smarty->assign('mps', $mp_list);
	$smarty->assign('mp_details', $mp_details);
	$smarty->assign('locality', $locality);
	$smarty->display('write.tpl');
}

function send_page()
{
	global $api_data, $api_wtt;
	$smarty = new SmartyWtt;

	// prevent mail header injection
	$subject = escape_header_fields($_POST['subject']);
	$name = escape_header_fields($_POST['name']);
	$email = escape_header_fields($_POST['email']);
	$address = $_POST['address'];
	$body = $_POST['body'];
	$is_public = $_POST['is_public'];
	$mps = array_slice(array_unique(explode('|', $_POST['mp'])), 0, 3);

	// generate a random unique confirmation code
	$confirmation_code = unique_random_code(10, 'Message', 'confirmation_code');

	// store the message
	$message_pkey = $api_data->create('Message', array('subject' => $subject, 'body' => $body, 'sender_name' => $name, 'sender_address' => $address, 'sender_email' => $email, 'is_public' => $is_public, 'confirmation_code' => $confirmation_code));
	$message_id = $message_pkey['id'];

	// prepare records for responses from all addressees of the message
	$responses = array();
	foreach ($mps as $mp)
	{
		$reply_code = unique_random_code(10, 'Response', 'reply_code');
		$p = strrpos($mp, '/');
		$responses[] = array('message_id' => $message_id, 'mp_id' => substr($mp, $p + 1), 'parliament_code' => substr($mp, 0, $p), 'reply_code' => $reply_code);
	}
	$api_data->create('Response', $responses);

	// send confirmation mail to the sender
	$from = compose_email_address(WTT_TITLE, FROM_EMAIL);
	$to = compose_email_address($name, $email);
	$confirmation_subject = mime_encode(sprintf(_('Please confirm that you want to send the message using %s'), WTT_TITLE));
	$mp_details = $api_wtt->read('MpDetails', array('mp' => implode('|', $mps)));
	$smarty->assign('addressee', $mp_details);
	$smarty->assign('message', array('subject' => $subject, 'body' => $body, 'is_public' => $is_public, 'confirmation_code' => $confirmation_code));
	$text = $smarty->fetch('email/request_to_confirm.tpl');
	send_mail($from, $to, $confirmation_subject, $text);

	// order newsletter if requested
	if (isset($_POST['newsletter']))
		order_newsletter($email);

	$smarty->display('confirm.tpl');
}

function confirm_page()
{
	global $api_data, $api_wtt;

	$action = (isset($_GET['action'])) ? $_GET['action'] : null;
	$confirmation_code = (isset($_GET['cc'])) ? $_GET['cc'] : null;

	// find a message corresponding to the given confirmation_code
	$message = $api_data->readOne('Message', array('confirmation_code' => $confirmation_code));
	if (!$message)
		return static_page('confirmation_result/wrong_link');

	switch ($action)
	{
		case 'send':
			if ($message['state'] != 'created')
				return static_page('confirmation_result/already_confirmed');

			// prevent sending the same message more than once
			$my_messages = $api_data->read('Message', array('sender_email' => $message['sender_email']));
			if (similar_message($message, $my_messages))
			{
				$api_data->update('Message', array('id' => $message['id']), array('state' => 'blocked'));
				return static_page('confirmation_result/already_sent');
			}

			// send profane messages to a reviewer
			if (message_is_profane($message))
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
			else if ($message['state'] != 'waiting for approval')
				static_page('confirmation_result/reviewer/already_approved');
			else if ($action == 'approve')
			{
				send_message($message);
				static_page('confirmation_result/reviewer/approved');
			}
			else
			{
				refuse_message($message);
				static_page('confirmation_result/reviewer/refused');
			}
			break;

		default:
			static_page('confirmation_result/wrong_link');
	}
}

function send_message($message)
{
	global $api_data, $api_wtt, $locales;
	$smarty = new SmartyWtt;

	// send the message to all addressees one by one
	$mps = addressees_of_message($message);
	$addressees = array();
	foreach ($mps as $mp)
	{
		// skip MPs that have no e-mail address
		if (!isset($mp['email']) || empty($mp['email']))
		{
			$addressees['no_email'][] = $mp;
			continue;
		}

		// prevent sending the same message to one MP multiple times
		$messages_to_mp = $api_wtt->read('MessageToMp', array('mp_id' => $mp['id'], 'parliament_code' => $mp['parliament_code']));
		if (($similar_message_id = similar_message($message, $messages_to_mp)) !== false)
		{
			$api_data->delete('Response', array('message_id' => $message['id'], 'mp_id' => $mp['id'], 'parliament_code' => $mp['parliament_code']));
			$former_message = $api_data->readOne('Message', array('id' => $similar_message_id));
			$addressees['blocked'][] = $mp + array('former_message' => $former_message);
			continue;
		}

		// process also To: addresses in the form common-mailbox@host?subject=addressee
		$subject = mime_encode($message['subject']);
		$to = $mp['email'];
		if (($p = strpos($to, '?subject=')) !== false)
		{
			$subject = mime_encode(substr($to, $p + strlen('?subject=')) . ' – ') . $subject;
			$to = substr($to, 0, $p);
		}
		$to = compose_email_address($mp['first_name'] . (!empty($mp['middle_names']) ? ' ' . $mp['middle_names'] . ' ' : ' ') . $mp['last_name'], $to);
		$from = compose_email_address($message['sender_name'], 'reply.' . $mp['reply_code'] . '@' . WTT_HOST);
		$reply_to = ($message['is_public'] == 'yes') ? $from : compose_email_address($message['sender_name'], $message['sender_email']);

		$smarty->assign('message', array('sender_name' => $message['sender_name'], 'sender_email' => $message['sender_email'],
			'subject' => $message['subject'], 'body' => $message['body'], 'is_public' => $message['is_public'], 'reply_to' => $reply_to));

		// instructions in the e-mail for MPs are always in the primary language of the site
		$old_locale = setlocale(LC_ALL, '0');
		$locale = reset($locales);
		putenv('LC_ALL=' . $locale['system_locale']);
		setlocale(LC_ALL, $locale['system_locale']);
		$text = $smarty->fetch('email/message_to_mp.tpl');
		putenv('LC_ALL=' . $old_locale);
		setlocale(LC_ALL, $old_locale);

		send_mail($from, $to, $subject, $text, $reply_to);
		$addressees['sent'][] = $mp;
	}

	// send a copy to the sender
	$from = compose_email_address(WTT_TITLE, FROM_EMAIL);
	$to = compose_email_address($message['sender_name'], $message['sender_email']);
	$subject = (!isset($addressees['sent'])) ?
		mime_encode(_('Your message has not been sent')) : (
		(count($addressees['sent']) == count($mps)) ?
			mime_encode(_('Your message has been sent')) :
			mime_encode(_('Your message has been sent only to some of the addressees'))
		);
	$smarty->assign('addressee', $addressees);
	$smarty->assign('message', array('subject' => $message['subject'], 'body' => $message['body'], 'is_public' => $message['is_public']));
	$text = $smarty->fetch('email/message_sent.tpl');
	send_mail($from, $to, $subject, $text);

	// change message state
	if (isset($addressees['sent']))
		$api_data->update('Message', array('id' => $message['id']), array('state' => 'sent', 'sent_on' => 'now'));
	else
		$api_data->update('Message', array('id' => $message['id']), array('state' => 'blocked'));
}

function send_to_reviewer($message)
{
	global $api_data;
	$smarty = new SmartyWtt;

	// generate a random approval code for the message
	$approval_code = random_code(10);

	// send the message to a reviewer to approve
	$from = compose_email_address(WTT_TITLE, FROM_EMAIL);
	$to = REVIEWER_EMAIL;
	$subject = mime_encode(_('A message to representatives needs your approval'));
	$smarty->assign('addressee', addressees_of_message($message));
	$smarty->assign('message', array('subject' => $message['subject'], 'body' => $message['body'], 'is_public' => $message['is_public'], 'confirmation_code' => $message['confirmation_code'], 'approval_code' => $approval_code));
	$text = $smarty->fetch('email/request_to_review.tpl');
	send_mail($from, $to, $subject, $text);

	// change message state
	$api_data->update('Message', array('id' => $message['id']), array('state' => 'waiting for approval', 'approval_code' => $approval_code));
}

function refuse_message($message)
{
	global $api_data;
	$smarty = new SmartyWtt;

	// send explanation of the refusal to the sender
	$from = compose_email_address(WTT_TITLE, FROM_EMAIL);
	$to = compose_email_address($message['sender_name'], $message['sender_email']);
	$subject = mime_encode(_('Your message has been found unpolite and it has not been sent'));
	$smarty->assign('addressee', addressees_of_message($message));
	$smarty->assign('message', array('subject' => $message['subject'], 'body' => $message['body'], 'is_public' => $message['is_public']));
	$text = $smarty->fetch('email/message_refused.tpl');
	send_mail($from, $to, $subject, $text);

	// change message state
	$api_data->update('Message', array('id' => $message['id']), array('state' => 'refused'));
}

function addressees_of_message($message)
{
	global $api_data, $api_wtt;

	// get list of MPs' id-s the message is addressed to
	$responses = $api_data->read('Response', array('message_id' => $message['id']));
	$mp_list = '';
	foreach($responses as $response)
		$mp_list .= $response['parliament_code'] . '/' . $response['mp_id'] . '|';

	// get details of those MPs
	$mp_list = rtrim($mp_list, '|');
	$mp_details = $api_wtt->read('MpDetails', array('mp' => $mp_list));

	// add a reply_code for each addressee to the returned details
	$i = 0;
	foreach ($mp_details as &$mp)
		$mp['reply_code'] = $responses[$i++]['reply_code'];
	return $mp_details;
}

function message_is_profane($message)
{
	$file = ($message['is_public'] == 'yes') ? 'profanities_public.lst' : 'profanities_private.lst';
	$profanities = file("../$file", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$prefix_only = !($message['is_public'] == 'yes');
	return text_is_profane($message['subject'], $profanities, $prefix_only) || text_is_profane($message['body'], $profanities, $prefix_only);
}

function text_is_profane($text, $profanities_list, $prefix_only)
{
	$text = mb_strtolower($text);
	$text = ' ' . strtr($text, ".,:;!?-'\"()\r\n", '              ');
	foreach ($profanities_list as $p)
	{
		if ($prefix_only)
			$p = ' ' . $p;
		if (strpos($text, $p) !== false)
			return true;
	}
	return false;
}

function public_messages_page()
{
	global $api_wtt;
	$smarty = new SmartyWtt;

	$params = array();
	if (isset($_SESSION['parliament']) && !empty($_SESSION['parliament']))
		$params['parliament'] = $_SESSION['parliament'];
	$messages = $api_wtt->read('PublicMessagePreview', $params);

	foreach ($messages as &$message)
		$message['response_exists'] = explode(', ', $message['response_exists']);

	$smarty->assign('messages', $messages);
	$smarty->display('list.tpl');
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
	global $api_data;
	do
	{
		$code = random_code($length);
		$res = $api_data->readOne($resource, array($field => $code));
	}
	while ($res);
	return $code;
}

function escape_header_fields($text)
{
	$escape_tokens = array('To:', 'Cc:', 'Bcc:', 'From:', 'Sender:', 'Reply-To:', 'Subject:');
	foreach($escape_tokens as $token)
		$text = str_ireplace($token, strtr($token, ':', ';'), $text);
	return $text;
}


// must use header lines separator \n instead of the correct one \r\n due to a bug in centrum.cz mail client
function send_mail($from, $to, $subject, $message, $reply_to = null, $additional_headers = null)
{
	// make standard headers
	if (empty($reply_to))
		$reply_to = $from;
	if ($from == compose_email_address(WTT_TITLE, FROM_EMAIL))
		$reply_to = CONTACT_EMAIL;
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
	$log = new Log(WTT_LOGS_DIR . '/error.log', 'a');
	$log->write("Sending of a mail failed. Mail fields:\n" .
		print_r(array('to' => $to, 'subject' => $subject, 'message' => $message, 'headers' => $headers), true), Log::ERROR);

	// and inform admin
	$headers = 'From: ' . compose_email_address(WTT_TITLE, FROM_EMAIL) . "\n" .
	'Reply-To: ' . compose_email_address(WTT_TITLE, FROM_EMAIL) . "\n" .
	'Content-Type: text/plain; charset="UTF-8"' . "\n" .
	'X-Mailer: PHP';
	mail(ADMIN_EMAIL, mime_encode(_('Sending of a mail failed')), _('Check') . ' ' . WTT_LOGS_DIR . '/error.log', $headers);
}

function order_newsletter($email)
{
	$from = compose_email_address(WTT_TITLE, FROM_EMAIL);
	$to = ORDER_NEWSLETTER_EMAIL;
	$subject = mime_encode(_('Newsletter order'));
	$message = $email;
	send_mail($from, $to, $subject, $message);
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

function similar_message($sample_message, $messages)
{
	$sample_text = str_replace(array($sample_message['sender_name'], $sample_message['sender_address']), '', $sample_message['body']);
	$sample_length = mb_strlen($sample_text);
	foreach ($messages as $message)
	{
		// skip the tested message itself
		if ($message['id'] == $sample_message['id']) continue;

		// remove signature from the text
		$text = str_replace(array($message['sender_name'], $message['sender_address']), '', $message['body']);

		// different text lengths by more than 20% implies different texts
		$length = mb_strlen($text);
		if (abs($length - $sample_length) > 0.2 * min($length, $sample_length)) continue;

		// compare bodies for similarity
		if (similarity($text, $sample_text) > 0.8)
			return $message['id'];
	}
	return false;
}

function similarity($text1, $text2)
{
	// remove accents and convert to lowercase
	$text1 = preg_replace('/[\'^"]/', '', strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $text1)));
	$text2 = preg_replace('/[\'^"]/', '', strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $text2)));

	// split texts to arrays of words
	$words1 = preg_split('/[\W]+/', $text1, -1, PREG_SPLIT_NO_EMPTY);
	$words2 = preg_split('/[\W]+/', $text2, -1, PREG_SPLIT_NO_EMPTY);

	// sort the words alphabetically
	sort($words1, SORT_STRING);
	sort($words2, SORT_STRING);

	// count number of common words in both arrays
	$count = 0;
	$word1 = reset($words1);
	$word2 = reset($words2);
	while ($word1 !== false && $word2 !== false)
	{
		if ($word1 == $word2)
		{
			$count++;
			$word1 = next($words1);
			$word2 = next($words2);
		}
		elseif ($word1 < $word2)
			$word1 = next($words1);
		else
			$word2 = next($words2);
	}

	// return similarity of the texts
	return $count / max(count($words1), count($words2));
}

?>
