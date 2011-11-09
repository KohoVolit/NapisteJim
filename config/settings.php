<?php

// instalation settings
const WTT_DIR = '/home/shared/napistejim.cz';
const API_DIR = '/home/shared/api.kohovolit.eu';
const API_FILES_URL = 'http://api.kohovolit.eu/files';
const SMARTY_DIR = '/usr/local/lib/php/Smarty/libs/';

define("WTT_LOGS_DIR", WTT_DIR . '/logs');

// domain and service e-mail addresses
const WTT_TITLE = 'NapišteJim.cz';
const WTT_HOST = 'napistejim.cz';
const CONTACT_EMAIL = 'info@kohovolit.eu';
const FROM_EMAIL = 'neodpovidejte@napistejim.cz';
const BCC_EMAIL = 'napistejim.cz@gmail.com';
const ADMIN_EMAIL = 'jaroslav_semancik@yahoo.com';
const REVIEWER_EMAIL = 'marek@nasipolitici.cz';
const ORDER_NEWSLETTER_EMAIL = 'marek@nasipolitici.cz';

// error reporting
error_reporting(0);

// Google geocoding restriction to a country
const COUNTRY_NAME = 'Česká republika';
const COUNTRY_CODE = 'cz';

// address field required in the result of Google geocoding to treat the input address as complete (reverse geocoding is used otherwise)
const REQUIRED_ADDRESS_LEVEL = 'administrative_area_level_2';

// Google map viewport
const MAP_CENTER_LAT = 50;
const MAP_CENTER_LNG = 15;
const MAP_ZOOM = 5;

// available locales
$locales = array(
	'cs_CZ' => array('lang' => 'cs', 'system_locale' => 'cs_CZ.utf8', 'date_format' => '%-d. %-m. %Y', 'time_zone' => 'Europe/Prague'),
	'en_US' => array('lang' => 'en', 'system_locale' => 'en_US.utf8', 'date_format' => '%Y-%m-%d', 'time_zone' => 'GMT')
);

$global_parliaments_to_fix = array(
	'cz/senat' => array('sublocality')
);

?>
