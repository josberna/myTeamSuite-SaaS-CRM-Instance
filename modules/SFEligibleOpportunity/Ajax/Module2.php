<?php
if($_REQUEST['Type'] == "1")// Module # 0 - Get view
{
	if(strtotime($_REQUEST['sdate']) <= strtotime($_REQUEST['edate']))
	{
		$_SESSION["sdate"]= $_REQUEST['sdate'];
		$_SESSION["edate"]= $_REQUEST['edate'];
		echo GetMainView2();
	}else
	{
	   $response = '<table width="100%" style="border: 1px solid black;" border="0" cellspacing="0" cellpadding="3">';
	   $response .= '<tr style="border: 1px solid black;">';
	   $response .= '<td style="border: 1px solid black;line-height:40px;align:center;"> Start Date must be less then End Date </td>';
	   
	   $response .= '</tr>';
	   $response .= '</table>';
	   echo $response;
	}
}else if($_REQUEST['Type'] == "2")// Module # 0 - Get view
{
	UpdateStatus();
}

function UpdateStatus()
{
   global $adb,$current_user;
   $col_name='';
   $result=$adb->query("SHOW COLUMNS FROM vtiger_potentialscf");
   while($row = $adb->fetch_array($result))
   {
   		$col_name = $row[0];
   }
   $adb->query("Update vtiger_potentialscf set ".$col_name."='".$_REQUEST['val']."' where potentialid = ".$_REQUEST['pid']);
}
function GetMainView2() { 
   global $adb,$current_user;
   $response = '';
   $col_name='';
   $end_date =date("Y-m-d", strtotime($_REQUEST['edate']));
   $start_date =date("Y-m-d", strtotime($_REQUEST['sdate']));
   $result=$adb->query("SHOW COLUMNS FROM vtiger_potentialscf");
   $role=$current_user->column_fields['roleid'];
   while($row = $adb->fetch_array($result))
   {
   		$col_name = $row[0];
   }
   if($role == 'H4')//Manager View: manager can only view
   {
	   $result = $adb->query("select * from  
	   						   vtiger_potential a, vtiger_crmentity b, vtiger_users c, vtiger_user2role vr ,vtiger_role vrole
							   where 
							   c.id = vr.userid and 
							   vrole.roleid = vr.roleid and
							   b.crmid = a.potentialid and 
							   c.id = b.smownerid and
							   (vr.roleid = 'H5' or  c.id = ".$current_user->id.") and
							   closingdate between '".$start_date."' and '".$end_date."'");
   }
   else if($role == 'H5')//Manager View: manager can only view
   {
	   $result = $adb->query("select * from  
	   						   vtiger_potential a, vtiger_crmentity b, vtiger_users c
							   where 
							   b.crmid = a.potentialid and 
							   c.id = b.smownerid and
							   closingdate between '".$start_date."' and '".$end_date."' and
							   c.id = ".$current_user->id);
   }else
   {
	    $result = $adb->query("select * from  
	   						   vtiger_potential a, vtiger_crmentity b, vtiger_users c
							   where 
							   b.crmid = a.potentialid and 
							   c.id = b.smownerid and
							   closingdate between '".$start_date."' and '".$end_date."'");
   }
		
   $no_rows=$adb->num_rows($result);
   if($no_rows > 0 )
   {
   		$count = 1;
		while($row = $adb->fetch_array($result))
		{
			
			$cDate =date("Y-m-d", strtotime($row['closingdate']));
			$cDate =date("d-M-Y", strtotime($cDate));
			$response .='<tr bgcolor="white"  id="row_pane1_'.$count.'"
							 onmouseover="this.className=\'lvtColDataHover\'" 
							 onmouseout="this.className=\'lvtColData\'" class="lvtColDataHover">
							<td 
							 	onmouseover="vtlib_listview.trigger("cell.onmouseover", $(this))" 
	  						    onmouseout="vtlib_listview.trigger("cell.onmouseout", $(this))"><a href="index.php?module=Potentials&parenttab=Sales&action=DetailView&record='.$row['potentialid'].'">'.$row['potentialname'].'</a></td>
							<td 
								onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" 
								onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))">'.$row['last_name'].' '.$row['first_name'].'</td>
							<td 
							    onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" 
							    onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))">'.$row['amount'].'</td>
							<td 
							    onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" 
							    onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))">'.$row['sales_stage'].'</td>
							<td 
								onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" 
							    onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))">'.$row['nextstep'].'</td>
							<td 
							    onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" 
							    onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))">'.$row['probability'].'</td>
							<td 
							    onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" 
							    onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))">'.ComType($row[$col_name],$row['potentialid'],$row['roleid'],$current_user->column_fields['roleid']).'</td>
							<td 
							    onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" 
							    onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))">'.$cDate.'</td>								
							<td 
							    onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" 
							    onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))">'.TimeCalculation($row['closingdate']).'</td>
						</tr>';
		}
		$count++;
   }
   return $response; 
} 
function ComType($str_return,$pid,$depth,$role)
{
	$val = $str_return;

	if($role=='H4' && $depth=='H5')
	{
		if(empty($val))
			return 'N/A';
		else
			return $val;
	}
	
	$str_return = '<select onchange="return UpdateAction(this,'.$pid.');" class="txtBox" style="width:100px;">';
	if($val == 'Commit')
		$str_return .='<option value="Commit" selected="selected">Commit</option>';
	else
		$str_return .='<option value="Commit" >Commit</option>';
	
	if($val == 'Upside')
		$str_return .='<option value="Upside" selected="selected">Upside</option>';
	else
		$str_return .='<option value="Upside" >Upside</option>';
		
	if(strtolower($val) == 'do not include')
		$str_return .='<option value="Do Not Include" selected="selected">Do Not Include</option>';
	else
		$str_return .='<option value="Do Not Include" >Do Not Include</option>';

	if(empty($val))
		$str_return .='<option value="N/A" selected="selected">N/A</option>';
	else
		$str_return .='<option value="N/A" >N/A</option>';		

	$str_return .= '</select>';
	return $str_return;
}
function TimeCalculation($str_date)
{
	$str_return='';
	if(date("D", strtotime($str_date)) != "Sun")
	{
		$str_date =date("Y-m-d", strtotime($str_date));
		$str_date =strtotime(date("d-M-Y", strtotime($str_date)));
	
		$weekStart = 0;
		$cDate =  date('d-M-Y', 
						mktime(0,0,0,
							   date('n',$str_date),date('j',$str_date),date('Y',$str_date)
							   )
					   );
		$timestamp = strtotime(date('d-M-Y'));
	
		$dayOfWeek = date('N', $timestamp);
	
		$current_week_start =
		mktime(0,0,0, 
					date('n', $timestamp), 
					date('j', $timestamp) - $dayOfWeek + ($weekStart+1), 
					date('Y', $timestamp)
				);
		$current_week_end = 
		mktime(0,0,0, 
					date('n', $timestamp), 
					date('j', $timestamp) - $dayOfWeek + 6 + $weekStart, 
					date('Y', $timestamp)
					);
		
		$sDate =  date('d-M-Y', $current_week_start);
		$eDate =  date('d-M-Y', $current_week_end);
	
		if(strtotime($cDate) >= strtotime($sDate) && strtotime($cDate) <= strtotime($eDate))
		{
			$str_return = 'Current week';
		}
		else
		{
			$nxt_week_start = mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + ($weekStart+8), date('Y', $timestamp));
			$nxt_week_end = mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + 14 + $weekStart, date('Y', $timestamp));
			$sDate =  date('d-M-Y', $nxt_week_start);
			$eDate =  date('d-M-Y', $nxt_week_end);
	
			if(strtotime($cDate) >= strtotime($sDate) && strtotime($cDate) <= strtotime($eDate))
			{
				$str_return = 'Next week';
			}else
			{
				$month_end = mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + ($weekStart+30), date('Y', $timestamp));
				$eDate =  date('d-M-Y', $month_end);
				if(strtotime($cDate) <= strtotime($eDate))
				{
					$str_return = 'Month';
				}else
				{
					$days = array(60, 90, 120);
					foreach ($days as $value) 
					{
						$month_end = 
						mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + ($weekStart+$value), date('Y', $timestamp));
						$eDate =  date('d-M-Y', $month_end);
						
						if(strtotime($cDate) <= strtotime($eDate))
						{
							$str_return = $value.'-day';
							break;
						}
					}
				}
			}
		}
	}else
	{
		$str_return ='Outlook';
	}
	return $str_return;
}

?>