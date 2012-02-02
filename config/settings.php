<?php

// instalation settings
const NJ_DIR = '/home/shared/napistejim.cz';
const API_DIR = '/home/shared/api.kohovolit.eu';
const API_FILES_URL = 'http://api.kohovolit.eu/files';
const SMARTY_DIR = '/usr/local/lib/php/Smarty/libs/';

define("NJ_LOGS_DIR", NJ_DIR . '/logs');

// domain and service e-mail addresses
const NJ_TITLE = 'NapišteJim.cz';
const NJ_HOST = 'napistejim.cz';
const CONTACT_EMAIL = 'info@kohovolit.eu';
const FROM_EMAIL = 'neodpovidejte@napistejim.cz';
const BCC_EMAIL = 'napistejim.cz@gmail.com';
const ADMIN_EMAIL = 'jaroslav_semancik@yahoo.com';
const REVIEWER_EMAIL = 'kamil.gregor@gmail.com';
const ORDER_NEWSLETTER_EMAIL = 'kamil.gregor@gmail.com';

// error reporting
error_reporting(0);

// Google geocoding restriction to a country
const COUNTRY_NAME = 'Česká republika';
const COUNTRY_CODE = 'cz';

// code of the language the constituency areas in the database are specified in
const AREAS_LANGUAGE = 'cs';

// address field required in the result of Google geocoding to treat the input address as complete (reverse geocoding is used otherwise)
const REQUIRED_ADDRESS_LEVEL = 'administrative_area_level_2';

// Google map viewport
const MAP_CENTER_LAT = 50;
const MAP_CENTER_LNG = 15;
const MAP_ZOOM = 5;

// available locales
$locales = array(
	'cs_CZ' => array('lang' => 'cs', 'system_locale' => 'cs_CZ.utf8', 'date_format' => '%-d. %-m. %Y', 'time_zone' => 'Europe/Prague'),
	'sk_SK' => array('lang' => 'sk', 'system_locale' => 'sk_SK.utf8', 'date_format' => '%-d. %-m. %Y', 'time_zone' => 'Europe/Bratislava'),
	'en_US' => array('lang' => 'en', 'system_locale' => 'en_US.utf8', 'date_format' => '%Y-%m-%d', 'time_zone' => 'GMT')
);

// a fix of discrepancies between Google geocoding and official constituencies' areas in some parliaments
// if no representative is found in these parliaments, remove the given field(s) from entered address and repeat the search again
$global_parliaments_to_fix = array(
	'cz/senat' => array('sublocality')
);

// number of items per page in paged listings
const PAGER_SIZE = 20;

// Google analytics account key
const GOOGLE_ANALYTICS_KEY = 'UA-8592359-2';

// images of the logo
const LOGO_FILENAME = 'logo_cz.png';
const SMALL_LOGO_FILENAME = 'logo_cz_small.png';

// link to promotion video
const PROMOTION_VIDEO = 'http://www.youtube.com/v/UKmMiNxd0xk?version=3';

?>
