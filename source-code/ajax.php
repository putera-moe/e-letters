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

define('AJAX', true);
require_once("global.php");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

if (is_online($w_user))
{
	/**
	##################################################
	# USERS ONLINE
	##################################################
	*/



}
else
{
	/**
	##################################################
	# ANONYMOUS ONLY
	##################################################
	*/

}
/**
##################################################
# ALL ACCESS
##################################################
*/
function Pipeline() {
	global $config, $db, $w_user;

	
	settimeout('Pipeline();',($config->PipelineDelay*1000));
}


#--------------------------------------------------
if (isset($_REQUEST['op'])) {
	$op = $_REQUEST['op'];
} else if (isset($_POST['op'])) {
	$op = $_POST['op'];
} else if (isset($_GET['op'])) {
	$op = $_GET['op'];
} else {
	$op = "";
}

switch($op)
{
	default:
		header("Location: ".SITEURL);
	break;

	#########################################
	# Global Functions
	#########################################
	case "pipeline":
		Pipeline();
	break;
	
	#########################################
	# Administrators Functions
	#########################################
}
?>