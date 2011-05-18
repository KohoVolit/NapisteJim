<?php

const NAPISTEJIM_ROOT = '/home/shared/napistejim.cz';
const SMARTY_DIR = '/usr/local/lib/Smarty/';
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Europe/Prague');

set_include_path(NAPISTEJIM_ROOT . PATH_SEPARATOR . get_include_path());

function napistejimcz_autoload($class_name)
{
    if (file_exists(NAPISTEJIM_ROOT . "/classes/$class_name.php"))
		require_once "classes/$class_name.php";
}
spl_autoload_register('napistejimcz_autoload');

?>
