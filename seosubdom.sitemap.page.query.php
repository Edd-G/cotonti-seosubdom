<?php
/* ====================
[BEGIN_COT_EXT]
Code=seosubdom
File=seosubdom.sitemap.page.query
Hooks=sitemap.page.query
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
	$excludecat = array_filter(array_map('trim', explode(',', $cfg['plugin']['seosubdom']['excludecat'])));
	$sitemap_where['excludecat'] = "page_cat NOT IN ('" . implode("','", $excludecat) . "')"; 
}
