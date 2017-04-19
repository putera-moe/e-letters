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

define('_WEB', true);

session_start();
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$start_time = $mtime;

function GRIP() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

define('WEB_BASE',dirname(__FILE__));
define('DS',DIRECTORY_SEPARATOR);

# Dapatkan fail configuration.php
if (!file_exists(WEB_BASE.DS."configuration.php") || (filesize(WEB_BASE.DS."configuration.php") < 10)) {
	die('Fail configuration.php tidak dijumpai !');
}
require_once(WEB_BASE.DS."configuration.php");
require_once(WEB_BASE.DS.'includes'.DS.'defines.php');

# Web Debug
if ($config->WebDebug == true) {
	error_reporting(E_ALL & ~E_NOTICE); // in Development
} else {
	error_reporting(0); // in Production
}

# Seting Date & Timezone
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {
    date_default_timezone_set("Asia/Kuala_Lumpur");
}

# Handling Variables
if (version_compare(PHP_VERSION, '4.1.0', '<')) {
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
	$_FILES = $HTTP_POST_FILES;
	$_ENV = $HTTP_ENV_VARS;
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$_REQUEST = $_POST;
	} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
		$_REQUEST = $_GET;
	}
	if (isset($HTTP_COOKIE_VARS)) {
  		$_COOKIE = $HTTP_COOKIE_VARS;
	}
	if (isset($HTTP_SESSION_VARS)) {
  		$_SESSION = $HTTP_SESSION_VARS;
 	}
}
if (version_compare(PHP_VERSION, '4.1.0', '>=')) {
	$HTTP_GET_VARS = $_GET;
  	$HTTP_POST_VARS = $_POST;
  	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_POST_FILES = $_FILES;
  	$HTTP_ENV_VARS = $_ENV;
	$PHP_SELF = $_SERVER['PHP_SELF'];	
	if (isset($_SESSION)) {
    	$HTTP_SESSION_VARS = $_SESSION;
	}	
  	if (isset($_COOKIE)) {
    	$HTTP_COOKIE_VARS = $_COOKIE;
	}
}
if (PHP_VERSION >= '4.0.4pl1' && isset($_SERVER['HTTP_USER_AGENT']) && strstr($_SERVER['HTTP_USER_AGENT'],'compatible')) {
	if (extension_loaded('zlib')) {
    	@ob_end_clean();
	    ob_start('ob_gzhandler');
  	}
} else if (PHP_VERSION > '4.0' && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && !empty($_SERVER['HTTP_ACCEPT_ENCODING'])) {
	if (strstr($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
    	if (extension_loaded('zlib')) {
      		$do_gzip_compress = true;
			ob_start('ob_gzhandler');
      		ob_implicit_flush(0);
			if (preg_match("/MSIE/i", $_SERVER['HTTP_USER_AGENT'])) {
				header('Content-Encoding: gzip');
      		}
    	}
  	}
}
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	if (!ini_get('register_globals')) {
		import_request_variables("GPC", "");
	}
}
if (!function_exists('stripos')) {
	function stripos_clone($haystack, $needle, $offset=0) {
    	return strpos(strtoupper($haystack), strtoupper($needle), $offset);
	}
} else {
  	function stripos_clone($haystack, $needle, $offset=0) {
    	return stripos($haystack, $needle, $offset=0);
  	}
}
if (stristr(htmlentities($_SERVER['PHP_SELF']), "global.php")) {
    header("Location: index.php");
    exit();
}
if ((isset($w_user) && $w_user != $_COOKIE['w_user'])) {
	header("Location: index.php");
}
if (isset($_COOKIE['w_user'])) {
	$w_user = $_COOKIE['w_user'];
	$w_user = base64_decode($w_user);
	$w_user = addslashes($w_user);
	$w_user = base64_encode($w_user);
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (isset($_SERVER['HTTP_REFERER'])) {
    	if (!stripos_clone($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) {
        	header("Location: index.php");
    	}
  	} else {
    	header("Location: index.php");
  	}
}

if (!file_exists(WEB_BASE.DS.'vendor'.DS.'autoload.php')) {
	die('PHP Composer autoload gagal ! Sila pastikan composer telah dikemaskini.');
}
require_once(WEB_BASE.DS.'vendor'.DS.'autoload.php');
require_once(WEB_INCLUDES."database.php");
require_once(WEB_INCLUDES."functions.php");

# Language
$newlang = $_REQUEST['newlang'];
$locale = $_COOKIE['locale'];
$default_lang = $config->DefaultLang;
if (isset($newlang) AND !stripos_clone($newlang,"."))
{
	if (file_exists(WEB_LANGUAGES."lang-".$newlang.".php"))
	{
		set_cookie("locale",$newlang,time()+31536000);
		include_once(WEB_LANGUAGES."lang-".$newlang.".php");
		$config->setLanguage($newlang);
	}
	else
	{
		set_cookie("locale",$default_lang,time()+31536000);
		include_once(WEB_LANGUAGES."lang-".$default_lang.".php");
		$config->setLanguage($default_lang);
	}
}
else if (isset($locale))
{
	include_once(WEB_LANGUAGES."lang-".$locale.".php");
	$config->setLanguage($locale);
}
else
{
	set_cookie("locale",$default_lang,time()+31536000);
	include_once(WEB_LANGUAGES."lang-".$default_lang.".php");
	$config->setLanguage($default_lang);
}

WebInit();

?>