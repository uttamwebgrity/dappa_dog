<?php 
include_once("includes/header.php");

$data=array();


if(isset($_POST['enter']) && $_POST['enter']=="customer"){
	
	$first_name=$_REQUEST['first_name'];
	$last_name=$_REQUEST['last_name'];
	$landline_number=$_REQUEST['landline_number'];
	$mobile_number=$_REQUEST['mobile_number'];
	$othere_number=$_REQUEST['othere_number'];
	$partners_number=$_REQUEST['partners_number'];
	$email=$_REQUEST['email'];
	$password=trim($_REQUEST['password']);
		
	$physical_address1=$_REQUEST['physical_address1'];
	$physical_address2=$_REQUEST['physical_address2'];
	$physical_suburb=$_REQUEST['physical_suburb'];
	$physical_city=$_REQUEST['physical_city'];
	$physical_state=$_REQUEST['physical_state'];
	$physical_post_code=$_REQUEST['physical_post_code'];
	
	$postal_address1=$_REQUEST['postal_address1'];
	$postal_address2=$_REQUEST['postal_address2'];
	$postal_suburb=$_REQUEST['postal_suburb'];
	$postal_city=$_REQUEST['postal_city'];
	$postal_state=$_REQUEST['postal_state'];
	$postal_post_code=$_REQUEST['postal_post_code'];	
		
	$SMS_notifications=(isset($_REQUEST['SMS_notifications']) && $_REQUEST['SMS_notifications']==1)?1:0;
	$email_notifications=(isset($_REQUEST['email_notifications']) && $_REQUEST['email_notifications']==1)?1:0;
	$mail_notifications=(isset($_REQUEST['mail_notifications']) && $_REQUEST['mail_notifications']==1)?1:0;
	
			
			
	if($db->already_exist_inset("customers","email",$email)){
		$_SESSION['client_msg']="Sorry, your specified email address is already taken!";					
	}else if(trim($mobile_number) != NULL && $objdappaDogs->already_exist_mobile("customers","mobile_number",$mobile_number)){
		$_SESSION['client_msg']="Sorry, your specified mobile number is already taken!";			
	}else{			
		$data['first_name']=$first_name;
		$data['last_name']=$last_name;
		$data['landline_number']=$landline_number;
		$data['mobile_number']=$mobile_number;
		$data['othere_number']=$othere_number;
		$data['partners_number']=$partners_number;
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
		$data['mail_notifications']=$mail_notifications;			
		
		
		$data['sent_email']=1;
						
		$data['created_ip']=$_SERVER['REMOTE_ADDR'];
		$data['created']='now()';		
			
		$db->query_insert("customers",$data);	
		
						
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
		
	if(!validate_text(document.ff.last_name,1,"Please enter last name"))
		return false;
		
	if(!allLetter(document.ff.last_name,"Last name must have alphabet characters only"))
		return false;
	
	//if(document.ff.email_notifications.checked == true){		
		if(!validate_email(document.ff.email,1,"Enter email address"))
			return false;		
	//}	
	if(document.ff.SMS_notifications.checked == true){		
		if(!validate_text(document.ff.mobile_number,1,"Please enter your xxxxxxxx mobile number"))
			return false;
		
		if(!exact_length(document.ff.mobile_number,8,"Please enter your xxxxxxxx mobile number"))
			return false;				
	}
		
	if(!validate_text(document.ff.password,1,"Please enter password"))
		return false;
		
	if(!passid_validation(document.ff.password,6,12,"Password must be of length between"))
		return false;			
					
		
}

function change(){
	if (document.ff.other_billing.checked == true){
		document.ff.postal_address1.value=document.ff.physical_address1.value
		document.ff.postal_address2.value=document.ff.physical_address2.value
		document.ff.postal_suburb.value=document.ff.physical_suburb.value
		document.ff.postal_city.value=document.ff.physical_city.value
		document.ff.postal_state.value=document.ff.physical_state.value
		document.ff.postal_post_code.value=document.ff.physical_post_code.value
	} else {
		document.ff.postal_address1.value="";
		document.ff.postal_address2.value="";
		document.ff.postal_suburb.value="";
		document.ff.postal_city.value="";
		document.ff.postal_state.value="";
		document.ff.postal_post_code.value="";		
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
    	<h1>Salon Finder</h1>
      	<div class="tabPnl">
       	  
          <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="customer" />
          <div class="tabPnlCont">
          	<div class="tabPnlContInr" style="background:url(images/regBg.png) no-repeat right bottom #fff;">
              <div class="slnSerch">
                <h3>Find your Salon</h3>
                <div class="slnSerchPnl" style="margin-top:15px;">
                	<select><option>Select Salon</option></select>
                    <h5>Services</h5>
                    <ul>
                    	<li><input name="" type="radio" value="" /><strong>Full Groom</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>Wash &amp; Blow Dry</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>Mini Groom</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>Nail Trim</strong><img alt="" src="images/i.png" /></li>
                    </ul>
                </div>
                <div class="slnSerchPnl">
                	<h5>Spa Treatments</h5>
                    <ul>
                    	<li><input name="" type="checkbox" value="" /><strong>Top Dog</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="checkbox" value="" /><strong>Kissable Dog</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="checkbox" value="" /><strong>Facial</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="checkbox" value="" /><strong>Calming Canine</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="checkbox" value="" /><strong>Citrus Sensation</strong><img alt="" src="images/i.png" /></li>
                    </ul>
                    <h5>Size of your pet</h5>
                    <ul class="xl">
                    	<li><input name="" type="radio" value="" /><strong>S</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>M</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>L</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>XL</strong><img alt="" src="images/i.png" /></li>
                    </ul>
                    <br class="clear">
                    <input name="" type="submit" value="" />
                </div>
              </div>
            
            
            
            
                <br class="clear">
            </div>
          </div>
          </form>
      	</div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>