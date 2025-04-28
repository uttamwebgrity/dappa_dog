<?php include_once("includes/header.php"); 

if(!isset($_SESSION['choosed_salon_finder']) || $_SESSION['choosed_salon_finder'] != 1){		
	$_SESSION['client_msg']="Please choose your salon and its service to view this page!";	
	$general_func->header_redirect("index.php");	
}

$spa_ids=implode(",",$_SESSION['salon_finder']['spa']);
//print_r ($_SESSION['salon_finder']);


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
                      <tr>
                        <th align="center" valign="middle">Monday</th>
                        <th align="center" valign="middle">Tuesday</th>
                        <th align="center" valign="middle">Wednesday</th>
                        <th align="center" valign="middle">Thursday</th>
                        <th align="center" valign="middle">Friday</th>
                        <th align="center" valign="middle">Saturday</th>
                        <th align="center" valign="middle">Sunday</th>
                      </tr>
                      <tr>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle">1</td>
                        <td align="center" valign="middle">2</td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle">3</td>
                        <td align="center" valign="middle">4</td>
                        <td align="center" valign="middle">5</td>
                        <td align="center" valign="middle">6</td>
                        <td align="center" valign="middle">7</td>
                        <td align="center" valign="middle">8</td>
                        <td align="center" valign="middle">9</td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle">10</td>
                        <td align="center" valign="middle">11</td>
                        <td align="center" valign="middle">12</td>
                        <td align="center" valign="middle">13</td>
                        <td align="center" valign="middle">14</td>
                        <td align="center" valign="middle">15</td>
                        <td align="center" valign="middle">16</td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" class="open">17</td>
                        <td align="center" valign="middle" class="fullyBlock">18</td>
                        <td align="center" valign="middle" class="fullyBlock">19</td>
                        <td align="center" valign="middle" class="open">20</td>
                        <td align="center" valign="middle" class="open">21</td>
                        <td align="center" valign="middle" class="open">22</td>
                        <td align="center" valign="middle" class="open">23</td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" class="open">24</td>
                        <td align="center" valign="middle" class="open">25</td>
                        <td align="center" valign="middle" class="open">26</td>
                        <td align="center" valign="middle" class="open">27</td>
                        <td align="center" valign="middle" class="fullyBlock">28</td>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td align="center" valign="middle">&nbsp;</td>
                      </tr>
  </table>
                  </div>
                <ul class="serviceList">
                    <li><img src="images/open.png" alt=""><br> Open</li>
                    <li><img src="images/fullyblock.png" alt=""><br> Fully Blocked</li>
                    <li><img src="images/close.png" alt=""><br> Close</li>
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