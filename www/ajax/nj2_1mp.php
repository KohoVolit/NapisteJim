<?php

echo $_GET['id'];
echo "
<div id='mp-in-box-{$_GET['id']}' class='mp-in-box'>
  <div class='mp-photo'>
    <img src='xxx' />
  </div>
  <div class='mp-in-box'>Jméno Příjmení</div>
  <div class='mp-in-box-deselect'>X</div>
</div>
";
?>
