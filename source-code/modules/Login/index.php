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

if (!defined('MODULE')) { die("No Access"); }
require_once(WEB_ROOT.DS."global.php");

function Login() {
	
}

#-------------------------------------------------
if (!empty($_REQUEST['p'])) { $p = $_REQUEST['p']; }
switch ($p)
{
	default:
		Login();
	break;
}
?>