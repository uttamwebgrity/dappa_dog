<?php include_once("includes/header.php"); 

/*if(!isset($_SESSION['choosed_salon_finder']) || $_SESSION['choosed_salon_finder'] != 1){		
	$_SESSION['client_msg']="Please choose your salon and its service to view this page!";	
	$general_func->header_redirect("index.php");	
}*/

$spa_ids=implode(",",$_SESSION['salon_finder']['spa']);
//print_r ($_SESSION['salon_finder']);


//************ working_days **********************//	
$sql_working_day="select working_day from salon_working_days where salon_id='" . $_SESSION['salon_finder']['salon_id'] . "' order by working_day ASC";
$result_working_day=$db->fetch_all_array($sql_working_day);
$total_working_day=count($result_working_day);
	
$working_days=array();
	
for($day=0; $day<$total_working_day; $day++){
	$working_days[]=$result_working_day[$day]['working_day'];	
}
//************ working_days **********************//		


//This time slot can not be reserved Someone else booked the time slot before you confirmed.

require("Calc.php");

if(isset($_REQUEST['year']) || isset($_REQUEST['month']) || isset($_REQUEST['day'])){	
	$year = $_REQUEST['year'];
	$month =$_REQUEST['month'];
	$day = $_REQUEST['day'];
}else{		
	$year = Date_Calc::dateNow("%Y");
	$month = Date_Calc::dateNow("%m");
	$day = "01";
}

$month_cal = Date_Calc::getCalendarMonth($month,$year,"%E");
$view = "month";


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
                  	<a href="<?php echo $PHP_SELF."?".Date_Calc::beginOfPrevMonth($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>"><img src="images/lftArrow.png" class="lftArw" alt="Previous" title="Previous" /></a>
                  	<h3><?php echo Date_Calc::dateFormat($day,$month,$year,"%B, %Y  %n"); ?></h3>
                   <a href="<?php echo $PHP_SELF."?".Date_Calc::beginOfNextMonth($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>"><img src="images/rhtArrow.png" class="rhtArw" alt="Next" title="Next" /></a>
                  </div>
                  <div class="mwdBtn">
                    <ul>
                    	<li class="mwdCurrent"><a href="calendar.php?<?=Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")?>" style=" border-radius:8px 0 0 8px;">Month</a></li>
                        <li><a href="calender-week-view.php?<?=Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")?>">Week</a></li>
                        <li class="noBg"><a href="calender-date-view.php?<?=Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")?>"  style=" border-radius:0px 8px 8px 0;">Day</a></li>
                    </ul>
                  </div>
                  <div class="calenderTablePnl">
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="calender">
                    <?php
					if(DATE_CALC_BEGIN_WEEKDAY == 0){
					?>
					<tr>
						<th align="center" valign="middle" width="14.5%">Sunday</th>
                        <th align="center" valign="middle" width="14.5%">Monday</th>
                        <th align="center" valign="middle" width="14.5%">Tuesday</th>
                        <th align="center" valign="middle" width="14.5%">Wednesday</th>
                        <th align="center" valign="middle" width="14.5%">Thursday</th>
                        <th align="center" valign="middle" width="14.5%">Friday</th>
                        <th align="center" valign="middle" width="14.5%">Saturday</th>                        
                      </tr>
					<?php
					}else{
					?>
					<tr>
						<th align="center" valign="middle" width="14.5%">Monday</th>
                        <th align="center" valign="middle" width="14.5%">Tuesday</th>
                        <th align="center" valign="middle" width="14.5%">Wednesday</th>
                        <th align="center" valign="middle" width="14.5%">Thursday</th>
                        <th align="center" valign="middle" width="14.5%">Friday</th>
                        <th align="center" valign="middle" width="14.5%">Saturday</th>
                        <th align="center" valign="middle" width="14.5%">Sunday</th>
                  	</tr>
					<?php } 
					$curr_day = Date_Calc::dateNow("%Y%m%d");	
					
					// loop through each week of the calendar month
					for($row = 0; $row < count($month_cal); $row++){
						echo "<tr>\n";						
						// loop through each day of the current week
						for($col=0; $col < 7; $col++){
							// set the font color of the day, highlight if it is today
							if(Date_Calc::daysToDate($month_cal[$row][$col],"%m") == $month){
								if(in_array($col+1,$working_days)){
								
									
									echo "<td class=\"open\">"
									."<a href=\"calender-date-view.php?"
									.Date_Calc::daysToDate($month_cal[$row][$col],"year=%Y&month=%m&day=%d")
									."\">"									
									.Date_Calc::daysToDate($month_cal[$row][$col],"%d")									
									."</a>"
									."</td>\n";	
								}else{
									echo "<td class=\"close\"></td>";									
								}
								
							}else{
								echo "<td></td>\n";								
							}						
						}
						echo "</tr>\n";					
						
					}
					
					
					
					/*$curr_day = Date_Calc::dateNow("%Y%m%d");					
					
					for($row = 0; $row < count($month_cal); $row++){
						echo "<tr>\n";						
						for($col=0; $col < 7; $col++){
							if(Date_Calc::daysToDate($month_cal[$row][$col],"%Y%m%d") == $curr_day)
								$fontColor="#a00000";			
							elseif(Date_Calc::daysToDate($month_cal[$row][$col],"%m") == $month)
								$fontColor="#0000ff";
							else
								$fontColor="#777777";
				
							echo "<td align=\"center\" valign=\"middle\" class=\"open\">"
									."<a href=\"calender-date-view.php?"
									.Date_Calc::daysToDate($month_cal[$row][$col],"year=%Y&month=%m&day=%d")
									."\">"
									.Date_Calc::daysToDate($month_cal[$row][$col],"%d")									
									."</a>"
									."</td>\n";
						}
						echo "</tr>\n";						
					}*/
					
					// class="open" "fullyBlock"
					?></table>
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