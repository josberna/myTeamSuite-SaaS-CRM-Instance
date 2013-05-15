<?php 
require_once('include/utils/utils.php');
require_once('config.inc.php');
global $adb;


$adb->query("insert into vtiger_parenttab(parenttabid ,parenttab_label ,sequence,visible) values(9,'Sales Forecast',8,0)");
$adb->query("update vtiger_parenttab set sequence=5 where parenttabid=4");
$adb->query("update vtiger_parenttab set sequence=6 where parenttabid=5");
$adb->query("update vtiger_parenttab set sequence=7 where parenttabid=6");
$adb->query("update vtiger_parenttab set sequence=8 where parenttabid=7");
$adb->query("update vtiger_parenttab set sequence=4 where parenttabid=9");


$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_SFQuotaDistribution_quota` (
				`qoid` bigint(20) NOT NULL AUTO_INCREMENT,
			    `assign_to` int(11) NOT NULL,
		        `assign_by` bigint(20) NOT NULL,
                `quota` int(11) NOT NULL,
                `start_date` date NOT NULL,
                `end_date` date NOT NULL,
                 PRIMARY KEY (`qoid`)
                 ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
				 
$adb->query("CREATE TABLE IF NOT EXISTS vtiger_SFQuotaDistribution_month 
				(
					 qid bigint(20) NOT NULL AUTO_INCREMENT,
					 period date NOT NULL,
					 quota int(11) NOT NULL,
					 PRIMARY KEY (`qid`)
				);");	
echo 'done';
?>