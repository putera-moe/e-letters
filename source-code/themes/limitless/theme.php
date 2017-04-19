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
require_once(WEB_ROOT.DS."global.php");

function ThemesHeader() {
	global $config, $db, $cookie, $locale, $w_user, $body, $pagetitle, $cssload, $module_name, $meta, $author, $jsload, $jsplugins, $jquery, $jscript;
	$module_name = strtolower(MODULE);
	$_p = strtolower($_REQUEST['p']);

	if (is_online($w_user)) {
		cookiedecode($w_user);
	}

	# HTML 5
	echo "<!DOCTYPE html>\n";
	echo "<html lang=\"en\">\n";
	echo "<head>\n";
	
	# Meta Tags
	if (!$page_description) {
		$page_description = $config->SiteDescription;
	} else {
		$page_description = trimall(stripslashes($page_description));
	}
	echo '<meta http-equiv="pragma" content="no-cache">'."\n";
	echo '<meta http-equiv="expires" content="-1">'."\n";
	echo '<meta http-equiv="cache-control" content="no-cache">'."\n";
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'."\n";
	echo '<meta http-equiv="content-type" content="text/html; charset='.CHARSET.'">'."\n";
	echo '<meta name="developer" content="'.$config->Developer.'">'."\n";
	echo '<meta name="description" content="'.$config->SiteDescription.'">'."\n";
	echo '<meta name="keywords" content="'.$config->Keywords.'">'."\n";
	echo '<meta name="robots" content="index, follow">'."\n";
	echo '<meta name="googlebot" content="noarchive">'."\n";
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />'."\n";

	if (isset($meta))
	{
		echo $meta;
	}

	# Pagetitle
	if (isset($pagetitle)) {
		$pagetitle = $pagetitle;
	} else {
		$pagetitle = SITENAME;
	}
	echo "<title>$pagetitle</title>\n";

	# Fonts
	echo "<link href=\"https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900\" rel=\"stylesheet\" type=\"text/css\" />\n";

	//-----------------------------------
	// Global Stylesheets
	//-----------------------------------
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".URL_THEMES."/assets/css/icons/icomoon/styles.css\" />\n";	
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".URL_THEMES."/assets/css/icons/fontawesome/styles.min.css\" />\n";	
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".URL_THEMES."/assets/css/bootstrap.css\" />\n";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".URL_THEMES."/assets/css/core.css\" />\n";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".URL_THEMES."/assets/css/components.css\" />\n";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".URL_THEMES."/assets/css/colors.css\" />\n";

	# Page Level CSS
	for($cssl=0; $cssl < count($cssload); $cssl++)
	{
		echo "<link href=\"".URL_THEMES."/assets/css/".$cssload[$cssl]."\" rel=\"stylesheet\" type=\"text/css\" />\n";
	}

	//-----------------------------------
	// Global Javascript Libraries
	//-----------------------------------
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/plugins/loaders/pace.min.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/core/libraries/jquery.min.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/core/libraries/bootstrap.min.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/plugins/loaders/blockui.min.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/plugins/ui/nicescroll.min.js\"></script>\n";
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/plugins/ui/drilldown.js\"></script>\n";

	//-----------------------------------
	// Page Level Javascript Libraries
	//-----------------------------------

	// Datatables
	echo "<script src=\"".URL_THEMES."/assets/js/plugins/tables/datatables/datatables.min.js\"></script>\n";

	echo "<script src=\"".URL_THEMES."/assets/js/plugins/forms/styling/uniform.min.js\"></script>\n";
	echo "<script src=\"".URL_THEMES."/assets/js/plugins/notifications/sweet_alert.min.js\"></script>\n";
	echo "<script src=\"".URL_THEMES."/assets/js/plugins/forms/selects/select2.min.js\"></script>\n";
	echo "<script src=\"".URL_THEMES."/assets/js/plugins/forms/styling/switchery.min.js\"></script>\n";
	echo "<script src=\"".URL_THEMES."/assets/js/plugins/forms/styling/switch.min.js\"></script>\n";
	echo "<script src=\"".URL_THEMES."/assets/js/plugins/uploaders/dropzone.min.js\"></script>\n";

	# Apps
	echo "<script src=\"".URL_THEMES."/assets/js/core/app.js.php?m=$module_name\"></script>\n";
	echo "<script src=\"".URL_THEMES."/assets/js/pages/form_checkboxes_radios.js\"></script>\n";
	
	###############################################

	# System Default Ajax & JS Library
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/ajax.js\"></script>\n";	
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/global.js\"></script>\n\n";	
	echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/functions.js\"></script>\n\n";	

	# Javascript Loader (Plugins)
	for ($jsp=0; $jsp < count($jsplugins); $jsp++) {
		echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/plugins/".$jsplugins[$jsp]."\"></script>\n";
	}

	# Javascript Loader (Page Level Plugins)
	for ($jsl=0; $jsl < count($jsload); $jsl++) {
		echo "<script type=\"text/javascript\" src=\"".URL_THEMES."/assets/js/pages/".$jsload[$jsl]."\"></script>\n";
	}

	# jQuery Ready
	if (isset($jquery)) {
		echo "<script type=\"text/javascript\">\n";
		echo "$(document).ready(function() {\n";
		echo $jquery."\n";
		echo "});\n";
		echo "</script>\n";
	}

	# JScript
	if (isset($jscript)) {
		echo "<script>\n";
		echo $jscript."\n";
		echo "</script>\n";
	}

	echo "</head>\n";
	
	# Body
	if (isset($body)) {
		echo "$body\n";
	} else {
		echo "<body class=\"layout-boxed\">\n";
	}

	# Anchor Named
	echo "<a name=\"top\" id=\"top\"></a>\n";

	#################

	# USER MENU
	if (is_online($w_user))
	{
		
	}
	else
	{
		
	}

	if ( (!defined('FULLBODY')) && (!defined('CLOSED')) )
	{
		$t = new Template;
		$t->Load(WEB_TEMPLATES."system".DS."header.html");
		$t->Replace("TOP_MENU", $top_menu);
		$t->Replace("USER_MENU", $user_menu);
		$t->Replace("USER_NAME", getUserDetail('Nama'));		
		$t->Publish();
	}
}

function ThemesFooter() {
	global $config, $user, $db, $cookie, $locale, $w_user, $module_name;
	$module_name = strtolower(MODULE);
	if (is_online($w_user)) {
		cookiedecode($w_user);
	}

	echo "\n\n";
	
	# Footer Template
	if ( (!defined('FULLBODY')) && (!defined('CLOSED')) )
	{
		$t = new Template;
		$t->Load(WEB_TEMPLATES."system".DS."footer.html");
		$t->Publish();	
	}
}
?>