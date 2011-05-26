<?php

set_include_path(WTT_DIR . PATH_SEPARATOR . get_include_path());

function wtt_autoload($class_name)
{
    if (file_exists(WTT_DIR . "/classes/$class_name.php"))
		require_once "classes/$class_name.php";
}
spl_autoload_register('wtt_autoload');

mb_internal_encoding('UTF-8');

// ajax address2mps settings
$parl_order = array(
'cz/psp' => array('weight' => -100, 'info' => array('office_town','office_distance')),
'cz/senat' => array('weight' => -99, 'info' => array()),
);

$parl_zero_constit = array( //in case no constituency is found
  'cz/senat' => true,
);

?>
