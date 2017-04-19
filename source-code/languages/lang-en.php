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

global $config, $db, $w_user, $cookie;

if (is_online($w_user)) {
	cookiedecode($w_user);
	define("USERID",strtolower($cookie[0]));
	define("SID",strtoupper($cookie[1]));
} else {
	define("USERID","");
	define("SID","");
}

# Global
define("CHARSET","UTF-8");
define("VERSION",$config->WebVersion);
define("SITENAME",$config->SiteName);
define("SITE_DESCRIPTION",$config->SiteDescription);
define("DEVELOPER",$config->Developer);
define("YEAR",date('Y'));
define("LOCALE",'en');
define("SALT",strtoupper(md5($config->LicenseKey.$_SERVER['REMOTE_ADDR'].time())));
?>