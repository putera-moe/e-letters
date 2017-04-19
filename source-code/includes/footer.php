<?php
/*
#############################################################################
#
#  SISTEM PENGURUSAN SURAT KELUAR/MASUK (e-Letters)
#
#############################################################################
#
#  Dibangunkan Oleh : CyberSpace Development Team
#  Hakcipta Terpelihara (c) 2017 oleh CyberSpace DevTeam
#
#  Juruteknik Komputer Negeri Perak (JTKPK)
#
############################################################################
*/

defined('_WEB') or die('No Access');
define('FOOTER', true);

function LoadingTime() {
	global $start_time;
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$end_time = $mtime;
	$total_time = ($end_time - $start_time);
	$total_time = substr($total_time,0,4);
	return $total_time;
}

function WebFooter() {
	global $config, $jquery, $jscript, $jsload, $w_user;

	ThemesFooter();
	echo "\n<!-- Loading Time: ".LoadingTime()." //-->\n";
	echo "</body>\n";
	echo "</html>";
	ob_end_flush();
	die();
}

WebFooter();
?>