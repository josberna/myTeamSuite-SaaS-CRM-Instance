<?php 
global $app_strings, $mod_strings, $current_language, $currentModule, $theme;
global $list_max_entries_per_page, $adb;

require_once('Smarty_setup.php');
?>
<?php
/*	global $adb;
	
	$adb->query("CREATE TABLE IF NOT EXISTS `vtiger_salesforecast_quota` (
				`qoid` bigint(20) NOT NULL AUTO_INCREMENT,
			    `assign_to` int(11) NOT NULL,
		        `assign_by` bigint(20) NOT NULL,
                `quota` int(11) NOT NULL,
                `start_date` date NOT NULL,
                `end_date` date NOT NULL,
                 PRIMARY KEY (`qoid`)
                 ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
				 
	$adb->query("CREATE TABLE IF NOT EXISTS vtiger_salesforecasttype_month 
				(
					 qid bigint(20) NOT NULL AUTO_INCREMENT,
					 period date NOT NULL,
					 quota int(11) NOT NULL,
					 PRIMARY KEY (`qid`)
				);");	*/			 
?>
<link  href="modules/SalesForecast/css/Style.css" rel="stylesheet" type="text/css">
  <script src="modules/SalesForecast/js/jquery.js" type="text/javascript" ></script>
  <script type="text/javascript">
	  var $j = jQuery;
  </script>
  <script language="JavaScript" type="text/javascript" src="include/js/json.js"></script> 
  <script language="JavaScript" type="text/javascript" src="include/js/general.js"></script> 
  <!-- vtlib customization: Javascript hook --> 
  <script language="JavaScript" type="text/javascript" src="include/js/vtlib.js"></script> 
  <!-- END --> 
  <script language="JavaScript" type="text/javascript" src="include/js/en_us.lang.js?"></script> 
  <script language="JavaScript" type="text/javascript" src="include/js/QuickCreate.js"></script> 
  <script type="text/javascript" src="include/scriptaculous/prototype.js"></script> 
  <script type="text/javascript" src="include/scriptaculous/scriptaculous.js"></script> 
  <script type="text/javascript" src="include/scriptaculous/accordion.js"></script> 
  <script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script> 
  <script language="JavaScript" type="text/javascript" src="include/calculator/calc.js"></script> 
  <script language="JavaScript" type="text/javascript" src="modules/Calendar/script.js"></script> 
  <script language="javascript" type="text/javascript" src="include/scriptaculous/dom-drag.js"></script> 
  <script language="JavaScript" type="text/javascript" src="include/js/notificationPopup.js"></script> 
  <script type="text/javascript" src="jscalendar/calendar.js"></script> 
  <script type="text/javascript" src="jscalendar/calendar-setup.js"></script> 
  <script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script> 
  <!-- asterisk Integration --> 
 <div>
 		<script type="text/javascript" src="modules/Potentials/Potentials.js"></script>
<!--START BUTTONS-->
<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class="small homePageButtons">
<tr style="cursor: pointer;">
			
	<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>Sales Management > <a class="hdrLink" href="index.php?module=SalesForecast&action=index&parenttab=Sales&area=3">Sales Forecast</a></td>
	</td>
</tr>
</TABLE>
 </div>
<div class="mainDiv">
	<div class="childPan" id="pan1">Quota Distribution</div>
	<div class="childPan" id="pan2">Opportunities Eligible for Forecast </div>
	<div class="childPan" id="pan3">Forecast Details </div>
	<div class="childPan" id="pan4">Forecast Summary</div>
   	<div style="float:left;height:35px;vertical-align:middle;width:140px;line-height:45px;">
    	 <img id="imgProcess" src="modules/SalesForecast/img/processing.gif" alt="Processing"/>
    </div>

    <div class="Pane1" id="Body1">
        <div class="Qtr">
            <div style="margin:3px 0px 0px 3px;float:left;vertical-align:middle;line-height:50px;border:1px solid Black;">&nbsp;
              <input id="sdate_1" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['sdate1']))
			  																echo '01-'.date('-M-Y'); 
																		else
																			echo $_SESSION['sdate1'];
																	?>" />
              &nbsp;-&nbsp;
              <input id="edate_1" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate1']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('-M-Y');
																		else
																			echo $_SESSION['edate1'];
																	?>" />
              <input type="button" onclick="javascript:QuotaDistribute('1');" value="Confirm" class="crmbutton small edit" />&nbsp;
           </div>
           <div id="container_1" style="margin:3px 3px 0 0;width:77%;float:right;height:50px;background-color:White;">
           </div>
        </div>
        <div class="Qtr">
            <div style="margin:3px 0px 0px 3px;float:left;vertical-align:middle;line-height:50px;border:1px solid Black;">&nbsp;
              <input id="sdate_2" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['sdate2']))
			  																echo '01-'.date('-M-Y'); 
																		else
																			echo $_SESSION['sdate2'];
																	?>" />
              &nbsp;-&nbsp;
              <input id="edate_2" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate2']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('-M-Y');
																		else
																			echo $_SESSION['edate2'];
																	?>" />
              <input type="button" onclick="javascript:QuotaDistribute('2');" value="Confirm"  class="crmbutton small edit" />&nbsp;
           </div>
           <div id="container_2" style="margin:3px 3px 0 0;width:77%;float:right;height:50px;background-color:White;">
           </div>
        </div>
         <div class="Qtr">
            <div style="margin:3px 0px 0px 3px;float:left;vertical-align:middle;line-height:50px;border:1px solid Black;">&nbsp;
              <input id="sdate_3" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['sdate3']))
			  																echo '01-'.date('-M-Y'); 
																		else
																			echo $_SESSION['sdate3'];
																	?>" />
              &nbsp;-&nbsp;
              <input id="edate_3" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate3']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('-M-Y');
																		else
																			echo $_SESSION['edate3'];
																	?>"/>
              <input type="button" onclick="javascript:QuotaDistribute('3');" value="Confirm"  class="crmbutton small edit" />&nbsp;
           </div>
           <div id="container_3" style="margin:3px 3px 0 0;width:77%;float:right;height:50px;background-color:White;">
           </div>
        </div>
        <div class="Qtr">
            <div style="margin:3px 0px 0px 3px;float:left;vertical-align:middle;line-height:50px;border:1px solid Black;">&nbsp;
              <input id="sdate_4" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['sdate4']))
			  																echo '01-'.date('-M-Y'); 
																		else
																			echo $_SESSION['sdate4'];
																	?>"/>
              &nbsp;-&nbsp;
              <input id="edate_4" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate4']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('-M-Y');
																		else
																			echo $_SESSION['edate4'];
																	?>" />
              <input type="button" onclick="javascript:QuotaDistribute('4');" value="Confirm" class="crmbutton small edit" />&nbsp;
           </div>
           <div id="container_4" style="margin:3px 3px 0 0;width:77%;float:right;height:50px;background-color:White;">
           </div>
        </div>
        <div>
             <fieldset id="DetailView" style="float:left;width:98%;">
       <legend><h3>Quota Assignment</h3></legend>
   	       &nbsp;
     </fieldset>
        </div>
    </div>
    <div class="Pane1" id="Body2"> 
        <table border="0" cellspacing="1" cellpadding="3" class="lvt small" style="width:100%;" id="pane1_tbl">
            <tbody> 
            <tr style="line-height:35px;text-align:center;">
	            <td colspan="8">
    	            <strong>Close Date:</strong>&nbsp;&nbsp;&nbsp;
        	        <input id="p2_sdate" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['sdate']))
			  																echo '01-'.date('-M-Y'); 
																		else
																			echo $_SESSION['sdate'];
																	?>" />
            	    &nbsp;-&nbsp;
                	<input id="p2_edate" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('-M-Y');
																		else
																			echo $_SESSION['edate'];
																	?>" />
                    &nbsp;&nbsp;
                    <input type="button" onclick="javascript:GetPotential();" value="Confirm" class="crmbutton small edit" />
	             </td>
            </tr>
            <tr>
                <td class="lvtCol"><a href="javascript:void(0);"> Potential Name</a></td>
                <td class="lvtCol"><a href="javascript:void(0);"> Assigned Name </a></td>
                <td class="lvtCol"><a href="javascript:void(0);"> Amount ($) </a></td>
                <td class="lvtCol"><a href="javascript:void(0);"> Sale Stage </a></td>
                <td class="lvtCol"><a href="javascript:void(0);"> Next Steps </a></td>
                <td class="lvtCol"><a href="javascript:void(0);"> Probability </a></td>
                <td class="lvtCol"><a href="javascript:void(0);"> Commit / Upside </a></td>
                <td class="lvtCol"><a href="javascript:void(0);"> Closing Date </a></td>
                <td class="lvtCol"><a href="javascript:void(0);"> Period </a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="Pane1" id="Body3">
	    <div style="float:left;">
            <div class="div_header" style="border:none;">
                &nbsp;
            </div>
            <div>
                <div class="div_menu_item">
                <br />
                   Current Week
                </div>
            </div>
            <div>
                <div class="div_menu_item">
                <br />
                  Following Week
                </div>
            </div>
            <div>
                <div class="div_menu_item">
                <br />
                  Total
                </div>
            </div>
        </div>
        <div style="float:left">
        	<?php include("Ajax/Module3.php"); ?>
        </div>
    </div>
    <div class="Pane1" id="Body4"> 
    	<div style="float:left;">
            <div class="div_header" style="border:none;">
                &nbsp;
            </div>
            <div>
                <div class="div_menu_item">
                <br />
                   Current Week
                </div>
            </div>
            <div>
                <div class="div_menu_item">
                <br />
                  Following Week
                </div>
            </div>
             <div>
                <div class="div_menu_item">
                <br />
                  60 - Days
                </div>
            </div>
             <div>
                <div class="div_menu_item">
                <br />
                  90 - Days
                </div>
            </div>
             <div>
                <div class="div_menu_item">
                <br />
                  120 - Days
                </div>
            </div>
            <div>
                <div class="div_menu_item">
                <br />
                  Total
                </div>
            </div>
        </div>
        <div style="float:left">
        	<?php include("Ajax/Module4.php"); GetPane3();?>
        </div>
     </div>

</div>

<script type="text/javascript">
 
$j(document).ready(function() {
	/* MAIN MENU */
	$j('#DetailView').hide();
	var last='1';
	$j('div[id*="pan"]').bind({ 
		click: function() 
		{
			if(confirm('do you want to switch the module ?'))
			{
				if(last)
				{
					$j('#pan'+last).css("background-color","#003366");
					$j('#pan'+last).css("color","#CCCCCC");
					$j('#Body'+last).hide();
				}
				$j(this).css("background-color","#568EC5");
				$j(this).css("color","White");
				last = $j(this).attr('id').replace('pan','');
				$j('#DetailView').hide();
				$j('#Body'+last).show();
			}
		},
		mouseover: function() 
		{
			$j(this).css('border-color','#568EC5');
		},
		mouseout: function() 
		{
			$j(this).css('border-color','');
		}
  });
  $j('#div_btn1,#div_btn2,#div_btn3,#div_btn4,#div_btn5').bind({ 
		click: function() 
		{
			 $j(this).children().attr('checked','checked');
		}
  });
  $j('#pan1').css("background-color","#568EC5");
  $j('#pan1').css("color","White");
  $j('#Body2').hide();  $j('#Body3').hide();  $j('#Body4').hide();$j('#imgProcess').hide();

  /* MODULE # 1 */
});
/* PAN - 1 */
function GetPotential()
{
	 
	$j('#imgProcess').show();
	$j.ajax({
         type: "POST",
         cache: false,
		 data: 
		 'M=2&Type=1&module=SalesForecast&action=SalesForecastAjax&file=HomestuffAjax&sdate='+$j('#p2_sdate').val()+'&edate='+$j('#p2_edate').val(),
         url: 'index.php',
         success: function (msg) 
		 {
 	 	    $j('tr[id*="row_pane1_"]').remove();
			$j('#pane1_tbl').append(msg);
			$j('#imgProcess').hide();
         }
    });
}
function UpdateAction(element,potential_id)
{
	 
	$j('#imgProcess').show();
	$j.ajax({
         type: "POST",
         cache: false,
		 data: 
		 'M=2&Type=2&module=SalesForecast&action=SalesForecastAjax&file=HomestuffAjax&pid='+potential_id+'&val='+$j(element).val(),
         url: 'index.php',
         success: function (msg) 
		 {
			 $j('#imgProcess').hide();
         }
    });
	return false;
}
/* PAN - O */
function QuotaDistribute(index)
{
	 
	//alert($j('#sdate_'+index).val()+'&edate='+$j('#edate_'+index).val()+'&pindex='+index);
 	var msg ='<legend><h3>Quota Assignment</h3></legend>';
    $j("#DetailView").html(msg);
	$j('#imgProcess').show();
	$j.ajax({
         type: "POST",
         cache: false,
		 data: 
		 'M=1&Type=1&module=SalesForecast&action=SalesForecastAjax&file=HomestuffAjax&sdate='+$j('#sdate_'+index).val()+'&edate='+$j('#edate_'+index).val()+'&pindex='+index,
         url: 'index.php',
         success: function (msg) 
		 {
		 	 $j('#container_'+index).html(msg);
  		     if(index=='1')
			 {
				   $j('#p2_sdate').val($j('#sdate_1').val());
				   $j('#p2_edate').val($j('#edate_1').val());
			 }
//			 $j('#imgProcess').hide();
         }
    });
    if(index=='1')GetPotential();
}
function QuotaDetail(element,sdate,ldate,index)
{
	 
	var imgs=["up.png","down.png"];
	var src = $j('#arrow_'+element).closest('img').attr('src')+'';
	if(src.indexOf(imgs[0])>0)
	{	
		$j('#arrow_'+element).closest('img').attr('src','modules/SalesForecast/img/'+imgs[1]);
		$j('#imgProcess').show();
		$j.ajax({
        	 type: "POST",
	         cache: false,
			 data: 'M=1&Type=2&module=SalesForecast&action=SalesForecastAjax&file=HomestuffAjax&sdate='+sdate+'&edate='+ldate+'&pindex='+index,
	         url: 'index.php',
        	 success: function (msg) 
			 {
				 $j('#DetailView').show();
			 	 msg ='<legend><h3>Quota Assignment</h3></legend>'+msg;
		 		 $j("#DetailView").html(msg);
				 $j('#imgProcess').hide();
    	     }
    		});
	}else
	{
		$j('#DetailView').hide();
		$j('#arrow_'+element).closest('img').attr('src','modules/SalesForecast/img/'+imgs[0]);
	 	var msg ='<legend><h3>Quota Assignment</h3></legend>';
	    $j("#DetailView fieldset:first").html(msg);
	}

	//$j("#DetailView fieldset:first").html(sdate + ' '+ ldate);
}
function AssignQuota(index)
{
	 
    $j("#msg").html('Saving...');
	var elems = $j('input[name*="Pane0_"]');
	var vals = 'vals=';
	for(var count=0 ; count<elems.length-1;)
	{
		vals +=$j(elems[count]).val()+',';
		count +=1;
		vals +=$j(elems[count]).val()+',';
		count +=1;
		vals +=$j(elems[count]).val()+'$';
		count +=1;
	}

	$j('#imgProcess').show();
	$j.ajax({
		 type: "POST",
		 cache: false,
		 data: vals+'&M=1&Type=3&module=SalesForecast&action=SalesForecastAjax&file=HomestuffAjax&sdate='+$j('#sdate_'+index).val()+'&edate='+$j('#edate_'+index).val()+'&pindex='+index,
		 url: 'index.php',
		 success: function (msg) 
		 {
			 $j('#container_'+index).html(msg);
			 var msg ='<legend><h3>Quota Assignment</h3></legend>';
		     $j("#DetailView").html(msg);
			 $j("#msg").html('');
			 $j('#imgProcess').hide();
		 }
		});
}
function AssignMonthQuota(date,element,index)
{
	 
	$j('#imgProcess').show();
	$j.ajax({
		 type: "POST",
		 cache: false,
		 data: '&M=1&&Type=4&module=SalesForecast&action=SalesForecastAjax&file=HomestuffAjax&quota='+$j(element).val()+'&period='+date+'&sdate='+$j('#sdate_'+index).val()+'&edate='+$j('#edate_'+index).val()+'&pindex='+index,
		 url: 'index.php',
		 success: function (msg) 
		 {
	         $j('#container_'+index).html(msg);
		     $j('#imgProcess').hide();
		 }
		});
}
/* PAN - 2 */
function GetViewForPane2()
{
	 
	$j('#imgProcess').show();
	$j.ajax({
         type: "POST",
         cache: false,
		 data: 
		 'M=3&module=SalesForecast&action=SalesForecastAjax&file=HomestuffAjax',
         url: 'index.php',
         success: function (msg) 
		 {
 	 	    $j('tr[id*="row_pane1_"]').remove();
			$j('#pane1_tbl').append(msg);
			$j('#imgProcess').hide();
         }
    });
}
</script>
<?php
for($count=1;$count<=4;$count++)
{
   if(!empty($_SESSION['sdate'.$count]))
     echo '<script type="text/javascript">
			 $j(document).ready(function() {
	 			$j("#imgProcess").show();QuotaDistribute("'.$count.'");
				});
			</script>';
}
/*
echo '<script type="text/javascript">$j("#imgProcess").show();GetPotential();</script>';
*/
?>