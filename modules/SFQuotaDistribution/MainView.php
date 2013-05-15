<?php 
global $app_strings, $mod_strings, $current_language, $currentModule, $theme;
global $list_max_entries_per_page, $adb;
require_once('Smarty_setup.php');
?>

<link  href="modules/SFQuotaDistribution/css/Style.css" rel="stylesheet" type="text/css">
  <script src="modules/SFQuotaDistribution/js/jquery.js" type="text/javascript" ></script>
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
			
	<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>Sales Forecast > <a class="hdrLink" href="index.php?module=SFQuotaDistribution&action=index&parenttab=Sales&area=3">Quota Distribution</a></td>
	</td>
</tr>
</TABLE>
 <hr/>
 </div>
<div class="mainDiv">
   	<div style="float:right;position:absolute;width:100px;">
    	 <img id="imgProcess" src="modules/SFQuotaDistribution/img/processing.gif" alt="Processing"/>
    </div>

    <div class="Pane1" id="Body1">
        <div class="Qtr">
            <div style="margin:3px 0px 0px 3px;float:left;vertical-align:middle;line-height:50px;border:1px solid Black;">&nbsp;
              <input id="sdate_1" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['sdate1']))
			  																echo '01-'.date('M-Y'); 
																		else
																			echo $_SESSION['sdate1'];
																	?>" />
              &nbsp;-&nbsp;
              <input id="edate_1" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate1']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('M-Y');
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
			  																echo '01-'.date('M-Y'); 
																		else
																			echo $_SESSION['sdate2'];
																	?>" />
              &nbsp;-&nbsp;
              <input id="edate_2" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate2']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('M-Y');
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
			  																echo '01-'.date('M-Y'); 
																		else
																			echo $_SESSION['sdate3'];
																	?>" />
              &nbsp;-&nbsp;
              <input id="edate_3" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate3']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('M-Y');
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
			  																echo '01-'.date('M-Y'); 
																		else
																			echo $_SESSION['sdate4'];
																	?>"/>
              &nbsp;-&nbsp;
              <input id="edate_4" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate4']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('M-Y');
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
</div>

<script type="text/javascript">
 
$j(document).ready(function() {
  $j('#DetailView').hide();
  $j('#imgProcess').hide();
});
/* PAN - O */
function QuotaDistribute(index)
{
 	var msg ='<legend><h3>Quota Assignment</h3></legend>';
    $j("#DetailView").html(msg);
	$j('#imgProcess').show();
	$j.ajax({
         type: "POST",
         cache: false,
		 data: 
		 'M=1&Type=1&module=SFQuotaDistribution&action=SFQuotaDistributionAjax&file=HomestuffAjax&sdate='+$j('#sdate_'+index).val()+'&edate='+$j('#edate_'+index).val()+'&pindex='+index,
         url: 'index.php',
         success: function (msg) 
		 {
		 	 $j('#container_'+index).html(msg);
  		     if(index=='1')
			 {
				   $j('#p2_sdate').val($j('#sdate_1').val());
				   $j('#p2_edate').val($j('#edate_1').val());
			 }
			 $j('#imgProcess').hide();
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
		$j('#arrow_'+element).closest('img').attr('src','modules/SFQuotaDistribution/img/'+imgs[1]);
		$j('#imgProcess').show();
		$j.ajax({
        	 type: "POST",
	         cache: false,
			 data: 'M=1&Type=2&module=SFQuotaDistribution&action=SFQuotaDistributionAjax&file=HomestuffAjax&sdate='+sdate+'&edate='+ldate+'&pindex='+index,
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
		$j('#arrow_'+element).closest('img').attr('src','modules/SFQuotaDistribution/img/'+imgs[0]);
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
		 data: vals+'&M=1&Type=3&module=SFQuotaDistribution&action=SFQuotaDistributionAjax&file=HomestuffAjax&sdate='+$j('#sdate_'+index).val()+'&edate='+$j('#edate_'+index).val()+'&pindex='+index,
		 url: 'index.php',
		 success: function (msg) 
		 {
			 $j('#container_'+index).html(msg);
		     $j("#DetailView").hide();
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
		 data: '&M=1&&Type=4&module=SFQuotaDistribution&action=SFQuotaDistributionAjax&file=HomestuffAjax&quota='+$j(element).val()+'&period='+date+'&sdate='+$j('#sdate_'+index).val()+'&edate='+$j('#edate_'+index).val()+'&pindex='+index,
		 url: 'index.php',
		 success: function (msg) 
		 {
	         $j('#container_'+index).html(msg);
		     $j('#imgProcess').hide();
		 }
		});
}
</script>
<script type="text/javascript">
	$j(document).ready(function() 
	{
		$j("#imgProcess").show();
		<?php
		for($count=1;$count<=4;$count++)
		{
		   if(!empty($_SESSION['sdate'.$count]))
		   {
		     echo 'setTimeout(function(){QuotaDistribute("'.$count.'");},1000);';
		   }
		}
		?>
		$j("#imgProcess").hide();
	});
</script>