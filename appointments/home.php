<?php
include_once("head.htm");
$link_name = "Welcome";

//print_r ($_SESSION['access_permission']);

//print_r ($_SESSION);
?>

<div class="breadcrumb">
      	<p>Dashboard</p>
</div>
<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<div class="dashBrd">
	<div class="dashBrdLeft">
      <div class="qAcc">
        <h3>Quick Access</h3>
            <ul>
            	<li><a href="calendar/calendar.php"><img src="images/icons/calendar.png" alt="Calendar" /> Calendar</a></li>
                <li><a href="customers/customers.php"><img src="images/icons/customers.png" alt="Customers" /> Customers</a></li>                
                <li><a href="customers/pets.php"><img src="images/icons/pet.png" alt="pets" /> Pets</a></li>
                <li><a href="products/products.php"><img src="images/icons/products.png" alt="Products" /> Products</a></li>
                <?php if($_SESSION['admin_access_level'] != 3){ ?>   
                <li><a href="settings/staffs.php"><img src="images/icons/customers.png" alt="staffs" /> Staffs</a></li>
                <li><a href="settings/salons.php"><img src="images/icons/customers.png" alt="Salons" />Salons</a></li>
                <li><a href="email-templates/index.php"><img src="images/icons/messages.png" alt="Email Tempales" />Email Tempales</a></li>
                <li><a href="messages/newsletter.php"><img src="images/icons/messages.png" alt="Newsletter" /> Newsletter</a></li>
                <?php }  if($_SESSION['admin_access_level'] == 1){?>
                <li><a href="settings/settings.php"><img src="images/icons/settings.png" alt="" />General Settings</a></li>
            	<?php }?>            
            </ul>
      </div>
      
      
      <div class="lInHis">
          <h3><img src="images/hours.png" alt="Hours" /> Latest Activities</h3>
            <ul>
              <li>There are no latest activities.</li>
              <!--<li><a href="#url">Calendar</a></li>
                <li><a href="#url">Customers</a></li>
                <li><a href="#url">Messages</a></li>
                <li><a href="#url">Reports</a></li>
                <li><a href="#url">Promote</a></li>
                <li><a href="#url">Settings</a></li>
                <li><a href="#url">Account</a></li>-->
        </ul>
      </div>
      <br class="clear" />
      <div class="myAppo">
          <h3><img src="images/icons/appointment.png" alt="" />&nbsp;
          	<?php
          	if($_SESSION['admin_access_level'] == 1)
				echo "Appointment (s)";
			else if($_SESSION['admin_access_level'] == 2)	
          		echo "Your Salon Appointment (s)";
			else
				echo "My Appointment (s)";	
          	?> </h3>
            <ul>
            	<li>There are no appointments for you.</li>
               <!-- <li><a href="#url">Uttam<br /><span>7th Mar 2013 12:35 PM from IP - 192.168.0.35</span></a></li>
                <li><a href="#url">Uttam<br /><span>7th Mar 2013 12:35 PM from IP - 192.168.0.35</span></a></li>
                <li><a href="#url">Uttam<br /><span>7th Mar 2013 12:35 PM from IP - 192.168.0.35</span></a></li>
                <li><a href="#url">Uttam<br /><span>7th Mar 2013 12:35 PM from IP - 192.168.0.35</span></a></li>-->
            </ul>
      </div>
      
      <?php if($_SESSION['admin_access_level'] != 3){ ?>      
      <div class="lInHis">
          <h3>Log In History</h3>
            <ul>
            	<?php
            	$sql_history="select fname,lname,login_ip,login_date_time from admin_login_hostory h left join admin a";
				$sql_history .=" on h.user_id=a.user_id order by login_date_time DESC limit 10";
				$result_history=$db->fetch_all_array($sql_history);
				$total_history=count($result_history);
				
				for($history=0; $history < $total_history; $history++ ){?>
				 <li><?=$result_history[$history]['fname']." ".$result_history[$history]['lname']?> <span><?=date("jS M Y h:i A",strtotime($result_history[$history]['login_date_time']))?> from IP - <?=$result_history[$history]['login_ip']?></span></li>	
				<?php } ?>            	
              
        </ul>
      </div>
      <?php }?>
    </div>
  	<div class="dashBrdRiht">
   	  <div class="icoLst">
      	<h3>Icon Listing</h3>
        	<ul>       
                <li><img src="images/view-details.png" alt="View" /> View</li>
                <li><img src="images/edit.png" alt="Edit" /> Edit</li>
                <li><img src="images/delete.png" alt="Delete" /> Delete</li> 
                <li><img src="images/icons/print.png" alt="" /> Print</li>
                <li><img src="images/icons/information.png" alt="" /> Information</li>
            </ul>
            <ul>
                <li><img src="images/services.png" alt="Services" /> Services</li>
                <li><img src="images/holidays.png" alt="Holidays" /> Holidays</li>
                <li><img src="images/hours.png" alt="Hours" /> Hours</li>
                <li><img src="images/place_order.png" alt="Place Orde" /> Place Order</li>                
                <li><img src="images/icons/appointment.png" alt="" /> Appointment</li>
            </ul>
      </div>
  	</div>
  	<br class="clear" />
  	
</div>
<?php
include_once("foot.htm");
?>