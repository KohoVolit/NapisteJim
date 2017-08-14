<?php
require '../../config/settings.php';
require '../../setup.php';
require '../../utils.php';

// get MP's details
$api_napistejim = new ApiDirect('napistejim');
$mp_details = $api_napistejim->readOne('MpDetails', array('mp' => $_GET['id']));

// format the details into HTML
$smarty = new SmartyNapisteJim;
$smarty->assign('mp', $mp_details);
$smarty->display('ajax/mp_box.tpl');
?>
