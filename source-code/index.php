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

require_once("global.php");

function Login() {
	global $body;
	define('FULLBODY', true);
	$body = '<body class="login-container">';
	include(WEB_INCLUDES."header.php");
	$t = new Template;
	$t->Load(WEB_TEMPLATES_SYSTEM.'login.html');
	$t->Publish();
	include(WEB_INCLUDES."footer.php");
}
function Auth() {
	global $db, $config;

	// Dapatkan apa yang di POST
	$user_id = $_REQUEST['user_id'];
	$pwd = $_REQUEST['pwd'];

	// Encrypted password dia
	$encrypted_pwd = strtoupper(md5(strtoupper($pwd) . $config->LicenseKey));

	// Cari rekod di database
	$r = $db->Execute("SELECT * FROM users WHERE user_id='$user_id' AND pwd='$encrypted_pwd' AND account_status='AKTIF'");
	if (!$r)
	{
		die($db->ErrorMsg());
	}

	// Jika jumpa user berkenaan dan akaun dia 'AKTIF'
	if ($r->RecordCount() == 1)
	{
		// Update rekod user sebagai online
		$session_id = strtoupper(random_string('alnum', 32));
		$update = $db->Execute("UPDATE users SET session_id='$session_id', status_online='ONLINE' WHERE user_id='$user_id'");
		if (!$update)
		{
			die($db->ErrorMsg());
		}

		// set cookie
		$cookie_value = base64_encode("$user_id|$session_id");
		set_cookie("w_user",$cookie_value,$config->UserSession);

		// selesai, redirect user ke dashboard
		header('Location: '.$config->SiteUrl);
	}
	else
	{
		header('Location: '.$config->SiteUrl.'/?error=1');
	}	
}
function Logout()
{
	global $config, $db;

	$update = $db->Execute("UPDATE users SET session_id='', status_online='OFFLINE' WHERE user_id='".USERID."'");
	if (!$update)
	{
		die($db->ErrorMsg());
	}

	delete_cookie('w_user');
	header('Location: '.$config->SiteUrl);
}

//===============================================================
//
//  Nota Kepada Developer :
//  Sila jangan ubah function Login() dan juga Auth()
//
//	function is_online($w_user) - Bermaksud sekiranya user telah log masuk ke sistem
//	function is_admin($w_user) - Bermaksud sekiranya user berkenaan adalah administrator
//
//===============================================================

/**
	Function Dashboard
	===================

	Sekiranya user telah log masuk ke sistem,
	Ia akan terus automatik ke muka depan DASHBOARD
	Disini, kita menyediakan butang-butang atau function-function
	kepada semua pengguna.

*/
function Dashboard()
{
	global $config, $w_user;

	if (is_online($w_user))
	{
		include(WEB_INCLUDES."header.php");
		$t = new Template;
		$t->Load(WEB_TEMPLATES.'dashboard.html');
		$t->Publish();
		include(WEB_INCLUDES."footer.php");
	}
	else
	{
		Login();
	}
}



#-------------------------------------------------
if (!empty($_REQUEST['p'])) { $p = $_REQUEST['p']; } else { $p = "";}
switch ($p)
{
	default:
		Dashboard();
	break;
	case "login":
		Login();
	break;
	case "auth":
		Auth();
	break;
	case "logout":
		Logout();
	break;
}
?>