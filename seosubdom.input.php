<?php
/* ====================
[BEGIN_COT_EXT]
Code=seosubdom
File=seosubdom.input
Hooks=input
[END_COT_EXT]
==================== */

/**
 * Seosubdom input part
 *
 * @package Seosubdom
 * @copyright (c) Edward Gabishev
 * @license https://github.com/Cotonti/Cotonti/blob/master/License.txt
 */

if (!defined('COT_CODE')) { die('Wrong URL'); }

require_once cot_incfile('seosubdom', 'plug');

$alldomains = explode('.', $_SERVER['HTTP_HOST']);
$subdomain = count($alldomains) >= 3 ? $alldomains[0] : '';

$dom_sql = $db->query("SELECT * FROM $db_seosubdom WHERE seos_domain='".$db->prep($subdomain)."' LIMIT 1" )->fetchAll();

if (!$dom_sql && $subdomain !== 'www' && $subdomain !== '') {
	header("HTTP/1.1 403 Forbidden");
	echo "<html>
		<head><title>403 Forbidden</title></head>
		<body bgcolor=\"white\">
		<center><h1>403 Forbidden</h1></center>
		<hr><center>nginx 2.3.8</center>
		</body>
		</html>
		<!-- a padding to disable MSIE and Chrome friendly error page -->
		<!-- a padding to disable MSIE and Chrome friendly error page -->
		<!-- a padding to disable MSIE and Chrome friendly error page -->
		<!-- a padding to disable MSIE and Chrome friendly error page -->
		<!-- a padding to disable MSIE and Chrome friendly error page -->
		<!-- a padding to disable MSIE and Chrome friendly error page -->
		";
		exit;
}
