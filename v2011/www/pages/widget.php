<?php
/**
* generates widget
*/
require '../../config/settings.php';
require '../../setup.php';
generate_widget();

function generate_widget($data = array()) {

  //new smarty
  $smarty = new SmartyNapisteJimCz;

  $data = array(
    'width' => 200,
    'height' => 200,
    'img_width' => 190,
    'img_height' => 100,
    'project' => 'napistejim.cz',
    'projectname' => 'NapišteJim.cz',
    'text1' => 'Vaše město, vesnice ...',
    'text2' => 'Psát Vašim politikům',
  );
  $smarty->assign('data',$data);
  $smarty->display('widget_box_1.tpl');
}
?>
