<?php

set_include_path(NJ_DIR . PATH_SEPARATOR . get_include_path());

// set autoloading function for classes
function napistejim_autoload($class_name)
{
    if (file_exists(NJ_DIR . "/classes/$class_name.php"))
		require_once "classes/$class_name.php";
}
spl_autoload_register('napistejim_autoload');

// set locale
if (defined('USE_SESSION'))
{
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
}
else
	$locale = reset($locales);

mb_internal_encoding('UTF-8');
date_default_timezone_set($locale['time_zone']);

putenv('LC_ALL=' . $locale['system_locale']);
setlocale(LC_ALL, $locale['system_locale']);
bindtextdomain('messages', NJ_DIR . '/www/locale');
textdomain('messages');

?>
