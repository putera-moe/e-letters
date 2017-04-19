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

$parts = explode(DS,WEB_BASE);
define('IP_ADDRESS',GRIP());

define('WEB_ROOT',				implode(DS,$parts));
define('WEB_VENDOR',			WEB_ROOT.DS.'vendor'.DS);
define('WEB_INCLUDES',			WEB_ROOT.DS.'includes'.DS);
define('WEB_TEMPLATES',			WEB_ROOT.DS.'templates'.DS);
define('WEB_TEMPLATES_SYSTEM',	WEB_ROOT.DS.'templates'.DS.'system'.DS);
define('WEB_LANGUAGES',			WEB_ROOT.DS.'languages'.DS);
define('WEB_IMAGES',			WEB_ROOT.DS.'images'.DS);

define('SITEURL',				$config->SiteUrl);
define('URL_IMAGES',			SITEURL.'/images');
define('URL_VENDOR',			SITEURL.'/vendor');

# Themes
define('WEB_THEMES',			WEB_ROOT.DS.'themes'.DS.$config->DefaultTheme.DS);
define('URL_THEMES',			'themes/'.$config->DefaultTheme);

?>