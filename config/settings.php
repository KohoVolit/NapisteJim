<?php

const NAPISTEJIM_ROOT = '/var/www/michal/napistejim.cz';
const SMARTY_DIR = '/usr/local/lib/php/Smarty/';
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Europe/Prague');
const LOCALE = 'cs_CZ.UTF8';	//note: must be with capital UTF8, not utf8
const LOCALE_DIR = "./locale";	//with respect to index.php
const LOCALIZED_DOMAIN = 'messages';	//name of translation files

set_include_path(NAPISTEJIM_ROOT . PATH_SEPARATOR . get_include_path());

function napistejimcz_autoload($class_name)
{
    if (file_exists(NAPISTEJIM_ROOT . "/classes/$class_name.php"))
		require_once "classes/$class_name.php";
}
spl_autoload_register('napistejimcz_autoload');

?>
