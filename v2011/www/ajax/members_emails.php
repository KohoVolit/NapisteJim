<?php
require '../../config/settings.php';
require '../../setup.php';
require '../../utils.php';

if (!isset($_GET['parliament_code']) || $_GET['parliament_code'] == '0') exit;

// prepare parameters for MP search
$params = array();
foreach ($_GET as $key => $item)
	if ($item != 0)
	{
		if ($key == 'constituency')
			$params['constituency_id'] = $item;
		else if ($key != 'parliament_code')
			$params['groups'][] = $item;
	}
if (empty($params)) exit;
if (isset($params['groups']))
	$params['groups'] = implode('|', $params['groups']);

// find MPs with the given memberships
$api_napistejim = new ApiDirect('napistejim');
$mp_names = $api_napistejim->read('FindMps', $params);

// get details of those MPs
$mp_ids = array();
foreach ($mp_names as $mp)
	$mp_ids[] = $_GET['parliament_code'] . '/' . $mp['id'];
$mps = $api_napistejim->read('MpDetails', array('mp' => implode('|', $mp_ids)));

// print emails of the found MPs
$emails = array();
foreach ($mps as $mp)
	if (isset($mp['email']) && !empty($mp['email']))
		$emails[] = $mp['email'];

echo implode(', ', $emails);

?>
