<?php

set_include_path(WTT_DIR . PATH_SEPARATOR . get_include_path());

function wtt_autoload($class_name)
{
    if (file_exists(WTT_DIR . "/classes/$class_name.php"))
		require_once "classes/$class_name.php";
}
spl_autoload_register('wtt_autoload');

?>
