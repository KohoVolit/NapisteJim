<?php
require '../../config/settings.php';
require '../../setup.php';
require '../../utils.php';

if (!isset($_GET['terms']) || empty($_GET['terms'])) return;

// get names of all MPs matching the search terms
$api_napistejim = new ApiDirect('napistejim');
$names = $api_napistejim->read('MpName', array('terms' => $_GET['terms']));

// sort by name using locale-correct sorting
usort($names, 'cmp_by_name');

// format the names
$formated_names = array();
foreach ($names as $name)
	$formated_names[] = array('name' => format_personal_name($name), 'disambiguation' => $name['disambiguation']);

// return the result in JSON or JSONP format
$result = json_encode($formated_names);
if (isset($_GET['callback']))
	$result = $_GET['callback'] . '(' . $result . ');';
echo $result;

function cmp_by_name($a, $b)
{
	$res = strcoll($a['last_name'], $b['last_name']);
	if ($res != 0) return $res;
	$res = strcoll($a['first_name'], $b['first_name']);
	if ($res != 0) return $res;
	$res = strcoll($a['middle_names'], $b['middle_names']);
	if ($res != 0) return $res;
	return strcoll($a['disambiguation'], $b['disambiguation']);
}
?>
