<?php

set_include_path(WTT_DIR . PATH_SEPARATOR . get_include_path());

// set autoloading function for classes
function wtt_autoload($class_name)
{
    if (file_exists(WTT_DIR . "/classes/$class_name.php"))
		require_once "classes/$class_name.php";
}
spl_autoload_register('wtt_autoload');

// choose locale according to 'locale' parameter in URL
if (isset($_GET['locale']) && array_key_exists($_GET['locale'], $locales))
	$locale = $locales[$_GET['locale']];
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
