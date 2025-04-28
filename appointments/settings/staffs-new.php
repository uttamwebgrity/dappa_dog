<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

if((int)$_SESSION['admin_access_level'] == 3){		
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if($_REQUEST['action']=="EDIT" && $_SESSION['admin_access_level'] == 2 &&  !$objdappaDogs->his_own_salon_staff($_SESSION['admin_user_id'],$_REQUEST['id'])){
	$_SESSION['msg']="Sorry, you do not have the permission to access this staff!";
	$general_func->header_redirect($general_func->admin_url."home.php");	
} 



$data=array();

if(isset($_REQUEST['return_url']) && trim($_REQUEST['return_url']) != NULL){
	$_SESSION['return_url']=trim($_REQUEST['return_url']);	
}


if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){
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
	$sent_email=$result[0]['sent_email'];
		
	//***************** login_info **********************//
	$sql_login_info="select admin_user,admin_pass  from admin  where user_id =" . (int) $_REQUEST['id'] . " and access_level=3  limit 1";
	$result_login_info=$db->fetch_all_array($sql_login_info);	
	
	$user_name=$result_login_info[0]['admin_user'];
	$password=$result_login_info[0]['admin_pass'];

	//************ staff **********************//	
	$sql_salon="select salon_id  from staff_salon where staff_id='" . $_REQUEST['id'] . "'";
	$result_salon=$db->fetch_all_array($sql_salon);
	$total_salon=count($result_salon);
	
	$salons=array();
	
	for($salon=0; $salon<$total_salon; $salon++){
		$salons[]=$result_salon[$salon]['salon_id'];	
	}
		
	
	$button="Update";
}else{	
	$staff_name="";
	$email_address="";
	$landline_no="";
	$mobile_no="";
	$address1="";
	$address2="";
	$city="";
	$state="";
	$zip="";
	$job_title="";
	$bio="";
	$sent_email=0;
	
	$user_name="";
	$password="";
	
	$salons=array();
	
	
	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="staff"){	
	
	$staff_name=trim($_REQUEST['staff_name']);
	$email_address=trim($_REQUEST['email_address']);
	$landline_no=trim($_REQUEST['landline_no']);
	$mobile_no=trim($_REQUEST['mobile_no']);
	$address1=trim($_REQUEST['address1']);
	$address2=trim($_REQUEST['address2']);
	$city=trim($_REQUEST['city']);
	$state=trim($_REQUEST['state']);
	$zip=trim($_REQUEST['zip']);
	$job_title=trim($_REQUEST['job_title']);
	$bio=trim($_REQUEST['bio']);
	$sent_email=(isset($_REQUEST['sent_email']) && $_REQUEST['sent_email']==1)?1:0;
	
	$user_name=trim($_REQUEST['user_name']);
	$password=trim($_REQUEST['password']);
	
	$salon=array();
	
	$salon=$_REQUEST['salon'];
	
	
	
	
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("staffs","email_address",$email_address)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";	
		}else if($db->already_exist_inset("admin","admin_user",$user_name)){
			$_SESSION['msg']="Sorry, your specified username is already taken!";				
		}else{			
			$data['staff_name']=$staff_name;
			$data['email_address']=$email_address;
			$data['landline_no']=$landline_no;
			$data['mobile_no']=$mobile_no;
			$data['address1']=$address1;
			$data['address2']=$address2;
			$data['city']=$city;			
			$data['state']=$state;
			$data['zip']=$zip;
			$data['job_title']=$job_title;
			$data['bio']=$bio;		
			$data['sent_email']=$sent_email;				
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];
			$data['created']='now()';		
			
			$staff_id=$db->query_insert("staffs",$data);			
			
			
			if(count($salon)> 0){
				$salon_id_data = "INSERT INTO `staff_salon` (`salon_id`, `staff_id`) VALUES ";
				
				for($p=0; $p<count($salon); $p++){
					$salon_id_data .="('" . $salon[$p] ."', '" . $staff_id ."'), ";
				}
				
				$salon_id_data = substr($salon_id_data,0,-2);
				$salon_id_data .=";";
				
				$db->query($salon_id_data);
			}
				
			
		
			$salon_data=array();	
			$salon_data['admin_user']=$user_name;
			$salon_data['admin_pass']=$password;
			$salon_data['fname']=$staff_name;		
			$salon_data['access_level']=3;
			$salon_data['user_id']=$staff_id;
			$db->query_insert("admin",$salon_data);
			
			if($sent_email == 1){//*************  send email to staff
				$sql_email_template="select template_subject,template_content from email_template where id=2 limit 1";
				$result_email_template = $db -> fetch_all_array($sql_email_template);
					
				if(count($result_email_template) == 1){
					$message_content=$result_email_template[0]['template_content'];	
							
					$message_content=str_replace("#staff_name#",$staff_name,$message_content);
					$message_content=str_replace("#username#",$user_name,$message_content);
					$message_content=str_replace("#password#",$password,$message_content);	
					
					$message_content=str_replace("#staff_login_link#",$general_func->admin_url,$message_content);	
					$message_content=str_replace("#contact_link#",$general_func->site_url."contact.php",$message_content);	
											
					$receiver_info = array();
					$receiver_info['subject'] = $result_email_template[0]['template_subject'];	
					$receiver_info['content'] = $message_content;
					$receiver_info['email'] = $email_address;
					$sendmail -> register_welcome_to_user($receiver_info, $general_func -> admin_email_id, $general_func -> site_title, $general_func -> site_url);				
				}			
				
			}
			
			
			
			$_SESSION['msg']="Staff successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{			
		if($db->already_exist_update("staffs","id",$_REQUEST['id'],"email_address",$email_address)){	
			$_SESSION['msg']="Sorry, your specified email address is already taken!";
		}if($db->already_exist_update("admin","user_id",$_REQUEST['id'],"admin_user",$admin_user)){	
			$_SESSION['msg']="Sorry, your specified username is already taken!";								
		}else{
			$data['staff_name']=$staff_name;
			$data['email_address']=$email_address;
			$data['landline_no']=$landline_no;
			$data['mobile_no']=$mobile_no;
			$data['address1']=$address1;
			$data['address2']=$address2;
			$data['city']=$city;			
			$data['state']=$state;
			$data['zip']=$zip;
			$data['job_title']=$job_title;
			$data['bio']=$bio;
			$data['sent_email']=$sent_email;			
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			
			$db->query_update("staffs",$data,"id='".$_REQUEST['id'] ."'");
			
					
			$db->query("delete from staff_salon where staff_id='" . $_REQUEST['id'] . "'");			
			
			if(count($salon)> 0){
				$salon_id_data = "INSERT INTO `staff_salon` (`salon_id`, `staff_id`) VALUES ";
				
				for($p=0; $p<count($salon); $p++){
					$salon_id_data .="('" . $salon[$p] ."', '" . $_REQUEST['id'] ."'), ";
				}
				
				$salon_id_data = substr($salon_id_data,0,-2);
				$salon_id_data .=";";
				$db->query($salon_id_data);
			}
				
									
			
			$salon_data=array();	
			$salon_data['admin_user']=$user_name;
			$salon_data['admin_pass']=$password;
			$salon_data['fname']=$staff_name;			
			
			$db->query_update("admin",$salon_data,"user_id='".$_REQUEST['id'] ."' and access_level=3");		
			
			if($sent_email == 1){//*************  send email to staff
				$sql_email_template="select template_subject,template_content from email_template where id=2 limit 1";
				$result_email_template = $db -> fetch_all_array($sql_email_template);
					
				if(count($result_email_template) == 1){
					$message_content=$result_email_template[0]['template_content'];	
							
					$message_content=str_replace("#staff_name#",$staff_name,$message_content);
					$message_content=str_replace("#username#",$user_name,$message_content);
					$message_content=str_replace("#password#",$password,$message_content);	
					
					$message_content=str_replace("#staff_login_link#",$general_func->admin_url,$message_content);	
					$message_content=str_replace("#contact_link#",$general_func->site_url."contact.php",$message_content);	
											
					$receiver_info = array();
					$receiver_info['subject'] = $result_email_template[0]['template_subject'];	
					$receiver_info['content'] = $message_content;
					$receiver_info['email'] = $email_address;
					$sendmail -> register_welcome_to_user($receiver_info, $general_func -> admin_email_id, $general_func -> site_title, $general_func -> site_url);				
				}		
				
			}
			
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Staff successfully updated!";
			
			$general_func->header_redirect($_SESSION['return_url']);
		}
	}
}	

?>
<script language="JavaScript">
function validate(){		

	if(!validate_text(document.ff.staff_name,1,"Please enter staff name"))
		return false;
		
	if(!validate_email(document.ff.email_address,1,"Enter email address"))
		 return false;		
			
	if(!validate_text(document.ff.mobile_no,1,"Please enter xxxxxxxx mobile number"))
		return false;
		
	if(!exact_length(document.ff.mobile_no,8,"Please enter xxxxxxxx mobile number"))
			return false;				

			
		
	if(!validate_text(document.ff.address1,1,"Please enter address line 1"))
		return false;
	
	if(!validate_text(document.ff.city,1,"Please enter city"))
		return false;
		
	if(!validate_text(document.ff.state,1,"Please enter state"))
		return false;
		
	if(!validate_text(document.ff.zip,1,"Please enter post code"))
		return false;			
		
	
	var salon_length=parseInt(document.ff.salon.length);
	var salon_checked=false;
	
	for(var index=0; index < salon_length; index++){
		if(document.ff.salon[index].checked == true){
			salon_checked = true;
			break;			
		}
	}
	
	if(salon_checked == false){
		alert("Please choose at least a salon");		
	}
	
	
	if(!validate_text(document.ff.user_name,1,"Please enter username"))
		return false;
		
	if(!passid_validation(document.ff.user_name,6,12,"Username must be of length between"))
		return false;
		
	if(!validate_text(document.ff.password,1,"Please enter password"))
		return false;
		
	if(!passid_validation(document.ff.password,6,12,"Password must be of length between"))
		return false;	

	
}
</script>
 <div class="breadcrumb">
      	<p><a href="settings/staffs.php">Staff</a> &raquo; <?=$button?> </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;"><?=$button?> Staff</a></li>             
                
            </ul>
         <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="staff" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
       
            <input name="submit" type="hidden" value="<?=$button?>" />
        
<div class="tabPnlCont">
<div class="tabPnlContInr">
              <div class="tabcontArea" style="background:none">
          	 <h3>General Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">                   
                   <li>Staff Name <span class="star">*</span><br><input name="staff_name" value="<?=$staff_name?>" type="text" /></li>
                    <li>Email <span class="star">*</span><br><input name="email_address" value="<?=$email_address?>" type="text" /></li>
                   <li>Landline Number <br><input name="landline_no" value="<?=$landline_no?>" type="text" /></li>
                   <li>Mobile Number (SMS Number) <span class="star">*</span><br><input name="mobile_no" value="<?=$mobile_no?>" type="text"  style="background:#fff; width:281px;"  /></li>
                   <li>Address line 1 <span class="star">*</span><br><input name="address1" value="<?=$address1?>" type="text"  /></li>
                   <li>Address line 2 <br><input name="address2" value="<?=$address2?>" type="text"  /></li>
                  	<li>City <span class="star">*</span><br><input name="city" value="<?=$city?>" type="text"  /></li>
                    <li>State <span class="star">*</span><br><input name="state" value="<?=$state?>" type="text"  /></li>
                    <li>Post Code <span class="star">*</span><br><input name="zip" value="<?=$zip?>" type="text"  /></li>
                    </li>   
                 </ul>
                    <h4>Attached Salons<span class="star">*</span></h4>
                      <ul class="formTwoCbox">
                        
						<?php
                        $salon_query .=" where 1";
                      	if((int)$_SESSION['admin_access_level'] == 2){
							$salon_query .=" and id='" . $_SESSION['admin_user_id'] . "'";
						}		
			
                        
                   		$sql_salon="select id,salon_name from salons $salon_query order by salon_name ASC";
						$result_salon=$db->fetch_all_array($sql_salon);
						$total_salon=count($result_salon);
					
						for($salon=0; $salon < $total_salon; $salon++){?>
	                       <li> <input type="checkbox" name="salon[]" id="salon" <?=in_array($result_salon[$salon]['id'],$salons)?'checked="checked"':'';?>  value="<?=$result_salon[$salon]['id']?>" >
	                        <span><?=$result_salon[$salon]['salon_name']?></span>	</li>				
	                        <?php }	?>
                            
                      </ul>
                    
               </div>
             </div>
             <h3>Bio Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">                   
                   <li>Job Title <br><input name="job_title" value="<?=$job_title?>" type="text" /></li>
                  <li style="clear:both;">Bio <br><textarea name="bio" rows="10" cols="90"><?=$bio?></textarea> </li>
                                                
                 </ul>
               </div>
             </div>
             
            <h3>Login  Information:</h3>
            <div class="row">
              <div class="formCenter">
                <ul class="formOne">
                <li>Username<span class="star">*</span><br><input name="user_name" value="<?=$user_name?>" type="text" /></li>
                 <li>Password <span class="star">*</span><br><input name="password" value="<?=$password?>" type="password" /></li>                  
                	<li><?=$sent_email==1?'Resend':'Send';?> access info to email address <input type="checkbox" name="sent_email"  value="1" ></li>
                </ul>
              </div>
            </div>           
          
            <div class="submitSection">
            	<?php if($button =="Add New"){?>
            		 <input name="save" type="submit" value="" class="saveBtn" />					
            	<?php }else{?>            		
					 <input name="update" type="submit" value="" class="updateBtn" />
            	<?php }?>           	
       	   
            	<input name="back" type="button" value="Back" onclick="location.href='<?=$_SESSION['return_url']?>'" class="backBtn" />
               <?php if($button =="Add New"){?>
                <input name="Cancel" type="reset" value="Cancel" class="cancelBtn" />
                <?php }?>
            </div>
          </div>
<br class="clear" />
</div>
</div>
          </form>
          <script>
	document.ff.staff_name.focus();
	
</script>  
            
<?php
include("../foot.htm");
?>