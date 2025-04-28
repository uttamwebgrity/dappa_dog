<?php 
include_once("includes/header.php");

$data=array();


if(isset($_SESSION['client_login']) || $_SESSION['client_login'] == "yes"){
	$_SESSION['client_msg']="You have already registered in our site, please choose your salon and its service to make your appointment!";	
	$general_func->header_redirect("index.php");	
}

if(isset($_POST['enter']) && $_POST['enter']=="customer"){	
	$first_name=trim($_REQUEST['first_name']);
	$last_name=trim($_REQUEST['last_name']);
	$landline_number=trim($_REQUEST['landline_number']);
	$mobile_number=trim($_REQUEST['mobile_number']);	
	$email=trim($_REQUEST['email']);
	$password=trim($_REQUEST['password']);	
	$comments=trim($_REQUEST['comments']);			
		
	$physical_address1=trim($_REQUEST['physical_address1']);
	$physical_address2=trim($_REQUEST['physical_address2']);
	$physical_suburb=trim($_REQUEST['physical_suburb']);
	$physical_city=trim($_REQUEST['physical_city']);
	$physical_state=trim($_REQUEST['physical_state']);
	$physical_post_code=trim($_REQUEST['physical_post_code']);
	
	
	if(isset($_REQUEST['other_billing']) && $_REQUEST['other_billing']== 1){
		$postal_address1=$_REQUEST['physical_address1'];
		$postal_address2=$_REQUEST['physical_address2'];
		$postal_suburb=$_REQUEST['physical_suburb'];
		$postal_city=$_REQUEST['physical_city'];
		$postal_state=$_REQUEST['physical_state'];
		$postal_post_code=$_REQUEST['physical_post_code'];
	}else{
		$postal_address1=$_REQUEST['postal_address1'];
		$postal_address2=$_REQUEST['postal_address2'];
		$postal_suburb=$_REQUEST['postal_suburb'];
		$postal_city=$_REQUEST['postal_city'];
		$postal_state=$_REQUEST['postal_state'];
		$postal_post_code=$_REQUEST['postal_post_code'];		
	}
		
	$SMS_notifications=(isset($_REQUEST['SMS_notifications']) && $_REQUEST['SMS_notifications']==1)?1:0;
	$email_notifications=(isset($_REQUEST['email_notifications']) && $_REQUEST['email_notifications']==1)?1:0;
					
			
	if($db->already_exist_inset("customers","email",$email)){
		$_SESSION['client_msg']="Sorry, your specified email address is already taken!";					
	}else if(trim($mobile_number) != NULL && $objdappaDogs->already_exist_mobile("customers","mobile_number",$mobile_number)){
		$_SESSION['client_msg']="Sorry, your specified mobile number is already taken!";			
	}else{			
		$data['first_name']=$first_name;
		$data['last_name']=$last_name;
		$data['landline_number']=$landline_number;
		$data['mobile_number']=$mobile_number;		
		$data['email']=$email;
		$data['password']=$password;
				
		$data['physical_address1']=$physical_address1;
		$data['physical_address2']=$physical_address2;
		$data['physical_suburb']=$physical_suburb;
		$data['physical_city']=$physical_city;
		$data['physical_state']=$physical_state;
		$data['physical_post_code']=$physical_post_code;
		
		$data['postal_address1']=$postal_address1;
		$data['postal_address2']=$postal_address2;
		$data['postal_suburb']=$postal_suburb;
		$data['postal_city']=$postal_city;
		$data['postal_state']=$postal_state;
		$data['postal_post_code']=$postal_post_code;
		
			
		$data['SMS_notifications']=$SMS_notifications;
		$data['email_notifications']=$email_notifications;
		$data['sent_email']=1;
						
		$data['created_ip']=$_SERVER['REMOTE_ADDR'];
		$data['created']='now()';		
			
		$customer_id=$db->query_insert("customers",$data);
		
		if(trim($comments) != NULL){
			$data_comment=array();				
			$data_comment['customer_id']=$customer_id;
			$data_comment['comments']=trim($comments);			
			$data_comment['added']='now()';		
			$db->query_insert("customers_comments",$data_comment);
		}
		
						
		$sql_email_template="select template_subject,template_content from email_template where id=6 limit 1";
		$result_email_template = $db -> fetch_all_array($sql_email_template);
			
		if(count($result_email_template) == 1){
			$message_content=$result_email_template[0]['template_content'];	
					
			$message_content=str_replace("#dog_owner_name#",$first_name . " " . $last_name,$message_content);
			$message_content=str_replace("#email_address# ",$email,$message_content);
			$message_content=str_replace("#password#",$password,$message_content);	
			
			$message_content=str_replace("#customer_login_link#",$general_func->site_url."login.php",$message_content);	
			$message_content=str_replace("#contact_link#",$general_func->site_url."contact.php",$message_content);	
									
			$receiver_info = array();
			$receiver_info['subject'] = $result_email_template[0]['template_subject'];	
			$receiver_info['content'] = $message_content;
			$receiver_info['email'] = $email;
			$sendmail -> register_welcome_to_user($receiver_info, $general_func -> admin_email_id, $general_func -> site_title, $general_func -> site_url);				
		}
		
			
		$_SESSION['client_success_msg']="Thank you for your registration with us, your login information has been sent to your specified email address!";
		$general_func->header_redirect("login.php");
	}		
}	

?>

<script language="JavaScript">
function validate(){				
	if(!validate_text(document.ff.first_name,1,"Please enter first name"))
		return false;
		
	if(!allLetter(document.ff.first_name,"First name must have alphabet characters only"))
		return false;		
	
	if(!validate_text(document.ff.mobile_number,1,"Please enter your mobile number"))
		return false;
		
	if(!validate_email(document.ff.email,1,"Enter email address"))
		return false;
		
	if(!validate_text(document.ff.password,1,"Please enter password"))
		return false;
		
	if(!passid_validation(document.ff.password,6,12,"Password must be of length between"))
		return false;					
		
	if(!validate_text(document.ff.cpassword,1,"Please enter your confirm password"))
		return false;	
		
	if(document.ff.password.value != document.ff.cpassword.value){
		alert("Your password and confirm password must be same");
		document.ff.cpassword.focus();
		return false;
	}			
		
}

function change(){
	if (document.ff.other_billing.checked == true){
		document.getElementById("postal_address_div").style.display="none";		
	} else {
		document.getElementById("postal_address_div").style.display="block";		
	}
}
</script>



<div class="middilePnl">

<div class="bodyContentInr">
	<?php if(isset($_SESSION['client_msg']) && trim($_SESSION['client_msg']) != NULL ){?>
		<div class="row">
		    <div class="errorPnl">
		      <?=$_SESSION['client_msg']; $_SESSION['client_msg']=""; ?>
		    </div>
 		</div>		
		
	<?php }
	
	if(isset($_SESSION['client_success_msg']) && trim($_SESSION['client_success_msg']) != NULL ){?>
		<div class="row">
    <div class="succPnl">
      <?=$_SESSION['client_success_msg']; $_SESSION['client_success_msg']=""; ?>
    </div>
 </div>	
		
	<?php }?>
  <div class="mainDiv">
    	<h1>Register</h1>
      	<div class="tabPnl">
       	  <div class="tabPnlLft">
          	<ul>
            	<li class="logIcon"><a href="login.php">Login</a></li>
                <li class="regIcon"><a href="register.php" class="regCurrent">Register</a></li>
            </ul>
          </div>
          <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="customer" />
          <div class="tabPnlCont">
          	<div class="tabPnlContInr" style="background:url(images/regBg.png) no-repeat left bottom #fff;">
       	    <div class="regPnl">
            	<h3>Personal Information</h3>
            	<ul class="loginForm" style="margin:20px 0 0;">
                   <li><span>First Name <b>*</b></span> <input type="text" value="<?=$_REQUEST['first_name']?>" name="first_name" class="regFild"></li>
                   <li><span>Last Name </span> <input type="text" value="<?=$_REQUEST['last_name']?>" name="last_name" class="regFild"></li>
                   <li><span>Landline No </span> <input type="text" value="<?=$_REQUEST['landline_number']?>" name="landline_number" class="regFild"></li>
                   <li><span>Mobile No <b>*</b></span> <input type="text" class="regFild"  value="<?=$_REQUEST['mobile_number']?>" name="mobile_number"></li>
                   <li><span>Email <b>*</b></span><input type="text" value="<?=$_REQUEST['email']?>" name="email" class="regFild"></li>
                   <li><span>Password <b>*</b></span> <input type="password" value="<?=$_REQUEST['password']?>" name="password" class="regFild"></li>                   
               		<li><span>Confirm Password <b>*</b></span> <input type="password" value="<?=$_REQUEST['cpassword']?>" name="cpassword" class="regFild"></li>
		    	 	<li><span>Comments </span> <textarea class="regFild" name="comments"><?=$_REQUEST['comments']?></textarea></li>               
                </ul>
                
                <h3>Appointment Reminder Notifications</h3>
            	<ul class="loginForm" style="margin:20px 0 0;">            
                                
                    <li><input name="SMS_notifications" value="1" type="checkbox" <?=$_REQUEST['SMS_notifications']==1?'checked="checked"':'';?>>Send SMS notifications</li>
                    <li><input name="email_notifications" value="1"  type="checkbox" checked="checked" <?=$_REQUEST['email_notifications']==1?'checked="checked"':'';?>>Send email notifications</li>
    			</ul>
                
            </div>            
            <div class="regPnl">
            	<h3>Physical Address:</h3>
            	<ul class="loginForm" style="margin:20px 0 0;">
                   <li><span>Address line 1</span> <input type="text" value="<?=$_REQUEST['physical_address1']?>" name="physical_address1" class="regFild"></li>
                   <li><span>Address line 2</span> <input type="text" value="<?=$_REQUEST['physical_address2']?>" name="physical_address2" class="regFild"></li>
                   <li><span>Suburb</span> <input type="text" value="<?=$_REQUEST['physical_suburb']?>" name="physical_suburb" class="regFild"></li>
                   <li><span>City</span> <input type="text" class="regFild" value="<?=$_REQUEST['physical_city']?>" name="physical_city"></li>
                   <li><span>State</span> <input type="text" value="<?=$_REQUEST['physical_state']?>" name="physical_state" class="regFild"></li>
                   <li><span>Post code</span> <input type="text" value="<?=$_REQUEST['physical_post_code']?>" name="physical_post_code" class="regFild"></li>
                </ul>            	
            	<h3>Postal Address:</h3>
            	 <ul class="loginForm" style="margin:20px 0 0;">
                 <li style="padding:0;"><input type="checkbox" name="other_billing" value="1" checked="checked" onclick="change();"> Same as Physical Address</li>            	</ul>
           	   <ul class="loginForm" id="postal_address_div" style="margin:20px 0; display: none;">                  
                   <li><span>Address line 1</span> <input type="text" value="<?=$_REQUEST['postal_address1']?>" name="postal_address1" class="regFild"></li>
                   <li><span>Address line 2</span> <input type="text" value="<?=$_REQUEST['postal_address2']?>" name="postal_address2" class="regFild"></li>
                   <li><span>Suburb</span> <input type="text" value="<?=$_REQUEST['postal_suburb']?>" name="postal_suburb" class="regFild"></li>
                   <li><span>City</span> <input type="text" class="regFild" value="<?=$_REQUEST['postal_city']?>" name="postal_city"></li>
                   <li><span>State</span> <input type="text" value="<?=$_REQUEST['postal_state']?>" name="postal_state" class="regFild"></li>
                   <li><span>Post code</span> <input type="text" value="<?=$_REQUEST['postal_post_code']?>" name="postal_post_code" class="regFild"></li>
                   <li></li>
                </ul>
                
            	
                
            </div>
            <br class="clear">
            <div class="regPnl" style="width:92%; padding-bottom:25px;"><input name="" type="submit" value="" class="submitBtn" style="float:right;" /><input name="" type="submit" value="" class="bckBtn" style="float:right;" /></div>
            
            <br class="clear">
            </div>
          </div>
          </form>
      	</div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>