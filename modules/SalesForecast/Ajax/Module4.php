<?php
	function GetPane3()
	{
	   global $adb,$current_user;
	   
	   $response = '';
	   $col_name='';
       $result=$adb->query("SHOW COLUMNS FROM vtiger_potentialscf");
	   while($row = $adb->fetch_array($result))
   	   {
   			$col_name = $row[0];
	   }
	   
	   $result = $adb->query("select id , CONCAT(first_name,' ',last_name) AS NAME from vtiger_users");
	
	   $no_rows = $adb->num_rows($result);
	   if($no_rows > 0 )
	   {
			while($row1 = $adb->fetch_array($result))
			{
			   $response .='<div style="float:left;height:135px;width:145px;">
							<div class="pane3_cell">
								<div style="float:left;width:100%;">
									<strong>'.$row1['name'].'</strong>
								</div>
								<div style="float:left;">
									Commit
								</div>
								<div style="float:right;">
									Upside
								</div>
							</div>';
			   $res = $adb->query("select 
											closingdate,".$col_name.",amount
									  from 
											vtiger_potential a, vtiger_crmentity b, vtiger_users c,vtiger_potentialscf d
									  where 
									  		a.potentialid = d.potentialid and
											b.crmid = a.potentialid and 
											c.id = b.smownerid and
											c.id = ".$row1["id"]);
			
			   $n_rows=$adb->num_rows($res);
			   $cWeek = array(0,0); $nWeek = array(0,0);$Days60 = array(0,0); $Days90 = array(0,0); $Days120 = array(0,0);
			   $total = array(0,0);
			   if($n_rows > 0 )
			   {
					while($row2 = $adb->fetch_array($res))
					{
						$time =  strtolower(GetPeriod2($row2['closingdate']));
						if($time == strtolower('current week'))
						{
							if('commit'==strtolower($row2[$col_name]))
							{
								$cWeek[0]+=$row2['amount'] * 1;
							}else if('upside'==strtolower($row2[$col_name]))
							{
								$cWeek[1]+=$row2['amount'] * 1;
							}
							
						}else if($time == strtolower('next week'))
						{
							if('commit'==strtolower($row2[$col_name]))
							{
								$nWeek[0]+=$row2['amount'] * 1;
							}else if('upside'==strtolower($row2[$col_name]))
							{
								$nWeek[1]+=$row2['amount'] * 1;
							}
						}else if($time == strtolower('60-days'))
						{
							if('commit'==strtolower($row2[$col_name]))
							{
								$Days60[0]+=$row2['amount'] * 1;
							}else if('upside'==strtolower($row2[$col_name]))
							{
								$Days60[1]+=$row2['amount'] * 1;
							}
						}else if($time == strtolower('90-days'))
						{
							if('commit'==strtolower($row2[$col_name]))
							{
								$Days90[0]+=$row2['amount'] * 1;
							}else if('upside'==strtolower($row2[$col_name]))
							{
								$Days90[1]+=$row2['amount'] * 1;
							}
						}else if($time == strtolower('120-days'))
						{
							if('commit'==strtolower($row2[$col_name]))
							{
								$Days120[0]+=$row2['amount'] * 1;
							}else if('upside'==strtolower($row2[$col_name]))
							{
								$Days120[1]+=$row2['amount'] * 1;
							}
						}
					}
					$total[0] = $cWeek[0] + $nWeek[0] + $Days60[0] + $Days90[0] + $Days120[0];
					$total[1] = $cWeek[1] + $nWeek[1] + $Days60[1] + $Days90[1] + $Days120[1];
			   }
			   $response .='<div class="pane3_cell"><div style="float:left;">'.$cWeek[0].'$</div>
			   				<div style="float:right;">'.$cWeek[1].'$</div></div>
							<div class="pane3_cell"><div style="float:left;">'.$nWeek[0].'$</div>
							<div style="float:right;">'.$nWeek[1].'$</div></div>
							<div class="pane3_cell"><div style="float:left;">'.$Days60[0].'$</div>
							<div style="float:right;">'.$Days60[1].'$</div></div>
							<div class="pane3_cell"><div style="float:left;">'.$Days90[0].'$</div>
							<div style="float:right;">'.$Days90[1].'$</div></div>
							<div class="pane3_cell"><div style="float:left;">'.$Days120[0].'$</div>
							<div style="float:right;">'.$Days120[1].'$</div></div>
							<div class="pane3_cell"><div style="float:left;">'.$total[0].'$</div>
							<div style="float:right;">'.$total[1].'$</div></div>
							</div>';
			}
	   }
	   echo $response;
	}
   //echo $response;
   function GetPeriod2($str_date)
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
			$days = array(60, 90, 120);
			foreach ($days as $value) 
			{
				$month_end = 
				mktime(0,0,0, date('n', $timestamp), date('j', $timestamp) - $dayOfWeek + ($weekStart+$value), date('Y', $timestamp));
				$eDate =  date('d-M-Y', $month_end);
					
				if(strtotime($cDate) <= strtotime($eDate))
				{
					$str_return = $value.'-days';
					break;
				}
			}
		}
	}
	return $str_return;
   }
?>