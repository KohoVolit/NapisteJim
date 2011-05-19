<?php

require_once '../config/settings.php';

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
		if (isset($_GET['mp']))
			write_page();
		else if (isset($_GET['address']) || isset($_GET['constituency']) || isset($_GET['political_group']) || isset($_GET['committee']) || isset($_GET['commission']) || isset($_GET['delegation']))
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
	// ... process search criteria
	// ... perform database search
	
	$smarty = new SmartyNapisteJimCz;
	$smarty->display('search_results.tpl');
}

function write_page()
{
	// ... process given MPs
	// ... perform database query form details about the MPs
	
	$smarty = new SmartyNapisteJimCz;
	$smarty->display('write.tpl');
}

function confirm_page()
{
	// ...
}

function messages_page()
{
	// ...
}

// function declaration
function do_translation ($params, $content, $smarty, &$repeat, $template)
	{
	if (isset($content)) {
	$lang = $params["lang"];
	// do some translation with $content
	return $translation;
	}
}


?>
