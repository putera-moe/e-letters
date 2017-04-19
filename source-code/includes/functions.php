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

function WebInit() {
	global $db, $config, $w_user, $cookie;
	$module = strtolower(MODULE);
}

/**
	COOKIES
*/
function set_cookie($name = '', $value = '', $expire = '', $domain = '', $path = '/', $prefix = '') {
	if (is_array($name)) {
		foreach (array('value', 'expire', 'domain', 'path', 'prefix', 'name') as $item) {
			if (isset($name[$item])) {
				$$item = $name[$item];
			}
		}
	}
			
	if ( ! is_numeric($expire)) {
		$expire = time() - 86500;
	} else {
		if ($expire > 0) {
			$expire = time() + $expire;
		} else {
			$expire = 0;
		}
	}
	
	setcookie($prefix.$name, $value, $expire, $path, $domain, 0);
}
function delete_cookie($name = '', $domain = '', $path = '/', $prefix = '') {
	set_cookie($name, '', '', $domain, $path, $prefix);
}

/**
	DATABASE
*/
function RecordCount($sql) {
	global $db;

	$rs = $db->Execute($sql);
	if (!$rs) {
		die($db->ErrorMsg());
	} else {
		$tr = $rs->RecordCount();
	}

	return $tr;
}
function getv($field,$table,$where,$value) {
	global $db;

	$rs = $db->Execute("SELECT ".$field." FROM ".$table." WHERE ".$where."='".$value."'");
	if (!$rs) {
		return $db->ErrorMsg();
		die($db->ErrorMsg());
	}
	$retn = $rs->fields[0];
	return $retn;
}

/**
	USERS
*/
function cookiedecode($w_user) {
    global $cookie, $db;
    static $sidOnline;
	
    if (!is_array($w_user)) {
        $w_user = base64_decode($w_user);
        $w_user = addslashes($w_user);
        $cookie = explode("|", $w_user);
    } else {
        $cookie = $w_user;
    }
	
    $uid = $cookie[0];
    $sid = $cookie[1];

    if (!isset($sidOnline)) {
		$rs = $db->Execute("SELECT session_id FROM users WHERE user_id='$uid' AND session_id='$sid' AND status_online='ONLINE' AND account_status='AKTIF'");
		list($sidOnline) = $rs->FetchRow();
	}
	
    if ($cookie[1] == $sidOnline && !empty($sidOnline)) { return $cookie; }
}
function is_online($w_user) {
    if (!$w_user) { return 0; }
    if (isset($userSave)) return $userSave;
    if (!is_array($w_user)) {
        $w_user = base64_decode($w_user);
        $w_user = addslashes($w_user);
        $w_user = explode("|", $w_user);
    }
    $userid = $w_user[0];
    $sid = $w_user[1];
    //$userid = intval($userid);
    if (!empty($userid) AND !empty($sid)) {
        global $db;
		$rs = $db->Execute("SELECT user_id,session_id FROM users WHERE user_id='$userid' AND session_id='$sid' AND status_online='ONLINE' AND account_status='AKTIF'");
		list($dbuserid,$dbsid) = $rs->FetchRow();
		if (($sid==strtoupper($dbsid)) && ($userid==$dbuserid)) {
			static $userSave;
			return $userSave = 1;
		}
    }
    static $userSave;
    return $userSave = 0;
}
function is_admin($w_user) {
    if (!$w_user) { return 0; }
    if (isset($userSave_S)) return $userSave_S;
    if (!is_array($w_user)) {
        $w_user = base64_decode($w_user);
        $w_user = addslashes($w_user);
        $w_user = explode("|", $w_user);
    }
    $userid = $w_user[0];
    $sid = $w_user[1];
    //$userid = intval($userid);
    if (!empty($userid) AND !empty($sid)) {
        global $db;
		$rs = $db->Execute("SELECT user_id,session_id,user_role FROM users WHERE user_id='$userid' AND session_id='$sid' AND account_status='AKTIF'");
		list($dbuserid,$dbsid,$user_role) = $rs->FetchRow();
		if (($sid==strtoupper($dbsid)) && ($userid==$dbuserid) && (strtolower($user_role)=='admin')) {
			static $userSave_S;
			return $userSave_S = 1;
		}
    }
    static $userSave_S;
    return $userSave_S = 0;
}
function getUserDetail($field,$uid=NULL) {
	global $db, $w_user;

    if ($uid != NULL) { $u_id = $uid; } else { $u_id = USERID; }
	if (is_online($w_user))
	{
		$get_field = getv($field,'users',"user_id",$u_id);
		return $get_field;
	}
	else
	{
		return '';
	}
}

/**
	TEMPLATES
*/
class Template {
   	public $template;   
   	function Load($filepath) {
      	$this->template = file_get_contents($filepath);
   	}   
   	function Replace($var, $content) {
     	$this->template = str_replace("#$var#", $content, $this->template);
   	}   
   	function Publish() {
		# Replace {D_DEFINE}
		preg_match_all('#\{D_([A-Z0-9\-_]+)\}#', $this->template, $matches2, PREG_SET_ORDER);
		foreach ($matches2 as $val2) {
			$value2 = substr($val2[0],3,-1);
			$this->template = str_replace($val2[0], "<?php echo ".$value2."; ?>", $this->template);
		}
		
		# Replace {S_DEFINE}
		preg_match_all('#\{S_([A-Z0-9\-_]+)\}#', $this->template, $matches_s, PREG_SET_ORDER);
		foreach ($matches_s as $val_s) {
			$value_s = substr($val_s[0],3,-1);
			$this->template = str_replace($val_s[0], "<?php echo removeslashes(_".$value_s."); ?>", $this->template);
		}
		
		# Replace {DEFINE}
		preg_match_all('#\{([A-Z0-9\-_]+)\}#', $this->template, $matches, PREG_SET_ORDER);
		foreach ($matches as $val) {
			$value = "_".substr($val[0],1,-1);
			$this->template = str_replace($val[0], "<?php echo ".$value."; ?>", $this->template);
		}
				
		eval('?>'.$this->template);
   	}	
   	function Evaluate($plain=NULL) {
		# Replace {D_DEFINE}
		preg_match_all('#\{D_([A-Z0-9\-_]+)\}#', $this->template, $matches2, PREG_SET_ORDER);
		foreach ($matches2 as $val2) {
			$value2 = substr($val2[0],3,-1);
			eval('$value2 = '.$value2.';');
			$this->template = str_replace($val2[0], $value2, $this->template);
		}
		
		# Replace {S_DEFINE}
		preg_match_all('#\{S_([A-Z0-9\-_]+)\}#', $this->template, $matches_s, PREG_SET_ORDER);
		foreach ($matches_s as $val_s) {
			$value_s = substr($val_s[0],3,-1);
			eval('$value_s = _'.$value_s.';');
			$this->template = str_replace($val_s[0], removeslashes($value_s), $this->template);
		}

		# Replace {DEFINE}
		preg_match_all('#\{([A-Z0-9\-_]+)\}#', $this->template, $matches, PREG_SET_ORDER);
		foreach ($matches as $val) {
			$value = "_".substr($val[0],1,-1);
			eval('$value = '.$value.';');
			$this->template = str_replace($val[0], $value, $this->template);
		}
		
		if ($plain != NULL) {
			# <br> -> new line
			preg_match_all('#<br[^>]*>#is', $this->template, $matches_br, PREG_SET_ORDER);
			foreach ($matches_br as $val_br) {
				$this->template = str_replace($val_br[0], "\n", $this->template);
			}
			
			// HTML -> Text
			preg_match_all('#<[^>]*>#is', $this->template, $matches_all, PREG_SET_ORDER);
			foreach ($matches_all as $val_all) {
				$this->template = str_replace($val_all[0], "", $this->template);
			}			
		}

		return $this->template;
   	}	
}
function EvaluateTemplate($subject, $template, $format, $data = array()) {
	global $db, $config;

	$t = new Template;
	if (strtolower($format) == 'plain')
	{
		$t->Load(WEB_TEMPLATES.strtolower($template)."-plain.tpl");
	}
	else
	{
		$t->Load(WEB_TEMPLATES.strtolower($template)."-html.tpl");
	}
	
	$t->Replace("Email_Subject",$subject);
	foreach ($data as $key => $value)
	{
		$t->Replace($key,$value);
	}
	
	if (strtolower($format) == 'plain')
	{
		$MsgReturn = $t->Evaluate('plain');
	}
	else
	{
		$MsgReturn = $t->Evaluate();
	}

	return $MsgReturn;	
}

function random_string($type = 'alnum', $len = 6) {
	switch($type) {
		case 'alnum'	:
		case 'numeric'	:
		case 'nozero'	:
		
				switch ($type) {
					case 'alnum'	:	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
					break;
					
					case 'numeric'	:	$pool = '0123456789';
					break;
					
					case 'nozero'	:	$pool = '123456789';
					break;
				}

				$str = '';
				for ($i=0; $i < $len; $i++) {
					$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
				}
				return $str;
		break;
		
		case 'unique' : return md5(uniqid(mt_rand()));
		break;
	}
}

function settimeout($content,$time) {
	echo "setTimeout(function() { $content },$time);";
}

?>