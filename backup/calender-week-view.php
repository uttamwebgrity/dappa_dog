<?php include_once("includes/header.php");

if(!isset($_SESSION['choosed_salon_finder']) || $_SESSION['choosed_salon_finder'] != 1){		
	$_SESSION['client_msg']="Please choose your salon and its service to view this page!";	
	$general_func->header_redirect("index.php");	
}

$spa_ids=implode(",",$_SESSION['salon_finder']['spa']);

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
                  	<img src="images/lftArrow.png" class="lftArw" alt="" />
                  	<h3>Week 9</h3>
                    <img src="images/rhtArrow.png" class="rhtArw" alt="" />
                    <p><strong>Feb 18</strong> ( Monday ) -- <strong>Feb 24</strong> ( Sanday )</p>
                  </div>
                  <div class="mwdBtn">
                    <ul>
                    	<li><a href="calendar.php" style=" border-radius:8px 0 0 8px;">Month</a></li>
                        <li class="mwdCurrent"><a>Week</a></li>
                        <li class="noBg"><a href="calender-date-view.php" style=" border-radius:0px 8px 8px 0;">Day</a></li>
                    </ul>
                  </div>
                  <div class="calenderTablePnl">
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="calenderWek">
  <tr>
    <th align="center" valign="middle">Monday<br><strong>Feb 18</strong></th>
    <th align="center" valign="middle">Tuesday<br><strong>Feb 19</strong></th>
    <th align="center" valign="middle">Wednesday<br><strong>Feb 20</strong></th>
    <th align="center" valign="middle">Thursday<br><strong>Feb 21</strong></th>
    <th align="center" valign="middle">Friday<br><strong>Feb 22</strong></th>
    <th align="center" valign="middle">Saturday<br><strong>Feb 23</strong></th>
    <th align="center" valign="middle">Sunday<br><strong>Feb 24</strong></th>
  </tr>
  <tr>
    <td align="center" valign="middle">9:00 am</td>
    <td align="center" valign="middle">9:00 am</td>
    <td align="center" valign="middle">9:00 am</td>
    <td align="center" valign="middle">9:00 am</td>
    <td align="center" valign="middle">9:00 am</td>
    <td align="center" valign="middle">9:00 am</td>
    <td align="center" valign="middle">9:00 am</td>
  </tr>
  <tr>
    <td align="center" valign="middle">9:30 am</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">9:30 am</td>
    <td align="center" valign="middle">9:30 am</td>
    <td align="center" valign="middle">9:30 am</td>
    <td align="center" valign="middle" class="fullyBlock">Booked</td>
    <td align="center" valign="middle">9:30 am</td>
  </tr>
  <tr>
    <td align="center" valign="middle">10:00 am</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle" class="fullyBlock">Booked</td>
    <td align="center" valign="middle">10:00 am</td>
    <td align="center" valign="middle" class="fullyBlock">Booked</td>
    <td align="center" valign="middle" class="fullyBlock">Booked</td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle">10:30 am</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">10:30 am</td>
    <td align="center" valign="middle">10:30 am</td>
    <td align="center" valign="middle">10:30 am</td>
    <td align="center" valign="middle">10:30 am</td>
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