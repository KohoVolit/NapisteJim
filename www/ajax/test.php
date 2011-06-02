<?php

require '/home/michal/napistejim.cz/classes/ApiDirect.php';
const API_DIR = '/home/michal/api.kohovolit.eu/www';

 
	$ad = new ApiDirect('kohovolit');
	
	$adn = new ApiDirect('napistejim');
	
	$message_id = $_GET['id'];
	$message_ar = $ad->read('Message', array('id' => $message_id));
	$message = $message_ar['message'][0];
	
	echo nl2br($message['body_']);die();
	
	$responses_orig = $ad->read('Response', array('message_id' => $message_id));
	$responses = $responses_orig['response'];
	
	foreach((array)$responses as $key => $response) {
	  $responder = $ad->read('Mp', array('id' => $response['mp_id']));
	  $responder['mp'][0]['name'] = $responder['mp'][0]['last_name'] ."&nbsp;" . $responder['mp'][0]['first_name'];
	  $responses[$key]['responder'] = $responder['mp'][0];
	}
	
	print_r($message);print_r($responses);die();
	
	
	/*
	$messages_orig = $ad->read('Message', array('is_public' => 'yes','state_' => 'sent' ));
	$messages =  $messages_orig['message'];
	$responses_orig = $ad->read('Response', array());
	
	//reorder $responses to be able to access them directly
	foreach ((array)$responses_orig['response'] as $row) {
	  $responses[$row['message_id']][] = $row;
	}
	//sort messages by date, add responses, add mps' names
	foreach ((array) $messages as $key => $message) {
	  //for sorting
	  $sort[$key]  = $message['sent_on'];
	  //add answers
	  $messages[$key]['response'] = $responses[$message['id']];
	  //add shortened body_
	  $messages[$key]['body_short'] = mb_substr($message['body_'],0,150,"UTF-8");
	  //add formatted date
	  $date = new DateTime($message['sent_on']);
	  $messages[$key]['date'] = $date->format('j.n.Y');
	  // + 2weeks more date ?
	  $date_limit = $date->add(new DateInterval('P14D'));
	  $now = new DateTime('now');
	  if ($now > $date_limit) 
	    $over14 = true;
	  else
	    $over14 = false;
	  //add mps' names + response status
	  foreach ((array) $responses[$message['id']] as $response) {
	    $responder = $ad->read('Mp', array('id' => $response['mp_id']));
	    $responder['mp'][0]['name'] = $responder['mp'][0]['last_name'] ."&nbsp;" . mb_substr($responder['mp'][0]['first_name'],0,1,"UTF-8") . '.';
	    $messages[$key]['responder'][] = $responder['mp'][0];
	    //response status: answered, not-answered-long (>2 weeks), not-answered-short (<2 weeks)
	    if ($response['body_'] != '')
	      $messages[$key]['response_status'][] = array('code' => 'answered','text' => 'Email zodpovězen');
		else if ($over14)
		  $messages[$key]['response_status'][] = array('code' => 'not-answered-long','text' => 'Email nezodpovězen (méně jak 14 dní)');
		else
		  $messages[$key]['response_status'][] = array('code' => 'not-answered-short','text' => 'Email nezodpovězen (více jak 14 dní)');
	  }
	}
	array_multisort($sort, SORT_DESC, $messages );
	
	print_r($messages);die();
	*/
	
	//$res = $ad->read('AddressRepresentatives', array('latitude' => 49.7132821, 'longitude' => 16.2620636, 'administrative_area_level_1' => 'Hlavní město Praha','administrative_area_level_2' => 'Hlavní město Praha','locality' => 'Praha', 'sublocality' => 'Praha 2', 'neighborhood'=>'Vyšehrad', 'nic'=>'nic'));
	//'administrative_area_level_1' => 'Moravskoslezský',, 'administrative_area_level_2' => 'Ostrava', 'locality' => 'Ostrava'
	$res = $ad->read('Term', array('datetime' => '2011-05-25'));
	print_r($res);
	
?>
