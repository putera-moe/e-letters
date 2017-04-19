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

define('ADODB_ASSOC_CASE', 2);

# MySQL Database
$db = newAdoConnection('mysqli');
$db->debug = $config->DatabaseDebug;
$db->connect($config->DatabaseHost,$config->DatabaseUser,$config->DatabasePass,$config->DatabaseName);
if (!$db->isConnected())
{
	die('Sambungan ke pangkalan data e-letters gagal !');
}

?>