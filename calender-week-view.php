<?php include_once("includes/header.php");

if(!isset($_SESSION['choosed_salon_finder']) || $_SESSION['choosed_salon_finder'] != 1){		
	$_SESSION['client_msg']="Please choose your salon and its service to view this page!";	
	//$general_func->header_redirect("index.php");	
}

$spa_ids=implode(",",$_SESSION['salon_finder']['spa']);


//************ working_days **********************//	
$sql_working_day="select working_day from salon_working_days where salon_id='" . $_SESSION['salon_finder']['salon_id'] . "' order by working_day ASC";
$result_working_day=$db->fetch_all_array($sql_working_day);
$total_working_day=count($result_working_day);
	
$working_days=array();
	
for($day=0; $day<$total_working_day; $day++){
	$working_days[]=$result_working_day[$day]['working_day'];	
}
//************ working_days **********************//	



require("Calc.php");

if(isset($_REQUEST['date']) || isset($_REQUEST['month']) || isset($_REQUEST['day'])){
	$year_array=explode("=",$_REQUEST['date']);
	$year = $year_array[1];
	$month =$_REQUEST['month'];
	$day = $_REQUEST['day'];
}else{		
	$year = Date_Calc::dateNow("%Y");
	$month = Date_Calc::dateNow("%m");
	$day = Date_Calc::dateNow("%d");
}



$week_cal = Date_Calc::getCalendarWeek($day,$month,$year,"%E");
$view = "week";



$service_time_required=0;

$result_core_service_time_required=$db->fetch_all_array("select time_required from service_time where service_id='" .$_SESSION['salon_finder']['service_id']. "'  and service_type=1  and pet_size_id='" .$_SESSION['salon_finder']['pet_size']. "' limit 1");

if(trim($result_core_service_time_required[0]['time_required']) != NULL)
	$service_time_required += trim($result_core_service_time_required[0]['time_required']);


if(isset($_SESSION['salon_finder']['spa']) && count($_SESSION['salon_finder']['spa'])){
	$result_spa_service_time_required=$db->fetch_all_array("select time_required from service_time where service_id IN ($spa_ids)  and service_type=2 and pet_size_id='" .$_SESSION['salon_finder']['pet_size']. "'");
	$total_spa=count($result_spa_service_time_required);
	
	for($spa=0; $spa<$total_spa; $spa++){
		$service_time_required += $result_spa_service_time_required[$spa]['time_required']; 	
	}
}


$sql_finder="select opening_time,closing_time from salons  where id=" . (int) $_SESSION['salon_finder']['salon_id'] . " limit 1";
$result_finder=$db->fetch_all_array($sql_finder);	
	
$finder_opening_time=$result_finder[0]['opening_time'];
$finder_closing_time=$result_finder[0]['closing_time'];	


 ?>
<div class="middilePnl">

<div class="bodyContentInr">
  <div class="mainDiv">
    	<h1>Appointment Scheduler</h1>
      	<div class="tabPnl">
       	  <div class="tabPnlLftTwo">
          	<ul>
            	<li class="logIcon"><a href="appointment-scheduler.php" class="logCurrent"><img src="images/bookIco.png" alt=""> Book Now</a></li>
                <li class="regIcon"><a href="#url"><img src="images/cancelBtn.png" alt=""> Cancel</a></li>
            </ul>
          </div>
          <div class="tabPnlCont">
            <div class="appsdule">
				<h2><?=$objdappaDogs->salon_name($_SESSION['salon_finder']['salon_id'])?></h2>
              <ul class="serviceList">
              	<li><strong>Service type:</strong><br> <?=$objdappaDogs->service_name($_SESSION['salon_finder']['service_id'])?></li>
               <?php if(isset($_SESSION['salon_finder']['spa']) && count($_SESSION['salon_finder']['spa'])){?>
               	<li><strong>Spa Treatments:</strong><br> <?=$objdappaDogs->spa_treatments($spa_ids)?>               		
               		</li>				
              <?php  } ?>              
                
                <li><strong>Size:</strong><br> <?=$objdappaDogs->show_size($_SESSION['salon_finder']['pet_size'])?></li>
              </ul>
              <div class="calenderPnl">
                <div class="row">
               	  <div class="monthHeading">
                  	<a href="<?php echo $PHP_SELF."?".Date_Calc::beginOfPrevWeek($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>"><img src="images/lftArrow.png" class="lftArw" alt="Previous" title="Previous" /></a>
                  	<h3><?php echo "Week " . Date_Calc::weekOftheYear($day,$month,$year);?></h3>
                    <a href="<?php echo $PHP_SELF."?".Date_Calc::beginOfNextWeek($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>"><img src="images/rhtArrow.png" class="rhtArw" alt="Next" title="Next" /></a>
                    <p><?php 	echo Date_Calc::beginOfWeek($day,$month,$year,"<strong>%b %e </strong> - ")
			.Date_Calc::endOfWeek($day,$month,$year,"<strong> %b %e, %Y</strong>%n");?>
			</p>
                  </div>
                  <div class="mwdBtn">
                    <ul>
                    	<li><a href="calendar.php?<?=Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")?>" style=" border-radius:8px 0 0 8px;">Month</a></li>
                        <li class="mwdCurrent"><a href="calender-week-view.php?<?=Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")?>">Week</a></li>
                        <li class="noBg"><a href="calender-date-view.php?<?=Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")?>" style=" border-radius:0px 8px 8px 0;">Day</a></li>
                    </ul>
                  </div>
                  <div class="calenderTablePnl">
                	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="calenderWek">
						<tr>
						<?php
						$curr_day = Date_Calc::dateNow("%Y%m%d");
						$curr_month = Date_Calc::dateNow("%m");
						
						for($row = 0; $row < 7; $row++){
							if(Date_Calc::daysToDate($week_cal[$row],"%Y%m%d") == $curr_day)
								$fontColor = "#a00000";
							elseif(Date_Calc::daysToDate($week_cal[$row],"%m") != $curr_month)
								$fontColor = "#777777";
							else
								$fontColor = "#0000ff";
						
						
							echo '<td width="14.5%">
									<table  width="100%"  border="0" cellspacing="0" cellpadding="0">
										<tr>
					    					<th align="center" valign="middle">';
									$week_year = Date_Calc::daysToDate(($week_cal[$row]),"%Y");
									$week_month = Date_Calc::daysToDate(($week_cal[$row]),"%m");
									$week_day = Date_Calc::daysToDate(($week_cal[$row]),"%d");			
									echo Date_Calc::dateFormat($week_day,$week_month,$week_year,"%A<br> <strong>%b %e, %Y </strong>%n");
							echo "</th>
					    		</tr>";
								
							if(in_array($row+1,$working_days)){
								$booking_date=$week_day.$week_month.$week_year;
								
								for($time_slot = $finder_opening_time; $time_slot < $finder_closing_time; $time_slot += $service_time_required){
									
									$hour_min="";	
									$hours = $time_slot / 60;
	    							$min = $time_slot % 60;	
																	
									
									$disp_hour=floor($hours);
									$time_suffix= $disp_hour > 11?'PM':'AM';
									
									if($disp_hour > 12)
										$disp_hour=$disp_hour % 12;
									
																									
									$disp_min=strlen($min)==1?'0'.$min:$min;							
									$hour_min=$disp_hour ." : " . $disp_min ." ". $time_suffix;
									
									echo '<tr>
					    				 <td align="center" valign="middle" class="open"><a href="add-pets.php?booking_date=' . $booking_date . '&timeslot_start=' . $time_slot .'&service_time_required='. $service_time_required .'" title="3 of 3 time slots are available" alt="3 of 3 time slots are available">' . $hour_min . '</a></td>
					    			</tr>';
									
									
								}		
								
								
									/*echo '<tr>
					    				 <td align="center" valign="middle" class="open"><a href="#url">10:00 am</a></td>
					    			</tr>
					    			<tr>
					    				  <td align="center" valign="middle" class="fullyBlock">Booked</td>
					    			</tr>
					    			<tr>
					    				  <td align="center" valign="middle" class="fullyBlock">Booked</td>
					    			</tr>
					    			';	*/	
								
							}
						
						
							echo "</table>								
							</td>";
							
						}
						
						?>							
						</tr> 
					</table>

                  </div>
                <ul class="serviceList">
                    <li><img src="images/open.png" alt=""><br>Available Appointments</li>
                    <li><img src="images/fullyblock.png" alt=""><br>Fully Booked</li>
                    <li><img src="images/close.png" alt=""><br>Closed</li>
                </ul>
                </div>
              </div>
            </div>
          </div>
      	</div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>