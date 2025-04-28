<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

if($_SESSION['admin_access_level'] != 1 && ! in_array(15,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if($_SESSION['admin_access_level'] == 2 &&  !$objdappaDogs->his_own_salon($_SESSION['admin_user_id'],$_REQUEST['id'])){
	$_SESSION['msg']="Sorry, you do not have the permission to access this salon!";
	$general_func->header_redirect($general_func->admin_url."home.php");	
} 


$data=array();
$return_url=$_REQUEST['return_url'];

if(isset($_REQUEST['action']) && $_REQUEST['action']=="VIEW"){	
	$sql="select * from salons  where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	

	$salon_name=$result[0]['salon_name'];
	
	$email_address=$result[0]['email_address'];
	$landline_no=$result[0]['landline_no'];
	$mobile_no=$result[0]['mobile_no'];
	$address1=$result[0]['address1'];
	$address2=$result[0]['address2'];
	$city=$result[0]['city'];
	$state=$result[0]['state'];
	$zip=$result[0]['zip'];	
	$opening_time=$result[0]['opening_time'];
	$closing_time=$result[0]['closing_time'];
	
	
	//***************** login_info **********************//
	$sql_login_info="select admin_user,admin_pass  from admin  where user_id =" . (int) $_REQUEST['id'] . " and access_level=2  limit 1";
	$result_login_info=$db->fetch_all_array($sql_login_info);	
	
	$user_name=$result_login_info[0]['admin_user'];
	$password=$result_login_info[0]['admin_pass'];

	//************ working_days **********************//	
	$sql_working_day="select working_day from salon_working_days where salon_id='" . $_REQUEST['id'] . "' order by working_day + 0 ASC";
	$result_working_day=$db->fetch_all_array($sql_working_day);
	$total_working_day=count($result_working_day);
	
	
	$days="";
	
	for($day=0; $day<$total_working_day; $day++){
		$days .= $all_days_in_a_week[$result_working_day[$day]['working_day']].", ";
	}
	
	$days=substr($days,0,-2);
	
					
	
	
	//************ groomings **********************//	
	$sql_grooming="select name from salon_grooming s left join grooming g on s.grooming_id=g.id where salon_id='" . $_REQUEST['id'] . "' order by display_order + 0 ASC";
	$result_grooming=$db->fetch_all_array($sql_grooming);
	$total_grooming=count($result_grooming);
	
	$gromming_list="";
	
	for($grooming=0; $grooming<$total_grooming; $grooming++){
		$gromming_list .=$result_grooming[$grooming]['name'].", ";	
	}
	
	 $gromming_list=substr($gromming_list,0,-2);
	
}
?>


 <div class="breadcrumb">
      	<p><a href="settings/salons.php">Salons</a> &raquo; <?=$salon_name?> </p>
</div>


<ul class="tabBtn">
            	 
        			<?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
            	
            	<li class="activeTab"><a style="cursor: pointer;">View Salon</a></li>              
                
            </ul>
        
        
  <div class="tabPnlCont">
<div class="tabPnlContInr">      
<div class="tabcontArea" style="background:none">

    <h3>General Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    	<li>Salon Name <br><b><?=$salon_name?>&nbsp;</b></li>
       	<li>Email<br><b><?=$email_address?>&nbsp;</b></li>
        <li>Landline Number <br><b><?=$landline_no?>&nbsp;</b></li>
       	<li>Mobile Number <br><b><?=$mobile_no?>&nbsp;</b></li>
        <li>Address line 1 <br><b><?=$address1?>&nbsp;</b></li>
        <li>Address line 2 <br><b><?=$address2?>&nbsp;</b></li>
        <li>City <br><b><?=$city?>&nbsp;</b></li>
        <li>State<br><b><?=$state?>&nbsp;</b></li>
        <li>Post Code<br><b><?=$zip?>&nbsp;</b></li>
        <li>Opening Time (24 hours)<br><b>
         <?php 	$hour_min="";	
				$hours = $opening_time / 60;
    			$min = $opening_time % 60;	
					
				$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
				$disp_min=strlen($min)==1?'0'.$min:$min;							
				echo $hour_min=$disp_hour ." : " . $disp_min;								
        ?>
         </b>
        </li>        
        <li>Closing Time (24 hours)<br>
             	<b><?php  
				$hour_min="";	
				$hours = $closing_time / 60;
    			$min = $closing_time % 60;	
					
				$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
				$disp_min=strlen($min)==1?'0'.$min:$min;							
				echo $hour_min=$disp_hour ." : " . $disp_min;								
        		?>								
          </li> 
                   <li style="width: 100%">Available Grooming<br><b>
                   	<?=$gromming_list?></b>
                 </li>      
                   <li>Working Days<br>  <b>           	
                    <?=$days?>&nbsp;					
					</b>
                    </li>                   
    </ul>
    </div>
    </div>
    <h3>Login  Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    <li>Username<br><b><?=$user_name?>&nbsp;</b></li>
     <li>Password<br><b>**********&nbsp;</b></li>            
    
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
<?php
include("../foot.htm");
?>