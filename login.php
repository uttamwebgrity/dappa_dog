<?php
include_once("includes/header.php"); 


if(isset($_COOKIE['co_user_id']) && isset($_COOKIE['co_user_password']) && isset($_COOKIE['co_user_email'])){
	$email=$_COOKIE['co_user_email'];
	$password=$_COOKIE['co_user_password'];
	$remember=1;
}else{
	$email=$_COOKIE['co_user_email'];
	$password=$_COOKIE['co_user_password'];
	$remember=0;
}


if(isset($_POST['enter']) && $_POST['enter']=="login"){
	$email=$_POST['email'];
	$password=$_POST['password'];
	
	$sql_client="select * from customers where email='". $_REQUEST['email'] ."' and password='". $_REQUEST['password'] ."'  limit 1";	
	$result_client=$db->fetch_all_array($sql_client);
	if((int)count($result_client) == 1){
		$time=time() + (86400*365);
		$_SESSION['client']=array();
		
		$_SESSION['client']['id']=$result_client[0]['id'];		
		$_SESSION['client']['first_name']=$result_client[0]['first_name'];
		$_SESSION['client']['last_name']=$result_client[0]['last_name'];
		$_SESSION['client']['mobile_number']=$result_client[0]['mobile_number'];
		$_SESSION['client']['email']=$result_client[0]['email'];
		$_SESSION['client']['SMS_notifications']=$result_client[0]['SMS_notifications'];
		$_SESSION['client']['sent_email']=$result_client[0]['sent_email'];
		$_SESSION['client']['email_notifications']=$result_client[0]['email_notifications'];
		$_SESSION['client']['mail_notifications']=$result_client[0]['mail_notifications'];		
		$_SESSION['client_login']="yes";		
		
		
		//************************** Remember me **********************************//
		if( isset($_POST['remember']) && $_POST['remember']==1){
			setcookie("co_user_id","");
			setcookie("co_user_password","");
			setcookie("co_user_email","");
			setcookie("co_logged_in","");
			
			setcookie("co_user_id",$_SESSION['client']['id'],$time);
			setcookie("co_user_password",$_REQUEST['password'],$time);
			setcookie("co_user_email",$_REQUEST['email'],$time);
			setcookie("co_logged_in",$_SESSION['logged_in'],$time);
		}else{
			setcookie("co_user_id","");
			setcookie("co_user_password","");
			setcookie("co_user_email","");
			setcookie("co_logged_in","");
		}
	
		//**********************************************************************//		
		
		
		
		
		if(isset($_SESSION['client_redirect_to_page']) && trim($_SESSION['client_redirect_to_page']) != NULL)
			$general_func->header_redirect($_SESSION['client_redirect_to_page']);
		else 
			$general_func->header_redirect($general_func->site_url."my-apointment.php");
		
	}else{
		$_SESSION['client_msg']="Access denied. Incorrect Email address and/or Password!";	
	}
}





?>
<script language="javascript">
function login_validate(){ 
	if(!validate_email(document.frmlogin.email,1,"Please enter your email address"))
		return false;	
	if(!validate_text(document.frmlogin.password,1,"Please enter your password"))
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
    	<h1>Log In</h1>
      	<div class="tabPnl">
       	  <div class="tabPnlLft">
          	<ul>
            	<li class="logIcon"><a href="login.php" class="logCurrent">Login</a></li>
                <li class="regIcon"><a href="register.php">Register</a></li>
            </ul>
          </div>
          <div class="tabPnlCont">
          	<div class="tabPnlContInr">
       	  <ul class="loginForm">
                	 <form name="frmlogin" action="login.php" method="post"  autocomplete="off" onsubmit="return login_validate();">
                          <input type="hidden" name="enter" value="login" />
                	<li><span>Email :</span> <input  name="email" value="<?=$email?>" type="text"  class="loginFild" /></li>
                    <li><span>Password :</span> <input type="password"  name="password"  value="<?=$password?>" class="loginFild" /><br/>
                    	
                    </li>
                    <li><span class="onOff">&nbsp;</span>  <input type="checkbox"  name="remember" value="1"  <?=$remember==1?'checked':'';?>/> Store my User ID on this computer</li>
                  <li><span class="onOff">&nbsp;</span> <input name="" type="submit" value="" class="loginBtn" /></li>
                </form>
                </ul>
                <p class="forgtLink"><a href="forgot-password.php">Forgot your Password ?</a> | <a href="register.php">Register Now!</a></p>
                <br class="clear">
            </div>
          </div>
      	</div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>