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
                  	<h3>Sat, 9 March 2013</h3>
                    <img src="images/rhtArrow.png" class="rhtArw" alt="" />
                  </div>
                  <div class="mwdBtn">
                    <ul>
                    	<li><a href="calendar.php" style=" border-radius:8px 0 0 8px;">Month</a></li>
                        <li><a href="calender-week-view.php">Week</a></li>
                        <li class="noBg mwdCurrent"><a  style=" border-radius:0px 8px 8px 0;">Day</a></li>
                    </ul>
                  </div>
                  <div class="calenderTablePnl">
                    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="calenderDate">
                      <tr>
                        <td align="right" valign="top">&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
                      </tr>
                      
                      <tr>
                        <td width="10%" align="right" valign="top">9 am</td>
                        <td width="90%" align="left" valign="top" class="dateSty">Lorem ipsum dolor sit amet, consectetur.</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">10 am</td>
                        <td align="left" valign="top" class="dateRed">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">11 am</td>
                        <td align="left" valign="top" class="dateSty">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">12 am</td>
                        <td align="left" valign="top" class="dateRed">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="10%" align="right" valign="top">1 pm</td>
                        <td width="90%" align="left" valign="top" class="dateSty">Lorem ipsum dolor sit amet, consectetur.</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">2 pm</td>
                        <td align="left" valign="top" class="dateRed">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">3 pm</td>
                        <td align="left" valign="top" class="dateSty">&nbsp;</td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">4 pm</td>
                        <td align="left" valign="top" class="dateRed">&nbsp;</td>
                      </tr>
                      
                      <tr>
                        <td align="right" valign="top">&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
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