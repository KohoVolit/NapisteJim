<?php

set_include_path(WTT_DIR . PATH_SEPARATOR . get_include_path());

// set autoloading function for classes
function wtt_autoload($class_name)
{
    if (file_exists(WTT_DIR . "/classes/$class_name.php"))
		require_once "classes/$class_name.php";
}
spl_autoload_register('wtt_autoload');

// store URL parameters that should be persistent to the session
session_start();
if (isset($_GET['parliament']))
	$_SESSION['parliament'] = $_GET['parliament'];
if (isset($_GET['locale']))
	$_SESSION['locale'] = $_GET['locale'];

// choose locale according to locale stored in session
if (isset($_SESSION['locale']) && array_key_exists($_SESSION['locale'], $locales))
	$locale = $locales[$_SESSION['locale']];
else
	$locale = reset($locales);

mb_internal_encoding('UTF-8');
date_default_timezone_set($locale['time_zone']);

// set locale
putenv('LC_ALL=' . $locale['system_locale']);
setlocale(LC_ALL, $locale['system_locale']);
bindtextdomain(GETTEXT_DOMAIN, LOCALE_DIR);
textdomain(GETTEXT_DOMAIN);

?>
