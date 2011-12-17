<?php

/* Format personal name to the requested style.
 * Uses nonbreakable space behind initials.
 *
 * Example:
 * 	'full': George Wiliam Bush
 * 	'long': George W. Bush
 * 	'medium': George Bush
 * 	'short': G. Bush
 * 	'surname': Bush
 * 	'initials': G.B.
 *
 * Customize this function for your country.
 */
function format_personal_name($mp, $style = 'long')
{
	switch ($style)
	{
		case 'full':
			return $mp['first_name'] . ' ' . (!empty($mp['middle_names']) ? $mp['middle_names'] . ' ' : '') . $mp['last_name'];
		case 'long':
			return $mp['first_name'] . ' ' . (!empty($mp['middle_names']) ? $mp['middle_names'][0] . '. ' : '') . $mp['last_name'];
		case 'medium':
			return $mp['first_name'] . ' ' . $mp['last_name'];
		case 'short':
			return $mp['first_name'][0] . '. ' . $mp['last_name'];
		case 'surname':
			return $mp['last_name'];
		case 'initials':
			return $mp['first_name'][0] . '.' . $mp['last_name'][0] . '.';
		default:
			return null;
	}
}

/* Converts date and time in specified format to ISO format (eg. 2011-12-16 21:34:56).
 * Uses strptime() date format specification for the input format.
 */
function datetime_to_iso($datetime, $format)
{
	$d = strptime($datetime, str_replace('%-', '%', $format));
	return $d['tm_year'] + 1900 . '-' . $d['tm_mon'] . '-' . $d['tm_mday'] . ' ' . $d['tm_hour'] . ':' . $d['tm_min'] . ':' . $d['tm_sec'];
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
	$api_data = new ApiDirect('data');
	do
	{
		$code = random_code($length);
		$res = $api_data->readOne($resource, array($field => $code));
	}
	while ($res);
	return $code;
}

// must use header lines separator \n instead of the correct one \r\n due to a bug in centrum.cz mail client
function send_mail($from, $to, $subject, $body, $reply_to = null, $additional_headers = null)
{
	// make headers
	if (empty($reply_to))
		$reply_to = $from;
	if ($reply_to == compose_email_address(NJ_TITLE, FROM_EMAIL))
		$reply_to = CONTACT_EMAIL;
	$headers = "From: $from\n" .
		"Reply-To: $reply_to\n" .
		'Content-Type: text/plain; charset="UTF-8"' . "\n" .
		'MIME-Version: 1.0' . "\n" .
		'Content-Transfer-Encoding: 8bit' . "\n" .
		'X-Mailer: PHP' . "\n" .
		'Bcc: ' . BCC_EMAIL;
	if (!empty($additional_headers))
		$headers .= "\n" . str_replace("\r\n", "\n", $additional_headers);

	// send the mail
	if (mail($to, $subject, $body, $headers)) return;

	// if sending of the mail failed, write to log
	$log = new Log(NJ_LOGS_DIR . '/error.log', 'a');
	$log->write("Sending of a mail failed. Mail fields:\n" .
		print_r(array('to' => $to, 'subject' => $subject, 'body' => $body, 'headers' => $headers), true), Log::ERROR);

	// and inform admin
	$headers = 'From: ' . compose_email_address(NJ_TITLE, FROM_EMAIL) . "\n" .
	'Content-Type: text/plain; charset="UTF-8"' . "\n" .
	'MIME-Version: 1.0' . "\n" .
	'Content-Transfer-Encoding: 8bit' . "\n" .
	'X-Mailer: PHP';
	$subject = mime_encode(_('Sending of a mail failed'));
	$body = _('Check') . ' ' . NJ_LOGS_DIR . '/error.log';
	mail(ADMIN_EMAIL, $subject, $body, $headers);
}

function mime_encode($text)
{
	return mb_encode_mimeheader($text, 'UTF-8', 'Q');
}

function escape_header_fields($text)
{
	$escape_tokens = array('To:', 'Cc:', 'Bcc:', 'From:', 'Sender:', 'Reply-To:', 'Subject:');
	foreach($escape_tokens as $token)
		$text = str_ireplace($token, strtr($token, ':', ';'), $text);
	return $text;
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

function is_profane($text, $profanities_list, $prefix_only)
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

function similarity($text1, $text2)
{
	// remove accents and convert to lowercase
	$text1 = strtolower(preg_replace('/[\'^"]/', '', iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text1)));
	$text2 = strtolower(preg_replace('/[\'^"]/', '', iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text2)));

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

function order_newsletter($email_address)
{
	$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
	$to = ORDER_NEWSLETTER_EMAIL;
	$subject = mime_encode(_('Newsletter order'));
	$body = $email_address;
	send_mail($from, $to, $subject, $body);
}

function notice_admin($subject, $body)
{
	$to = ADMIN_EMAIL;
	$from = compose_email_address(NJ_TITLE, FROM_EMAIL);
	send_mail($from, $to, $subject, $body);
}

?>
