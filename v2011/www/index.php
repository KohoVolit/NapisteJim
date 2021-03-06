<?php
require '../config/settings.php';
require '../setup.php';
require '../utils.php';

$api_data = new ApiDirect('data');
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
	case 'news':
		static_page($page);
		break;

	case 'confirm':
		confirm_page();
		break;

	case 'public':
		public_page();
		break;

	case 'list':
		list_page();
		break;

	case 'statistics':
		statistics_page();
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
				message_page($_GET['message']);
			else
				static_page('search');
		}
}

function static_page($page)
{
	$smarty = new SmartyNapisteJim;
	$smarty->display($page . '.tpl');
}

function search_advanced_page()
{
	global $api_data, $api_napistejim, $locale;
	$smarty = new SmartyNapisteJim;

	// get all parliaments in this country
	$parliaments = $api_data->read('Parliament', array('country_code' => COUNTRY_CODE));
	$parl_codes = array();
	foreach ($parliaments as $p)
		$parl_codes[] = $p['code'];

	$parliament_details = $api_napistejim->read('ParliamentDetails', array('parliament' => implode('|', $parl_codes), 'lang' => $locale['lang']));
	usort($parliament_details, 'cmp_by_weight_name');

	$smarty->assign('parliaments', $parliament_details);
	$smarty->display('search_advanced.tpl');
}

function cmp_by_weight_name($a, $b)
{
	return ($a['weight'] < $b['weight']) ? -1 : (($a['weight'] > $b['weight']) ? 1 : strcoll($a['name'], $b['name']));
}

function choose_page()
{
	$smarty = new SmartyNapisteJim;
	$smarty->assign('address', $_GET['address']);
	$smarty->display('choose.tpl');
}

function choose_advanced_page()
{
	global $api_napistejim;
	$smarty = new SmartyNapisteJim;

	$params = array();
	if (isset($_GET['groups']) && !empty($_GET['groups']))
		$params['groups'] = $_GET['groups'];
	if (isset($_GET['constituency_id']) && !empty($_GET['constituency_id']))
		$params['constituency_id'] = $_GET['constituency_id'];
	if (isset($_GET['parliament_code']) && !empty($_GET['parliament_code']))
		$params['parliament_code'] = $_GET['parliament_code'];
	if (isset($_GET['_datetime']) && !empty($_GET['_datetime']))
		$params['_datetime'] = $_GET['_datetime'];
	$found_mps = $api_napistejim->read('FindMps', $params);

	$smarty->assign('mps', $found_mps);
	if (isset($_GET['parliament_code']))
		$smarty->assign('parliament', array('code' => $_GET['parliament_code']));
	$smarty->display('choose_advanced.tpl');
}

function write_page()
{
	global $api_napistejim, $locale;
	$smarty = new SmartyNapisteJim;

	// block writing of a message if IP address is on the blacklist
	if (on_blacklist($_SERVER['REMOTE_ADDR'], 'ip'))
		return static_page('blocked_ip');

	$mp_list = implode('|', array_slice(array_unique(explode('|', $_GET['mp'])), 0, 3));
	$mp_details = $api_napistejim->read('MpDetails', array('mp' => $mp_list, 'lang' => $locale['lang']));
	$locality = isset($_SESSION['locality']) ? $_SESSION['locality'] : '';

	// remove MPs without an email address
	if (!empty($mp_details))
		foreach ($mp_details as $key => $mp)
			if (!isset($mp['email']) || empty($mp['email']))
				unset($mp_details[$key]);

	if (empty($mp_details))
		return static_page('search');

	// include stylesheet for use in an iframe
	if (isset($_GET['css']))
		$smarty->assign('css', $_GET['css']);

	$smarty->assign('mp_list', $mp_list);
	$smarty->assign('mp_details', $mp_details);
	$smarty->assign('locality', $locality);
	$smarty->assign('requested_at', $_SERVER['REQUEST_TIME']);
	$smarty->display("write.tpl");
}

function send_page()
{
	global $api_data, $api_napistejim;
	$smarty = new SmartyNapisteJim;

	// block sending of a message if IP address is on the blacklist
	if (on_blacklist($_SERVER['REMOTE_ADDR'], 'ip'))
		return static_page('blocked_ip');

	// block sending of a message if sender's e-mail address is on the blacklist
	if (on_blacklist($_POST['email'], 'sender'))
		return static_page('blocked_sender');

	// check that all required fields are present
	if (!isset($_POST['name']) || empty($_POST['name']) ||
		!isset($_POST['email']) || empty($_POST['email']) ||
		!isset($_POST['is_public']) || $_POST['is_public'] != 'yes' && $_POST['is_public'] != 'no' ||
		!isset($_POST['subject']) || empty($_POST['subject']) ||
		!isset($_POST['body']) || empty($_POST['body']))
		return static_page('search');

	// prevent mail header injection
	$subject = escape_header_fields($_POST['subject']);
	$name = escape_header_fields($_POST['name']);
	$email = escape_header_fields($_POST['email']);
	$address = $_POST['address'];
	$body = $_POST['body'];
	$is_public = $_POST['is_public'];
	$mps = array_slice(array_unique(explode('|', $_POST['mp'])), 0, 3);
	$form_requested_at = isset($_POST['form_requested_at']) ? $_POST['form_requested_at'] : $_SERVER['REQUEST_TIME'];

	// generate a random unique confirmation code
	$confirmation_code = unique_random_code(10, 'Message', 'confirmation_code');

	// store the message
	$message_pkey = $api_data->create('Message', array('subject' => $subject, 'body' => $body, 'sender_name' => $name, 'sender_address' => $address, 'sender_email' => $email, 'is_public' => $is_public, 'confirmation_code' => $confirmation_code, 'remote_addr' => $_SERVER['REMOTE_ADDR'], 'typing_duration' => $_SERVER['REQUEST_TIME'] - $form_requested_at));
	$message_id = $message_pkey['id'];

	// create relationship between the message and all its addressees
	$relationships = array();
	foreach ($mps as $mp)
	{
		$reply_code = unique_random_code(10, 'MessageToMp', 'reply_code');
		$p = strrpos($mp, '/');
		$relationships[] = array('message_id' => $message_id, 'mp_id' => substr($mp, $p + 1), 'parliament_code' => substr($mp, 0, $p), 'reply_code' => $reply_code);
	}
	$api_data->create('MessageToMp', $relationships);

	// send confirmation mail to the sender
	$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
	$to = compose_email_address($name, $email);
	$mail_subject = mime_encode(sprintf(_('Please confirm that you want to send the message using %s'), NJ_TITLE));
	$addressees = $api_napistejim->read('MpDetails', array('mp' => implode('|', $mps)));
	$smarty->assign('addressees', $addressees);
	$smarty->assign('message', array('subject' => $subject, 'body' => $body, 'is_public' => $is_public, 'confirmation_code' => $confirmation_code));
	$mail_body = $smarty->fetch('email/request_to_confirm.tpl');
	send_mail($from, $to, $mail_subject, $mail_body);

	// order newsletter if requested
	if (isset($_POST['newsletter']))
		order_newsletter($email);

	// include stylesheet for use in an iframe
	if (isset($_POST['css']))
		$smarty->assign('css', $_POST['css']);

	$smarty->display('confirm.tpl');
}

function confirm_page()
{
	global $api_data, $api_napistejim;

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
			$my_messages = $api_data->read('Message', array('sender_email' => $message['sender_email'], 'state' => 'sent'));
			if (similar_message_exists($message, $my_messages))
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

function public_page()
{
	global $api_data, $api_napistejim, $locale;
	$smarty = new SmartyNapisteJim;

	// recently sent and recently replied to messages
	$params = array('country' => COUNTRY_CODE, '_limit' => 5, 'order' => 'sent');
	if (isset($_SESSION['parliament']) && !empty($_SESSION['parliament']))
		$params['parliament'] = $_SESSION['parliament'];
	$recently_sent_messages = $api_napistejim->read('PublicMessagesPreview', $params);
	$params['order'] = 'replied';
	$recently_replied_messages = $api_napistejim->read('PublicMessagesPreview', $params);
	$smarty->assign('message_sets', array(
		array('title' => _('Recently sent messages'), 'messages' => $recently_sent_messages, 'next_params' => 'order=sent'),
		array('title' => _('Recently replied messages'), 'messages' => $recently_replied_messages, 'next_params' => 'order=replied')
	));

	// parliaments for message filtering
	$parliaments = $api_data->read('Parliament', array('country_code' => COUNTRY_CODE));
	$smarty->assign('parliaments', $parliaments);

	// MP statistics
	$params = array('country' => COUNTRY_CODE, '_limit' => 10);
	if (isset($_SESSION['parliament']) && !empty($_SESSION['parliament']))
		$params['parliament'] = $_SESSION['parliament'];
	$mp_statistics = $api_napistejim->read('MpStatistics', $params);
	$smarty->assign('mp_statistics', $mp_statistics);

	$smarty->display('public.tpl');
}

function list_page()
{
	global $api_data, $api_napistejim, $locale;
	$smarty = new SmartyNapisteJim;

	// get the messages
	$filter_params = array('country' => COUNTRY_CODE, '_limit' => PAGER_SIZE + 1) + $_GET + array('_offset' => 0);
	// parameter 'parliament_code' is used to restrict the shown messages
	// while 'parliament' hold in session restricts the entire web to given parliament(s)
	if (isset($filter_params['parliament_code']))
		$filter_params['parliament'] = $filter_params['parliament_code'];
	else if (isset($_SESSION['parliament']) && !empty($_SESSION['parliament']))
		$filter_params['parliament'] = $_SESSION['parliament'];
	$iso_dates = array();
	if (isset($filter_params['since']) && !empty($filter_params['since']))
		$iso_dates['since'] = datetime_to_iso($filter_params['since'], $locale['date_format']);
	if (isset($filter_params['until']) && !empty($filter_params['until']))
	{
		$iso_dates['until'] = datetime_to_iso($filter_params['until'], $locale['date_format']);
		$iso_dates['until'] = preg_replace('/[\d]+:[\d]+:[\d]+/', '23:59:59.99999', $iso_dates['until']);
	}
	$messages = $api_napistejim->read('PublicMessagesPreview', $iso_dates + $filter_params);

	// make pager links
	$pager_params = $filter_params;
	if (isset($pager_params['parliament']))
		$pager_params['parliament_code'] = $pager_params['parliament'];
	unset($pager_params['parliament'], $pager_params['page'], $pager_params['country'], $pager_params['_limit']);
	$smarty->assign('pager', make_pager_links($messages, $pager_params));
	// and remove the last message afterwards - it served only as indicator of an existing next page
	if (count($messages) > PAGER_SIZE)
		unset($messages[PAGER_SIZE]);

	$smarty->assign('messages', $messages);

	// get parliaments for message filtering
	$parliaments = $api_data->read('Parliament', array('country_code' => COUNTRY_CODE));
	$smarty->assign('parliaments', $parliaments);

	// show filter params in the form
	$form_params = $pager_params;
	if (isset($form_params['mp_id']) && !empty($form_params['mp_id']))
	{
		$mp = $api_data->readOne('Mp', array('id' => $form_params['mp_id']));
		$form_params['recipient'] = format_personal_name($mp);
	}
	$smarty->assign('params', $form_params);

	$smarty->display('list.tpl');
}

function message_page($message_id)
{
	global $api_data, $api_napistejim, $locale;
	$smarty = new SmartyNapisteJim;

	$message = $api_data->readOne('Message', array('id' => $message_id));
	$smarty->assign('message', $message);

	if ($message['is_public'] == 'no')
		return $smarty->display('message_private.tpl');

	$replies = $api_napistejim->read('RepliesToMessage', array('message_id' => $message_id, 'lang' => $locale['lang']));

	// get statistics of the addressees
	$mp_ids = array();
	foreach ($replies['mp'] as $mp)
		$mp_ids[] = $mp['mp_id'];
	$mp_stats = $api_napistejim->read('MpStatistics', array('mp' => implode('|', $mp_ids)));
	foreach ($replies['mp'] as &$mp)
		foreach ($mp_stats as $stat)
			if ($stat['id'] == $mp['mp_id'])
			{
				$mp['received_public_messages'] = $stat['received_public_messages'];
				break;
			}
	$smarty->assign('replies', $replies);

	$smarty->display('message.tpl');
}

function statistics_page()
{
	global $api_data, $api_napistejim;
	$smarty = new SmartyNapisteJim;

	// get the statistics
	$filter_params = array('country' => COUNTRY_CODE, '_limit' => PAGER_SIZE + 1) + $_GET + array('_offset' => 0);
	// parameter 'parliament_code' is used to restrict the shown MPs
	// while 'parliament' hold in session restricts the entire web to given parliament(s)
	if (!isset($filter_params['parliament_code']) && isset($_SESSION['parliament']) && !empty($_SESSION['parliament']))
		$filter_params['parliament_code'] = $_SESSION['parliament'];
	$statistics = $api_napistejim->read('MpStatistics', $filter_params);

	// make pager links
	$pager_params = $filter_params;
	unset($pager_params['page'], $pager_params['country'], $pager_params['_limit']);
	$smarty->assign('pager', make_pager_links($statistics, $pager_params));
	// and remove the last MP afterwards - it served only as indicator of an existing next page
	unset($statistics[PAGER_SIZE]);

	$smarty->assign('statistics', $statistics);

	// get parliaments for filtering
	$parliaments = $api_data->read('Parliament', array('country_code' => COUNTRY_CODE));
	$smarty->assign('parliaments', $parliaments);

	$smarty->assign('params', $pager_params);
	$smarty->display('statistics.tpl');
}

function send_message($message)
{
	global $api_data, $api_napistejim, $locales;
	$smarty = new SmartyNapisteJim;

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

		// prevent sending the same message to a particular MP multiple times
		$messages_to_mp = $api_napistejim->read('MessagesToMp', array('mp_id' => $mp['id'], 'parliament_code' => $mp['parliament_code']));
		if (($similar_message_id = similar_message_exists($message, $messages_to_mp)) !== false)
		{
			$api_data->delete('MessageToMp', array('message_id' => $message['id'], 'mp_id' => $mp['id'], 'parliament_code' => $mp['parliament_code']));
			$former_message = $api_data->readOne('Message', array('id' => $similar_message_id));
			$addressees['blocked'][] = array('former_message' => $former_message) + $mp;
			continue;
		}

		// set mail headers
		$subject = mime_encode($message['subject']);
		$to = $mp['email'];
		// process also To: addresses in the form common-mailbox@host?subject=addressee-name
		if (($p = strpos($to, '?subject=')) !== false)
		{
			$subject = mime_encode(substr($to, $p + strlen('?subject=')) . ' – ') . $subject;
			$to = substr($to, 0, $p);
		}
		if (isset($mp['private_email']) && !empty($mp['private_email']))
			$to .= ', ' . $mp['private_email'];
		$to = compose_email_address(format_personal_name($mp), $to);
		$from = compose_email_address($message['sender_name'], 'reply.' . $mp['reply_code'] . '@' . NJ_HOST);
		$reply_to = ($message['is_public'] == 'yes') ? $from : compose_email_address($message['sender_name'], $message['sender_email']);

		// instructions in the e-mail for MPs are always in the primary language of the site
		$old_locale = setlocale(LC_ALL, '0');
		$locale = reset($locales);
		putenv('LC_ALL=' . $locale['system_locale']);
		setlocale(LC_ALL, $locale['system_locale']);
		$smarty->assign('message', array('reply_to' => $reply_to) + $message);
		$text = $smarty->fetch('email/message_to_mp.tpl');
		putenv('LC_ALL=' . $old_locale);
		setlocale(LC_ALL, $old_locale);

		// send message to the MP
		send_mail($from, $to, $subject, $text, $reply_to);
		$addressees['sent'][] = $mp;
	}

	// send a copy to the sender
	$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
	$to = compose_email_address($message['sender_name'], $message['sender_email']);
	$subject = (!isset($addressees['sent'])) ?
		mime_encode(_('Your message has not been sent')) : (
		(count($addressees['sent']) == count($mps)) ?
			mime_encode(_('Your message has been sent')) :
			mime_encode(_('Your message has been sent only to some of the addressees'))
		);
	$smarty->assign('addressees', $addressees);
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
	$smarty = new SmartyNapisteJim;

	// send the message to a reviewer to approve
	$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
	$to = REVIEWER_EMAIL;
	$subject = mime_encode(_('A message to representatives needs your approval'));
	$approval_code =  random_code(10);
	$smarty->assign('message', array('approval_code' => $approval_code) + $message);
	$text = $smarty->fetch('email/request_to_review.tpl');
	send_mail($from, $to, $subject, $text);

	// change message state
	$api_data->update('Message', array('id' => $message['id']), array('state' => 'waiting for approval', 'approval_code' => $approval_code));
}

function refuse_message($message)
{
	global $api_data;
	$smarty = new SmartyNapisteJim;

	// send explanation of the refusal to the sender
	$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
	$to = compose_email_address($message['sender_name'], $message['sender_email']);
	$subject = mime_encode(_('Your message has been found unpolite and it has not been sent'));
	$smarty->assign('addressees', addressees_of_message($message));
	$smarty->assign('message', $message);
	$text = $smarty->fetch('email/message_refused.tpl');
	send_mail($from, $to, $subject, $text);

	// change message state
	$api_data->update('Message', array('id' => $message['id']), array('state' => 'refused'));
}

function addressees_of_message($message)
{
	global $api_data, $api_napistejim;

	// get MPs the message is addressed to
	$relationships = $api_data->read('MessageToMp', array('message_id' => $message['id']));
	$mps = array();
	foreach($relationships as $r)
		$mps[] = $r['parliament_code'] . '/' . $r['mp_id'];
	$mp_details = $api_napistejim->read('MpDetails', array('mp' => implode('|', $mps)));

	// add a reply_code for each addressee to the returned details
	$i = 0;
	foreach ($mp_details as &$mp)
		$mp['reply_code'] = $relationships[$i++]['reply_code'];
	return $mp_details;
}

function message_is_profane($message)
{
	global $locale;

	$filename = ($message['is_public'] == 'yes') ? 'public.lst' : 'private.lst';
	$profanities = file("locale/{$locale['system_locale']}/profanities/$filename", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$prefix_only = ($message['is_public'] == 'no');
	return is_profane($message['subject'], $profanities, $prefix_only) ||
		is_profane($message['body'], $profanities, $prefix_only);
}

function similar_message_exists($sample_message, $messages)
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

function make_pager_links($items, $params)
{
	$pager = array();
	if ($params['_offset'] > 0)
	{
		$prev_params = $params;
		$prev_params['_offset'] = ($params['_offset'] >= PAGER_SIZE) ? $params['_offset'] - PAGER_SIZE : 0;
		$pager['prev_url_query'] = http_build_query($prev_params);
	}
	if (count($items) > PAGER_SIZE)
	{
		$next_params = $params;
		$next_params['_offset'] = $params['_offset'] + PAGER_SIZE;
		$pager['next_url_query'] = http_build_query($next_params);
	}
	return $pager;
}

function on_blacklist($item, $blacklist_name)
{
	$blacklist_filename = NJ_DIR . "/config/blacklists/$blacklist_name.lst";
	if (!file_exists($blacklist_filename)) return false;
	$blacklist = file($blacklist_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$blacklist = array_map('trim', $blacklist);
	return in_array($item, $blacklist);
}

?>
