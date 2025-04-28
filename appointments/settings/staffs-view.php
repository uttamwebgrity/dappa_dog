<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

if((int)$_SESSION['admin_access_level'] == 3){		
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if($_SESSION['admin_access_level'] == 2 &&  !$objdappaDogs->his_own_salon_staff($_SESSION['admin_user_id'],$_REQUEST['id'])){
	$_SESSION['msg']="Sorry, you do not have the permission to access this staff!";
	$general_func->header_redirect($general_func->admin_url."home.php");	
} 


$data=array();
$return_url=$_REQUEST['return_url'];

if(isset($_REQUEST['action']) && $_REQUEST['action']=="VIEW"){	
	$sql="select * from staffs  where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	

	$staff_name=$result[0]['staff_name'];	
	$email_address=$result[0]['email_address'];
	$landline_no=$result[0]['landline_no'];
	$mobile_no=$result[0]['mobile_no'];
	$address1=$result[0]['address1'];
	$address2=$result[0]['address2'];
	$city=$result[0]['city'];
	$state=$result[0]['state'];
	$zip=$result[0]['zip'];	
	$job_title=$result[0]['job_title'];
	$bio=$result[0]['bio'];
	
	
	//***************** login_info **********************//
	$sql_login_info="select admin_user,admin_pass  from admin  where user_id =" . (int) $_REQUEST['id'] . " and access_level=3  limit 1";
	$result_login_info=$db->fetch_all_array($sql_login_info);	
	
	$user_name=$result_login_info[0]['admin_user'];
	$password=$result_login_info[0]['admin_pass'];

	//************ salon **********************//	
	
	$sql_salon="select salon_name from staff_salon left join salons on staff_salon.salon_id=salons.id where staff_id='" . $_REQUEST['id'] . "'";
	$result_salon=$db->fetch_all_array($sql_salon);
	$total_salon=count($result_salon);
	
	$salons="";
	
	for($salon=0; $salon<$total_salon; $salon++){
		$salons .=$result_salon[$salon]['salon_name'].", ";	
	}
	$salons=substr($salons,0,-2);	
	
	
			
					
	
	
}
?>


 <div class="breadcrumb">
      	<p><a href="settings/staffs.php">Staffs</a> &raquo; <?=$staff_name?> </p>
</div>


<ul class="tabBtn">
            	 
        			<?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
            	
            	<li class="activeTab"><a style="cursor: pointer;">View Staff</a></li>              
                
            </ul>
        
        
<div class="tabPnlCont">
<div class="tabPnlContInr">        
<div class="tabcontArea" style="background:none">

    <h3>General Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    	<li>Staff Name <br><b><?=$staff_name?></b></li>
       	<li>Email<br><b><?=$email_address?></b></li>
        <li>Landline Number <br><b><?=$landline_no?></b></li>
       	<li>Mobile Number <br><b><?=$mobile_no?></b></li>
        <li>Address line 1 <br><b><?=$address1?></b></li>
        <li>Address line 2 <br><b><?=$address2?></b></li>
        <li>City <br><b><?=$city?></b></li>
        <li>State<br><b><?=$state?></b></li>
        <li>Post Code<br><b><?=$zip?></b></li>
        <li>Attached Salons<br><b>
         <?php 	echo $salons ?>
         </b>
        </li>        
           
    </ul>
    </div>
    </div>
    <h3>Bio  Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    <li>Job Title<br><b><?=$job_title?></b></li>
     <li>Bio<br><b><?=$bio?></b></li>            
    
    </ul>
    </div>
    </div>
    
    <h3>Login  Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    <li>Username<br><b><?=$user_name?></b></li>
     <li>Password<br><b>**********</b></li>            
    
    </ul>
    </div>
    </div>
  
  
  
    <div class="submitSection">            	
    <input name="back" type="button" value="Back" onclick="location.href='<?=$return_url?>'" class="backBtn" />

</div>
</div>
<br class="clear" />
</div>
</div>


          </form>
           
            
<?php
include("../foot.htm");
?>