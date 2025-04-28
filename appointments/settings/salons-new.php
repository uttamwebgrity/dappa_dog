<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

if($_SESSION['admin_access_level'] != 1 && ! in_array(14,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if($_SESSION['admin_access_level'] == 2 &&  !$objdappaDogs->his_own_salon($_SESSION['admin_user_id'],$_REQUEST['id'])){
	$_SESSION['msg']="Sorry, you do not have the permission to access this salon!";
	$general_func->header_redirect($general_func->admin_url."home.php");	
} 

$data=array();

if(isset($_REQUEST['return_url']) && trim($_REQUEST['return_url']) != NULL){
	$_SESSION['return_url']=trim($_REQUEST['return_url']);	
}


if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){
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
	$sent_email=$result[0]['sent_email'];
	$content=$result[0]['content'];
	
	
	
	//***************** login_info **********************//
	$sql_login_info="select admin_user,admin_pass  from admin  where user_id =" . (int) $_REQUEST['id'] . " and access_level=2  limit 1";
	$result_login_info=$db->fetch_all_array($sql_login_info);	
	
	$user_name=$result_login_info[0]['admin_user'];
	$password=$result_login_info[0]['admin_pass'];

	//************ working_days **********************//	
	$sql_working_day="select working_day from salon_working_days where salon_id='" . $_REQUEST['id'] . "'";
	$result_working_day=$db->fetch_all_array($sql_working_day);
	$total_working_day=count($result_working_day);
	
	$working_days=array();
	
	for($day=0; $day<$total_working_day; $day++){
		$working_days[]=$result_working_day[$day]['working_day'];	
	}
	
	
	//************ groomings **********************//	
	$sql_grooming="select grooming_id from salon_grooming where salon_id='" . $_REQUEST['id'] . "'";
	$result_grooming=$db->fetch_all_array($sql_grooming);
	$total_grooming=count($result_grooming);
	
	$available_groomings=array();
	
	for($grooming=0; $grooming<$total_grooming; $grooming++){
		$available_groomings[]=$result_grooming[$grooming]['grooming_id'];	
	}
	
	
	$button="Update";
}else{	
	$salon_name="";
	$email_address="";
	$landline_no="";
	$mobile_no="";
	$address1="";
	$address2="";
	$city="";
	$state="";
	$zip="";
	$opening_time="";
	$closing_time="";
	$sent_email=0;
	$content="";
	
	$user_name="";
	$password="";
	
	$working_days=array();
	$available_groomings=array();
	
	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="salon"){	
	
	$salon_name=trim($_REQUEST['salon_name']);
	$email_address=trim($_REQUEST['email_address']);
	$landline_no=trim($_REQUEST['landline_no']);
	$mobile_no=trim($_REQUEST['mobile_no']);
	$address1=trim($_REQUEST['address1']);
	$address2=trim($_REQUEST['address2']);
	$city=trim($_REQUEST['city']);
	$state=trim($_REQUEST['state']);
	$zip=trim($_REQUEST['zip']);
	$opening_time=trim($_REQUEST['opening_time']);
	$closing_time=trim($_REQUEST['closing_time']);
	
	$user_name=trim($_REQUEST['user_name']);
	$password=trim($_REQUEST['password']);
	
	$working_day=array();
	$available_grooming=array();
	
	$working_day=$_REQUEST['working_day'];
	$available_grooming=$_REQUEST['available_grooming'];
	$sent_email=(isset($_REQUEST['sent_email']) && $_REQUEST['sent_email']==1)?1:0;
	
	$content=trim($_REQUEST['content']);
	
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("salons","email_address",$email_address)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";	
		}else if($db->already_exist_inset("admin","admin_user",$user_name)){
			$_SESSION['msg']="Sorry, your specified username is already taken!";				
		}else{			
			$data['salon_name']=$salon_name;
			$data['email_address']=$email_address;
			$data['landline_no']=$landline_no;
			$data['mobile_no']=$mobile_no;
			$data['address1']=$address1;
			$data['address2']=$address2;
			$data['city']=$city;			
			$data['state']=$state;
			$data['zip']=$zip;
			$data['opening_time']=$opening_time;
			$data['closing_time']=$closing_time;
			$data['sent_email']=$sent_email;
			$data['content']=$content;
			
									
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];
			$data['created']='now()';		
			
			$salon_id=$db->query_insert("salons",$data);
			
			
			
			if(count($working_day)> 0){
				$working_id_data = "INSERT INTO `salon_working_days` (`salon_id`, `working_day`) VALUES ";
				
				for($p=0; $p<count($working_day); $p++){
					$working_id_data .="('" . $salon_id ."', '" . $working_day[$p] ."'), ";
				}
				
				$working_id_data = substr($working_id_data,0,-2);
				$working_id_data .=";";
				
				$db->query($working_id_data);
			}
			
			if(count($available_grooming)> 0){
				$grooming_id_data = "INSERT INTO `salon_grooming` (`salon_id`, `grooming_id`) VALUES ";
				
				for($p=0; $p<count($available_grooming); $p++){
					$grooming_id_data .="('" . $salon_id ."', '" . $available_grooming[$p] ."'), ";
				}
				
				$grooming_id_data = substr($grooming_id_data,0,-2);
				$grooming_id_data .=";";
				
				
			
				$db->query($grooming_id_data);
			}
			
			
		
			$salon_data=array();	
			$salon_data['admin_user']=$user_name;
			$salon_data['admin_pass']=$password;
			$salon_data['fname']=$salon_name;		
			$salon_data['access_level']=2;
			$salon_data['user_id']=$salon_id;
			$db->query_insert("admin",$salon_data);
			
			
			if($sent_email == 1){//*************  send email to salon admin				
				$sql_email_template="select template_subject,template_content from email_template where id=1 limit 1";
				$result_email_template = $db -> fetch_all_array($sql_email_template);
					
				if(count($result_email_template) == 1){
					$message_content=$result_email_template[0]['template_content'];	
							
					$message_content=str_replace("#salon_name#",$salon_name,$message_content);
					$message_content=str_replace("#username# ",$user_name,$message_content);
					$message_content=str_replace("#password#",$password,$message_content);	
					
					$message_content=str_replace("#salon_admin_login_link#",$general_func->admin_url,$message_content);	
					$message_content=str_replace("#contact_link#",$general_func->site_url."contact.php",$message_content);	
											
					$receiver_info = array();
					$receiver_info['subject'] = $result_email_template[0]['template_subject'];	
					$receiver_info['content'] = $message_content;
					$receiver_info['email'] = $email_address;
					$sendmail -> register_welcome_to_user($receiver_info, $general_func -> admin_email_id, $general_func -> site_title, $general_func -> site_url);				
				}
			}
			
			
			$_SESSION['msg']="Salon successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{			
		if($db->already_exist_update("salons","id",$_REQUEST['id'],"email_address",$email_address)){	
			$_SESSION['msg']="Sorry, your specified email address is already taken!";
		}if($db->already_exist_update("admin","user_id",$_REQUEST['id'],"admin_user",$admin_user)){	
			$_SESSION['msg']="Sorry, your specified username is already taken!";								
		}else{
			$data['salon_name']=$salon_name;
			$data['email_address']=$email_address;
			$data['landline_no']=$landline_no;
			$data['mobile_no']=$mobile_no;
			$data['address1']=$address1;
			$data['address2']=$address2;
			$data['city']=$city;			
			$data['state']=$state;
			$data['zip']=$zip;
			$data['opening_time']=$opening_time;
			$data['closing_time']=$closing_time;
			$data['sent_email']=$sent_email;
			$data['content']=$content;
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			
			$db->query_update("salons",$data,"id='".$_REQUEST['id'] ."'");
			
					
			$db->query("delete from salon_working_days where salon_id='" . $_REQUEST['id'] . "'");			
			if(count($working_day)> 0){
				$working_id_data = "INSERT INTO `salon_working_days` (`salon_id`, `working_day`) VALUES ";
				
				for($p=0; $p<count($working_day); $p++){
					$working_id_data .="('" . $_REQUEST['id'] ."', '" . $working_day[$p] ."'), ";
				}
				
				$working_id_data = substr($working_id_data,0,-2);
				$working_id_data .=";";
				
				$db->query($working_id_data);
			}
			
			
			$db->query("delete from salon_grooming where salon_id='" . $_REQUEST['id'] . "'");
			if(count($available_grooming)> 0){
				$grooming_id_data = "INSERT INTO `salon_grooming` (`salon_id`, `grooming_id`) VALUES ";
				
				for($p=0; $p<count($available_grooming); $p++){
					$grooming_id_data .="('" . $_REQUEST['id'] ."', '" . $available_grooming[$p] ."'), ";
				}
				
				$grooming_id_data = substr($grooming_id_data,0,-2);
				$grooming_id_data .=";";
				
				
				$db->query($grooming_id_data);
			}
			
			
			
			$salon_data=array();	
			$salon_data['admin_user']=$user_name;
			$salon_data['admin_pass']=$password;
			$salon_data['fname']=$salon_name;			
			
			$db->query_update("admin",$salon_data,"user_id='".$_REQUEST['id'] ."' and access_level=2");		
			
			
			if($sent_email == 1){//*************  send email to salon admin
				$sql_email_template="select template_subject,template_content from email_template where id=1 limit 1";
				$result_email_template = $db -> fetch_all_array($sql_email_template);
					
				if(count($result_email_template) == 1){
					$message_content=$result_email_template[0]['template_content'];	
							
					$message_content=str_replace("#salon_name#",$salon_name,$message_content);
					$message_content=str_replace("#username#",$user_name,$message_content);
					$message_content=str_replace("#password#",$password,$message_content);	
					
					$message_content=str_replace("#salon_admin_login_link#",$general_func->admin_url,$message_content);	
					$message_content=str_replace("#contact_link#",$general_func->site_url."contact.php",$message_content);	
											
					$receiver_info = array();
					$receiver_info['subject'] = $result_email_template[0]['template_subject'];	
					$receiver_info['content'] = $message_content;
					$receiver_info['email'] = $email_address;
					$sendmail -> register_welcome_to_user($receiver_info, $general_func -> admin_email_id, $general_func -> site_title, $general_func -> site_url);				
				}	
				
			}
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Product successfully updated!";
			
			$general_func->header_redirect($_SESSION['return_url']);
		}
	}
}	

?>
<script language="JavaScript">
function validate(){		
	
	if(!validate_text(document.ff.salon_name,1,"Please enter salon name"))
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
		
		
	if(parseInt(document.ff.opening_time.value) >= parseInt(document.ff.closing_time.value)){
		alert("Closing time must be greater than opening time");
		document.ff.closing_time.focus();
		return false;			
	}	
		
	if(document.ff.available_grooming[0].checked== false && document.ff.available_grooming[1].checked== false ){
		alert("Please choose at least a Grooming (Dog or Cat)");		
		return false;	
	}	
	
	var working_day=document.ff.working_day;
	
	if(working_day[0].checked== false && working_day[1].checked== false && working_day[2].checked== false && working_day[3].checked== false  && working_day[4].checked== false  && working_day[5].checked== false  && working_day[6].checked== false ){
		alert("Please choose at least a working day");		
		return false;	
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
      	<p><a href="settings/salons.php">Salons</a> &raquo; <?=$button?> </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;"><?=$button?> Salon</a></li>             
                
            </ul>
         <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="salon" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
       
            <input name="submit" type="hidden" value="<?=$button?>" />
   <div class="tabPnlCont">
<div class="tabPnlContInr">     
        
              <div class="tabcontArea" style="background:none">
          	 <h3>General Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">                   
                   <li>Salon Name <span class="star">*</span><br><input name="salon_name" value="<?=$salon_name?>" type="text" /></li>
                  <li>Email <span class="star">*</span><br><input name="email_address" value="<?=$email_address?>" type="text" /></li>
                   <li>Landline Number <br><input name="landline_no" value="<?=$landline_no?>" type="text" /></li>
                   <li>Mobile Number (SMS Number) <span class="star">*</span><br><input name="mobile_no" value="<?=$mobile_no?>" type="text"  style="background:#fff; width:281px;"  /></li>
                   <li>Address line 1 <span class="star">*</span><br><input name="address1" value="<?=$address1?>" type="text"  /></li>
                   <li>Address line 2 <br><input name="address2" value="<?=$address2?>" type="text"  /></li>
                  	<li>City <span class="star">*</span><br><input name="city" value="<?=$city?>" type="text"  /></li>
                    <li>State <span class="star">*</span><br><input name="state" value="<?=$state?>" type="text"  /></li>
                    <li>Post Code <span class="star">*</span><br><input name="zip" value="<?=$zip?>" type="text"  /></li>
                  <li>Opening Time (24 hours)<span class="star">*</span><br>
                    	<select name="opening_time">
                    	<?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$opening_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                    		
                    	</select>
                    	</li>        
                   <li>Closing Time (24 hours)<span class="star">*</span><br>
                   	
                   	<select name="closing_time">
                    	<?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$closing_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                    		
                    	</select>
                   	</li> 
                   <li style="width: 100%">Available Grooming <span class="star">*</span><br>
                   	<?php
                   	$sql_grooming="select id,name from grooming order by display_order + 0 ASC";
					$result_grooming=$db->fetch_all_array($sql_grooming);
					$total_grooming=count($result_grooming);
					
					for($grooming=0; $grooming < $total_grooming; $grooming++){?>
					<input type="checkbox" name="available_grooming[]" id="available_grooming" <?=in_array($result_grooming[$grooming]['id'],$available_groomings)?'checked="checked"':'';?>  value="<?=$result_grooming[$grooming]['id']?>" >
					<?=$result_grooming[$grooming]['name']?><br/>						
					<?php }	?>
                 </li>      
                   <li>Working Days <span class="star">*</span><br>             	
                    <?php
					foreach($all_days_in_a_week as $day_index=>$day_value){?>
					<input type="checkbox" name="working_day[]" id="working_day" <?=in_array($day_index,$working_days)?'checked="checked"':'';?>  value="<?=$day_index?>" >
					<?=$day_value?><br/>					
					<?php }	?>
                    </li>                     
                 </ul>
               </div>
             </div>
            <h3>Login  Information:</h3>
            <div class="row">
              <div class="formCenter">
                <ul class="formOne">
                <li>Username <span class="star">*</span><br><input name="user_name" value="<?=$user_name?>" type="text" /></li>
                 <li>Password <span class="star">*</span><br><input name="password" value="<?=$password?>" type="password" /></li>                  
                <li><?=$sent_email==1?'Resend':'Send';?> access info to email address <input type="checkbox" name="sent_email"  value="1" ></li>
                </ul>
              </div>
            </div> 
            <h3>Content Information:</h3>
            <div class="row">
              <div class="formCenter">
                <ul class="formOne">                
                  <li style="width: 100%;"><?php
					include("../fckeditor/fckeditor.php") ;
					$sBasePath ="fckeditor/";
					$oFCKeditor = new FCKeditor('content') ;
					$oFCKeditor->BasePath	= $sBasePath ;
					$oFCKeditor->Height = '400' ;
					$oFCKeditor->width = '400' ;
					$oFCKeditor->Value		= $content;
					$oFCKeditor->Create();
					?></li> 
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
	document.ff.salon_name.focus();
	
</script>    
            
<?php
include("../foot.htm");
?>