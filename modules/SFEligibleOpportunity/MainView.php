<?php 
global $app_strings, $mod_strings, $current_language, $currentModule, $theme;
global $list_max_entries_per_page, $adb;

require_once('Smarty_setup.php');
?>

<link  href="modules/SFEligibleOpportunity/css/Style.css" rel="stylesheet" type="text/css">
  <script src="modules/SFEligibleOpportunity/js/jquery.js" type="text/javascript" ></script>
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
	<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><div style="width:350px;">Sales Forecast > <a class="hdrLink" href="index.php?module=SFEligibleOpportunity&action=index&parenttab=Sales&area=3">Opportunities Eligible</a></div></td>
	</td>
</tr>
</TABLE>
 <hr/>
 </div>
<div class="mainDiv">
   	<div style="float:left;height:35px;vertical-align:middle;width:140px;line-height:45px;">
    	 <img id="imgProcess" src="modules/SFEligibleOpportunity/img/processing.gif" alt="Processing"/>
    </div>
    <div class="Pane1" id="Body2"> 
        <table border="0" cellspacing="1" cellpadding="3" class="lvt small" style="width:100%;" id="pane1_tbl">
            <tbody> 
            <tr style="line-height:35px;text-align:center;">
	            <td colspan="8">
    	            <strong>Close Date:</strong>&nbsp;&nbsp;&nbsp;
        	        <input id="p2_sdate" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['sdate']))
			  																echo '01-'.date('M-Y'); 
																		else
																			echo $_SESSION['sdate'];
																	?>" />
            	    &nbsp;-&nbsp;
                	<input id="p2_edate" type="text" class="input" value="<?php 
			  															if(empty($_SESSION['edate']))
			  																echo cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-'.date('M-Y');
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
</div>

<script type="text/javascript">
 
$j(document).ready(function() {
	/* MAIN MENU */
	$j('#DetailView').hide();
    $j('#imgProcess').hide();
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
		 'M=2&Type=1&module=SFEligibleOpportunity&action=SFEligibleOpportunityAjax&file=HomestuffAjax&sdate='+$j('#p2_sdate').val()+'&edate='+$j('#p2_edate').val(),
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
		 'M=2&Type=2&module=SFEligibleOpportunity&action=SFEligibleOpportunityAjax&file=HomestuffAjax&pid='+potential_id+'&val='+$j(element).val(),
         url: 'index.php',
         success: function (msg) 
		 {
			 $j('#imgProcess').hide();
         }
    });
	return false;
}
</script>