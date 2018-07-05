<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

/**
 * Seosubdom admin
 *
 * @package Seosubdom
 * @copyright (c) Edward Gabishev
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

(defined('COT_CODE') && defined('COT_ADMIN')) or die('Wrong URL.');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('plug', 'seosubdom');
cot_block($usr['isadmin']);

require_once cot_incfile('seosubdom', 'plug');
require_once cot_incfile('seosubdom', 'plug', 'resources');

$filter_rows = $db->query("SELECT seos_address_city FROM $db_seosubdom")->fetchAll();

if($filter_rows)
{
	foreach ($filter_rows as $filter_letter) {
	    $first_letter[] = mb_strtoupper(mb_substr($filter_letter['seos_address_city'], 0, 1));
	}
	$first_letter = array_unique($first_letter);
	sort($first_letter, SORT_STRING);

	// $collator = new Collator('ru_RU');
	// $collator->sort($first_letter);
}

$sort_types = array(
	'seos_id' => $L['Id'],
	'seos_domain' => $L['seos_by_domain'],
	'seos_address_city' => $L['seos_address_city'],
);
$sort_ways = array(
	'asc' => $L['Ascending'],
	'desc' => $L['Descending'],
);

$a = cot_import('a', 'G', 'ALP');
$a = empty($a) || !in_array($a, array('main', 'delete', 'manage')) ? 'main' : $a;
$id = cot_import('id', 'G', 'INT');
$s = cot_import('s', 'G', 'BOL');
$v = cot_import('v', 'G', 'ALP');
$op = cot_import('op', 'G', 'BOL');

/* === Hook === */
foreach (cot_getextplugins('seosubdom.admin.import') as $pl)
{
	include $pl;
}
/* ===== */

list($pg, $d, $durl) = cot_import_pagenav('d', $cfg['maxrowsperpage']);

$filter = cot_import('filter', 'R', 'TXT');
$filter = empty($filter) /*|| !array_key_exists($filter, $filter_types)*/ ? 'all' : $filter;
$sorttype = cot_import('sorttype', 'R', 'ALP');
$sortway = mb_strtolower(cot_import('sortway', 'R', 'ALP'));
$sortway = empty($sortway) || !array_key_exists($sortway, $sort_ways) ? 'asc' : $sortway;
$sqlsorttype = (empty($sorttype) || !array_key_exists($sorttype, $sort_types)) ? 'seos_id' : $sorttype;

$common_params = '&d='.$durl.'&filter='.$filter.'&sorttype='.$sorttype.'&sortway='.$sortway.'&op='.$op;

if($filter_rows)
{
	foreach($first_letter as $first_letter_link) {
	    $fl_link[] = '<li style="display: inline;"><a href="' . cot_url('admin', 'm=other&p=seosubdom&a=main&d='.$durl.'&filter='.$first_letter_link.'&sorttype='.$sorttype.'&sortway='.$sortway.'&op='.$op) . '">' . $first_letter_link . '</a></li>';
	}
	$fl_link[] = '<li style="display: inline;"><a href="' . cot_url('admin', 'm=other&p=seosubdom&a=main&d='.$durl.'&filter=all&sorttype='.$sorttype.'&sortway='.$sortway.'&op='.$op) . '">' . $L['All'] . '</a></li>';
}

/* === Hook === */
foreach (cot_getextplugins('seosubdom.admin.first') as $pl)
{
	include $pl;
}
/* ===== */

$t = new XTemplate(cot_tplfile('seosubdom.admin.'.$a, 'plug', true));

if($a == 'main')
{

	if($filter == 'all')
	{
		$sqlwhere = "1 ";
	}
	else
	{
		$sqlwhere = "seos_address_city LIKE '".$db->prep($filter.'%')."'";
	}

	if($op)
	{
		$limit = "";
	}
	else
	{
		$limit = "LIMIT $d, ".$cfg['maxrowsperpage'];
	}

	$rows = $db->query("SELECT * FROM $db_seosubdom WHERE $sqlwhere ".
		"ORDER BY $sqlsorttype $sortway $limit")->fetchAll();

	/* === Hook === */
	foreach (cot_getextplugins('seosubdom.admin.main.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if($rows)
	{
		$items_on_page = 0;
		foreach($rows as $row)
		{
			$t->assign(array(
				'ADMIN_SEOS_ID' => (int)$row['seos_id'],
				'ADMIN_SEOS_DOMAIN' => htmlspecialchars($row['seos_domain']),
				'ADMIN_SEOS_CITY' => htmlspecialchars($row['seos_address_city']),
				'ADMIN_SEOS_PHONE' => htmlspecialchars($row['seos_phone']),
				'ADMIN_SEOS_DELETE_URL' => cot_confirm_url(cot_url('admin', 'm=other&p=seosubdom&a=delete&id='.(int)$row['seos_id'].$common_params.'&'.cot_xg()), 'seosubdom', 'seos_confirm_delete'), 
				'ADMIN_SEOS_MANAGE_URL' => cot_url('admin', 'm=other&p=seosubdom&a=manage&id='.$row['seos_id'].$common_params),
			));
			$t->parse('MAIN.ADMIN_SEOS_DOMAINS');
			$items_on_page++;
		}
	}
	else
	{
		$items_on_page = 0;
		$t->parse('MAIN.ADMIN_SEOS_NO_DOMAINS');
	}

	$totalitems = $db->query("SELECT COUNT(*) FROM $db_seosubdom WHERE ".$sqlwhere)->fetchColumn();
	$pagenav = cot_pagenav('admin','m=other&p=seosubdom'.$common_params, $d, $totalitems, $cfg['maxrowsperpage'], 'd');
	
	/* === Hook === */
	foreach (cot_getextplugins('seosubdom.admin.main.main') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->assign(array(
		'ADMIN_SEOS_TOTALITEMS' => $totalitems,
		'ADMIN_SEOS_FORM_FILTER_URL' => cot_url('admin', 'm=other&p=seosubdom&a=main'.$common_params),
		'ADMIN_SEOS_ONE_PAGE' => cot_checkbox($op, 'op', $L['seos_admin_onepage'], '', '1', 'seos_admin_onepage'),
		'ADMIN_SEOS_CONFIG_URL' => cot_url('admin', 'm=config&n=edit&o=plug&p=seosubdom'),
		'ADMIN_SEOS_ORDER' => cot_selectbox($sorttype, 'sorttype', array_keys($sort_types), array_values($sort_types), false), 
		'ADMIN_SEOS_WAY' => cot_selectbox($sortway, 'sortway', array_keys($sort_ways), array_values($sort_ways), false),
		'ADMIN_SEOS_PAGENAV_MAIN' => $pagenav['main'],
		'ADMIN_SEOS_PAGENAV_NEXT' => $pagenav['next'],
		'ADMIN_SEOS_PAGENAV_PREV' => $pagenav['prev'],
		'ADMIN_SEOS_ON_PAGE' => $items_on_page,
		'ADMIN_SEOS_FL_LINK' => $filter_rows ? implode('&nbsp;&nbsp;', $fl_link) : '',
	));
}
if($a == 'delete')
{
	cot_check_xg();
	if(seos_delete($id))
	{
		cot_message('seos_delete_success');
	}
	else
	{
		cot_error('seos_delete_fail');
	}
	cot_redirect(cot_url('admin', 'm=other&p=seosubdom'.$common_params, '', true));
}
if($a == 'manage')
{

	if($v == 'update')
	{
		cot_check_xp();
		$rseos = array();
		$rseos['seos_id'] = !empty($id) ? $id : '';
		$rseos['seos_domain'] = cot_import('rseosdomain', 'P', 'TXT');
		$rseos['seos_address_index'] = cot_import('rseosaddressindex', 'P', 'INT');
		$rseos['seos_address_region'] = cot_import('rseosaddressregion', 'P', 'TXT');
		$rseos['seos_address_city'] = cot_import('rseosaddresscity', 'P', 'TXT');
		$rseos['seos_address_street'] = cot_import('rseosaddressstreet', 'P', 'TXT');
		$rseos['seos_address_house'] = cot_import('rseosaddresshouse', 'P', 'TXT');
		$rseos['seos_address_office'] = cot_import('rseosaddressoffice', 'P', 'TXT');
		$rseos['seos_address_working_days'] = cot_import('rseosaddressworkingdays', 'P', 'TXT');
		$rseos['seos_address_working_hours'] = cot_import('rseosaddressworkinghours', 'P', 'TXT');
		$rseos['seos_mail'] = cot_import('rseosmail', 'P', 'TXT');
		$rseos['seos_phone'] = cot_import('rseosphone', 'P', 'TXT');
		$rseos['seos_video'] = cot_import('rseosvideo', 'P', 'TXT');
		$rseos['seos_image'] = cot_import('rseosimage', 'P', 'TXT');
		$rseos['seos_map_coordinate'] = cot_import('rseoscoordinate', 'P', 'TXT');
		$rseos['seos_description'] = cot_import('rseosdescription', 'P', 'HTM');

		$rseos['seos_phone'] = empty($rseos['seos_phone']) ? $cfg['seosubdom']['default_phone'] : $rseos['seos_phone'];
		$rseos['seos_mail'] = empty($rseos['seos_mail']) ? $cfg['seosubdom']['default_mail'] : $rseos['seos_mail'];

		// Extrafields
		foreach ($cot_extrafields[$db_seosubdom] as $exfld)
		{
			$rseos['seos_'.$exfld['field_name']] = cot_import_extrafields('rseos'.$exfld['field_name'], $exfld, 'POST', $rseos['seos_'.$exfld['field_name']]);
		}

		/* === Hook === */
		foreach (cot_getextplugins('seosubdom.admin.manage.update.first') as $pl)
		{
			include $pl;
		}
		/* ===== */

		cot_check(mb_strlen($rseos['seos_domain']) < 3 || empty($rseos['seos_domain']), 'seos_domain_tooshort', 'rseosdomain');
		cot_check(mb_strlen($rseos['seos_address_index']) < 3 || empty($rseos['seos_address_index']), 'seos_address_index_tooshort', 'rseosaddressindex');
		cot_check(mb_strlen($rseos['seos_address_region']) < 3 || empty($rseos['seos_address_region']), 'seos_address_region_tooshort', 'rseosaddressregion');
		cot_check(mb_strlen($rseos['seos_address_city']) < 3 || empty($rseos['seos_address_city']), 'seos_address_city_tooshort', 'rseosaddresscity');
		cot_check(mb_strlen($rseos['seos_address_street']) < 3 || empty($rseos['seos_address_street']), 'seos_address_street_tooshort', 'rseosaddressstreet');
		cot_check(mb_strlen($rseos['seos_address_house']) < 1, 'seos_address_house_tooshort', 'rseosaddresshouse');
		//cot_check(mb_strlen($rseos['seos_address_office']) < 1, 'seos_address_office_tooshort', 'rseosaddressoffice');
		cot_check(mb_strlen($rseos['seos_address_working_days']) < 1, 'seos_address_working_days_tooshort', 'rseosaddressworkingdays');
		cot_check(mb_strlen($rseos['seos_address_working_hours']) < 1, 'seos_address_working_hours_tooshort', 'rseosaddressworkinghours');
		cot_check(mb_strlen($rseos['seos_image']) < 3 || empty($rseos['seos_image']), 'seos_image_tooshort', 'rseosimage');
		cot_check(mb_strlen($rseos['seos_map_coordinate']) < 12 || empty($rseos['seos_map_coordinate']), 'seos_map_coordinate_tooshort', 'rseoscoordinate');
		cot_check(mb_strlen($rseos['seos_description']) < 10, 'seos_description_tooshort', 'rseosdescription');
		
		/* === Hook === */
		foreach (cot_getextplugins('seosubdom.admin.update.error') as $pl)
		{
			include $pl;
		}
		/* ===== */

		if(!cot_error_found())
		{
			if(!empty($rseos['seos_id']))
			{
				seos_update($rseos);
				cot_message('seos_update_success');

				/* === Hook === */
				foreach (cot_getextplugins('seosubdom.admin.manage.update.done') as $pl)
				{
					include $pl;
				}
				/* ===== */

			}
			else
			{
				seos_add($rseos);
				cot_message('seos_add_success');

				/* === Hook === */
				foreach (cot_getextplugins('seosubdom.admin.manage.add.done') as $pl)
				{
					include $pl;
				}
				/* ===== */

			}
			cot_redirect(cot_url('admin', 'm=other&p=seosubdom'.$common_params, '', true));
		}
	}

	$id = ($id > 0) ? $id : '';
	$adminpath[] = array(cot_url('admin', 'm=other&p=seosubdom&a=manage&id='.$id.$common_params), empty($id) ? $L['seos_add_domain'] : $L['seos_edit_domain']);
	$row = $db->query("SELECT * FROM $db_seosubdom ".
		"WHERE seos_id=? LIMIT 1", $id)->fetch();

	if(empty($id))
	{
		$seos_domain = $rseos['seos_domain'];
		$seos_address_index = $rseos['seos_address_index'];
		$seos_address_region = $rseos['seos_address_region'];
		$seos_address_city = $rseos['seos_address_city'];
		$seos_address_street = $rseos['seos_address_street'];
		$seos_address_house = $rseos['seos_address_house'];
		$seos_address_office = $rseos['seos_address_office'];
		$seos_address_working_days = $rseos['seos_address_working_days'];
		$seos_address_working_hours = $rseos['seos_address_working_hours'];
		$seos_phone = $rseos['seos_phone'];
		$seos_mail = $rseos['seos_mail'];
		$seos_video = $rseos['seos_video'];
		$seos_image = $rseos['seos_image'];
		$seos_map_coordinate = $rseos['seos_map_coordinate'];
		$seos_description = $rseos['seos_description'];
	}
	else
	{
		$seos_domain = $row['seos_domain'];
		$seos_address_index = $row['seos_address_index'];
		$seos_address_region = $row['seos_address_region'];
		$seos_address_city = $row['seos_address_city'];
		$seos_address_street = $row['seos_address_street'];
		$seos_address_house = $row['seos_address_house'];
		$seos_address_office = $row['seos_address_office'];
		$seos_address_working_days = $row['seos_address_working_days'];
		$seos_address_working_hours = $row['seos_address_working_hours'];
		$seos_phone = $row['seos_phone'];
		$seos_mail = $row['seos_mail'];
		$seos_video = $row['seos_video'];
		$seos_image = $row['seos_image'];
		$seos_map_coordinate = $row['seos_map_coordinate'];
		$seos_description = $row['seos_description'];
	}
	
	/* === Hook === */
	foreach (cot_getextplugins('seosubdom.admin.manage.main') as $pl)
	{
		include $pl;
	}
	/* ===== */

	$t->assign(array(
		'ADMIN_SEOS_MANAGE_DOMAIN_ID' => $id,
		'ADMIN_SEOS_MANAGE_DOMAIN' => cot_inputbox('text', 'rseosdomain', $seos_domain, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_ADDRESS_INDEX' => cot_inputbox('text', 'rseosaddressindex', $seos_address_index, array('style' => 'width: 98%;')), 
		'ADMIN_SEOS_MANAGE_ADDRESS_REGION' => cot_inputbox('text', 'rseosaddressregion', $seos_address_region, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_ADDRESS_CITY' => cot_inputbox('text', 'rseosaddresscity', $seos_address_city, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_ADDRESS_STREET' => cot_inputbox('text', 'rseosaddressstreet', $seos_address_street, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_ADDRESS_HOUSE' => cot_inputbox('text', 'rseosaddresshouse', $seos_address_house, array('style' => 'width: 150px;')),
		'ADMIN_SEOS_MANAGE_ADDRESS_OFFICE' => cot_inputbox('text', 'rseosaddressoffice', $seos_address_office, array('style' => 'width: 150px;')),
		'ADMIN_SEOS_MANAGE_ADDRESS_WORKING_DAYS' => cot_inputbox('text', 'rseosaddressworkingdays', $seos_address_working_days, array('style' => 'width: 150px;')),
		'ADMIN_SEOS_MANAGE_ADDRESS_WORKING_HOURS' => cot_inputbox('text', 'rseosaddressworkinghours', $seos_address_working_hours, array('style' => 'width: 150px;')),
		'ADMIN_SEOS_MANAGE_PHONE' => cot_inputbox('text', 'rseosphone', $seos_phone, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_MAIL' => cot_inputbox('text', 'rseosmail', $seos_mail, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_VIDEO' => cot_inputbox('text', 'rseosvideo', $seos_video, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_IMAGE' => cot_inputbox('text', 'rseosimage', $seos_image, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_MAP_COORDINATE' => cot_inputbox('text', 'rseoscoordinate', $seos_map_coordinate, array('style' => 'width: 98%;')),
		'ADMIN_SEOS_MANAGE_DESCRIPTION' => cot_textarea('rseosdescription', $seos_description, 10, 120, '', 'input_textarea_editor'),
		'ADMIN_SEOS_MANAGE_FORM_URL' => cot_url('admin', 'm=other&p=seosubdom&a=manage&v=update&id='.$id.$common_params),
		'ADMIN_SEOS_MANAGE_FORM_DELETE_URL' => cot_url('admin', 'm=other&p=seosubdom&a=delete&id='.$id.$common_params.'&'.cot_xg()),
		'ADMIN_SEOS_MANAGE_FORM_UPDATE_URL' => cot_url('admin', 'm=other&p=seosubdom&a=manage&v=update&id='.$id.$common_params),
	));

	// Extrafields
	if (isset($cot_extrafields[$db_seosubdom]))
	{
		foreach ($cot_extrafields[$db_seosubdom] as $exfld)
		{
			$tag = mb_strtoupper($exfld['field_name']);
			$t->assign(array(
				'ADMIN_SEOS_MANAGE_' . $tag . '_TITLE' => isset($L['seos_' . $exfld['field_name'] . '_title']) ? $L['seos_' . $exfld['field_name'] . '_title'] : $exfld['field_description'],
				//$tag => cot_build_extrafields_data('seosubdom', $exfld, $row['seos_' . $exfld['field_name']]),
				'ADMIN_SEOS_MANAGE_' . $tag => cot_build_extrafields('rseos'.$exfld['field_name'], $exfld, $row['seos_'.$exfld['field_name']]),
			));
		}
	}

	/* === Hook === */
	foreach (cot_getextplugins('seosubdom.admin.manage.tags') as $pl)
	{
		include $pl;
	}
	/* ===== */
}

$t->assign(array(
	'ADMIN_SEOS_DOMAINS_ADD_URL' => cot_url('admin', 'm=other&p=seosubdom&a=manage'.$common_params),
));

cot_display_messages($t);

/* === Hook === */
foreach (cot_getextplugins('seosubdom.admin.tags') as $pl)
{
	include $pl;
}
/* ===== */

$t->parse('MAIN');
$adminmain = $t->text();
