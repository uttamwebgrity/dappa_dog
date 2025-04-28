<?php
include_once("../../includes/configuration.php");

if(!isset($_SESSION['admin_login']) || $_SESSION['admin_login']!="yes"){
	$_SESSION['redirect_to']=substr($_SERVER['PHP_SELF'],strpos($_SERVER['PHP_SELF'],"administrator/") + 14);
   	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
	
    $_SESSION['message']="Please login to view this page!";
	$general_func->header_redirect("../index.php");
}



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
	
	
	//if($data['send_to'] == 2)
	$sql="select DISTINCT(email_address) as subscriber_email from subscribers where unsubscribe=0";
	$result=$db->fetch_all_array($sql);
	
		
	
	$send_to_emails="";	
	$total_subscribers=count($result);
		
	for($i=0; $i<$total_subscribers; $i++){
	
		$newsletter_email_content= '<table width="620" border="0" cellspacing="0" cellpadding="0" style="padding:0;margin:0">
		<tr>
		<td style="padding:0 0 10px;margin:0;height:120px;background:#dcdcdc"><div style="float:left;width:110px;height:103px;margin:8px 20px 0 20px;padding:0;background:#2c2c2d"><img src="http://sandisfieldartscenter.org/cms_images/logo.jpg" width="72" height="84" alt="" style="margin-left:auto;margin-right:auto;display:block;margin-top:10px" /></div>
		<h1 style="font:italic 25px/30px Georgia,\'Times New Roman\',Times,serif;color:#736f6f;text-shadow:#fff 2px 2px 2px;padding:0;margin:22px 0">To succeed in life, you need two things:<br />
		ignorance and confidence.</h1></td>
		</tr>
		<tr>
		<td style="padding:20px;margin:0;background:#fff;font:normal 13px/18px Arial,Helvetica,sans-serif;color:#736f6f">';											
									
	$newsletter_email_content .= str_replace("/cms_images/","http://sandisfieldartscenter.org/cms_images/",$message);
	
	$newsletter_email_content .= '<div style="float:left;width:100%;padding:100px 0 0 0">
									If you do not like to receive this newsletter again in future, please click here to <a href="' . $general_func->site_url .'/unsubscribe.php?email_address=' . $result[$i]['subscriber_email'] . '" style="color:#b85d04;text-decoration:none">Unsubscribe</a>
								</div>	
								</td>
								</tr>
								<tr>
								<td style="padding:25px 25px 15px;margin:0;background:#dcdcdc;height:180px"><div style="float:left;width:280px;padding:5px 0 0 0">
								<h3 style="font:bold 20px/26px Arial,Helvetica,sans-serif;color:#6d6b6b;padding:0 0 0 0px;margin:0;"><img src="http://sandisfieldartscenter.org/cms_images/footerIcon.jpg" /> Sandisfield Arts Center</h3>
								<ul style="padding:0;margin:0">
								<li style="list-style:none;color:#6d6b6b;font:normal 13px/18px Arial,Helvetica,sans-serif"><strong style="float:left;width:70px;padding-bottom:10px">Address:</strong> <span style="float:left;width:190px;padding-bottom:10px">5 Hammertown Road,<br>
								P.O. Box 31<br>
								Sandisfield, MA 01255</span></li>
								<li style="list-style:none;color:#6d6b6b;font:normal 13px/18px Arial,Helvetica,sans-serif"><strong style="float:left;width:70px;padding-bottom:10px">Phone #:</strong> <span style="float:left;width:190px;padding-bottom:10px">413-258-4100</span></li>
								<li style="list-style:none;color:#6d6b6b;font:normal 13px/18px Arial,Helvetica,sans-serif"><strong style="float:left;width:70px;padding-bottom:10px">Email Us:</strong> <span style="float:left;width:190px;padding-bottom:10px">info@Sandisfieldartscenter.org</span></li>
								</ul>
								</div>
								<div style="float:right;width:275px;padding:0;margin:0"> <img src="http://sandisfieldartscenter.org/cms_images/footerPic.jpg" alt="" style="padding:36px 0 0 0;margin:0;float:right" />
								<p style="color:#6d6b6b;text-align:right;font:normal 12px/20px Arial,Helvetica,sans-serif;clear:both;padding:10px 0 0 0;margin:0">© 2013 Sandisfield Arts Center. All rights reserved. </p>
								</div></td>
								</tr>
								</table>
								';
	
	
	
		
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
	$general_func->header_redirect($general_func->admin_url ."newsletter/newsletter.php");
} 
?>
