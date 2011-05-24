<?php
require '../../config/settings.php';
require '../../setup.php';

//get array with mp
$ad = new ApiDirect('napistejim');
$res = $ad->read('MpDetails',array('mp' => $_GET['id']));

//new smarty
$smarty = new SmartyNapisteJimCz;
$smarty->assign('mp',$res['mp_details'][0]);
$smarty->display('ajax.id2mp.search_results.tpl');
?>
