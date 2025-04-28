<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/

$data=array();
$return_url=$_REQUEST['return_url'];

if(isset($_REQUEST['action']) && $_REQUEST['action']=="VIEW"){
	$sql="select * from customers where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	
	$first_name=$result[0]['first_name'];
	$last_name=$result[0]['last_name'];
	$landline_number=$result[0]['landline_number'];
	$mobile_number=$result[0]['mobile_number'];
	$othere_number=$result[0]['othere_number'];
	$partners_number=$result[0]['partners_number'];
	$email=$result[0]['email'];
		
	$physical_address1=$result[0]['physical_address1'];
	$physical_address2=$result[0]['physical_address2'];
	$physical_suburb=$result[0]['physical_suburb'];
	$physical_city=$result[0]['physical_city'];
	$physical_state=$result[0]['physical_state'];
	$physical_post_code=$result[0]['physical_post_code'];
	
	$postal_address1=$result[0]['postal_address1'];
	$postal_address2=$result[0]['postal_address2'];
	$postal_suburb=$result[0]['postal_suburb'];
	$postal_city=$result[0]['postal_city'];
	$postal_state=$result[0]['postal_state'];
	$postal_post_code=$result[0]['postal_post_code'];
	
		
	$SMS_notifications=$result[0]['SMS_notifications'];
	$email_notifications=$result[0]['email_notifications'];
	$mail_notifications=$result[0]['mail_notifications'];		
}
?>


 <div class="breadcrumb">
      	<p><a href="customers/customers.php">Customers</a> &raquo; <?=$first_name?> <?=$last_name?> </p>
</div>


<ul class="tabBtn">
            	 
        			<?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
            	
            	<li class="activeTab"><a style="cursor: pointer;">View Customer</a></li>              
                
            </ul>
         <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="customer" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
           <input type="hidden" name="return_url" value="<?=$return_url?>" />
        
        
<div class="tabPnlCont">
<div class="tabPnlContInr">
<div class="tabcontArea" style="background:none;">
	<ul class="icoMenu">
      	<li><a ><img src="images/icoMnu1.png" alt="" />Pets</a></li>
        <li><a ><img src="images/icoMnu2.png" alt="" />Purchased History</a></li>
        <li><a ><img src="images/icoMnu3.png" alt="" />Reminder(s)</a></li>
        <li><a ><img src="images/icoMnu4.png" alt="" />Make Appointment</a></li>
      </ul>
    <h3>Personal Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    <li>First Name<br><b><?=$first_name?> &nbsp;</b></li>
    <li>Last Name <br><b><?=$last_name?>&nbsp;</b></li>
    <li>Landline Number<br><b><?=$landline_number?>&nbsp;</b></li>
    <li>Mobile Number (SMS Number)<br><b style="width:215px;"><?=trim($mobile_number) != NULL?''.trim($mobile_number):'&nbsp;'?></b>
    	
    	 <?php if(trim($mobile_number) != NULL){?>
              <img src="images/foneIcon.png" alt="" style="margin-top:3px;"  />
       <?php }?>
    	
    </li>
    <li>Other Number<br><b><?=$othere_number?>&nbsp;</b></li>
    <li>Partners Number<br><b><?=$partners_number?>&nbsp;</b></li>
    <li>Email<br><b style="width:215px;"><?=$email?></b>
    <?php if(trim($email) != NULL){?>
           <img src="images/mailIcon.png" alt="" style="margin-top:6px;"  />
       <?php }?>
    	
    </li>             
    </ul>
    </div>
    </div>
    <h3>Physical Address:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    <li>Address line 1<br><b><?=$physical_address1?>&nbsp;</b></li>
    <li>Address line 2<br><b><?=$physical_address2?>&nbsp;</b></li>
    <li>Suburb<br><b><?=$physical_suburb?>&nbsp;</b></li>
    <li>City<br><b><?=$physical_city?>&nbsp;</b></li>
    <li>State<br><b><?=$physical_state?>&nbsp;</b></li>
    <li>Post code<br><b><?=$physical_post_code?>&nbsp;</b></li>
    
    </ul>
    </div>
    </div>
    <h3> Postal Address:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    <li>Address line 1<br><b><?=$postal_address1?>&nbsp;</b></li>
    <li>Address  line 2<br><b><?=$postal_address2?>&nbsp;</b></li>
    <li>Suburb<br><b><?=$postal_suburb?>&nbsp;</b></li>
    <li>City<br><b><?=$postal_city?>&nbsp;</b></li>
    <li>State<br><b><?=$postal_state?>&nbsp;</b></li>
    <li>Post code<br><b><?=$postal_post_code?>&nbsp;</b></li>
    
    </ul>
    </div>
    </div>
    <h3>Notifications:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    <li><b><?=$SMS_notifications==1?'Send SMS notifications':'Do not Send SMS notifications';?> <br />
    <?=$email_notifications==1?'Send email notifications':'Do not Send email notifications';?><br />
    <?=$mail_notifications==1?'Do not mail':'Send mail';?></b></li>
    </ul>
    </div>
    </div>
    <div class="submitSection">            	
    <input name="back" type="button" value="Back" onclick="location.href='<?=$return_url?>'" class="backBtn" />

</div>
<br class="clear" />
</div>
<br class="clear" />
</div>
</div>


          </form>
           
            
<?php
include("../foot.htm");
?>