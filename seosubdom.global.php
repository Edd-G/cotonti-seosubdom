<?php
/* ====================
[BEGIN_COT_EXT]
Code=seosubdom
File=seosubdom.global
Hooks=global
[END_COT_EXT]
==================== */

/**
 * Seosubdom global part
 *
 * @package Seosubdom
 * @copyright (c) Edward Gabishev
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

if (!defined('COT_CODE')) { die('Wrong URL'); }

require_once cot_incfile('seosubdom', 'plug');
//require_once cot_langfile('seosubdom', 'plug');

if($dom_sql)
{
	foreach($dom_sql as $dom_row)
	{
		$gl_seos_domain = $dom_row['seos_domain'];
		$gl_seos_address_index = $dom_row['seos_address_index'];
		$gl_seos_address_region = $dom_row['seos_address_region'];
		$gl_seos_address_city = $dom_row['seos_address_city'];
		$gl_seos_address_street = $dom_row['seos_address_street'];
		$gl_seos_address_house = $dom_row['seos_address_house'];
		$gl_seos_address_office = $dom_row['seos_address_office'];
		$gl_seos_address_working_days = $dom_row['seos_address_working_days'];
		$gl_seos_address_working_hours = $dom_row['seos_address_working_hours'];
		$gl_seos_phone = $dom_row['seos_phone'] ? $dom_row['seos_phone'] : $cfg['seosubdom']['default_phone'];
		$gl_seos_mail = $dom_row['seos_mail'] ? $dom_row['seos_mail'] : $cfg['seosubdom']['default_mail'];
		$gl_seos_description = $dom_row['seos_description'];
		$gl_seos_video = $dom_row['seos_video'];
		$gl_seos_image = $dom_row['seos_image'];
		$gl_seos_map_coordinate = $dom_row['seos_map_coordinate'];
		$gl_seos_map_coordinate_lat = trim(explode(',', $dom_row['seos_map_coordinate'])[0]);
		$gl_seos_map_coordinate_lon = trim(explode(',', $dom_row['seos_map_coordinate'])[1]);

		// Extrafields
		if (isset($cot_extrafields[$db_seosubdom]))
		{
			foreach ($cot_extrafields[$db_seosubdom] as $gl_seos_exfld)
			{
				${'gl_seos_' . $gl_seos_exfld['field_name']} = cot_build_extrafields_data('seosubdom', $gl_seos_exfld, $dom_row['seos_' . $gl_seos_exfld['field_name']]);
				${'gl_seos_' . $gl_seos_exfld['field_name'] . '_title'} = isset($L['seos_' . $gl_seos_exfld['field_name'] . '_title']) ? $L['seos_' . $gl_seos_exfld['field_name'] . '_title'] : $gl_seos_exfld['field_description'];
			}
		}
	}
}
else
{
	$gl_seos_domain = 'default_domain';
	$gl_seos_address_index = $cfg['plugin']['seosubdom']['default_address_index'];
	$gl_seos_address_region = $cfg['plugin']['seosubdom']['default_address_region'];
	$gl_seos_address_city = $cfg['plugin']['seosubdom']['default_address_city'];
	$gl_seos_address_street = $cfg['plugin']['seosubdom']['default_address_street'];
	$gl_seos_address_house = $cfg['plugin']['seosubdom']['default_address_house'];
	$gl_seos_address_office = $cfg['plugin']['seosubdom']['default_address_office'];
	$gl_seos_address_working_days = $cfg['plugin']['seosubdom']['default_address_working_days'];
	$gl_seos_address_working_hours = $cfg['plugin']['seosubdom']['default_address_working_hours'];
	$gl_seos_phone = $cfg['plugin']['seosubdom']['default_phone'];
	$gl_seos_mail = $cfg['plugin']['seosubdom']['default_mail'];
	$gl_seos_description = cot_parse($cfg['plugin']['seosubdom']['default_description']);
	$gl_seos_video = $cfg['plugin']['seosubdom']['default_video'];
	$gl_seos_image = $cfg['plugin']['seosubdom']['default_image'];
	$gl_seos_map_coordinate = $cfg['plugin']['seosubdom']['default_map_coordinate'];
	$gl_seos_map_coordinate_lat = trim(explode(',', $cfg['plugin']['seosubdom']['default_map_coordinate'])[0]);
	$gl_seos_map_coordinate_lon = trim(explode(',', $cfg['plugin']['seosubdom']['default_map_coordinate'])[1]);
}

// use Morphos namespace
use morphos\Russian\GeographicalNamesInflection;
if (cot_plugin_active('morphos')) {

	// add Morphos
	require_once cot_incfile('morphos', 'plug', 'functions');

	$gl_seos_address_city_rod = GeographicalNamesInflection::getCase($gl_seos_address_city, 'родительный');
	$gl_seos_address_city_dat = GeographicalNamesInflection::getCase($gl_seos_address_city, 'дательный');
	$gl_seos_address_city_vin = GeographicalNamesInflection::getCase($gl_seos_address_city, 'винительный');
	$gl_seos_address_city_tvo = GeographicalNamesInflection::getCase($gl_seos_address_city, 'творительный');
	$gl_seos_address_city_pre = GeographicalNamesInflection::getCase($gl_seos_address_city, 'предложный');

	$gl_seos_address_region_rod = GeographicalNamesInflection::getCase($gl_seos_address_region, 'родительный');
	$gl_seos_address_region_dat = GeographicalNamesInflection::getCase($gl_seos_address_region, 'дательный');
	$gl_seos_address_region_vin = GeographicalNamesInflection::getCase($gl_seos_address_region, 'винительный');
	$gl_seos_address_region_tvo = GeographicalNamesInflection::getCase($gl_seos_address_region, 'творительный');
	$gl_seos_address_region_pre = GeographicalNamesInflection::getCase($gl_seos_address_region, 'предложный');
}
