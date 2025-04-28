<?php include_once("includes/header.php"); 

if(!isset($_SESSION['client_login']) || $_SESSION['client_login'] != "yes"){
	$_SESSION['client_msg']="Please login to view this page!";
	$_SESSION['client_redirect_to_page']=$_SERVER['HTTP_REFERER'];		
	$general_func->header_redirect("login.php");
}

?>

<div class="middilePnl">
<div class="bodyContentInr">
  <div class="mainDiv"> 
  	 <div class="myAccLft">
      	<h2>My Account</h2>
        <ul>
            <li><img src="images/myAcIco1.png" alt="" /><a href="#url">Your Pets</a></li>
            <li><img src="images/myAcIco2.png" alt="" /><a href="#url">Change / Update Profile</a></li>
            <li><img src="images/myAcIco3.png" alt="" /><a href="#url">My Appointment(s)</a></li>
            <li><img src="images/myAcIco4.png" alt="" /><a href="#url">Change Password</a></li>
            <li><img src="images/myAcIco5.png" alt="" /><a href="#url">Reminders</a></li>
        </ul>
      </div>
      <div class="myAccRht">
        <div class="row">
          <div class="myAppDePnl">
            <h1>My Appointments</h1>
            <ul>
            	<li><b>Service (s) :</b> <span> Wash &amp; Blow Dry</span></li>
                <li><b>Date &amp; Time :</b> <span> 24.04.2013 on 12.30 p.m</span></li>
                <li><b>Item Purchased :</b> <span> Puppy Shampoo, Royal Canin Junior,<br />Greenie Dental Chew, Playball</span></li>
                <li><b>Status :</b><span> Open Appointment</span></li>
                <li><textarea name="" cols="" rows="">Reschedule Reason :</textarea></li>
            </ul>
          </div>
          <div class="myAppDePnl">
            <h1>Salon Details</h1>
            <ul>
                <li><b>Salon Name :</b> <span>Re Tappa</span></li>
                <li><b>Phone No :</b> <span>+64 98765432</span></li>
                <li><b>Email Id :</b> <span>mailsaikatd@gmail.com</span></li>
                <li><b>Address :</b> <span>302 A, Kalicharan Dutta Rd<br />Kolkata - 8</span></li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="myAcBtnPnl">
          	<div class="makAnApp"><a href="#url">Make another Appointment</a></div>
            <div class="canclApp"><a href="#url">Cancel Appointment</a></div>
          </div>
        </div>
      </div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>