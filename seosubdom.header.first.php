<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=header.first
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

// add geo to header title tag
//if($gl_seos_domain != 'default_domain' && defined('COT_INDEX'))
if(defined('COT_INDEX'))
{
	$cfg['subtitle'] .= ' в ' . $gl_seos_address_city_pre;
}

// if($gl_seos_domain != 'default_domain' && isset($c) && ($c == 'system' || $c == 'about'))
if(isset($c) && ($c == 'system' || $c == 'about') || $out['uri'] == 'contact')
{
	$out['subtitle'] .= ' в ' . $gl_seos_address_city_pre;
}
