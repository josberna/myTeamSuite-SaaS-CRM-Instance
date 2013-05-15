<?php
   global $adb,$current_user;
   
   $response = '';
   $col_name='';
   $result=$adb->query("SHOW COLUMNS FROM vtiger_potentialscf");
   $role=$current_user->column_fields['roleid'];
   while($row = $adb->fetch_array($result))
   {
 		$col_name = $row[0];
   }
   if($role == 'H4')//Manager View: manager can only view
   {
	   $result = $adb->query("select id ,CONCAT(first_name,' ',last_name) AS NAME from  
	   						   vtiger_users c, vtiger_user2role vr ,vtiger_role vrole
							   where 
							   c.id = vr.userid and 
							   vrole.roleid = vr.roleid and
							   (vr.roleid = 'H5' or  c.id = ".$current_user->id.")");
   }
   else if($role == 'H5')//Manager View: manager can only view
   {
	    $result = $adb->query("select id ,CONCAT(first_name,' ',last_name) AS NAME from  
	   						   vtiger_users c, vtiger_user2role vr ,vtiger_role vrole
							   where 
							   c.id = vr.userid and 
							   vrole.roleid = vr.roleid and
							   c.id = ".$current_user->id);
   }else
   {
	    $result = $adb->query("select id ,CONCAT(first_name,' ',last_name) AS NAME from vtiger_users");
   }

   $no_rows = $adb->num_rows($result);
   if($no_rows > 0 )
   {
   		while($row1 = $adb->fetch_array($result))
		{
		   $res = $adb->query("select 
										closingdate,".$col_name.",amount
								  from 
										vtiger_potential a, vtiger_crmentity b, vtiger_users c,vtiger_potentialscf d
								  where 
										b.crmid = a.potentialid and 
										a.potentialid = d.potentialid and 										
										c.id = b.smownerid and
										c.id = ".$row1["id"]." and 
										".$col_name." like '%Commit%'");
		
		   $n_rows=$adb->num_rows($res);
		  
		   $ccount = 0;
		   $ncount = 0;
		   if($n_rows > 0 )
		   {
				while($row2 = $adb->fetch_array($res))
				{
					//					echo row2['amount'];
					$time =  strtolower(GetPeriod($row2['closingdate']));
					
					if($time == strtolower('current week'))
					{
						$ccount += $row2['amount'] * 1;
					}else if($time == strtolower('next week'))
					{
						$ncount += $row2['amount'] * 1;

					}
				}
		   }
  		   $response .= '<tr bgcolor="white" >';
		   $response .='<td style="text-align::right;"><strong>'.$row1['name'].'</strong></td>
			 		    <td><div style="float:right;">$'.$ccount.'</div></td>
		   				<td><div style="float:right;">$'.$ncount.'</div></td>
						<td><div style="float:right;">$'.($ccount + $ncount).'</div></td>
						</tr>';
		}
   }
   echo $response;
   //echo $response;
   function GetPeriod($str_date)
   {
	$str_return='';
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
	return $str_return;
   }
?>