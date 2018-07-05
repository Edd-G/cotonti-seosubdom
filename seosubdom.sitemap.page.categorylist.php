<?php
/* ====================
[BEGIN_COT_EXT]
Code=seosubdom
File=seosubdom.sitemap.page.categorylist
Hooks=sitemap.page.categorylist
[END_COT_EXT]
==================== */

/**
 * Seosubdom sitemap part
 *
 * @package Seosubdom
 * @copyright (c) Edward Gabishev
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

if (!defined('COT_CODE')) { die('Wrong URL'); }

require_once cot_incfile('seosubdom', 'plug');

if (cot_plugin_active('sitemap') && $cfg['plugin']['seosubdom']['excludecat'] && $gl_seos_domain != 'default_domain')
{
	$excludecat = array_map('trim', explode(',', $cfg['plugin']['seosubdom']['excludecat']));

	// All cats except blacklist
	foreach ($category_list as $code => $row)
	{
		if (in_array($code, $excludecat))
		{
			unset($category_list[$code]);
		}
	}
}
