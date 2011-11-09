<?php
require '../../config/settings.php';
require '../../setup.php';

// get representatives for the given address and parliament(s)
$params = $_GET;
$params['lang'] = $locale['lang'];
if (isset($_SESSION['parliament']) && !empty($_SESSION['parliament']))
	$params['parliament'] = $_SESSION['parliament'];
$api_wtt = new ApiDirect('wtt');
$representatives = $api_wtt->read('AddressRepresentative', $params);

// fix parliaments where no representative has been found but there should be at least one
fix_global_parliaments($representatives);

// show an encouragement to participate and to add contact data for missing local and regional parliaments
fix_local_parliaments($representatives, $params);

// format the found representatives into HTML
$smarty = new SmartyWtt;
$smarty->assign('representatives', $representatives['parliament']);
$smarty->display('ajax/address_representatives.tpl');

// store locality to be prefilled in the write message form
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

	$parliaments_restriction = isset($_SESSION['parliament']) ? explode('|', $_SESSION['parliament']) : array();

	foreach ($global_parliaments_to_fix as $parl_code => $remove_fields)
	{
		// check if the parliament is in the search results
		$parl_present = false;
		foreach ($representatives['parliament'] as $parl)
			if ($parl['code'] == $parl_code)
				$parl_present = true;

		if (!$parl_present && (empty($parliaments_restriction) || in_array($parl_code, $parliaments_restriction)))
		{
			// remove some address fields and search representatives of this parliament again
			$get = $_GET;
			foreach ($remove_fields as $field)
				unset($get[$field]);
			$get['parliament'] = $parl_code;
			$parl_reps = $api_wtt->read('AddressRepresentative', $get);
			if (empty($parl_reps['parliament'])) continue;

			// insert the parliament into the results
			insert_to_representatives($parl_reps['parliament'][0], $representatives);
		}
	}
}

/*
 * Checks if a local as well as a regional parliament is present in the results.
 * If not, it inserts an empty parliament instead of the missing one into the results.
 * The inserted empty parliament shows an encouragement to participate
 * and to add the missing representatives.
 */
function fix_local_parliaments(&$representatives, $params)
{
	// skip the fix in case that the search was explicitly restricted to particular parliaments
	if (isset($params['parliament'])) return;

	// check if local and regional parliaments are present
	$local_present = $regional_present = false;
	foreach ($representatives['parliament'] as $parl)
	{
		$local_present |= ($parl['kind'] == 'local');
		$regional_present |= ($parl['kind'] == 'regional');
	}

	// get weights of those parliament kinds
	$api_data = new ApiDirect('data');
	$parl_kinds = $api_data->read('ParliamentKind');
	foreach ($parl_kinds as $pk)
	{
		if ($pk['code'] == 'local')
			$local_weight = $pk['weight'];
		if ($pk['code'] == 'regional')
			$regional_weight = $pk['weight'];
	}

	// add encouragement for local parliament
	if (!$local_present && isset($params['locality']))
	{
		$local_parl = array(
			'code' => 'missing-local',
			'name' => $params['locality'],
			'kind' => 'local',
			'competence' => _("We don't know representatives of your town.") . ' ' .
				_('You can simply add them and give the option to contact them to the public. See <a href="http://community.kohovolit.eu/doku.php/wtt:external-datasets" target="_blank">how to do it</a>.'),
			'weight' => $local_weight,
			'constituency' => array()
		);
		insert_to_representatives($local_parl, $representatives);
	}

	// add encouragement for regional parliament
	if (!$regional_present && isset($params['administrative_area_level_1']))
	{
		$regional_parl = array(
			'code' => 'missing-regional',
			'name' => sprintf(_('Region %s'), $params['administrative_area_level_1']),
			'kind' => 'regional',
			'competence' => _("We don't know representatives of your region.") . ' ' .
				_('You can simply add them and give the option to contact them to the public. See <a href="http://community.kohovolit.eu/doku.php/wtt:external-datasets" target="_blank">how to do it</a>.'),
			'weight' => $regional_weight,
			'constituency' => array()
		);
		insert_to_representatives($regional_parl, $representatives);
	}
}

/*
 * Inserts representatives of a parliament into a representatives structure respecting the parliament's weight.
 */
function insert_to_representatives($parliament, &$representatives)
{
	$i = 0;
	while ($i < count($representatives['parliament']) &&
		($representatives['parliament'][$i]['weight'] < $parliament['weight'] ||
			$representatives['parliament'][$i]['weight'] == $parliament['weight'] && $representatives['parliament'][$i]['code'] < $parliament['code']))
		$i++;
	array_splice($representatives['parliament'], $i, 0, array($parliament));
}

?>
