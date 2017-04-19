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
define('HEADER', true);
require_once(WEB_ROOT.DS."global.php");
function WebHeader() {
	include_once(WEB_THEMES."theme.php");	
	ThemesHeader();
}
WebHeader();
?>