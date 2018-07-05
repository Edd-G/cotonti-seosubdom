<?php
/**
 * Seosubdom functions
 *
 * @package Seosubdom
 * @copyright (c) Edward Gabishev
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('seosubdom', 'plug');
require_once cot_incfile('extrafields');
require_once cot_incfile('forms');

cot::$db->registerTable('seosubdom');
cot_extrafields_register_table('seosubdom');

/**
 * Strpos for array
 *
 * @param string $haystack the string to search in
 * @param array $needles contain search string
 * @return bool true or false
 */

if (!function_exists('strpos_array')) {
	
	function strpos_array($haystack, $needles) {
	    $search = false;
	    foreach($needles as $n) {
	        if (preg_match("/(?<![\w\d])$n(?![\w\d])/u", $haystack)) {
	            $search = true;
	            break;
	        }
	    }
	    return $search;
	}
}

function seos_add($rseos)
{
	global $db, $db_seosubdom;
		
	/* === Hook === */
	foreach (cot_getextplugins('seosubdom.add.add.query') as $pl)
	{
		include $pl;
	}
	/* ===== */
	
	if($db->insert($db_seosubdom, $rseos))
	{
		
		/* === Hook === */
		foreach (cot_getextplugins('seosubdom.add.add.done') as $pl)
		{
			include $pl;
		}
		/* ===== */
		
		return $db->lastInsertID();
	}	
	else
	{
		return FALSE;
	}
}

function seos_update($rseos)
{
	global $db, $db_seosubdom;
	if((int)$rseos['seos_id'] == 0)
	{
		return FALSE;
	}
	
	/* === Hook === */
	foreach (cot_getextplugins('seosubdom.update.first') as $pl)
	{
		include $pl;
	}
	/* ===== */

	return $db->update($db_seosubdom, $rseos, 'seos_id=?', $rseos['seos_id'], true);

	/* === Hook === */
	foreach (cot_getextplugins('seosubdom.update.done') as $pl)
	{
		include $pl;
	}
	/* ===== */
}

function seos_delete($id, $rseos = array())
{
	global $db_seosubdom, $db;
	$id = (int)$id;
	if($id == 0)
	{
		return FALSE;
	}
	if(count($rseos) == 0)
	{
		$rseos = $db->query("SELECT seos_id FROM $db_seosubdom WHERE seos_id=? LIMIT 1", $id)->fetch();
		if(!$rseos)
		{
			return FALSE;
		}
	}
	$deleted = $db->delete($db_seosubdom, 'seos_id=?', array($id));
	
	/* === Hook === */
	foreach (cot_getextplugins('seosubdom.delete.done') as $pl)
	{
		include $pl;
	}
	/* ===== */

	if($deleted)
	{
		return $deleted;
	}
	else
	{
		return FALSE;
	}
}

if (class_exists('XTemplate'))
 {
      function parse_page_tpl_tags($raw_tpl){
           $t = new XTemplate();
           $t->compile('<!-- BEGIN: MAIN-->'.$raw_tpl.'<!-- END: MAIN-->');
           $t->parse();
           return $t->text();
      }
      
 }
