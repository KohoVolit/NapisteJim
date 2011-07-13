<?php
require '../../config/settings.php';
require '../../setup.php';

//get array with mp
$ad = new ApiDirect('wtt');
$res = $ad->read('MpDetails',array('mp' => $_GET['id']));
//new smarty
$smarty = new SmartyWtt;
$smarty->assign('mp',$res['mp_details'][0]);
$smarty->assign('img_url',IMG_URL);
$smarty->display('ajax/id2mp_search_results.tpl');
?>
