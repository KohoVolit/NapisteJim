<?php

require '../../config/settings.php';
require '../../setup.php';

$api_napistejim = new ApiDirect('napistejim');
$api_kohovolit = new ApiDirect('kohovolit');

$data = array();
foreach ((array) $_GET as $key => $item) {
  switch($key) {
    case 'constituency' :
      if ($item != 0) $data['constituency'] = $item;
      break;
    case 'parliament_code':
      break;
    default:
      if ($item != 0) $data['groups'][] = $item;
  }
}
if (!empty($data)) {
  $out = '';
  $date = new DateTime('now');
  $search_mps = $api_napistejim->read('SearchMps', $data);
  foreach ((array) $search_mps['search_mps'] as $mp) {
    $mp_ar = $api_kohovolit->read('MpAttribute', array('datetime' => $date->format('Y-m-d H:i:s'),'parl' => $_GET['parliament_code'], 'mp_id' => $mp['id'], 'name_' => 'email'));
    if (isset($mp_ar['mp_attribute'][0]))
      $out .= $mp_ar['mp_attribute'][0]['value_'] . ', ';
  }
  $out = rtrim(trim($out),',');
  echo $out;
}
/*
	$data = array();
	if (isset($_GET['groups']))
		$data['groups'] = explode('|', $_GET['groups']);
	if (isset($_GET['constituency']))
		$data['constituency'] = $_GET['constituency'];
	$search_mps = $api_napistejim->read('SearchMps', $data);
	
	if (isset($_GET['parliament_code']))
		$smarty->assign('parliament', array('code' => $_GET['parliament_code']));
	$smarty->assign('mps', $search_mps['search_mps']);
	$smarty->display('search_results_advanced.tpl');*/
?>
