<?php

require_once('config.php');

include_once('include/pchart/class/pData.class.php');
include_once('include/pchart/class/pDraw.class.php');
include_once('include/pchart/class/pImage.class.php');
include_once('include/pchart/class/pPie.class.php');

function get_chart()
{
	global $log,$root_directory,$lang_crm,$theme,$adb,$current_user;
	
	$amount = '';
	$salestage = '';
	$sales_stage=array();
	$max_date=array();	
	
	$result=$adb->query("select sales_stage from vtiger_sales_stage");
	$no_acc_rows=$adb->num_rows($result);
	
	//GET SALES RECORDS
	if($no_acc_rows!=0)
	{
		$count=0;
		while($acc_row = $adb->fetch_array($result))
		{
			$sales_stage[$count]=$acc_row['sales_stage'];
			$count++;
		}
	}
	
	$salestage =  substr($salestage,0,strlen($salestage)-1);
	
	//GET MAX/MIN DATEs
	$count=0;
	foreach($sales_stage as $stage)
	{
		$query="select amount,lastmodified from vtiger_potstagehistory where lower(stage)='".strtolower($stage)."' order by lastmodified desc limit 1";
		$result = $adb->run_query_record($query);
		if(!empty($result[0]))
		{
			$max_date[$count]=$result[0];
 			//$sales_stage[$count]= '$'.$result[0].' - '.$sales_stage[$count];
		}else
		{
			$max_date[$count]=VOID;
			//$sales_stage[$count]= '$0 - '.$sales_stage[$count];
		}
		$count++;
	}
	$width=600;
	$height=270;
	$MyData = new pData();   
    $MyData->addPoints($max_date,"ScoreA");  
	$MyData->setSerieDescription("ScoreA","Application A");
	
	/* Define the absissa serie */
	$MyData->addPoints($sales_stage,"Labels");
	$MyData->setAbscissa("Labels");
	$MyData->loadPalette("include/pchart/colors/light.color", TRUE);
	/* Create the pChart object */
	$myPicture = new pImage($width,$height,$MyData);
	
	/* Overlay with a gradient */
	//$Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50);
	//$myPicture->drawGradientArea(0,0,400,400,DIRECTION_VERTICAL,$Settings);
	//$myPicture->drawGradientArea(0,0,$width,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>100));
	
	/* Add a border to the picture */
	$myPicture->drawRectangle(0,0,$width-1,$height-1,array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>0));
	
	/* Write the picture title */ 
	$myPicture->setFontProperties(array("FontName"=>"include/pchart/fonts/verdana.ttf","FontSize"=>12));
	$myPicture->drawText(10,17,"Opportunities by Sales Stage",array("R"=>0,"G"=>0,"B"=>0));
	
	/* Set the default font properties */ 
	$myPicture->setFontProperties(array("FontName"=>"include/pchart/fonts/verdana.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));
	
	/* Enable shadow computing */ 
	$myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>50));
	
	/* Create the pPie object */ 
	$PieChart = new pPie($myPicture,$MyData);
	
	/* Draw an AA pie chart */ 
	$PieChart->draw3DRing(($width/3) - 10,$height/2,array("WriteValues"=>TRUE));
	
	/* Write the legend box */ 
	$PieChart->drawPieLegend(($width/1.5)- 20,$height/5,array("Mode"=>LEGEND_VERTICAL,"Style"=>LEGEND_NOBORDER,"Alpha"=>20));

	$myPicture->Render('cache/images/pie3DHome'.$current_user->id.'.png');
	
	return "<img src=\"cache/images/pie3DHome".$current_user->id.".png\"  />";
}
?>