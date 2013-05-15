{*<!--

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

-->*}

{*<!-- module header -->*} 
<script language="JavaScript" type="text/javascript" src="modules/Reports/Reports.js"></script> 
<!--START BUTTONS-->

<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class="small homePageButtons">
<tr style="cursor: pointer;">
	{assign var="MODULELABEL" value=$MODULE|@getTranslatedString:$MODULE}
	{if $CATEGORY eq 'Settings'}
<!-- No List View in Settings - Action is index -->
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap><a class="hdrLink" href="index.php?action=index&module={$MODULE}&parenttab={$CATEGORY}">{$MODULELABEL}</a></td>
	{else}
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} > <a class="hdrLink" href="index.php?action=ListView&module={$MODULE}&parenttab={$CATEGORY}">{$MODULELABEL}</a></td>
	{/if}
	<td width=100% nowrap>
	
		<table border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td class="sep1" style="width:1px;"></td>
		<td class=small >
			<!-- Add and Search -->
			<table border=0 cellspacing=0 cellpadding=0>
			<tr>
			<td>
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					{if $CHECK.EditView eq 'yes'}
			        		{if $MODULE eq 'Calendar'}
		                      	        	<td style="padding-right:0px;padding-left:10px;"><a href="javascript:;" id="showSubMenu"  onMouseOver="fnvshobj(this,'reportLay');" onMouseOut="fninvsh('reportLay');"><img src="{$IMAGE_PATH}btnL3Add.gif" alt="{$APP.LBL_CREATE_BUTTON_LABEL} {$SINGLE_MOD|getTranslatedString:$MODULE}..." title="{$APP.LBL_CREATE_BUTTON_LABEL} {$SINGLE_MOD|getTranslatedString:$MODULE}..." border=0></a></td>
                	   			 {else}
	                        		       	<td style="padding-right:0px;padding-left:10px;"><a href="index.php?module={$MODULE}&action=EditView&return_action=DetailView&parenttab={$CATEGORY}"><img src="{$IMAGE_PATH}btnL3Add.gif" alt="{$APP.LBL_CREATE_BUTTON_LABEL} {$SINGLE_MOD|getTranslatedString:$MODULE}..." title="{$APP.LBL_CREATE_BUTTON_LABEL} {$SINGLE_MOD|getTranslatedString:$MODULE}..." border=0></a></td>
			                       	{/if}
					{else}
						<td style="padding-right:0px;padding-left:10px;"><img src="{'btnL3Add-Faded.gif'|@vtiger_imageurl:$THEME}" border=0></td>	
					{/if}
									
						<td style="padding-right:10px"><img src="{'btnL3Search-Faded.gif'|@vtiger_imageurl:$THEME}" border=0></td>
					
				</tr>
				</table>
			</td>
			</tr>
			</table>
		</td>
		<td style="width:20px;">&nbsp;</td>
		<td class="small">
			<!-- Calendar Clock Calculator and Chat -->
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					{if $CALENDAR_DISPLAY eq 'true'} 
 		                                                {if $CATEGORY eq 'Settings' || $CATEGORY eq 'Tools' || $CATEGORY eq 'Analytics'} 
 		                                                        {if $CHECK.Calendar eq 'yes'} 
 		                                                                <td style="padding-right:0px;padding-left:10px;"><a href="javascript:;" onClick='fnvshobj(this,"miniCal");getMiniCal("parenttab=My Home Page");'><img src="{$IMAGE_PATH}btnL3Calendar.gif" alt="{$APP.LBL_CALENDAR_ALT}" title="{$APP.LBL_CALENDAR_TITLE}" border=0></a></a></td> 
						{else}
                                                <td style="padding-right:0px;padding-left:10px;"><img src="{'btnL3Calendar-Faded.gif'|@vtiger_imageurl:$THEME}"></td>
                                                {/if}
					{else}
						{if $CHECK.Calendar eq 'yes'} 
 		                                                                <td style="padding-right:0px;padding-left:10px;"><a href="javascript:;" onClick='fnvshobj(this,"miniCal");getMiniCal("parenttab={$CATEGORY}");'><img src="{$IMAGE_PATH}btnL3Calendar.gif" alt="{$APP.LBL_CALENDAR_ALT}" title="{$APP.LBL_CALENDAR_TITLE}" border=0></a></a></td> 
 		                                                        {else} 
 		                                                                <td style="padding-right:0px;padding-left:10px;"><img src="{'btnL3Calendar-Faded.gif'|@vtiger_imageurl:$THEME}"></td> 
								{/if}
 		                               {/if} 
					{/if}
					{if $WORLD_CLOCK_DISPLAY eq 'true'} 
 		                                                <td style="padding-right:0px"><a href="javascript:;"><img src="{$IMAGE_PATH}btnL3Clock.gif" alt="{$APP.LBL_CLOCK_ALT}" title="{$APP.LBL_CLOCK_TITLE}" border=0 onClick="fnvshobj(this,'wclock');"></a></a></td> 
 		                                        {/if} 
 		                                        {if $CALCULATOR_DISPLAY eq 'true'} 
 		                                                <td style="padding-right:0px"><a href="#"><img src="{$IMAGE_PATH}btnL3Calc.gif" alt="{$APP.LBL_CALCULATOR_ALT}" title="{$APP.LBL_CALCULATOR_TITLE}" border=0 onClick="fnvshobj(this,'calculator_cont');fetch_calc();"></a></td> 
 		                                        {/if} 
 		                                        {if $CHAT_DISPLAY eq 'true'} 
 		                                                <td style="padding-right:0px"><a href="javascript:;" onClick='return window.open("index.php?module=Home&action=vtchat","Chat","width=600,height=450,resizable=1,scrollbars=1");'><img src="{$IMAGE_PATH}tbarChat.gif" alt="{$APP.LBL_CHAT_ALT}" title="{$APP.LBL_CHAT_TITLE}" border=0></a> 
 		                                        {/if} 
				</td>
					<td style="padding-right:10px"><img src="{$IMAGE_PATH}btnL3Tracker.gif" alt="{$APP.LBL_LAST_VIEWED}" title="{$APP.LBL_LAST_VIEWED}" border=0 onClick="fnvshobj(this,'tracker');">
                    			</td>	
				</tr>
				</table>
		</td>
		<td style="width:20px;">&nbsp;</td>
		<td class="small">
			<!-- Import / Export -->
			<table border=0 cellspacing=0 cellpadding=5>
			<tr>

			{* vtlib customization: Hook to enable import/export button for custom modules. Added CUSTOM_MODULE *}

			{if $MODULE eq 'Vendors' || $MODULE eq 'HelpDesk' || $MODULE eq 'Contacts' || $MODULE eq 'Leads' || $MODULE eq 'Accounts' || $MODULE eq 'Potentials' || $MODULE eq 'Products' || $MODULE eq 'Documents' || $CUSTOM_MODULE eq 'true' }
		   		{if $CHECK.Import eq 'yes' && $MODULE neq 'Documents'}	
					<td style="padding-right:0px;padding-left:10px;"><a href="index.php?module={$MODULE}&action=Import&step=1&return_module={$MODULE}&return_action=index&parenttab={$CATEGORY}"><img src="{$IMAGE_PATH}tbarImport.gif" alt="{$APP.LBL_IMPORT} {$MODULE|getTranslatedString:$MODULE}" title="{$APP.LBL_IMPORT} {$MODULE|getTranslatedString:$MODULE}" border="0"></a></td>	
				{else}	
					<td style="padding-right:0px;padding-left:10px;"><img src="{'tbarImport-Faded.gif'|@vtiger_imageurl:$THEME}" border="0"></td>	
				{/if}	
				{if $CHECK.Export eq 'yes'}
				<td style="padding-right:10px"><a name='export_link' href="javascript:void(0)" onclick="return selectedRecords('{$MODULE}','{$CATEGORY}')"><img src="{$IMAGE_PATH}tbarExport.gif" alt="{$APP.LBL_EXPORT} {$MODULE|getTranslatedString:$MODULE}" title="{$APP.LBL_EXPORT} {$MODULE|getTranslatedString:$MODULE}" border="0"></a></td>			
			
				{else}	
					<td style="padding-right:10px"><img src="{'tbarExport-Faded.gif'|@vtiger_imageurl:$THEME}" border="0"></td>
                {/if}
			{else}
				<td style="padding-right:0px;padding-left:10px;"><img src="{'tbarImport-Faded.gif'|@vtiger_imageurl:$THEME}" border="0"></td>
                <td style="padding-right:10px"><img src="{'tbarExport-Faded.gif'|@vtiger_imageurl:$THEME}" border="0"></td>
			{/if}
			{if $MODULE eq 'Contacts' || $MODULE eq 'Leads' || $MODULE eq 'Accounts'|| $MODULE eq 'Products'|| $MODULE eq 'HelpDesk'|| $MODULE eq 'Potentials'|| $MODULE eq 'Vendors'} 
				{if $VIEW eq true}
					<td style="padding-right:10px"><a href="index.php?module={$MODULE}&action=FindDuplicateRecords&button_view&list_view"><img src="{'findduplicates.gif'|@vtiger_imageurl:$THEME}" alt="{$APP.LBL_FIND_DUPICATES}" title="{$APP.LBL_FIND_DUPLICATES}" border="0"></a></td>
				{else}
					<td style="padding-right:10px"><img src="{'FindDuplicates-Faded.gif'|@vtiger_imageurl:$THEME}" border="0"></td>	
				{/if}
			{else}
				<td style="padding-right:10px"><img src="{'FindDuplicates-Faded.gif'|@vtiger_imageurl:$THEME}" border="0"></td>
			{/if}
			</tr>
			</table>	
		<td style="width:20px;">&nbsp;</td>
		<td class="small">
			<!-- All Menu -->
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<td style="padding-left:10px;"><a href="javascript:;" onmouseout="fninvsh('allMenu');" onClick="fnvshobj(this,'allMenu')"><img src="{$IMAGE_PATH}btnL3AllMenu.gif" alt="{$APP.LBL_ALL_MENU_ALT}" title="{$APP.LBL_ALL_MENU_TITLE}" border="0"></a></td>
				{if $CHECK.moduleSettings eq 'yes'}
	        		<td style="padding-left:10px;"><a href='index.php?module=Settings&action=ModuleManager&module_settings=true&formodule={$MODULE}&parenttab=Settings'><img src="{'settingsBox.png'|@vtiger_imageurl:$THEME}" alt="{$MODULE|getTranslatedString:$MODULE} {$APP.LBL_SETTINGS}" title="{$MODULE|getTranslatedString:$MODULE} {$APP.LBL_SETTINGS}" border="0"></a></td>
				{/if}
				</tr>
				</table>
		</td>
        <td style="padding-right:5px"><a href="javascript:;" onclick="gcurrepfolderid=0;fnvshobj(this,'reportLay');"><img src="{'reportsCreate.gif'|@vtiger_imageurl:$THEME}" alt="{$MOD.LBL_CREATE_REPORT}..." title="{$MOD.LBL_CREATE_REPORT}..." border=0></a></td>
                <td>&nbsp;</td>
                <td style="padding-right:5px"><a href="javascript:;" onclick="createrepFolder(this,'orgLay');"><img src="{'reportsFolderCreate.gif'|@vtiger_imageurl:$THEME}" alt="{$MOD.Create_New_Folder}..." title="{$MOD.Create_New_Folder}..." border=0></a></td>
                <td>&nbsp;</td>
                <td style="padding-right:5px"><a href="javascript:;" onclick="fnvshobj(this,'folderLay');"><img src="{'reportsMove.gif'|@vtiger_imageurl:$THEME}" alt="{$MOD.Move_Reports}..." title="{$MOD.Move_Reports}..." border=0></a></td>
                <td>&nbsp;</td>
                <td style="padding-right:5px"><a href="javascript:;" onClick="massDeleteReport();"><img src="{'reportsDelete.gif'|@vtiger_imageurl:$THEME}" alt="{$MOD.LBL_DELETE_FOLDER}..." title="{$MOD.Delete_Report}..." border=0></a></td>			
		</tr>
		</table>
	</td>
</tr>
</TABLE>

          
          
          
<div id="reportContents"> {include file="ReportContents.tpl"} </div>
<!-- Reports Table Ends Here --> 

<!-- POPUP LAYER FOR CREATE NEW REPORT -->
<div style="display: none; left: 193px; top: 106px;width:155px;" id="reportLay" onmouseout="fninvsh('reportLay')" onmouseover="fnvshNrm('reportLay')">
  <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td style="border-bottom: 1px solid rgb(204, 204, 204); padding: 5px;"><b>{$MOD.LBL_CREATE_NEW} :</b></td>
      </tr>
      <tr>
        <td> {foreach item=modules key=modulename from=$REPT_MODULES} <a href="javascript:CreateReport('{$modulename}');" class="drop_down">- {$modules}</a> {/foreach} </td>
      </tr>
    </tbody>
  </table>
</div>
<!-- END OF POPUP LAYER --> 

<!-- Add new Folder UI starts -->
<div id="orgLay" style="display:none;width:350px;" class="layerPopup">
  <table border=0 cellspacing=0 cellpadding=5 width=100% class=layerHeadingULine>
    <tr>
      <td class="genHeaderSmall" nowrap align="left" width="30%" id="editfolder_info">{$MOD.LBL_ADD_NEW_GROUP}</td>
      <td align="right"><a href="javascript:;" onClick="closeEditReport();"><img src="{'close.gif'|@vtiger_imageurl:$THEME}" align="absmiddle" border="0"></a></td>
    </tr>
  </table>
  <table border=0 cellspacing=0 cellpadding=5 width=95% align=center>
    <tr>
      <td class="small"><table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
          <tr>
            <td align="right" nowrap class="cellLabel small"><b>{$MOD.LBL_REP_FOLDER_NAME} </b></td>
            <td align="left"><input id="folder_id" name="folderId" type="hidden" value=''>
              <input id="fldrsave_mode" name="folderId" type="hidden" value='save'>
              <input id="folder_name" name="folderName"  type="text" width="100%" solid="#666666" font-family="Arial, Helvetica,sans-serif" font-size="11px"></td>
          </tr>
          <tr>
            <td class="cellLabel small" align="right" nowrap><b>{$MOD.LBL_REP_FOLDER_DESC} </b></td>
            <td class="cellText small" align="left"><input id="folder_desc" name="folderDesc"  type="text" width="100%" solid="#666666" font-family="Arial, Helvetica,sans-serif" font-size="11px"></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
    <tr>
      <td class="small" align="center"><input name="save" value=" &nbsp;{$APP.LBL_SAVE_BUTTON_LABEL}&nbsp; " class="crmbutton small save" onClick="AddFolder();" type="button">
        &nbsp;&nbsp;
        <input name="cancel" value=" {$APP.LBL_CANCEL_BUTTON_LABEL} " class="crmbutton small cancel" onclick="closeEditReport();" type="button"></td>
    </tr>
  </table>
</div>
<!-- Add new folder UI ends --> 

{*<!-- Contents -->*}
{literal} 
<script>
function createrepFolder(oLoc,divid)
{
	{/literal}
	$('editfolder_info').innerHTML=' {$MOD.LBL_ADD_NEW_GROUP} ';
	{literal}
	getObj('fldrsave_mode').value = 'save';	
	$('folder_id').value = '';
	$('folder_name').value = '';
	$('folder_desc').value='';
	fnvshobj(oLoc,divid);
}
function closeEditReport()
{
	$('folder_id').value = '';
	$('folder_name').value = '';
	$('folder_desc').value='';
	fninvsh('orgLay')
}
function DeleteFolder(id)
{
	var title = 'folder'+id;
	var fldr_name = getObj(title).innerHTML;
	{/literal}
        if(confirm("{$APP.DELETE_FOLDER_CONFIRMATION}"+fldr_name +"' ?"))
        {literal}
	{
		new Ajax.Request(
			'index.php',
	                {queue: {position: 'end', scope: 'command'},
        	                method: 'post',
                	        postBody: 'action=ReportsAjax&mode=ajax&file=DeleteReportFolder&module=Reports&record='+id,
                        	onComplete: function(response) {
							var item = trim(response.responseText);
							if(item.charAt(0)=='<')
						        getObj('customizedrep').innerHTML = item;
						    else
						    	alert(item);
                        	}
                	}
        	);
	}
	else
	{
		return false;
	}
}

function AddFolder()
{
	if(getObj('folder_name').value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0)
	{
		{/literal}
                alert('{$APP.FOLDERNAME_CANNOT_BE_EMPTY}');
                return false;
                {literal}
	}
	else if(getObj('folder_name').value.replace(/^\s+/g, '').replace(/\s+$/g, '').length > 20 )
	{
		{/literal}
                alert('{$APP.FOLDER_NAME_ALLOW_20CHARS}');
                return false;
                {literal}
	}
	else if((getObj('folder_name').value).match(/['"<>/\+]/) || (getObj('folder_desc').value).match(/['"<>/\+]/))
    {
            alert(alert_arr.SPECIAL_CHARS+' '+alert_arr.NOT_ALLOWED+alert_arr.NAME_DESC);
            return false;
    }	
	/*else if((!CharValidation(getObj('folder_name').value,'namespace')) || (!CharValidation(getObj('folder_desc').value,'namespace')))
	{
			alert(alert_arr.NO_SPECIAL +alert_arr.NAME_DESC);
			return false;
	}*/
	else
	{
		var foldername = encodeURIComponent(getObj('folder_name').value);
		new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'action=ReportsAjax&mode=ajax&file=CheckReport&module=Reports&check=folderCheck&folderName='+foldername,
                                onComplete: function(response) {
				var folderid = getObj('folder_id').value;
				var resresult =response.responseText.split("::");
				var mode = getObj('fldrsave_mode').value;
				if(resresult[0] != 0 &&  mode =='save' && resresult[0] != 999)
				{
					{/literal}
					alert("{$APP.FOLDER_NAME_ALREADY_EXISTS}");
					return false;
					{literal}
				}
				else if(((resresult[0] != 1 && resresult[0] != 0) || (resresult[0] == 1 && resresult[0] != 0 && resresult[1] != folderid )) &&  mode =='Edit' && resresult[0] != 999)
					{
						{/literal}
                                                alert("{$APP.FOLDER_NAME_ALREADY_EXISTS}");
                                                return false;
                                                {literal}
					}
				else if(response.responseText == 999) // 999 check for special chars
					{
                                                {/literal}
                                                alert("{$APP.SPECIAL_CHARS_NOT_ALLOWED}");
                                                return false;
                                                {literal}
					}
				else
					{
						fninvsh('orgLay');
						var folderdesc = encodeURIComponent(getObj('folder_desc').value);
						getObj('folder_name').value = '';
						getObj('folder_desc').value = '';
						foldername = foldername.replace(/^\s+/g, '').replace(/\s+$/g, '');
                                                foldername = foldername.replace(/&/gi,'*amp*');
                                                folderdesc = folderdesc.replace(/^\s+/g, '').replace(/\s+$/g, '');
                                                folderdesc = folderdesc.replace(/&/gi,'*amp*');
						if(mode == 'save')
						{
							url ='&savemode=Save&foldername='+foldername+'&folderdesc='+folderdesc;
						}
						else
						{
							var folderid = getObj('folder_id').value;
							url ='&savemode=Edit&foldername='+foldername+'&folderdesc='+folderdesc+'&record='+folderid;
						}
						getObj('fldrsave_mode').value = 'save';
						new Ajax.Request(
				                        'index.php',
				                        {queue: {position: 'end', scope: 'command'},
			                                method: 'post',
			                                postBody: 'action=ReportsAjax&mode=ajax&file=SaveReportFolder&module=Reports'+url,
			                                onComplete: function(response) {
			                                        var item = response.responseText;
                        			                getObj('customizedrep').innerHTML = item;
			                                }
						}
			                      
				                );
					}
				}
			}
			);
		
	}
}


function EditFolder(id,name,desc)
{
{/literal}
	$('editfolder_info').innerHTML= ' {$MOD.LBL_RENAME_FOLDER} '; 	
{literal}
	getObj('folder_name').value = name;
	getObj('folder_desc').value = desc;
	getObj('folder_id').value = id;
	getObj('fldrsave_mode').value = 'Edit';
}
function massDeleteReport()
{
	var folderids = getObj('folder_ids').value;
	var folderid_array = folderids.split(',')
	var idstring = '';
	var count = 0;
	for(i=0;i < folderid_array.length;i++)
	{
		var selectopt_id = 'selected_id'+folderid_array[i];
		var objSelectopt = getObj(selectopt_id);
		if(objSelectopt != null)
		{
			var length_folder = getObj(selectopt_id).length;
			if(length_folder != undefined)
			{
				var cur_rep = getObj(selectopt_id);
				for(row = 0; row < length_folder ; row++)
				{
					var currep_id = cur_rep[row].value;
					if(cur_rep[row].checked)
					{
						count++;
						idstring = currep_id +':'+idstring;
					}
				}
			}else
			{	
				if(getObj(selectopt_id).checked)
				{
					count++;
					idstring = getObj(selectopt_id).value +':'+idstring;
				}
			}
		}
	}
	if(idstring != '')
	{	{/literal}
                if(confirm("{$APP.DELETE_CONFIRMATION}"+count+"{$APP.RECORDS}"))
                {literal}
       		{
			new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'action=ReportsAjax&mode=ajax&file=Delete&module=Reports&idlist='+idstring,
                                onComplete: function(response) {
                                        var item = response.responseText;
                                        	getObj('customizedrep').innerHTML = item;
                                }
                        }
                );
		}else
		{
			return false;
		}
			
	}else
	{
		{/literal}
                alert('{$APP.SELECT_ATLEAST_ONE_REPORT}');
                return false;
                {literal}
	}
}
function DeleteReport(id)
{
	{/literal}
        if(confirm("{$APP.DELETE_REPORT_CONFIRMATION}"))
        {literal}
	{
		new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'action=ReportsAjax&file=Delete&module=Reports&record='+id,
                                onComplete: function(response) {
					getObj('reportContents').innerHTML = response.responseText;
                                }
                        }
                );
	}else
	{
		return false;
	}
}
function MoveReport(id,foldername)
{
	fninvsh('folderLay');
	var folderids = getObj('folder_ids').value;
	var folderid_array = folderids.split(',')
	var idstring = '';
	var count = 0;
	for(i=0;i < folderid_array.length;i++)
	{
		var selectopt_id = 'selected_id'+folderid_array[i];
		var objSelectopt = getObj(selectopt_id);
		if(objSelectopt != null)
		{
			var length_folder = getObj(selectopt_id).length;
			if(length_folder != undefined)
			{
				var cur_rep = getObj(selectopt_id);
				for(row = 0; row < length_folder ; row++)
				{
					var currep_id = cur_rep[row].value;
					if(cur_rep[row].checked)
					{
						count++;
						idstring = currep_id +':'+idstring;
					}
				}
			}else
			{	
				if(getObj(selectopt_id).checked)
				{
					count++;
					idstring = getObj(selectopt_id).value +':'+idstring;
				}
			}
		}
	}
	if(idstring != '')
	{
		{/literal}
                if(confirm("{$APP.MOVE_REPORT_CONFIRMATION}"+foldername+"{$APP.FOLDER}"))
                {literal}
        	{
			new Ajax.Request(
                        'index.php',
                        {queue: {position: 'end', scope: 'command'},
                                method: 'post',
                                postBody: 'action=ReportsAjax&file=ChangeFolder&module=Reports&folderid='+id+'&idlist='+idstring,
                                onComplete: function(response) {
                                	        getObj('reportContents').innerHTML = response.responseText;
                	                }
                        	}
	                );
		}else
		{
			return false;
		}
			
	}else
	{
		{/literal}
                alert('{$APP.SELECT_ATLEAST_ONE_REPORT}');
                return false;
                {literal}
	}
}
</script> 
{/literal} 