<?php
require '../../config/settings.php';
require '../../setup.php';

$adn = new ApiDirect('napistejim');
$adk = new ApiDirect('kohovolit');

//order of group_kinds, if not set, randomly afterwards
$order = array(
  'political group' => -99,
  'committee' => -98,
  'commission' => -97,
  'subcommittee' => -96,
);

//new smarty
$smarty = new SmartyNapisteJimCz;

//Language
// Set language to LOCALE
putenv('LC_ALL='. LOCALE);
setlocale(LC_ALL, LOCALE);
// Specify location of translation tables
bindtextdomain(LOCALIZED_DOMAIN, LOCALE_DIR);
// Choose domain
textdomain(LOCALIZED_DOMAIN);

$date_obj = new DateTime('now');
$date = $date_obj->format('Y-m-d H:i:s');

//check if parliament is not 0
if ( (!(isset($_GET['parliament_code']))) or ($_GET['parliament_code'] == '0') ) {
  //output "vyberte parlament";
  die();
}

//find info about parliament
$parl_res = $adk->read('Parliament', array('code' => $_GET['parliament_code']));
$parl = $parl_res['parliament'][0];

//find term for given parliament
$term_res = $adk->read('Term', array('parliament_kind_code' => $parl['parliament_kind_code'], 'country_code' => $parl['country_code'], 'datetime' => $date));
$term = $term_res['term'][0];

//find groups in given term and parliament
$group_res = $adk->read('Group', array('parliament_kind_code' => $parl['parliament_kind_code'], 'term_id' => $term['id']));

//reorder groups into arrays by group_kind_code
$groups = array();
foreach((array) $group_res['group'] as $group) {
  $groups[$group['group_kind_code']][] = $group;
}

//order groups within arrays alphabetically + order group_kinds
$groups_out = array();
$i = 1;
foreach ((array) $groups as $key => $group_kind) {
  if ($key != 'parliament') {
	  if (isset($order[$key]))
		$key_out = $order[$key];
	  else
		$key_out = $i;
	  $groups_out[$key_out] = order_array($groups[$key],'name_',SORT_ASC);
	  $i++;
	//quick hack to get right names of group_kinds
    $groups_out[$key_out][0]['group_kind_name'] = group_kind2name($groups_out[$key_out][0]['group_kind_code']);
  }
}

ksort($groups_out);
$smarty->assign('groups',$groups_out);

//select constituencies with parliament and datetime
$constit_res = $adk->read('Constituency', array('parliament_code' => $_GET['parliament_code'], 'datetime' => $date));
$constit = $constit_res['constituency'];

//order constituencies alphabetically !!wrong order, not using LOCALE!!
$constit = order_array($constit,'name_',SORT_ASC);

$smarty->assign('constit',$constit);
$smarty->display('ajax/parliament2groups.tpl');

/**
* function to order array according its one column
*
* @param $array
* @param $column
*
* @result $out sorted array
*/
function order_array($data,$column,$sort_order) {
	// Obtain a list of columns
	$order = array();
	foreach ((array)$data as $key => $row) {
		$order[$key]  = $row[$column];
	}
	// Sort the data with volume descending, edition ascending
	// Add $data as the last parameter, to sort by the common key
	array_multisort($order, $sort_order, $data);
	return $data;
}

/*
* quick hack
*/
function group_kind2name($gkc) { //group_kind_code
 switch ($gkc) {
   case 'political group':
     return 'Parlamentní klub';
   case 'committee':
     return 'Výbor';
   case 'commission':
     return 'Komise';
   case 'subcommittee':
     return 'Podvýbor';
   case 'friendship group':
     return 'Skupina přátel';
   case 'delegation':
     return 'Delegace';
   case 'working group':
     return 'Pracovní skupina';
   case 'verifier':
     return 'Ověřovatelé';
   default:
     return $gkc;
 }
}


?>
