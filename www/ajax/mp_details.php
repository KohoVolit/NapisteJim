<?php
require '../../config/settings.php';
require '../../setup.php';

// get MP's details
$api_wtt = new ApiDirect('wtt');
$mp_details = $api_wtt->readOne('MpDetails', array('mp' => $_GET['id']));

// format the details into HTML
$smarty = new SmartyWtt;
$smarty->assign('mp', $mp_details);
$smarty->display('ajax/mp_box.tpl');
?>
