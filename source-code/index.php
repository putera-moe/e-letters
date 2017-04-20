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
	global $body, $jquery;

	define('FULLBODY', true);
	
	$body = '<body class="login-container">';
	$jquery = '$(\'#user_id\').focus();';

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
	$remember_me = $_REQUEST['remember_me'];

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
		$UserSession = (!empty($remember_me)) ? $config->UserSessionRemember : $config->UserSession;
		set_cookie("w_user",$cookie_value,$UserSession);

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
		define('MODULE', 'Dashboard');
		
		if (is_admin($w_user))
		{
			$AdminMenu = '<div class="col-sm-6 col-md-4 mb-15">
				<a href="/?p=senarai-pengguna" class="btn btn-default btn-block btn-float btn-float-lg">
					<div class="icon-object border-success text-success">
						<i class="icon-users"></i>
					</div>
					<span class="h4 text-bold no-margin-top no-padding-top mb-10">
						Senarai Pengguna
					</span>
				</a>
			</div>';
		}

		include(WEB_INCLUDES."header.php");
		$t = new Template;
		$t->Load(WEB_TEMPLATES.'dashboard.html');
		$t->Replace('ADMIN_MENU',$AdminMenu);
		$t->Publish();
		include(WEB_INCLUDES."footer.php");
	}
	else
	{
		Login();
	}
}


function SenaraiPengguna()
{
	global $db, $config, $w_user;

	if (is_admin($w_user))
	{
		# DAPATKAN SEMUA DATA PENGGUNA
		$r = $db->Execute("SELECT * FROM users");
		if (!$r) {
			die($db->ErrorMsg());
		}

		if ($r->RecordCount() > 0)
		{
			while ($row = $r->FetchRow())
			{
				$Username = $row['user_id'];
				$Nama = $row['nama'];
				$Jawatan = $row['jawatan'];
				$StatusOnline = $row['status_online'];
				$StatusAkaun = $row['account_status'];

				$data_user .= '<tr>
					<td>'.$Username.'</td>
					<td>'.$Nama.'</td>
					<td>'.$Jawatan.'</td>
					<td>'.$StatusOnline.'</td>
					<td>'.$StatusAkaun.'</td>
					<td width="200" align="center">
						<button type="button" class="btn btn-xlg bg-primary">Edit</button>
						<button type="button" class="btn btn-xlg bg-danger">Padam</button>
					</td>
				</tr>';
			}
		}


		include(WEB_INCLUDES."header.php");
		$t = new Template;
		$t->Load(WEB_TEMPLATES.'senarai-pengguna.html');
		$t->Replace('DATA_PENGGUNA', $data_user);
		$t->Publish();
		include(WEB_INCLUDES."footer.php");
	}
	else
	{
		Login();
	}
}

function TambahPengguna()
{
	global $db, $config, $w_user;

	if (is_admin($w_user))
	{
		include(WEB_INCLUDES."header.php");
		$t = new Template;
		$t->Load(WEB_TEMPLATES.'tambah-pengguna.html');
		$t->Publish();
		include(WEB_INCLUDES."footer.php");
	}
	else
	{
		Login();
	}
}

function SimpanRekodPengguna()
{
	global $db, $config, $w_user;

	if (is_admin($w_user))
	{
		// Dapatkan maklumat form
		$username = $_REQUEST['username'];
		$pwd = $_REQUEST['pwd'];
		$nama = $_REQUEST['nama'];
		$jawatan = $_REQUEST['jawatan'];
		$status_akaun = $_REQUEST['status_akaun'];
		$kumpulan_pengguna = $_REQUEST['kumpulan_pengguna'];

		// check username dulu
		$record = RecordCount("SELECT * FROM users WHERE user_id='$username'");
		if ($record == 1)
		{
			die('Maaf ! username ini telah wujud dalam sistem.');
		}

		// Encrypted password dia
		$encrypted_pwd = strtoupper(md5(strtoupper($pwd) . $config->LicenseKey));

		// masuk dalam database
		$r = $db->Execute("INSERT INTO users (user_id,pwd,account_status,user_role,nama,jawatan) VALUES ('$username','$encrypted_pwd','$status_akaun','$kumpulan_pengguna','$nama','$jawatan')");
		if (!$r) {
			die($db->ErrorMsg());
		}

		header('Location: '.SITEURL.'/?p=senarai-pengguna');
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

	###########################
	# Fungsi Administrator
	###########################
	case "senarai-pengguna":
		SenaraiPengguna();
	break;
	case "tambah-pengguna":
		TambahPengguna();
	break;
	case "padam-pengguna":
		PadamPengguna();
	break;
	case "edit-pengguna":
		EditPengguna();
	break;
	case "simpan-rekod-pengguna":
		SimpanRekodPengguna();
	break;
}
?>