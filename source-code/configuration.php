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

class WebConfig
{
	# Maklumat asas sistem.
	var $WebSystem = "e-Letters";
	var $WebVersion = "1.0";
	var $Developer = "CyberSpace Development Team";

	# ID Lesen
	var $LicenseKey = "CSDT3303S47G621R45Y5722842783458";

	# Site Configuration
	var $WebDebug = true;
	var $SiteName = "e-Letters";
	var $SiteUrl = "http://www.e-letters.dev";
	var $SiteDescription = "Sistem Pengurusan Surat Keluar/Masuk";
	var $Keywords = "web, system, integration, laman web, laman, sistem, sistem surat, surat keluar masuk, perisian sistem";
	var $UserSession = 3600; // 1 jam
	var $UserSessionRemember = 86400; // 24 jam
	var $DefaultLang = 'ms'; // ms | en

	# Tema Web
	var $DefaultTheme = "limitless";

	# Konfigurasi Pangkalan Data
	var $DatabaseType = "MySQL";
	var $DatabaseName = "eletters";
	var $DatabaseHost = "localhost";
	var $DatabaseUser = "root";
	var $DatabasePass = 'sa';
	var $DatabaseDebug = false;

	# SMTP Configuration (PHPMailer)
	var $AdminMail = "";
	var $MailHost = "";
	var $MailUser = "";
	var $MailPwd = '';
	var $MailPort = 465;
	var $MailSecure = "ssl";
	var $MailDebug = 0;

	# Web Settings
	# ---------------------------------------
	var $PipelineDelay = 30; // saat
	
	#################################################################
	var $CurrentLang;

	public function setLanguage($NewLang) {
		$this->CurrentLang = $NewLang;
	}
	public function getLanguage() {
		return $this->CurrentLang;
	}
	public function setTheme($NewTheme) {
		$this->DefaultTheme = $NewTheme;
	}
	public function getTheme() {
		return $this->DefaultTheme;
	}
}
$config = new WebConfig();
?>