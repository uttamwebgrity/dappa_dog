<?php 
include_once("../includes/configuration.php");

if(isset($_COOKIE['cookie_username']) && isset($_COOKIE['cookie_password'])){
	$username=$_COOKIE['cookie_username'];
	$password=$_COOKIE['cookie_password'];
	//$access_level=$_COOKIE['cookie_access_level'];
	$remember_me=1;
}else{
	$username="";
	$password="";
	//$access_level=$_COOKIE['cookie_access_level'];
	$remember_me=0;	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$general_func->site_title?> :: Secure Area</title>
<style type="text/css">
*{ padding:0; margin:0; list-style:none; text-decoration:none; outline:none; border:none; }
body{ background:url(images/loginBodyBg.png) repeat 0 0; font:normal 12px/18px Arial, Helvetica, sans-serif; }
.row{ float:left; width:100%; padding:80px 0 0; }
.mainLoginPnl{ margin:0 auto; width:400px; }
.loginPnl{ float:left; width:400px; min-height:325px; background:#fff; border-radius:15px; box-shadow:0 1px 4px rgba(0, 0, 0, 0.7); }
.loginPnlTop{ padding:13px 20px 0; }
.headerPnl{ float:left; width:100%; border-bottom:1px solid #f58220; padding-bottom:9px; }
.headerPnl img.logo{ float:left; width:96px; }
.errorMsg{ float:left; width:100%; font:bold 11px/15px Tahoma, Geneva, sans-serif; color:#d93805; text-align:center; padding:10px 0; }
.formArea{ margin:0 auto; width:313px; }
.formAreaInr{ float:left; width:313px; }
/* border-bottom:1px solid #f58220;*/
.formAreaInr ul{ width:100%; float:left; margin:0; padding:0 0 20px;  }
.formAreaInr ul li{ list-style:none; float:left; width:100%; font:normal 13px/33px Arial, Helvetica, sans-serif; color:#86888a; }
.formAreaInr ul li span{ float:left; width:120px; font:bold 13px/33px Arial, Helvetica, sans-serif; color:#717172; padding:0 0 9px;}
.formAreaInr ul li input[type="text"]{ color:#87888a; border:1px solid #c7c9c9; border-radius:5px; width:169px; height:27px; padding:2px 10px; line-height:27px; }
.formAreaInr ul li input[type="checkbox"]{ margin:10px 5px 0 0; float:left; }
.formAreaInr ul li input[type="password"]{ color:#87888a; border:1px solid #c7c9c9; border-radius:5px; width:169px; height:27px; padding:2px 10px; line-height:27px; }
.formAreaInr ul li select{ color:#87888a; border:1px solid #c7c9c9; border-radius:5px; width:190px; height:31px; padding:2px; }

input.logSubmit{ float:right; background:url(images/loginBtn.png) no-repeat 0 0; width:88px; height:33px; font-size:0; border:none; display:block; text-indent:-9999px; margin:15px 0 0; cursor:pointer; }
input.logCancel{ float:right; background:url(images/cancelBtn.png) no-repeat 0 0; width:86px; height:33px; font-size:0; border:none; display:block; text-indent:-9999px; margin:15px 0 0 15px; cursor:pointer; }
.formAreaInr p{ font:normal 12px/25px Arial, Helvetica, sans-serif; color:#f4811f; }
.formAreaInr p a{ color:#f4811f; text-decoration:none; }

@media screen and (max-width: 479px) {
.mainLoginPnl{ margin:0 1%; width:98%; }
.loginPnl{ float:left; width:100%; min-height:325px; background:#fff; border-radius:15px; box-shadow:0 1px 4px rgba(0, 0, 0, 0.7); }
.loginPnl img.sareaBg{ width:100%; }

}


</style>
<script language="javascript" src="../includes/validator.js"></script>
<script language="javascript">
function validate(){
	if(!validate_text(document.frmlogin.username,1,"Enter Username")){
		document.frmlogin.username.value="";
        document.frmlogin.username.focus();
		return false;
	}	
	if(!validate_text(document.frmlogin.pawd,1,"Enter Password")){
		document.frmlogin.pawd.value="";
        document.frmlogin.pawd.focus();
		return false;
	}
	
/*	if(document.frmlogin.access_level.selectedIndex == 0){
		alert("Please choose an access level");
		document.frmlogin.access_level.focus();
		return false;
	}*/			
}
</script>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
</head>
<body>
<div class="row">
  <div class="mainLoginPnl">
    <div class="loginPnl">
      <div class="loginPnlTop">
        <div class="headerPnl"><img src="../images/logo.png" class="logo" alt="" /></div>
       <div class="errorMsg"><?=$_SESSION['message'];  $_SESSION['message']="";	?></div>     
        </div>  
      <div class="row" style="padding:0;">
      	<div class="formArea">
        	<div class="formAreaInr">
        		<form action="verified.php" method="post" name="frmlogin" onsubmit="return validate();">
              <input type="hidden" name="enter" value="1" />
            	<ul>
                	<li><span>Username:</span> <input name="username" type="text" value="<?=$username?>" /></li>
                    <li><span>Password:</span> <input name="pawd" type="password" value="<?=$password?>" /></li>
                    <!--<li><span>Access Level:</span> <select name="access_level">
                    	<option> Select One </option>
                    	<option value="1" <?=$access_level==1?'selected="selected"':'';?>>Super Admin</option>
                    	<option value="2" <?=$access_level==2?'selected="selected"':'';?>>Salon Admin</option>
                    	<option value="3" <?=$access_level==3?'selected="selected"':'';?>>Staff</option>                
                    </select></li>-->
                    <li><label><input type="checkbox" name="remember_me" value="1" <?=$remember_me == 1?'checked':'';?>> Store my Username on this computer</label></li>
                    <li><input name="logCancel" type="reset" class="logCancel" /><input name="logSubmit" type="submit" class="logSubmit" /></li>
                </ul>
                </form>
                <!-- <p><a href="#url">Forgot your Password ?</a></p>-->
            </div>
        </div>
      </div>
    <img src="images/sareaBg.png" alt="" class="sareaBg" /></div>
  </div>
</div>
</body>
</html>





