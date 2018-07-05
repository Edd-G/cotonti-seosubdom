<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.main
[END_COT_EXT]
==================== */

/**
 * Seosubdom header part
 *
 * @package Seosubdom
 * @copyright (c) Edward Gabishev
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

defined('COT_CODE') or die('Wrong URL');

if (isset($_GET['id']) || isset($_GET['al'])) {
	// $out['fulltitle'] = $out['subtitle'];
	// $ogtype = "product";
	// $ogimage = $ogimg;
}

// if($gl_seos_domain != 'default_domain')
// {
	$t->assign(array(
		// 'HEADER_META_OGTITLE' => $out['fulltitle'],
		// 'HEADER_META_OGDESC' => $out['desc'],
		// 'HEADER_META_OGIMAGE' => (!empty($ogimage)) ? $cfg['mainurl'] ."/". $ogimage : "",
		// 'HEADER_META_OGTYPE' => (!empty($ogtype)) ? $ogtype : "article",
		// 'HEADER_META_OGSITENAME' => "This site",
		// 'HEADER_META_OGSEEALSO' => $cfg['mainurl'],
	));
	// add geo to base header
	if(!defined('COT_INDEX'))
	{
		$out['meta_desc'] .= ' в ' . $gl_seos_address_city_pre;
	}
	$out['meta_keywords'] .= ', ' . $gl_seos_address_city;
//}

// $t->assign(array(
// 	'HEADER_META_OGTITLE' => $out['fulltitle'],
// 	'HEADER_META_OGDESC' => $out['desc'],
// 	'HEADER_META_OGIMAGE' => (!empty($ogimage)) ? $cfg['mainurl'] ."/". $ogimage : "",
// 	'HEADER_META_OGTYPE' => (!empty($ogtype)) ? $ogtype : "article",
// 	'HEADER_META_OGSITENAME' => "This site",
// 	'HEADER_META_OGSEEALSO' => $cfg['mainurl'],
// ));
