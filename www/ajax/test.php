<?php

require '/home/michal/napistejim.cz/classes/ApiDirect.php';
const API_DIR = '/home/michal/api.kohovolit.eu/www';

 
	$ad = new ApiDirect('kohovolit');
	
	$adn = new ApiDirect('napistejim');
	
	$res = $adn->read('SearchMps', array('constituency' => 9, 'groups' => array(40, 92)));
	print_r($res);die();
	
	
	//$res = $ad->read('AddressRepresentatives', array('latitude' => 49.7132821, 'longitude' => 16.2620636, 'administrative_area_level_1' => 'Hlavní město Praha','administrative_area_level_2' => 'Hlavní město Praha','locality' => 'Praha', 'sublocality' => 'Praha 2', 'neighborhood'=>'Vyšehrad', 'nic'=>'nic'));
	//'administrative_area_level_1' => 'Moravskoslezský',, 'administrative_area_level_2' => 'Ostrava', 'locality' => 'Ostrava'
	$res = $ad->read('Term', array('datetime' => '2011-05-25'));
	print_r($res);
	
?>
