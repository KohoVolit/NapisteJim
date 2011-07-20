<?php
require '../../config/settings.php';
require '../../setup.php';

//get array with mp
$api_wtt = new ApiDirect('wtt');
$mp_details = $api_wtt->readOne('MpDetails', array('mp' => $_GET['id']));

//new smarty
$smarty = new SmartyWtt;
$smarty->assign('mp', $mp_details);
$smarty->assign('img_url', IMG_URL);
$smarty->display('ajax/id2mp_search_results.tpl');
?>
