<?php

require '../config/settings.php';
require '../setup.php';

//Language
// Set language to LOCALE
putenv('LC_ALL='. LOCALE);
setlocale(LC_ALL, LOCALE);
// Specify location of translation tables
bindtextdomain(LOCALIZED_DOMAIN, LOCALE_DIR);
// Choose domain
textdomain(LOCALIZED_DOMAIN);

$page = isset($_GET['page']) ? $_GET['page'] : null;
switch ($page)
{
	case 'about':
	case 'faq':
	case 'privacy':
	case 'contact':
		static_page($page);
		break;

	case 'confirm':
		confirm_page();
		break;

	case 'list':
		messages_page();
		break;

	default:
		if (!empty($_POST))
			send_page();
		if (isset($_GET['mp']))
			write_page();
		else if (isset($_GET['name']) || isset($_GET['address']) || isset($_GET['constituency']) || isset($_GET['political_group']) || isset($_GET['committee']) || isset($_GET['commission']) || isset($_GET['delegation']))
			search_results_page();
		else if (isset($_GET['advanced']))
			static_page('advanced_search');
		else
			static_page('search');
}

function static_page($page)
{
	$smarty = new SmartyNapisteJimCz;
	$smarty->assign('locale', LOCALE);
	$smarty->display($page . '.tpl');
}

function search_results_page()
{
	$smarty = new SmartyNapisteJimCz;
	$smarty->assign('locale', LOCALE);
	$smarty->assign('lang', SEARCH_LANGUAGE);
	$smarty->assign('reg', SEARCH_REGION);
	$smarty->assign('parent_region', SEARCH_PARENT_REGION);
	$smarty->assign('parent_region_type', SEARCH_PARENT_REGION_TYPE);
	$smarty->assign('region_check', SEARCH_REGION_CHECK);
	$smarty->assign('lat', CENTER_LAT);
	$smarty->assign('lng', CENTER_LNG);
	$smarty->assign('zoom', ZOOM);
	$smarty->assign('address', $_GET['address']);
	$smarty->display('search_results.tpl');
}

function write_page()
{
	$ad = new ApiDirect('napistejim');
	$mp_details = $ad->read('MpDetails', array('mp' => $_GET['mp']));

	$smarty = new SmartyNapisteJimCz;
	$smarty->assign('locale', LOCALE);
	$smarty->assign('mps', $_GET['mp']);
	$smarty->assign('mp', $mp_details);
	$smarty->display('write.tpl');
}

function send_page()
{
}

function confirm_page()
{
	// ...
}

function messages_page()
{
	// ...
}

?>
