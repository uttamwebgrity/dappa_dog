<?php
class send_mail{
	
    //****************  mail header ****************************************//
	function mail_header($site_title,$site_url){
		$header='<table width="620" border="0" cellspacing="0" cellpadding="0" style="padding:0;margin:0">
					<tr>
						<td style="padding:5px;margin:0;height:auto;background:#f58220;"><img src="newsletterImg/logo.png" alt="" style="float:left; width:130px" /></td>
					</tr>
					<tr>
					<td background="newsletterImg/dogBanner.jpg" style="padding:20px;margin:0;font:normal 13px/18px Arial,Helvetica,sans-serif;color:#000; background-repeat:no-repeat; background-position:bottom;">';
		return ($header);
	}
	
	//********************* mail footer *************************************//
	function mail_footer($site_title,$site_url){
		$footer='<div style="float:left;width:100%;padding:70px 0 0 0;">
					<p style="text-align:center; font-size:11px;">
						This is a computer generated automated email, which does not require any signature further.<br />Please do not reply back to this email.<br /><br /></p></div></td>
					</tr>
					<tr>
						<td style="padding:10px;margin:0;height:auto;background:#f58220; ">
							<p style="font:normal 12px/18px Arial, Helvetica, sans-serif; color:#fff;">&copy; Copyright 2013 Dappadogs.co.nz All Rights Reserved</p></td>
					</tr>
			</table>';
		return ($footer);
	}
	
	public function make_link($url,$text=''){
		return "<a href=\"".$url."\" >".($text==''?$url:$text)."</a>";
	}

	public function get_ip() {
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	
		}
		elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip  = $_SERVER['HTTP_CLIENT_IP'];
		
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		
		}
		return $ip; 
	}
	
	
	
	
	public function hunt_booking_emails($receiver_info,$admin_email_id,$site_title,$site_url){
	
		$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Booking at huntersandguidesconnection.com</title>
					<style type="text/css">
					body {
						padding:0;
						margin:0;
						background-color:#fbe7b4;
					}
					.textstyle {
						padding:0px;
						margin:0px;
						font:normal 13px/19px Georgia, "Times New Roman", Times, serif;
						color:#604508;
					}
					.textstyle_another {
						font:normal 13px/22px Georgia, "Times New Roman", Times, serif;
						color:#604508;
					}
					.heading {
						color:#c89c33;
						font:normal 17px/22px Georgia, "Times New Roman", Times, serif;
					}
					.textstyle_heading {
						font:bold 15px/18px Arial, Helvetica, sans-serif;
						color:#852703;
						padding: 20px 0 5px 0;
						border-bottom:1px solid #d4be87;
					}
					.textstyle_display {
						font:normal 13px/16px Georgia, "Times New Roman", Times, serif;
						color:#604508;
					}
					.bold {
						font-weight:bold;
					}
					.georgia_nornmal {
						font-family: Georgia, "Times New Roman", Times, serif;
						font-weight:normal;
						color:#604508;
					 margin-top 20px;
					}
					.info_heading {
						font:bold 13px/14px Arial, Helvetica, sans-serif;
						color:#852703;
					}
					.textstyle_display td {
						padding: 7px 0px 7px 0px;
					}
					</style>
					</head>
					<body>
					<table width="100%" border="0" align="center">
					  <tr>
						<td align="center"><img src="'.$site_url.'images/email-header.jpg" alt="" /></td>
					  </tr>
					  <tr>
						<td align="center" height="20"></td>
					  </tr>
					</table>';
		$message .=$receiver_info['email_content'];
		
		$message .='<table width="100%" border="0" align="center">
				  <tr>
					<td align="center"><img src="'.$site_url.'images/email-footer.jpg" alt="" /></td>
				  </tr>
				</table>
				</body>
				</html>';
	
	
	
		//***************  email to member **************************//
		$subject=$site_title . " :: HAGC Hunt Reservation and Deposit Confirmation";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		@mail($receiver_info['member_email'],$subject,$message,$headers);
		
		//******************************************************************//
		
		
		//***************  email to outfitter and admin **************************//
		$subject=$site_title . " :: HAGC Hunt Reservation and Deposit Confirmation";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		@mail($receiver_info['outfitter_email'],$subject,$message,$headers);
		@mail($admin_email_id,$subject,$message,$headers);
		
		//******************************************************************//
	
	}	
	
	
	public function member_contact_with_texidermist($receiver_info,$admin_email_id,$site_title,$site_url){
		$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>' . $site_url .' </title>
					<style type="text/css">
					body {
						padding:0;
						margin:0;
						background-color:#fbe7b4;
					}
					.textstyle {
						padding:0px;
						margin:0px;
						font-family: Georgia, "Times New Roman", Times, serif;
						font-size: 13px;
						line-height: 22px;
						font-weight:normal;						
						color:#604508;
					}
					
					.bold {
						font-weight:bold;
					}
					.textstyle ul{
						padding:0;
						margin:0;
					}
					.textstyle ul li{
						list-style-type: disc;
						margin: 0 10px 0 35px;
						padding: 0 0 0 0px;				
						
					}	
					</style>
					</head>
					<body>
					<table width="798" border="0" align="center">
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-header2.jpg" alt="" /></td>
					  </tr>
					  <tr>
						<td align="center" height="20"></td>
					  </tr>
					</table>';
					
					
					
		$message .='<table width="785"  border="0" align="center">												
						<tr>
							<td colspan="2" align="left" class="textstyle bold">Taxidermist Contact Information</td>
						</tr>
						<tr>
							<td colspan="2" align="left" height="7px;"></td>
						</tr>
						<tr>
							<td align="left" class="textstyle" width="80">Name:</td>
							<td align="left" class="textstyle" width="705">' . $receiver_info['taxi_name'] . '</td>							
						</tr>
						<tr>
							<td align="left" class="textstyle"  width="80"  valign="top">Address:</td>
							<td align="left" class="textstyle" width="705"  valign="top">' . $receiver_info['taxi_address'] . '<br/>' . $receiver_info['taxi_area'] . '</td>							  
						</tr>
						<tr>
							<td align="left" class="textstyle"  width="80">Phone No.:</td>
							<td align="left" class="textstyle" width="705">' . $receiver_info['taxi_phone'] . '</td>							 
						</tr>
						<tr>
							<td align="left" class="textstyle"  width="80">Email:</td>
							<td align="left" class="textstyle" width="705">' . $receiver_info['taxi_email'] . '</td>							
						</tr>
						<tr>
							<td colspan="2" align="left" height="25px;"></td>
						</tr>
						<tr>
							<td colspan="2" align="left" class="textstyle bold">Member Contact Information</td>
						</tr>
						<tr>
							<td colspan="2" align="left" height="7px;"></td>
						</tr>
						<tr>
							<td align="left" class="textstyle"  width="80">Name:</td>
							<td align="left" class="textstyle" width="705">' . $receiver_info['mem_name'] . '</td>							
						</tr>
						<tr>
							<td align="left" class="textstyle"  width="80" valign="top">Address:</td>
							<td align="left" class="textstyle" width="705"  valign="top">' . $receiver_info['mem_address'] . '<br/>
							' . $receiver_info['mem_city'] . ', 
							' . $receiver_info['mem_state'] . ', 
							' . $receiver_info['mem_zip'] . '<br>
							' . $receiver_info['mem_country'] . '</td>							
						</tr>
						<tr>
							<td align="left" class="textstyle"  width="80">Phone No.:</td>
							<td align="left" class="textstyle" width="705">' . $receiver_info['mem_phone'] . '</td>							
						</tr>						
						<tr>
							<td align="left" class="textstyle"  width="80">Email:</td>
							<td align="left" class="textstyle" width="705">' . $receiver_info['mem_email_address'] . '</td>							
						</tr>						
						<tr>
							<td colspan="2" align="left" height="25px;"></td>
						</tr>
						<tr>
							<td colspan="2" align="left" class="textstyle bold">This email qualifies this HAGC Member for a 10% discount on the work as described as belowThis email qualifies this HAGC Member for a 10% discount on the work as described as below
							<br/>The type of mount or mounts member is interested in.</td>
						</tr>
						<tr>
							<td colspan="2" align="left" height="7px;"></td>
						</tr>
						<tr>
							<td colspan="2" align="left" class="textstyle"> ' . $receiver_info['mem_details'] . ' </td>
						</tr>
						<tr>
							<td colspan="2" align="left" height="20px;"></td>
						</tr>
					</table>
					';
		$message .='<table width="798"  border="0" align="center">
					  <tr>
							<td align="center" height="40"></td>
						  </tr>
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-footer.jpg" alt="" /></td>
					  </tr>
					</table>
				</body>
				</html>';
				
		$subject_member="Your HAGC Taxidermy Project Information";		
		$subject_taxidermist="New Taxidermy Project from HAGC Member";
		$subject_admin=$site_title . " :: Member contact information to the taxidermist for 10% discount";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		
		@mail($receiver_info['mem_email_address'],$subject_member,$message,$headers);		
		@mail($receiver_info['taxi_email'],$subject_taxidermist,$message,$headers);		
		@mail($admin_email_id,$subject_admin,$message,$headers);		
		
		/*echo $receiver_info['mem_email_address'];
		echo "<br/><br/>";
		echo $receiver_info['taxi_email'];
		echo "<br/><br/>";
		echo $admin_email_id;
		echo "<br/><br/>";
		echo $message;
		exit;*/
	}
	
	public function hunt_approval_email($receiver_info,$admin_email_id,$site_title,$site_url){
		
		$subject=$receiver_info['subject'];		
		$message=$receiver_info['content'];
		
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		
		@mail($receiver_info['email'],$subject,$message,$headers);
		
		echo $receiver_info['email'];
		echo "<br/><br/>";
		echo $message;
		exit;
		
	}
			
		
			
	public function approved_hunt_email($receiver_info,$admin_email_id,$site_title,$site_url){
			
		$subject=$receiver_info['subject'];		
		$message=$receiver_info['content'];		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <noreply@huntersandguidesconnection.com>\r\n";
		
		@mail($admin_email_id,$subject,$message,$headers);
		
	/*echo $admin_email_id;
		echo "<br/><br/>";
		echo $message;
		exit;*/
		
	}
				
	public function rejected_hunt_email($receiver_info,$admin_email_id,$site_title,$site_url){
		$subject=$receiver_info['subject'];		
		$message=$receiver_info['content'];		
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <noreply@huntersandguidesconnection.com>\r\n";
		
		@mail($admin_email_id,$subject,$message,$headers);
		
		/*echo $admin_email_id;
		echo "<br/><br/>";
		echo $message;
		exit;*/		
	}				
	
	
	public function review_approval_email_to_admin($receiver_info,$admin_email_id,$site_title,$site_url){
		
		$subject="HAGC hunter has added his review on a hunt and now it is waiting for your approval!";		
		
		$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>HAGC hunter has added his review on a hunt and now it is waiting for your approval</title>
					<style type="text/css">
					body {
						padding:0;-
						margin:0;
						background-color:#fbe7b4;
					}
					.textstyle {
						padding:0px;
						margin:0px;
						font-family: Georgia, "Times New Roman", Times, serif;
						font-size: 13px;						
						font-weight:normal;	
						line-height: 22px;					
						color:#604508;
					}
					
					.bold {
						font-weight:bold;
					}					
					</style>
					</head>
					<body>
					<table width="798" border="0" align="center">
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-header2.jpg" alt="" /></td>
					  </tr>
					  <tr>
						<td align="center" height="20"></td>
					  </tr>
					</table>';
					
					
					
		$message .='<table width="785"  border="0" align="center">
						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">' . $receiver_info['sending_date'] . '</td>
						</tr>
						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">Dear Administrator,</td>
						</tr>
						<tr>
						<td align="center" height="10"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
								The Hunters and Guides Connection hunter '. $receiver_info['member_name'] . ' has submitted a review on  Hunt # ' . $receiver_info['hunt_number'] . ', is now ready for your approval. 
								</td>
						</tr>
						
						<tr>
						<td align="center" height="10"></td>
					  </tr>
						
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Please use the following link to view the review <a href="' . $site_url . $receiver_info['approval_path'] .'">' . $site_url . $receiver_info['approval_path'] .'</a><br/><br/></td>
						
						</tr>
						<tr>
						<td align="center" height="30"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Thanks Again!<br/>
								-The Hunters and Guides Connection Team
							</td>
						
						</tr>
						</table>
					';
					
					
					
		$message .='<table width="798"  border="0" align="center">
					  <tr>
							<td align="center" height="40"></td>
						  </tr>
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-footer.jpg" alt="" /></td>
					  </tr>
					</table>
				</body>
				</html>';
		
		
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		
		@mail($admin_email_id,$subject,$message,$headers);
		
		/*echo $admin_email_id;
		echo "<br/><br/>";
		echo $message;
		exit;*/
		
	}


	public function review_approved_email_to_outfitter($receiver_info,$admin_email_id,$site_title,$site_url){
		
		$subject="HAGC hunter has submitted a review on your hunt!";		
		
		$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>HAGC hunter has submitted a review on your hunt</title>
					<style type="text/css">
					body {
						padding:0;-
						margin:0;
						background-color:#fbe7b4;
					}
					.textstyle {
						padding:0px;
						margin:0px;
						font-family: Georgia, "Times New Roman", Times, serif;
						font-size: 13px;						
						font-weight:normal;	
						line-height: 22px;					
						color:#604508;
					}
					
					.bold {
						font-weight:bold;
					}					
					</style>
					</head>
					<body>
					<table width="798" border="0" align="center">
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-header2.jpg" alt="" /></td>
					  </tr>
					  <tr>
						<td align="center" height="20"></td>
					  </tr>
					</table>';
					
					
					
		$message .='<table width="785"  border="0" align="center">
						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">' . $receiver_info['sending_date'] . '</td>
						</tr>
						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">Dear '. $receiver_info['outfitter_name'] .',</td>
						</tr>
						<tr>
						<td align="center" height="10"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
							HAGC hunter '. $receiver_info['member_screen_name'] . ' has submitted a review on your hunt #'. $receiver_info['hunt_number'] . '
							</td>
						</tr>
						
						<tr>
						<td align="center" height="10"></td>
					  </tr>
						
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Please use the following link to view the review  <a href="' . $site_url . $receiver_info['review_path'] .'">' . $site_url . $receiver_info['review_path'] .'</a><br/><br/></td>
						
						</tr>
						<tr>
						<td align="center" height="30"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Thanks Again!<br/>
								-The Hunters and Guides Connection Team
							</td>
						
						</tr>
						</table>
					';
					
					
					
		$message .='<table width="798"  border="0" align="center">
					  <tr>
							<td align="center" height="40"></td>
						  </tr>
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-footer.jpg" alt="" /></td>
					  </tr>
					</table>
				</body>
				</html>';
		
		
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		
		@mail($receiver_info['outfitter_email'],$subject,$message,$headers);
		
		/*echo $receiver_info['outfitter_email'];
		echo "<br/><br/>";
		echo $message;
		exit;*/
		
	}

	public function review_approved_email_to_member($receiver_info,$admin_email_id,$site_title,$site_url){
		
		$subject="HAGC administrator has approved your review! ";		
		
		$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>HAGC administrator has approved your review</title>
					<style type="text/css">
					body {
						padding:0;-
						margin:0;
						background-color:#fbe7b4;
					}
					.textstyle {
						padding:0px;
						margin:0px;
						font-family: Georgia, "Times New Roman", Times, serif;
						font-size: 13px;						
						font-weight:normal;	
						line-height: 22px;					
						color:#604508;
					}
					
					.bold {
						font-weight:bold;
					}					
					</style>
					</head>
					<body>
					<table width="798" border="0" align="center">
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-header2.jpg" alt="" /></td>
					  </tr>
					  <tr>
						<td align="center" height="20"></td>
					  </tr>
					</table>';
					
					
					
		$message .='<table width="785"  border="0" align="center">
						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">' . $receiver_info['sending_date'] . '</td>
						</tr>
						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">Dear '. $receiver_info['member_name'] .',</td>
						</tr>
						<tr>
						<td align="center" height="10"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
							HAGC administrator has approved your review on hunt #'. $receiver_info['hunt_number'] . '
							</td>
						</tr>
						
						<tr>
						<td align="center" height="10"></td>
					  </tr>
						
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Please use the following link to view the review  <a href="' . $site_url . $receiver_info['review_path'] .'">' . $site_url . $receiver_info['review_path'] .'</a><br/><br/></td>
						
						</tr>
						<tr>
						<td align="center" height="30"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Thanks Again!<br/>
								-The Hunters and Guides Connection Team
							</td>
						
						</tr>
						</table>
					';
					
					
					
		$message .='<table width="798"  border="0" align="center">
					  <tr>
							<td align="center" height="40"></td>
						  </tr>
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-footer.jpg" alt="" /></td>
					  </tr>
					</table>
				</body>
				</html>';
		
		
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		
		@mail($receiver_info['member_email'],$subject,$message,$headers);
		
		/*echo $receiver_info['member_email'];
		echo "<br/><br/>";
		echo $message;
		exit;*/
		
	}

			
	public function review_follow_up_email_to_hunter($receiver_info,$admin_email_id,$site_title,$site_url){
		
		$subject="A comment has been submitted to you review!";			
		$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>A comment has been submitted to you review</title>
					<style type="text/css">
					body {
						padding:0;-
						margin:0;
						background-color:#fbe7b4;
					}
					.textstyle {
						padding:0px;
						margin:0px;
						font-family: Georgia, "Times New Roman", Times, serif;
						font-size: 13px;						
						font-weight:normal;	
						line-height: 22px;					
						color:#604508;
					}
					
					.bold {
						font-weight:bold;
					}					
					</style>
					</head>
					<body>
					<table width="798" border="0" align="center">
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-header2.jpg" alt="" /></td>
					  </tr>
					  <tr>
						<td align="center" height="20"></td>
					  </tr>
					</table>';					
					
					
		$message .='<table width="785"  border="0" align="center">						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">' . $receiver_info['sending_date'] . '</td>
						</tr>						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">Dear '. $receiver_info['hunter_name'] .',</td>
						</tr>
						<tr>
						<td align="center" height="10"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
							HAGC '. $receiver_info['comment_given_by'] . ' has posted a comment on your review that you have submitted to the hunt #'. $receiver_info['hunt_number'] . '
						
							</td>
						</tr>						
						<tr>
						<td align="center" height="10"></td>
					  </tr>						
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Please use the following link to view the comment  <a href="' . $site_url . $receiver_info['review_path'] .'">' . $site_url . $receiver_info['review_path'] .'</a></td>					
						</tr>
						<tr>
						<td align="center" height="10"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
								To unsubscribe from HAGC email follow-up, please <a href="' . $site_url . $receiver_info['unsubscribe_path'] .'">click here</a><br/><br/></td>
							</tr>
						<tr>
						<td align="center" height="30"></td>
					  </tr>
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Thanks Again!<br/>
								-The Hunters and Guides Connection Team
							</td>						
						</tr>
						</table>';				
					
					
		$message .='<table width="798"  border="0" align="center">
					  <tr>
					  <td align="center" height="40"></td>
						  </tr>
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-footer.jpg" alt="" /></td>
					  </tr>
					</table>
				</body>
				</html>';
		
		
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		
		@mail($receiver_info['member_email'],$subject,$message,$headers);
		
		/*echo$receiver_info['hunter_email_address'];
		echo "<br/><br/>";
		echo $message;
		exit;*/
		
	}


		
		
		
			
	
	
	public function hunt_booking_feedback($receiver_info,$admin_email_id,$site_title,$site_url){
		
	
		$subject=$site_title . " : post your valuable reviews";
		$message=$this->mail_header($site_title,$site_url);
		$message .=$receiver_info['message_content'];
		$message .=	$this->mail_footer($site_title,$site_url);
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <" .  $admin_email_id . ">\r\n";
		@mail($receiver_info['email_address'],$subject,$message,$headers);
		
		/*$receiver_info['message_content'];
		print $message;*/
	
	
	}


	
	
	
	
	
		
	
	public function contact_with_provider($receiver_info,$admin_email_id,$site_title,$site_url){
	
		$subject=$site_title . " website viewer enquiry details";
		
		$message=$this->mail_header($site_title,$site_url);
		$message .='<table width="700" border="0" cellspacing="3" align="center" cellpadding="6">
                    <tr>
                      <td colspan="2"><p><strong>Dear '.$receiver_info['provider_name'].', </strong></p>
                      <p>A view has been sent the following contact information to you.</p>
                     
                      <p>&nbsp;</p></td>
                    </tr>
                    <tr>
                      <td width="100"><strong>First Name: </strong></td>
                      <td width="600">'.$receiver_info['first_name'].'</td>
                    </tr>
                    <tr>
                      <td width="100"><strong>Last Name: </strong></td>
                      <td width="600">'.$receiver_info['last_name'].'</td>
                    </tr>
                    <tr>
                      <td width="100"><strong>Email: </strong></td>
                      <td width="600">'.$receiver_info['email'].'</td>
                    </tr>
                    <tr>
                      <td width="100"><strong>Phone: </strong></td>
                      <td width="600">'.$receiver_info['phone'].'</td>
                    </tr>
                    <tr>
                      <td width="100"><strong>Address line 1: </strong></td>
                      <td width="600">'.$receiver_info['address1'].'</td>
                    </tr>
                    <tr>
                      <td width="100"><strong>Address line 2: </strong></td>
                      <td width="600">'.$receiver_info['address2'].'</td>
                    </tr>
                    <tr>
                      <td width="100"><strong>Country: </strong></td>
                      <td width="600">'.$receiver_info['country'].'</td>
                    </tr>
                    <tr>
                      <td width="100"><strong>State: </strong></td>
                      <td width="600">'.$receiver_info['state'].'</td>
                    </tr>
                     <tr>
                      <td width="100"><strong>City: </strong></td>
                      <td width="600">'.$receiver_info['city'].'</td>
                    </tr>
                     <tr>
                      <td width="100"><strong>Zip: </strong></td>
                      <td width="600">'.$receiver_info['zip'].'</td>
                    </tr>
                   
                    <tr>
                      <td valign="top"><strong>Message: </strong></td>
                      <td>'.nl2br($receiver_info['message']).'</td>
                    </tr>
                  </table>';
		
		$message .=	$this->mail_footer($site_title,$site_url);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $receiver_info['email'] .">\r\n";
		@mail($receiver_info['receiver_email'],$subject,$message,$headers);
	
		/*print $message;
		exit;*/
	}	
	
	
	function register_welcome_to_user($receiver_info,$admin_email_id,$site_title,$site_url){		
		$subject=$receiver_info['subject'];			
		$message .=$receiver_info['content'];
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		@mail($receiver_info['email'],$subject,$message,$headers);
		/*print $receiver_info['email'];
		print $message;
		exit;*/	
	}
	
	function logininfo_to_user($receiver_info,$admin_email_id,$site_title,$site_url){	
		$subject=$receiver_info['subject'];
		$message=$receiver_info['content'];
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		@mail($receiver_info['email'],$subject,$message,$headers);		
		
		/*print $receiver_info['email'];
		print $message;
		exit;*/
	}	
	
	public function contact_with_administrator($receiver_info,$admin_email_id,$site_title,$site_url){	
		$subject=$receiver_info['subject'];			
		$message=$receiver_info['content'];
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $receiver_info['email'] .">\r\n";
		@mail($receiver_info['receiver_email'],$subject,$message,$headers);
		
		/*print $receiver_info['receiver_email'];
		print $message;
		exit;*/
	}	
				
	/********************* for user  ******************/
	
	function email_to_user_for_forum($receiver_info,$admin_email_id,$site_title,$site_url){
	
		$subject=$receiver_info['subject'];	
		$message=$receiver_info['content'];
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		@mail($receiver_info['email'],$subject,$message,$headers);
		
		/*echo $receiver_info['email'];
		echo $message;
		exit;*/
		
	}



	/********************* forum/topic/post activation Email to Admin   ******************/
	function email_to_Admin_for_forum($receiver_info,$admin_email_id,$site_title,$site_url){
		$subject=$receiver_info['subject'];		
		$message=$receiver_info['content'];	
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		
		
		@mail($admin_email_id,$subject,$message,$headers);
		
		/*echo  $admin_email_id;
		echo $message;
		exit;*/
	}
	
	/********************* topic activation Email  to user  ******************/	
		
	function email_to_user_for_topic($receiver_info,$sub,$admin_email_id,$site_title,$site_url){
	
		$subject=$receiver_info['subject'];		
		$message=$receiver_info['content'];	
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		@mail($receiver_info['email'],$subject,$message,$headers);
		
		/*echo  $receiver_info['email'];
		echo $message;
		exit;*/
		
	}

	/********************* topic activation Email  to user  ******************/	
		
	function email_to_user_for_post($receiver_info,$admin_email_id,$site_title,$site_url){
	
		$subject=$receiver_info['subject'];		
		$message=$receiver_info['content'];	
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		@mail($receiver_info['email'],$subject,$message,$headers);
		
		/*echo  $receiver_info['email'];
		echo $message;
		exit;*/
		
	}
	
	/********************* topic activation Email  to user  ******************/	
		
		function email_to_user_for_post_rip($receiver_info,$sub,$admin_email_id,$site_title,$site_url){
	
		$subject=$site_title . " :: Topic Activation ";
		
	
		
		$message=$this->mail_header($site_title,$site_url);
		$message .='<table width="700" border="0" cellspacing="3" align="center" cellpadding="6">
					<tr>
						<td class="textstyle" align="left">Dear '.$receiver_info['post_user'].',</td>
					</tr>
					<tr>
						<td class="textstyle" align="left" height="5"></td>
					</tr>
					
					<tr>
						<td class="textstyle" align="left" height=20></td>
					</tr>
					<tr>
						<td class="textstyle" align="left"><strong>'.$sub.'</strong></td>
					</tr>	
					<tr>
						<td class="textstyle" align="left" height="10"></td>
					</tr>
					<tr>
						<td class="textstyle" align="left">'.$receiver_info['body'].'</td>
					</tr>
					</table>';
		
		$message .=	$this->mail_footer($site_title,$site_url);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		@mail($receiver_info['receiver_email'],$subject,$message,$headers);
	
		
	}
	//**********************  internal communication system *******************//
	public function message_copy_to_sender($receiver_info,$admin_email_id,$site_title,$site_url){		
		
		$subject=$receiver_info['message_subject'];			
		$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>' . $receiver_info['message_subject'] . '</title>
					<style type="text/css">
					body {
						padding:0;
						margin:0;
						background-color:#fbe7b4;
					}
					.textstyle {
						padding:0px;
						margin:0px;
						font-family: Georgia, "Times New Roman", Times, serif;
						font-size: 13px;						
						font-weight:normal;	
						line-height: 22px;					
						color:#604508;
					}
					
					.bold {
						font-weight:bold;
					}					
					</style>
					</head>
					<body>
					<table width="798" border="0" align="center">
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-header2.jpg" alt="" /></td>
					  </tr>
					  <tr>
						<td align="center" height="20"></td>
					  </tr>
					</table>';					
					
					
		$message .='<table width="785"  border="0" align="center">						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">Dear ' . $receiver_info['sender_name'] . ',</td>
						</tr>
						<tr>
						<td align="center" height="10"></td>
					  </tr>						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">This is a copy of message that you have sent  from HAGC site!</td>
						</tr>
						<tr>
						<td align="center" height="15"></td>
					  </tr>						
						<tr>
							<td colspan="2" align="left" class="textstyle">'. nl2br($receiver_info['receiver_message']) . '</td>
						</tr>
						';
					  
					  if(trim($receiver_info['uploaded_file']) != NULL){
						$message .='<tr>
						<td align="center" height="15"></td>
					  </tr>	
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Please click <a href="' . $site_url .  $receiver_info['uploaded_file'] .'">here</a> to view uploaded document.</td>					
						</tr>';
					  }
					 
					  
					  
						$message .='<tr>
						<td align="center" height="40"></td>
					  </tr>
						
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Thanks Again!<br/>
								-The Hunters and Guides Connection Team
							</td>						
						</tr>
						</table>';				
					
					
		$message .='<table width="798"  border="0" align="center">
					  <tr>
					  <td align="center" height="40"></td>
						  </tr>
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-footer.jpg" alt="" /></td>
					  </tr>
					</table>
				</body>
				</html>';
		
		
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		
		@mail($receiver_info['sender_email'],$subject,$message,$headers);
		
		/*echo $receiver_info['sender_email'];
		echo "<br/><br/>";
		echo $message;
		exit;	*/
	}


	public function message_copy_to_receiver($receiver_info,$admin_email_id,$site_title,$site_url){
		
		$subject=$receiver_info['message_subject'];			
		$message='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>'.$receiver_info['message_subject'].'</title>
					<style type="text/css">
					body {
						padding:0;
						margin:0;
						background-color:#fbe7b4;
					}
					.textstyle {
						padding:0px;
						margin:0px;
						font-family: Georgia, "Times New Roman", Times, serif;
						font-size: 13px;						
						font-weight:normal;	
						line-height: 22px;					
						color:#604508;
					}
					
					.bold {
						font-weight:bold;
					}					
					</style>
					</head>
					<body>
					<table width="798" border="0" align="center">
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-header2.jpg" alt="" /></td>
					  </tr>
					  <tr>
						<td align="center" height="20"></td>
					  </tr>
					</table>';					
					
					
		$message .='<table width="785"  border="0" align="center">						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">Dear ' . $receiver_info['receiver_name'] . ',</td>
						</tr>
						<tr>
						<td align="center" height="10"></td>
					  </tr>						
						<tr>
							<td colspan="2" align="left" class="textstyle bold">This message sent to you from HAGC site by ' . $receiver_info['sender_name'] . '</td>
						</tr>
						<tr>
						<td align="center" height="15"></td>
					  </tr>						
						<tr>
							<td colspan="2" align="left" class="textstyle">'. nl2br($receiver_info['receiver_message']) . '</td>
						</tr>
						';
					  
					  if(trim($receiver_info['uploaded_file']) != NULL){
						$message .='<tr>
						<td align="center" height="15"></td>
					  </tr>	
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Please click <a href="' . $site_url .  $receiver_info['uploaded_file'] .'">here</a> to view uploaded document.</td>					
						</tr>';
					  }
					 
					  
					  
						$message .='<tr>
						<td align="center" height="40"></td>
					  </tr>
						
						<tr>
							<td colspan="2" align="left" class="textstyle">
								Thanks Again!<br/>
								-The Hunters and Guides Connection Team
							</td>						
						</tr>
						</table>';				
					
					
		$message .='<table width="798"  border="0" align="center">
					  <tr>
					  <td align="center" height="40"></td>
						  </tr>
					  <tr>
						<td align="center"><img src="' . $site_url . 'images/email-footer.jpg" alt="" /></td>
					  </tr>
					</table>
				</body>
				</html>';
		
		
		
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <info@huntersandguidesconnection.com>\r\n";
		
		@mail($receiver_info['receiver_email'],$subject,$message,$headers);
		
		/*echo $receiver_info['receiver_email'];
		echo "<br/><br/>";
		echo $message;*/
		
	}

}
?>
