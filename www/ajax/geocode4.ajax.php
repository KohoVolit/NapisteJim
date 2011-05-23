<?php
 //print_r($_GET);
 /*foreach ((array) $_GET as $key=>$item) {
   echo $key . ': '. $item . '<br/>';
 }*/
 $mps_str = 'Petr,Jalowiczor,ČSSD,cssd,Třinec,30.125,1
Václav,Klučka,ČSSD,cssd,Opava,25.18,2
Alfréd,Michalík,ČSSD,cssd,Bohumín,12.15,3
Adam,Rykala,ČSSD,cssd,Ostrava,100,4
Ladislav,Šincl,ČSSD,cssd,Karviná,12.35,5
Dana,Váhalová,ČSSD,cssd,Nový Jičín,48,6
Ladislav,Velebný,ČSSD,cssd,Bruntál,16,7
Lubomír,Zaorálek,ČSSD,cssd,Ostrava,19,8
Pavel,Drobil,ODS,ods,Ostrava,22,9
Jaroslav,Krupka,ODS,ods,Karviná,28,10
Zbyněk,Stanjura,ODS,ods,Ostrava,13,11
Igor,Svoják,ODS,ods,Frýdek-Místek,19,12
Jaroslava,Wenigerová,ODS,ods,Ostrava,16,13
Milada,Halíková,KSČM,kscm,Karviná,12.7,14
Kateřina,Konečná,KSČM,kscm,Nový Jičín,58,15
Miroslav,Opálka,KSČM,kscm,Opava,99,16
Ludmila,Bubeníková,TOP09-S,top09-s,Ostrava,13.9,17
Pavol,Lukša,TOP09-S,top09-s,Ostrava,18.9,18
Renáta,Witoszová,TOP09-S,top09-s,Ostrava,64,19
Jana,Drastichová,VV,vv,Orlová,32,20
Jiří,Rusnok,VV,vv,Třinec,16,21
Kristýna,Kočí,Nezařazení,nezarazeni,Ostrava,12,22';
$mps_ar = explode("\n",$mps_str);
foreach ((array) $mps_ar as $row) {
  $mp_ar = explode(',',$row);
  //mp
  $mp[] = array('first_name' => $mp_ar[0], 'last_name' => $mp_ar[1], 'group' => $mp_ar[2], 'group_friendly' => $mp_ar[3], 'town' => $mp_ar[4], 'km' => $mp_ar[5], 'mp_id' => $mp_ar[6]);
  //group
  $groups[$mp_ar[3]]['group_friendly'] = $mp_ar[3];
  $groups[$mp_ar[3]]['group'] = $mp_ar[2];
  if (isset($groups[$mp_ar[3]]['number'])) $groups[$mp_ar[3]]['number'] ++; else $groups[$mp_ar[3]]['number'] = 1;
  //mp in group
  $mp_group[$mp_ar[3]][] = array('first_name' => $mp_ar[0], 'last_name' => $mp_ar[1], 'group' => $mp_ar[2], 'group_friendly' => $mp_ar[3], 'town' => $mp_ar[4], 'km' => $mp_ar[5], 'mp_id' => $mp_ar[6]);
  
}
//sort groups
foreach ((array) $groups as $key => $row) {
    $sort[$key]  = $row['number'];
}
array_multisort($sort, SORT_DESC, $groups);

//start printing psp
echo "<div id='parliament-psp/cz' class='parliament'>
	<div id='parliament-psp/cz-head' class='parliament-head'>Poslanecká sněmovna</div>
	<div id='parliament-psp/cz-body' class='parliament-body'>";

//print groups
foreach ((array) $groups as $group) {
  echo "<div id='group-{$group['group_friendly']}' class='group'>";
  echo " <img src='/images/1x1.png' class='party-logo-{$group['group_friendly']} party-logo' title='{$group['group']}' alt='{$group['group']}' />";
  echo "  <div class='group-mps'>";
  foreach((array) $mp_group[$group['group_friendly']] as $row) {
    echo "<div class='mp-{$row['mp_id']} mp draggable' id='1-{$row['mp_id']}'>";
    echo "  <img src='/images/1x1.png'  id='1mp-toggle-{$row['mp_id']}'  class='mp-toggle-{$row['mp_id']} mp-toggle mp-toggle-off' />";
    echo "  <span class='mp-name-{$row['mp_id']} mp-name'>{$row['last_name']} ({$row['town']})</span>";
    echo "</div>";
  }
  echo "  </div>";
  echo "</div>";
}

//sort mps
foreach ((array) $mp as $key => $row) {
    $mp_sort[$key]  = $row['km'];
}
array_multisort($mp_sort, SORT_ASC, $mp);
//print ordered by km
$max = 10;
$i = 1;
echo "<div id='group-km' class='group'>";
echo " <img src='img/1x1.png' class='group-logo-km group-logo' title='Dle vzdálenosti' alt='Dle vzdálenosti' />";
echo "  <div class='group-mps'>";
foreach((array) $mp as $row) {
  if ($i > $max) 
    continue;
  echo "<div class='mp-{$row['mp_id']} mp draggable' id='2-{$row['mp_id']}'>";
    echo "  <img src='1x1.png' id='2mp-toggle-{$row['mp_id']}' class='mp-toggle-{$row['mp_id']} mp-toggle mp-toggle-off' />";
    $tmp = round($row['km'],0);
    echo "  <span class='mp-name-{$row['mp_id']} mp-name'>{$row['last_name']} ({$row['town']},{$tmp}km)</span>";
    echo "</div>";
    $i++;
  
}
echo '...';
echo "  </div>";
echo "</div>";

//final of psp
echo "</div></div>";

//start senate
echo "<div id='parliament-senat/cz' class='parliament'>
	<div id='parliament-senat/cz-head' class='parliament-head'>Senát</div>
	<div id='parliament-senat/cz-body' class='parliament-body'>";
echo "<div id='group-cz/senat-1' class='group'>";
echo " <img src='img/1x1.png' class='group-logo-senat group-logo' title='Senát' alt='Senát' />";
echo "  <div class='group-mps'>";
echo "<div class='mp-99 mp draggable' id='3-99'>";
    echo "  <img src='1x1.png' id='2mp-toggle-99' class='mp-toggle-99 mp-toggle mp-toggle-off' />";
    echo "  <span class='mp-name-99 mp-name'>Senátor (Frýdek-Místek)</span>";
    echo "</div></div></div>";
echo "</div></div>";

?>
