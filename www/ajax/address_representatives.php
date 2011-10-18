<?php
require '../../config/settings.php';
require '../../setup.php';

// get representatives for the given address and parliament(s)
$params = $_GET;
if (isset($_SESSION['parliament']) && !empty($_SESSION['parliament']))
	$params['parliament'] = $_SESSION['parliament'];
$api_wtt = new ApiDirect('wtt');
$representatives = $api_wtt->read('AddressRepresentative', $params);

// fix parliaments where no representative has been found but there should be at least one
fix_global_parliaments($representatives);

// format the found representatives into HTML
$smarty = new SmartyWtt;
$smarty->assign('representatives', $representatives['parliament']);
$smarty->display('ajax/address_representatives.tpl');

// store locality to prefill in the write message form
if (isset($_GET['locality']))
	$_SESSION['locality'] = $_GET['locality'];


/*
 * Checks if all parliaments in global variable \c $global_parliaments_to_fix are present in the search results
 * and if not, they are searched for representatives with reduced address again and inserted to the results.
 *
 * This function is to fix some discrepancies between Google geocoding results and
 * constituencies' areas specification in some parliaments (e.g. Czech senate).
 */
function fix_global_parliaments(&$representatives)
{
	global $global_parliaments_to_fix, $api_wtt;

	foreach ($global_parliaments_to_fix as $parl_code => $remove_fields)
	{
		// check if the parliament is in the search results
		$parl_present = false;
		foreach ($representatives['parliament'] as $parl)
			if ($parl['code'] == $parl_code)
				$parl_present = true;

		if (!$parl_present)
		{
			// remove some address fields and search representatives of this parliament again
			$get = $_GET;
			foreach ($remove_fields as $field)
				unset($get[$field]);
			$get['parliament'] = $parl_code;
			$parl_reps = $api_wtt->read('AddressRepresentative', $get);
			if (empty($parl_reps['parliament'])) continue;

			// insert the parliament into the results sorted by weight
			$i = 0;
			while ($i < count($representatives['parliament']) &&
				($representatives['parliament'][$i]['weight'] < $parl_reps['parliament'][0]['weight'] ||
					$representatives['parliament'][$i]['weight'] == $parl_reps['parliament'][0]['weight'] && $representatives['parliament'][$i]['code'] < $parl_reps['parliament'][0]['code']))
				$i++;
			array_splice($representatives['parliament'], $i, 0, $parl_reps['parliament']);
		}
	}
}

?>
