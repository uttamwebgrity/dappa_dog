<?php 
include_once("includes/header.php");

if(!isset($_SESSION['choosed_salon_finder']) || $_SESSION['choosed_salon_finder'] != 1){
	$_SESSION['client_msg']="Please choose your salon and its service to view this page!";	
	$general_func->header_redirect("index.php");	
}

//******* Appointment details ***************************//



if(isset($_REQUEST['booking_date']) && isset($_REQUEST['timeslot_start'])  && isset($_REQUEST['service_time_required'])){
	$_SESSION['choosed_booking_date_time']=1;	
	
	unset($_SESSION['salon_booking_date_time']);		
	$_SESSION['salon_booking_date_time']['booking_date']=$_REQUEST['booking_date'];
	$_SESSION['salon_booking_date_time']['timeslot_start']=$_REQUEST['timeslot_start'];
	$_SESSION['salon_booking_date_time']['service_time_required']=$_REQUEST['service_time_required'];		
}

//******************************************************//

if(!isset($_SESSION['client_login']) || $_SESSION['client_login'] != "yes"){
	$_SESSION['client_msg']="Please login to make an appointment on your selected time slot!";
	$_SESSION['client_redirect_to_page']=$_SERVER['REQUEST_URI'];
	
	$general_func->header_redirect("login.php");
}

?>
<div class="middilePnl">
<p style="color:#F00; font-size:14px; font-weight:bold; text-align:center;">No Programing (coding) has been made yet.<br />We are working on it.</p>

<div class="bodyContentInr">
  <div class="mainDiv">  		  
    	<h1>Add Pets</h1>
      <div class="tabPnl">
      	<div class="tabPnlCont">
      	  <div class="tabPnlContInr" style="background:url(images/regBg.png) no-repeat right bottom #fff; padding-bottom:0;">
        <div class="regPnl" style="width:92%;">
		    <h3>Pet Information:</h3>
		    <div class="regPnl" style="width:50%;">
		  	<ul class="loginForm" style="margin:20px 0 10px;">
		    	<li><span>Pet Type <b>*</b></span> 
		    		
		      		<select name="grooming_id" class="regFild">
		      			
		            	<option>Select One</option>
		            </select>
		        </li>
		       	<li><span>Name: <b>*</b></span>
		       		<div style="float:left;"><input type="text" value="" name="" class="regFild"></div>
		       	</li>
		       	<li><span>Breed <b>*</b></span> 
		        	<div style="float:left;">
			           	<select class="regFild">
			            	<option>Select One</option>
			            </select>
		           		<b class="popup">
			           		<div id="div_add_your_breed_icon" style="display: block;"><img src="images/plus.png" alt="" /> Add your Breed if not Listed </div>
			           		<div id="div_close_your_breed_icon" style="display: none;"><img src="images/close_small.png" alt="" /> Close</div>
			           		<div class="disPopup">
			                	<input type="text" name="">
			                    <input type="submit" name="save" value="" class="addBtn">
			              	</div>
		           		</b>
		           </div>
		        </li>   
		       	<li>
		       		<span>
		       			<a onmouseout="hideddrivetip();"  onmouseover="ddrivetip('Hello!')"><img src="images/i.png" alt="" /></a> Medical </span>
		       			<textarea class="regFild" name="comments"></textarea>
		       	</li>
		       	<li><span><a onmouseout="hideddrivetip();"  onmouseover="ddrivetip('Hello!')"><img src="images/i.png" alt="" /></a> Behavioural </span>
		       		<textarea class="regFild" name="comments"></textarea>
		       	</li>
		       	<li>
		       		<span class="onOff2">&nbsp;</span><input name="" type="submit" value="" class="submitBtn" style="float:left; margin-left:0;" />
		           	<input name="" type="submit" value="" class="bckBtn" style="float:left;" />
		       	</li>
		    </li>
		</ul>
	</div>
</div>
            
            
           <!-- <div class="submitSection">
       	   		<input type="button" class="confAppBtn" value="Back" name="back">
            	<input type="button" class="backBtn" value="Back" name="back">
                <input type="reset" class="cancelBtn" value="Cancel" name="Cancel">
           </div>-->
            <br class="clear">
          </div>
      	</div>
      </div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>