<?php

// instalation settings
const WTT_DIR = '/home/shared/napistejim.cz';	//uprav local-server
const API_DIR = '/home/shared/api.kohovolit.eu/www';	//uprav local-server
const SMARTY_DIR = '/usr/local/lib/php/Smarty/libs/';	//uprav local-server (server: /libs/)
const IMG_URL = 'http://cs.kohovolit.eu/data/';

define("WTT_LOGS_DIR", WTT_DIR . '/logs');

const ADMIN_EMAIL = 'jaroslav_semancik@yahoo.com';
const REVIEWER_EMAIL = 'veronika.sumova@gmail.com';
const ORDER_NEWSLETTER_EMAIL = 'veronika.sumova@gmail.com';
const WTT_FROM_MAILBOX = 'neodpovidejte';
const WTT_FROM_HOST = 'napistejim.cz';
const WTT_FROM_NAME = 'NapišteJim.cz';

define("WTT_FROM_EMAIL", WTT_FROM_MAILBOX . '@' . WTT_FROM_HOST);

error_reporting(0);

// COUNTRY SPECIFIC SETTINGS
// locale
date_default_timezone_set('Europe/Prague');
const LOCALE = 'cs_CZ.UTF8';	// note: must be with capital UTF8, not utf8
const LOCALE_DIR = "./locale";	// with respect to index.php
const LOCALIZED_DOMAIN = 'messages';	// name of translation files
const LOCALIZED_DATE_FORMAT = '%-d. %-m. %Y';

// default map
const CENTER_LAT = 50;
const CENTER_LNG = 15;
const ZOOM = 5;

// search restrictions and checks for geocoding
const SEARCH_PARENT_REGION = "Česká republika";	// add to every address
const SEARCH_PARENT_REGION_TYPE = "country";	// for check if outside the region
const SEARCH_LANGUAGE = "cs";
const SEARCH_REGION = "cz";	// usually country, see google maps api documentation
const SEARCH_REGION_CHECK = "administrative_area_level_2";	// if this is not part of the address found by google, address entered is not good enough (but still possible to try reverse geocoding)

?>
