<?php

require '/home/michal/api.kohovolit.eu/www/classes/ApiDirect.php';

try
{  
	$ac = new KV\ApiDirect('kohovolit', array('parliament' => 'cz/psp'));
	
	$res = $ac->read('AddressRepresentatives', array('latitude' => 49.7132821, 'longitude' => 16.2620636, 'country' => 'Česká republika', 'administrative_area_level_1' => 'Pardubický', 'administrative_area_level_2' => 'Svitavy', 'locality' => 'Polička'));
