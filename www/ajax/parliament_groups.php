<?php
require '../../config/settings.php';
require '../../setup.php';

if (!isset($_GET['parliament_code']) || $_GET['parliament_code'] == '0') exit;

// get groups of the given parliament
$api_napistejim = new ApiDirect('napistejim');
$groups = $api_napistejim->read('ParliamentGroup', $_GET + array('lang' => $locale['lang']));

// get constituencies of the given parliament
$api_data = new ApiDirect('data');
$constituencies = $api_data->read('Constituency', array('parliament_code' => $_GET['parliament_code'], '_datetime' => 'now'));

// sort the groups within each group kind and constituencies using locale aware sorting
foreach ($groups['group_kind'] as $gk)
	usort($gk['group'], 'cmp_by_name');
usort($constituencies, 'cmp_by_name');

// format the groups and constituencies into HTML
$smarty = new SmartyNapisteJim;
$smarty->assign('groups', $groups['group_kind']);
$smarty->assign('constituencies', $constituencies);
$smarty->display('ajax/parliament_groups.tpl');


function cmp_by_name($a, $b)
{
	return strcoll($a['name'], $b['name']);
}

?>
