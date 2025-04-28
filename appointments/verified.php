<?php
include_once("../includes/configuration.php");
$remember_me=(isset($_POST["remember_me"]) && (int)$_POST["remember_me"] == 1)?1:0;
 

$_SESSION['access_permission']=array();

if(isset($_POST['enter']) && (int)$_POST['enter']==1){  
	$sql="select * from admin where admin_user='". $_POST['username'] ."' and admin_pass='" . $_POST['pawd'] . "'  limit 1";
	$result=$db->fetch_all_array($sql);
		
	if(count($result)==1){
		$_SESSION['email_address']=$result[0]['email_address'];
		$_SESSION['admin_id']=$result[0]['admin_id'];
		$_SESSION['admin_name']=$result[0]['fname'] ." ".$result[0]['lname'];
		$_SESSION['admin_user']=$result[0]['admin_user'];		
		$_SESSION['admin_access_level']=$result[0]['access_level'];//******  1-super admin/2-salon admin/3-staff 
		$_SESSION['admin_user_id']=$result[0]['user_id'];		
		
		$_SESSION['admin_login']="yes";		
		
		if((int)$remember_me == 1){
	  		setcookie("cookie_username",$_POST['username']); 
			setcookie("cookie_password",$_POST['pawd']);
			setcookie("cookie_access_level",$_POST['access_level']);
	 	}else{
			setcookie("cookie_username",$_POST['username'],time()-3600);
			setcookie("cookie_password",$_POST['pawd'],time()-3600);
			setcookie("cookie_access_level",$_POST['access_level'],time()-3600);
		}
		
		//**********Save admin login history **********************//
		$data=array();
		$data['login_date_time']='now()';
		$data['login_ip']=$_SERVER['REMOTE_ADDR'];	
		$data['user_id']=$result[0]['user_id'];
		$data['access_level']=$result[0]['access_level'];		
		$_SESSION['login_hostory_id']=$db->query_insert("admin_login_hostory",$data);	
		
				
		//********************* access_permission ************************************//
		 if(intval($_SESSION['admin_access_level']) == 2){//**** salon admin
		 	$result_access_matrix=$db->fetch_all_array("select id from access_matrix where salon_admin_access=1");
		 	$total_access_matrix=count($result_access_matrix);
		 	for($access=0; $access < $total_access_matrix; $access++ ){
		 		$_SESSION['access_permission'][]=$result_access_matrix[$access]['id'];				
		 	}		 
		}else if(intval($_SESSION['admin_access_level']) == 3){//**** staff
			$result_access_matrix=$db->fetch_all_array("select id from access_matrix where staff_access=1");
		 	$total_access_matrix=count($result_access_matrix);
		 	for($access=0; $access < $total_access_matrix; $access++ ){
		 		$_SESSION['access_permission'][]=$result_access_matrix[$access]['id'];				
		 	}	
		}
		
		//*********** where a person will go after login *******************//
		if(isset($_SESSION['redirect_to']) && trim($_SESSION['redirect_to'])!=NULL){
			$path=$_SESSION['redirect_to']."?".$_SESSION['redirect_to_query_string'];
			$general_func->header_redirect($path);		
		}else
			$general_func->header_redirect("home.php");
		
	}else{
		$_SESSION['message']="Error: Your username and/or password was incorrect!<br/>Check your username and password and try again!";
		$general_func->header_redirect("index.php");
	}
}else{
	echo "Hacking Attempt !";
	exit();

}
?>