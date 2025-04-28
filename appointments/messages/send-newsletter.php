<?php
include_once("../../includes/configuration.php");


if($_SESSION['admin_access_level'] != 1 && ! in_array(7,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}

$cms_images=$general_func->site_url."cms_images/";


if(isset($_REQUEST['enter']) && $_REQUEST['enter']==2){
	
	$subject=trim($_REQUEST['subject']);
	$message=trim($_REQUEST['message']); 

	
	//******************  keep record ****************************************************//
	$data=array();
	$data['send_to']=intval($_REQUEST['send_to']);
	$data['subject']=$subject;
	$data['message']=$message;
	$data['send_date']='now()';
	$id=$db->query_insert("newsletters",$data);
	
	
	if($data['send_to'] == 1){//*************** Customers
		$sql="select DISTINCT(email) as subscriber_email from customers where mail_notifications=1 and email IS NOT NULL";		
	}else if($data['send_to'] == 2){//********* Staff
		$sql="select DISTINCT(email_address) as subscriber_email from salons where email_address IS NOT NULL";
	}else if($data['send_to'] == 3){//********* Salon Admin
		$sql="select DISTINCT(email_address) as subscriber_email from staffs where email_address IS NOT NULL";
	}else{//*********************************** All
		$sql="select DISTINCT(email) as subscriber_email from customers where mail_notifications=1 and email IS NOT NULL UNION ";
		$sql .="select DISTINCT(email_address) as subscriber_email from salons where email_address IS NOT NULL UNION ";
		$sql .="select DISTINCT(email_address) as subscriber_email from staffs where email_address IS NOT NULL";
	}	
	
	$result=$db->fetch_all_array($sql);
		
	
	$send_to_emails="";	
	$total_subscribers=count($result);
		
	for($i=0; $i<$total_subscribers; $i++){
	
		$newsletter_email_content= '		
			<table width="620" border="0" cellspacing="0" cellpadding="0" style="padding:0;margin:0">
				<tr>
				<td style="padding:5px;margin:0;height:auto;background:#f58220;"><img src="'.$general_func->site_url.'newsletterImg/logo.png" alt="" style="float:left; width:130px" />
				</td>
				</tr>
				<tr>
				<td background="'.$general_func->site_url.'newsletterImg/dogBanner.jpg" style="padding:20px;margin:0;font:normal 13px/18px Arial,Helvetica,sans-serif;color:#000; background-repeat:no-repeat; background-position:bottom;">';											
				
												
		$newsletter_email_content .= str_replace("/cms_images/",$cms_images,$message);
	
		$newsletter_email_content .= '
				</td>
			</tr>
			<tr>
			<td style="padding:10px;margin:0;height:auto;background:#f58220; ">
			<p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#fff;">&copy; Copyright 2013 Dappadogs.co.nz All Rights Reserved</p></td>
			</tr>
			</table>';
	
	
	
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ".$general_func->site_title." <".$general_func->admin_url.">\r\n";
		
		@mail($result[$i]['subscriber_email'],$subject,stripslashes($newsletter_email_content),$headers);
		
			
		$send_to_emails .= $result[$i]['subscriber_email'] ."_~_";
	}
	
			
	$data=array();
	$data['send_to_emails']=$send_to_emails;
	$db->query_update("newsletters",$data,"id='".$id ."'");
	
	
	$_SESSION['msg']="Newsletter email has been successfully sent.";
	$general_func->header_redirect($general_func->admin_url ."messages/newsletter.php");
} 
?>
