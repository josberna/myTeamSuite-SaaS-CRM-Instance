<?php
if($_REQUEST['Type'] == "1")// Module # 0 - Get view
{
	if(strtotime($_REQUEST['sdate']) <= strtotime($_REQUEST['edate']))
	{
		$_SESSION["sdate".$_REQUEST['pindex']]= $_REQUEST['sdate'];
		$_SESSION["edate".$_REQUEST['pindex']]= $_REQUEST['edate'];
		echo GetMainView($_REQUEST['sdate'], $_REQUEST['edate']);
	}else
	{
	   $response = '<table width="100%" style="border: 1px solid black;" border="0" cellspacing="0" cellpadding="3">';
	   $response .= '<tr style="border: 1px solid black;">';
	   $response .= '<td style="border: 1px solid black;line-height:40px;align:center;"> Start Date must be less then End Date </td>';
	   
	   $response .= '</tr>';
	   $response .= '</table>';
	   echo $response;
	}
}else if($_REQUEST['Type'] == "2") // Module # 0 - Get month detail
{
	echo GetMonthyDetail();
}
else if($_REQUEST['Type'] == "3") // Module # 0 - Assign Quota
{
	echo SetAssignQuota();
}
else if($_REQUEST['Type'] == "4") // Module # 0 - Assign Montly Quota
{
	echo SetAssignMonthQuota();
}

$total = 0;
$subtract = 0;
function GetMainView($date1, $date2) { 
global $adb,$current_user;

$month = array ('01'=>"Jan", 
				'02'=>"Feb", 
				'03'=>"Mar", 
				'04'=>"Apr", 
				'05'=>"May", 
				'06'=>"Jun", 
				'07'=>"Jul", 
				'08'=>"Aug", 
				'09'=>"Sep", 
				'10'=>"Oct", 
				'11'=>"Nov", 
				'12'=>"Dec");
   date_default_timezone_set('UTC');
   $response = '<table width="100%" style="padding-left:5px;" border="0" cellspacing="0" cellpadding="3">';
   $response .= '<tr style="border: 1px solid #CFDBEC;">';
   $time1  = strtotime($date1); 
   $time2  = strtotime($date2); 
   $my     = date('mY', $time2); 

   $months = array(date('m', $time1)); 
   $years = array(date('Y', $time1));
   $role=$current_user->column_fields['roleid'];
   while($time1 < $time2) 
   { 
      $time1 = strtotime(date('Y-m-d', $time1).' +1 month'); 
      if(date('mY', $time1) != $my && ($time1 < $time2)) 
         $months[] = date('m', $time1); 
		 $years[] = date('Y', $time1); 
   }
    
   if(date('m',strtotime($_REQUEST['sdate'])) != date('m',strtotime($_REQUEST['edate'])))
   {
   	  $months[] = date('m', $time2); 
	  $years[] = date('Y', $time1); 
   }
   for ($count=0; $count <count($months); $count++) 
   {
   	 $start_date= $years[$count].'-'.$months[$count].'-01';
 	 $last_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($start_date))));
	 
     $response .='<td onclick="javascript:QuotaDetail(\''.$count.'\',\''.$start_date.'\',\''.$last_date.'\','.$_REQUEST['pindex'].');"
	 			   style="border: 1px solid black;background-color:#568EC5;color:white;cursor:pointer;">
				  <div style="float:left;"> <strong>'. $month[$months[$count]].'</strong> </div>
				  <div style="float:right"> 
				  		<img id="arrow_'.$count.'" src="modules/SFQuotaDistribution/img/up.png" alt="Processing"/>
				  </div>
				  </td>';
   }
   if($role != 'H5')
   {
	 $response .= '<td style="border: 1px solid black;background-color:#008340;color:white;width:70px;"><strong>Assigned</strong></td>';
	 $response .= '<td style="border: 1px solid black;background-color:#9E0000;color:white;width:70px;"><strong>Unassigned</strong></td>';
   }
   $response .= '</tr>';
   $response .= '<tr style="border: 1px solid black;">';

   for ($count=0; $count <count($months); $count++) 
   {
	   $start_date= $years[$count].'-'.$months[$count].'-01';
 	   $last_date = date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($start_date))));
	   if($role != 'H5')
		{
			 $response .='<td style="border: 1px solid black;line-height:20px;">
						  <input 
						   value="'. GetTotalOfMonth($months[$count],$years[$count]).'" 
						   onblur="javascript:return AssignMonthQuota(\''.$last_date.'\',this,'.$_REQUEST['pindex'].');" 
						   style="width:50px;height:10px;font-size:11px;"
  						  />
 						  </td>';
		}else
		{
			 $response .='<td style="border: 1px solid black;line-height:20px;">'. GetTotalOfMonth($months[$count],$years[$count]).' $</td>';
		}
   }
   if($role != 'H5')
   {
   	   $response .='<td style="border: 1px solid black;">'.$GLOBALS['total'].' $</td>';
	   $response .='<td style="border: 1px solid black;">'.str_replace('-','',$GLOBALS['subtract']).' $</td>';
   }
   $response .= '</tr>';

   $response .= '</table>';
   return $response; 
} 
function GetTotalOfMonth($month,$year) 
{
	global $adb,$current_user;

	$return = '0';
	$date= $year.'-'.$month.'-01';
	$last_date =date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($date))));

	$result=$adb->query("select quota from vtiger_SFQuotaDistribution_month where period = '".$last_date."'");
	$no_rows=$adb->num_rows($result);
	if($no_rows > 0 )
	{
		$acc_row = $adb->fetch_array($result);
	
		if($acc_row['quota'] != '')
		{
			$return = $acc_row['quota'];
			$GLOBALS['total'] = $GLOBALS['total'] + ($acc_row['quota'] *1);
			$res = $adb->query("select sum(quota) as quota	from vtiger_SFQuotaDistribution_quota where start_date ='".$date."' and end_date  = '".$last_date."'");
			
			$row = $adb->fetch_array($res);
			$GLOBALS['subtract'] = $GLOBALS['subtract'] + ($acc_row['quota'] - $row['quota'] *1);
		}else
		{
			$GLOBALS['total'] = $GLOBALS['total'] + 0;
			$GLOBALS['subtract'] = $GLOBALS['subtract'] + 0;
		}
	}else
	{
		$GLOBALS['total'] = $GLOBALS['total'] + 0;
		$GLOBALS['subtract'] = $GLOBALS['subtract'] + 0;
	}
	return $return;
}
function GetMonthyDetail()
{
	global $adb,$current_user;
	//return 1;
	$res = '';
	$date = $_REQUEST['sdate'];
	$last_date = $_REQUEST['edate'];
	
	$col_name='';
    $result=$adb->query("SHOW COLUMNS FROM vtiger_potentialscf");
	while($row = $adb->fetch_array($result))
   	{
   	   $col_name = $row[0];
	}
	   
	$cols='vu.first_name,vu.last_name ,vrole.rolename,vu.id';
	$role=$current_user->column_fields['roleid'];
	if($role == 'H1' || $role == 'H2' || $role == 'H3')// 
	{
		$query="select ".$cols." from vtiger_users vu, vtiger_user2role vr ,vtiger_role vrole
				where vu.id = vr.userid and vrole.roleid = vr.roleid";
	}
	else if($role == 'H4')//Sales Manager: can view the sales persons quotes and his own
	{
		$query="select ".$cols." from vtiger_users vu, vtiger_user2role vr ,vtiger_role vrole
				where vu.id = vr.userid and vrole.roleid = vr.roleid and (vr.roleid = 'H5' or vr.userid=".$current_user->id.")";
	}else if($role == 'H5')//Sales Man: can only view his own data
	{
		$query="select ".$cols." from vtiger_users vu, vtiger_user2role vr ,vtiger_role vrole
				where vu.id = vr.userid and vrole.roleid = vr.roleid and vr.userid=".$current_user->id;
	}

	$result=$adb->query($query);

    $res  = '<table width="100%" style="border: 1px solid black;position:relative;" border="0" cellspacing="0" cellpadding="3">';
    $res .= '<tr style="border: 1px solid #CFDBEC;">';
    $res .= '<td style="border: 1px solid black;background-color:#568EC5;color:white;cursor:pointer;">
			<strong>Assigned To</strong></td>';
    $res .= '<td style="border: 1px solid black;background-color:#568EC5;color:white;cursor:pointer;">
			<strong>Assigned By</strong></td>';
    $res .= '<td style="border: 1px solid black;background-color:#568EC5;color:white;cursor:pointer;">
			<strong>Quota($)</strong></td>';
    $res .= '<td style="border: 1px solid black;background-color:#568EC5;color:white;cursor:pointer;">
			<strong>Current Month Sale($)</strong></td>';
    $res .= '<td style="border: 1px solid black;background-color:#568EC5;color:white;cursor:pointer;">
			<strong>Percentage(%)</strong></td>';			
    $res .= '<td style="border: 1px solid black;background-color:#568EC5;color:white;cursor:pointer;">
			<strong>Period</strong></td>';
	$res .='</tr>';
	$count = 0;
	echo '<div id="msg" ></div>';
	while($acc_row = $adb->fetch_array($result))
	{
		$detail = GetInnerDetail($acc_row['id'],$date,$last_date);
		
		$res_amount = $adb->query("select sum(amount) amount 
								   from 
								   		vtiger_potential a, vtiger_crmentity b, vtiger_users c,vtiger_potentialscf d
								   where 
								   		a.closingdate between '".$date."' and '".$last_date."' and 
								  		a.potentialid = d.potentialid and
										b.crmid = a.potentialid and  
										c.id = b.smownerid and 
										c.id = ".$acc_row["id"]." and
										(lower(sales_stage) like '%won%' or lower(".$col_name.")='commit')");
		$row_amount = $adb->fetch_array($res_amount);
		
	    $res .= '<tr style="border: 1px solid #CFDBEC;">';
     	$res .='<td style="border: 1px solid black;line-height:20px;">
			   '.$acc_row['first_name'].' '.$acc_row['last_name'].' - '.$acc_row['rolename'].'</td>';
     	$res .='<td style="border: 1px solid black;line-height:20px;">'.$detail[1].'</td>';
     	$res .='<td style="border: 1px solid black;line-height:20px;">
				<input type="hidden" value="'.$acc_row['id'].'" name="Pane0_'.$count.'_ID" />
				<input type="hidden" value="'.$date .'|'.$last_date.'" name="Pane0_'.$count.'_Date" />';
		if($role != 'H5')
		{
			$res .='<input type="text" value="'.$detail[0].'" style="width:75px;height:10px;font-size:11px;" name="Pane0_'.$count.'_Quota" />';
		}else
		{
			$res .=$detail[0].'';
		}
		$res .='</td>';
		if(!empty($row_amount['amount']))
	     	$res .='<td style="border: 1px solid black;line-height:20px;">'.$row_amount['amount'].'</td>';
		else
			$res .='<td style="border: 1px solid black;line-height:20px;">0</td>';
		if($row_amount['amount'] != 0 && $detail[0] !=0 )
		{
			$percent = ($row_amount['amount'] / $detail[0])*100;
		}else
		{
			$percent = 0;
		}
	 	$res .='<td style="border: 1px solid black;line-height:20px;">'.round($percent).'&nbsp;%</td>';
		$res .='<td style="border: 1px solid black;line-height:20px;">'.date("F, Y",strtotime($date)).'</td>';
		$res .='</tr>';
		$count +=1;
	}
	$res .='<tr style="border: 1px solid #CFDBEC;">
			<td colspan="6" align="right"  style="border: 1px solid black;line-height:20px;">
			<input type="button" value="Apply Changes" class="crmbutton small edit" onclick="javascript:AssignQuota('.$_REQUEST['pindex'].');" />
			</td></tr>';
	$res .='</table>';
	return $res;
}

function GetInnerDetail($userid,$sdate,$edate)
{
	global $adb;
	$query="select quota,
		(
			select 
			concat(concat(vu.first_name,' ',vu.last_name),' - ', vrole.rolename)
			from 
			vtiger_users vu,vtiger_user2role vr ,vtiger_role vrole 
			where 
			vu.id = vr.userid 
			and 
			vrole.roleid = vr.roleid 
			and
			vu.id=assign_by
		) as assignby 
		from vtiger_SFQuotaDistribution_quota
		where 
		start_date ='".$sdate."' and end_date = '".$edate."' 
		and
		assign_to = ".$userid;
	$res = $adb->query($query);
	$row = $adb->fetch_array($res);
	
	if(!empty($row['quota']))
		return array($row['quota'],$row['assignby']);
	else
		return array('0','N/A');;
}

function SetAssignQuota()
{
	global $adb,$current_user;
	$vals =  explode('$',$_REQUEST['vals']);
	foreach($vals as $key => $value)
	{
		if(!empty($value))
		{
			$vals =  explode(',',$value);
			$dates = explode('|',$vals[1]);
			$result =  $adb->pquery("select * from 
									 vtiger_SFQuotaDistribution_quota where start_date=? and end_date=? and assign_to =? ",array($dates[0],$dates[1],$vals[0]));
			$no_acc_rows=$adb->num_rows($result);
			if($no_acc_rows == 0)
			{
				$adb->pquery("insert into 
									  vtiger_SFQuotaDistribution_quota(assign_to,assign_by,quota,start_date,end_date)
								      values(?,?,?,?,?)
									",
									array($vals[0],$current_user->id,$vals[2],$dates[0],$dates[1]));
			}
			else
			{
				$adb->pquery("update vtiger_SFQuotaDistribution_quota set assign_by=?,quota=?
								      where assign_to=? and start_date=? and end_date=? 
									",array($current_user->id,$vals[2],$vals[0],$dates[0],$dates[1]));
			}
		}
	}
	return GetMainView($_REQUEST['sdate'], $_REQUEST['edate']);
}
function SetAssignMonthQuota()
{
	global $adb,$current_user;
	$result =  $adb->pquery("select * from vtiger_SFQuotaDistribution_month where period = ? ",array($_REQUEST['period']));
	$no_acc_rows=$adb->num_rows($result);
	
	if($no_acc_rows == 0)
	{
		$adb->pquery("insert into vtiger_SFQuotaDistribution_month(period,quota) values(?,?)",array($_REQUEST['period'],$_REQUEST['quota']));
	}
	else
	{
		$adb->pquery("update vtiger_SFQuotaDistribution_month set quota=?	where period=? ",array($_REQUEST['quota'],$_REQUEST['period']));
	}
	return GetMainView($_REQUEST['sdate'], $_REQUEST['edate']);
}
?>