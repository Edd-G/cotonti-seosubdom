<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=parser.last
[END_COT_EXT]
==================== */

/**
 * Seosubdom parser part
 *
 * @package Seosubdom
 * @copyright (c) Edward Gabishev
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('seosubdom', 'plug');

global $env, $c, $gl_seos_address_city_rod, $gl_seos_address_city_dat, $gl_seos_address_city_vin, $gl_seos_address_city_tvo, $gl_seos_address_city_pre;

if ($env['ext'] == "page" && $c == "system")
{
     if ($env['location'] == "pages")
     {
          $text = preg_replace('#\[CITY_ROD\]#si', $gl_seos_address_city_rod, $text);
          $text = preg_replace('#\[CITY_DAT\]#si', $gl_seos_address_city_dat, $text);
          $text = preg_replace('#\[CITY_VIN\]#si', $gl_seos_address_city_vin, $text);
          $text = preg_replace('#\[CITY_TVO\]#si', $gl_seos_address_city_tvo, $text);
          $text = preg_replace('#\[CITY_PRE\]#si', $gl_seos_address_city_pre, $text);
     }
     $text = parse_page_tpl_tags($text);
}
