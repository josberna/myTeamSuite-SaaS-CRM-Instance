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

require_once('config.php');
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
function horizontal_graph($referdata,$refer_code,$width,$height,$left,$right,$top,$bottom,$title,$target_val,$cache_file_name,$html_image_name)
{

		global $log,$root_directory,$lang_crm,$theme;
	//We'll be getting the values in the form of a string separated by commas
		$datay=explode("::",$referdata); // The datay values  
		$datax=explode("::",$refer_code); // The datax values  
	
	// The links values are given as string in the encoded form, here we are decoding it
		$target_val=urldecode($target_val);
		$target=explode("::",$target_val);
	
		$alts=array();
		$temp=array();
		for($i=0;$i<count($datax);$i++)
		{
			$name=$datax[$i];
			$pos = substr_count($name," ");
			$alts[]=htmlentities($name)."=%d";
	//If the daatx value of a string is greater, adding '\n' to it so that it'll cme inh 2nd line
			 if(strlen($name)>=14)
							$name=substr($name, 0, 44);
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
	
		//datay is the values
		//datax is the status
	
		// Set the basic parameters of the graph
		$canvas =& Image_Canvas::factory('png', array('width' => $width, 'height' => $height, 'usemap' => true));
		$imagemap = $canvas->getImageMap();
		$graph =& Image_Graph::factory('graph', $canvas);
		$font =& $graph->addNew('font', calculate_font_name($lang_crm));
		// set the font size to 12
		$font->setSize(8);
	
		if($theme == "blue")
		{
			$font_color = "#212473";
		}
		else
		{
			$font_color = "#000000";
		}
		$font->setColor($font_color);
			
		$graph->setFont($font);
		$titlestr =& Image_Graph::factory('title', array($title,8));
		$plotarea =& Image_Graph::factory('plotarea',array(
					'axis',
					'axis',
					'horizontal'
					));
		$graph->add(
			Image_Graph::vertical($titlestr,
				$plotarea,
			5
			)
		);   
	
	
		// Now create a bar plot
		$max=0;
		// To create unique lables we need to keep track of lable name and its count
		$uniquex = array();
		
		$xlabels = array();
		$dataset = & Image_Graph::factory('dataset');
		if($theme == 'woodspice')
			$fill =& Image_Graph::factory('gradient', array(IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED, '#804000', 'white'));
		elseif($theme == 'bluelagoon')
			$fill =& Image_Graph::factory('gradient', array(IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED, 'blue', 'white'));
		elseif($theme == 'softed')
			$fill =& Image_Graph::factory('gradient', array(IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED, 'blue', 'white'));
		else
			$fill =& Image_Graph::factory('gradient', array(IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED, 'black', 'white'));
		$index = 0;
		$datasets = array();
		$xlabels = array();
		$points=array();	
		for($i=0;$i<count($datay); $i++)
		{
	//		echo 
			$points[$i]=$datay[$i];
			// build the xaxis label array to allow intermediate ticks
	
			$xlabels[$i] = $datax[$i].' ';
	
			// To have unique names even in case of duplicates let us add the id
		}
	    /* Create and populate the pData object */
		$MyData = new pData();  
		$MyData->addPoints($points,"");
		$MyData->setAxisName(0,"");
		$MyData->setAxisUnit(0,"$");
		$MyData->addPoints($xlabels,".");
		$MyData->setSerieDescription(".",".");
		$MyData->setAbscissa(".");
		$MyData->setAbscissaName(".");
		$MyData->setAxisDisplay(0,AXIS_FORMAT_DEFAULT,1);
     	$MyData->loadPalette("include/pchart/colors/vertical.color", TRUE);
		/* Create the pChart object */
		if($width <500)
		{
			$myPicture = new pImage($width+500,$height,$MyData);
		}else
		{
			$myPicture = new pImage($width,$height,$MyData);
		}
		$myPicture->setFontProperties(array("FontName"=>"include/pchart/fonts/verdana.ttf","FontSize"=>6));
		/* Draw the scale  */
		if($width <500){
			$myPicture->setGraphArea($width/4,50,$width+150,$height);
		}else{
			$myPicture->setGraphArea($width/4,50,$width,$height);
		}
		$myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM));
		/* Draw the chart */
		$settings = array("Gradient"=>TRUE,"DisplayValues"=>TRUE,"DisplayShadow"=>TRUE,"Surrounding"=>10,"OverrideColors"=>$Palette,"DisplayR"=>0,"DisplayG"=>0,"DisplayB"=>0,"Rounded"=>TRUE);
		$myPicture->drawBarChart($settings);
		/* Write the chart legend */
		$myPicture->drawText($width/7,20,$title,array("FontSize"=>12)); 
		
		$myPicture->Render($cache_file_name);
			
		return '<img src="'.$cache_file_name.'"  />';
}

?>
