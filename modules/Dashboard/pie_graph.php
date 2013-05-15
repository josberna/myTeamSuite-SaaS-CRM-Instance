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


require_once('include/utils/GraphUtils.php');
include_once ('Image/Graph.php');
include_once ('Image/Canvas.php');
/* pChart */
include_once('include/pchart/class/pData.class.php');
include_once('include/pchart/class/pDraw.class.php');
include_once('include/pchart/class/pImage.class.php');
include_once('include/pchart/class/pPie.class.php');

/** Function to render the Horizontal Graph
  * Portions created by vtiger are Copyright (C) vtiger.
  * All Rights Reserved.
  * Contributor(s): ______________________________________..
  */
function pie_chart($referdata,$refer_code,$width,$height,$left,$right,$top,$bottom,$title,$target_val,$cache_file_name,$html_image_name)
{
	global $log,$root_directory,$lang_crm,$theme;
	//We'll be getting the values in the form of a string separated by commas
	$datay=explode("::",$referdata); // The datay values
	$datax=explode("::",$refer_code); // The datax values

	$target_val=urldecode($target_val);
	$target=explode("::",$target_val);

	$alts=array();
	$temp=array();
	for($i=0;$i<count($datax); $i++)
	{
		$name=$datax[$i];
		$pos = substr_count($name," ");
		$alts[]=htmlentities($name)."=%d";
		//If the datax value of a string is greater, adding '\n' to it so that it'll come in 2nd line
		if(strlen($name)>=14)
			$name=substr($name, 0, 34);
		if($pos>=2)
		{
			$val=explode(" ",$name);
			$n=count($val)-1;

			$x="";
			for($j=0;$j<count($val);$j++)
			{
				if($j != $n)
				{
					$x  .=" ". $val[$j];
				}
				else
				{
					$x .= "@#".$val[$j];
				}
			}
			$name = $x;
		}
		$name=str_replace("@#", "\n",$name);
		$temp[]=$name; 
	}
	$datax=$temp;

    $width = $width + 140;	
	$uniquex = array();
	// Generate colours
	$sum = 0;
	$xLabels=array();
	for($i=0;$i<count($datay); $i++)
	{
		if(isset($_REQUEST['display_view']) && $_REQUEST['display_view']== 'MATRIX')
		{
			$datax[$i]=trim($datax[$i]);
			if(strlen($datax[$i]) <= 10)
				$datax[$i]=$datax[$i];
			else
				$datax[$i]= substr($datax[$i],0,10)."..";
		}
		// To have unique names even in case of duplicates let us add the id
		$datalabel = $datax[$i];
		$datax_appearance = $uniquex[$datax[$i]];
		if($datax_appearance == null) {
				$uniquex[$datax[$i]] = 1;			
		} else {
			$datalabel = $datax[$i] . ' ['.$datax_appearance.']';
			$uniquex[$datax[$i]] = $datax_appearance + 1;			
		}
		$xLabels[$i]=$datalabel;
	    $sum += $datay[$i];
	}

	// create an array with % values
	$pcvalues = array();
	for($i=0;$i<count($datay); $i++)
	{
		$pcvalues[$i] = sprintf('%0.1f%%',100*$datay[$i]/$sum);
	}

	$MyData = new pData();   
	$MyData->setSerieDescription("ScoreA","Application A");
	
	$MyData->addPoints($pcvalues,"ScoreA");  
	$MyData->setSerieDescription("ScoreA","Application A");

	$MyData->addPoints($xLabels,"Labels");
	$MyData->setAbscissa("Labels");
	$MyData->loadPalette("include/pchart/colors/light.color", TRUE);
	if($width <500)
	{
		$myPicture = new pImage($width,$height,$MyData,TRUE);
	}else
	{
		$myPicture = new pImage($width,$height,$MyData,TRUE);
	}
	
	$RectangleSettings = array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>30);
	$myPicture->drawRoundedFilledRectangle(0,0,$width,$height,0,$RectangleSettings);
	
	$myPicture->setFontProperties(array("FontName"=>"include/pchart/fonts/verdana.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));
	
	$PieChart = new pPie($myPicture,$MyData);
	
	$myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
	$PieChart->draw3DPie($width/3,$height/3,array("Radius"=>$width/5,"DataGapAngle"=>12,"DataGapRadius"=>10,"Border"=>TRUE));
	$myPicture->drawText($width/7,20,$title,array("FontSize"=>12)); 
	$myPicture->setFontProperties(array("FontName"=>"include/pchart/fonts/verdana.ttf","FontSize"=>9,"R"=>0,"G"=>0,"B"=>0));
	$PieChart->drawPieLegend($width/1.6,$height/5.5,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_VERTICAL,"BoxSize"=>15));
	
	$myPicture->Render($cache_file_name);
		
	return '<img src="'.$cache_file_name.'" />';

}
?>

