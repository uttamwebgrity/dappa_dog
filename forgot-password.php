<?php include_once("includes/header.php"); 

if(isset($_SESSION['client_login']) && trim($_SESSION['client_login']) =="yes"){
	$general_func->header_redirect($general_func->site_url."my-apointment.php");
}




if(isset($_POST['enter']) && $_POST['enter']=="forgotpassword"){
	$data=array();
	$sql="select CONCAT(first_name,' ',last_name) as name,email,password from customers where email='".trim($_POST['email'])."' limit 1";
	$result=$db->fetch_all_array($sql);
	
	if((int)count($result) == 1){
			
		$sql_email_template="select template_subject,template_content from email_template where id=9 limit 1";
		$result_email_template = $db -> fetch_all_array($sql_email_template);
			
		if(count($result_email_template) == 1){
			$message_content=$result_email_template[0]['template_content'];	
					
			$message_content=str_replace("#dog_owner_name#",$result[0]['name'],$message_content);
			$message_content=str_replace("#email_address# ",$result[0]['email'],$message_content);
			$message_content=str_replace("#password#",$result[0]['password'],$message_content);	
			
			$message_content=str_replace("#customer_login_link#",$general_func->site_url."login.php",$message_content);	
			$message_content=str_replace("#contact_link#",$general_func->site_url."contact.php",$message_content);	
									
			$receiver_info = array();
			$receiver_info['subject'] = $result_email_template[0]['template_subject'];	
			$receiver_info['content'] = $message_content;
			$receiver_info['email'] = $email;		
				
		
			$sendmail->logininfo_to_user($receiver_info,$general_func->admin_email_id,$general_func->site_title,$general_func->site_url);
		}
			
		$_SESSION['client_success_msg']="Your password has been sent to your specified email address!";
		$general_func->header_redirect($general_func->site_url."login.php");
	}else{
		$_SESSION['client_msg']="Sorry, E-Mail Address was not found in our records, please try again!";
	}
}

?>
<script language="javascript">
function forgotpassword_validate(){

	if(!validate_email(document.frmforgotpassword.email,1,"Enter email address"))
		return false;
		
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
    	<h1>Forgot Password? </h1>
      	<div class="tabPnl">
       	  <div class="tabPnlLft">
          	<ul>
            	<li class="logIcon"><a href="login.php" class="logCurrent">Login</a></li>
                <li class="regIcon"><a href="register.php">Register</a></li>
            </ul>
          </div>
          <form name="frmforgotpassword" action="forgot-password.php" method="post" onSubmit="return forgotpassword_validate();">
          <input type="hidden" name="enter" value="forgotpassword" />
          <div class="tabPnlCont">
          	<div class="tabPnlContInr">
       	  <ul class="loginForm">
                	<li><span>Email Id :</span> <input name="email" value="<?=$_REQUEST['email']?>"  type="text" class="loginFild" /></li>
                    <li><span class="onOff">&nbsp;</span> <input type="submit" class="submitBtn" value="" name=""></li>
                </ul>
                <br class="clear">
            </div>
          </div>
          </form>
      	</div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>