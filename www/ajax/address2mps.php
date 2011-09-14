<?php
require '../../config/settings.php';
require '../../setup.php';

//get array with mps
$api_wtt = new ApiDirect('wtt');
$res = $api_wtt->read('AddressRepresentative', $_GET);
$api_data = new ApiDirect('data');

//check for known problems in parliaments/areas and correct them
$res = parl_zero_constit($api_wtt, $_GET, $res, $parl_zero_constit);

//new smarty
$smarty = new SmartyWtt;

//Language
// Set language to LOCALE
putenv('LC_ALL='. LOCALE);
setlocale(LC_ALL, LOCALE);
// Specify location of translation tables
bindtextdomain(LOCALIZED_DOMAIN, LOCALE_DIR);
// Choose domain
textdomain(LOCALIZED_DOMAIN);

//reorder parliaments, rule: as set in $parl_order
$data = $res['parliament'];
foreach((array) $data as $key => $parl) {
  if (array_key_exists($parl['code'], $parl_order))
    $data[$key]['order'] = $parl_order[$parl['code']]['weight'];
  else
    $data[$key]['order'] = $key;
}
$data = order_array($data, 'order', SORT_ASC);

//for each parliament
foreach ((array)$data as $pkey => $parliament) {
  //more constituencies?
   if (count($parliament['constituency']) > 1) {
	  //reorder constituencies, rule: according to distance of closest mp
	  foreach((array)$parliament['constituency'] as $ckey => $constituency) {
		$constituency['distance'] = my_coalesce($constituency['group'][0]['mp'][0]['office_distance'],6378);
		foreach((array)$constituency['group'] as $group) {
		  $constituency['distance'] = min($constituency['distance'],my_coalesce($group['mp'][0]['office_distance'],6378));
		}
		$parliament['constituency'][$ckey] = $constituency;
	  }
	  $parliament['message'] = _('We were not able to recognize exactly which constituency your address belongs to.');
	  $one_constit = false;
  } else {
    $parliament['message'] = '';
    $parliament['constituency'][0]['distance'] = 0;
    $one_constit = true;
  }

  $parliament['constituency'] = order_array($parliament['constituency'], 'distance', SORT_ASC);

  //for each constituency
  foreach((array) $parliament['constituency'] as $ckey => $constituency) {
    //reorder groups, rule: number of mps
    foreach($constituency['group'] as $gkey => $group) {
      $group['count'] = count($group['mp']);
      $group['friendly_name'] = friendly_url($group['name'],LOCALE);
      //add mp info
      foreach($group['mp'] as $mkey=> $mp) {
        $mp['info'] = make_mp_info($mp, $parl_order[$parliament['code']]['info'], $one_constit, $api_data);
        
        $group['mp'][$mkey] = $mp;
      }
      
      $constituency['group'][$gkey] = $group;
    }
    $constituency['group'] = order_array($constituency['group'], 'count', SORT_DESC); 
   
    $parliament['constituency'][$ckey] = $constituency;
  }
  $parliament['description'] = ''; //popis, co parlament dela, jake topics jim lze psat
      
  $data[$pkey] = $parliament;
}

$smarty->assign('data', $data);
$smarty->display('ajax/address2mps.tpl');

/**
* correct known problems with parliament/constituency/areas
*
* @param $api_wtt ApiDirect('wtt')
* @param $get $_GET
* @param $res current results to be checked
* @param $parl_zero_constit array from settings.php to know, which parliament can be corrected
*
* @return $out new results (as $res)
*/
function parl_zero_constit($api_wtt, $get, $res, $parl_zero_constit) {
  $correction = array();
  $out = $res;
  
  foreach((array)$parl_zero_constit as $key=>$zero_parl) {
    $z_ok = false;
    foreach((array)$res['parliament'] as $parl) {
      if ($parl['code'] == $key) {
        $z_ok = true;
      }
    }
    if (!$z_ok) $correction[] = $zero_parl;
  }
  
  foreach ($correction as $c) {
    switch($c) {
	    case 'cz/senat':
	      if (isset($get['sublocality'])) {
	        unset($get['sublocality']);
	        $out = $api_wtt->read('AddressRepresentative', $get);
	      }
	  }
  }
  return $out;
}

/**
* make mp info
*
* @param $array
*
* @out mp info (string)
*/
function make_mp_info($mp, $array, $one_constit, $api_data) {
  $out = '';
  foreach ((array) $array as $item) {
    if (($item == 'office_distance') and ($item != ''))
      $out .= round($mp[$item],0) . '&nbsp;km&nbsp;';
    else
      if (is_numeric($mp[$item][strlen($mp[$item])-1]))	//hack for 'Praha 1'
        $out .= str_replace(' ', '&nbsp;', $mp[$item]) . ';&nbsp;';
      else
        $out .= str_replace(' ', '&nbsp;', $mp[$item]) . '&nbsp;';
  }
  if (!$one_constit) {
    $date = new DateTime('now');
    $mp_in_group = $api_data->read('MpInGroup', array('mp_id' => $mp['id'], 'role_code' => 'member', '#datetime' => $date->format('Y-m-d H:i:s')));
    foreach((array) $mp_in_group as $mig) {
      if ($mig['constituency_id'] > 0) {
        $group = $api_data->readOne('Group', array('id' => $mig['group_id']));
        if ($group and ($group['parliament_code'] == $mp['parliament_code'])) {
          $constit = $api_data->readOne('Constituency', array('id' => $mig['constituency_id']));
          $out .= $constit['name'];
          if ($constit['description'] != '')
            $out .= ': ' . $constit['description'];
        }
      }
    }
  }
  return trim($out);
}

/**
* function to order array according its one column
*
* @param $array
* @param $column
*
* @result $out sorted array
*/
function order_array($data, $column, $sort_order) {
	// Obtain a list of columns
	$order = array();
	foreach ((array)$data as $key => $row) {
		$order[$key]  = $row[$column];
	}
	// Sort the data with volume descending, edition ascending
	// Add $data as the last parameter, to sort by the common key
	array_multisort($order, $sort_order, $data);
	return $data;
}

/**
* creates "friendly url" version of text, translits string (gets rid of diacritics) and substitutes ' ' for '-', etc.
* @return friendly url version of text
* example:
* friendly_url('klub ČSSD')
*     returns 'klub-cssd'
*/
function friendly_url($text, $locale = 'cs_CZ.utf-8') {
    $old_locale = setlocale(LC_ALL, '0');
setlocale(LC_ALL, $locale);
$url = $text;
$url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
$url = trim($url, '-');
$url = iconv('utf-8', 'us-ascii//TRANSLIT', $url);
$url = strtolower($url);
$url = preg_replace('~[^-a-z0-9_]+~', '', $url);
setlocale(LC_ALL, $old_locale);
return $url;
}

/**
* my coalesce
*
* @param $value original value
* @param $replace_value new value
*
* @return coalesce
*/
function my_coalesce($value, $replace_value) {
  if ($value == '')
    return $replace_value;
  else
    return $value;
}
?>
