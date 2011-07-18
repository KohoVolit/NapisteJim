<?php

require '../../config/settings.php';
require '../../setup.php';

$api_wtt = new ApiDirect('wtt');
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
  $search_mps = $api_wtt->read('FindMp', $data);
  foreach ((array) $search_mps as $mp) {
    $mp_attr = $api_kohovolit->readOne('MpAttribute', array('#datetime' => $date->format('Y-m-d H:i:s'),'parl' => $_GET['parliament_code'], 'mp_id' => $mp['id'], 'name_' => 'email'));
    if ($mp_attr)
      $out .= $mp_attr['value_'] . ', ';
  }
  $out = rtrim(trim($out), ',');
  echo $out;
}

?>
