<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/

$data=array();

if(isset($_REQUEST['return_url']) && trim($_REQUEST['return_url']) != NULL){
	$_SESSION['return_url']=trim($_REQUEST['return_url']);	
}


if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){
	$sql="select * from customers where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	
	$first_name=$result[0]['first_name'];
	$last_name=$result[0]['last_name'];
	$landline_number=$result[0]['landline_number'];
	$mobile_number=$result[0]['mobile_number'];
	$othere_number=$result[0]['othere_number'];
	$partners_number=$result[0]['partners_number'];
	$email=$result[0]['email'];
		
	$physical_address1=$result[0]['physical_address1'];
	$physical_address2=$result[0]['physical_address2'];
	$physical_suburb=$result[0]['physical_suburb'];
	$physical_city=$result[0]['physical_city'];
	$physical_state=$result[0]['physical_state'];
	$physical_post_code=$result[0]['physical_post_code'];
	
	$postal_address1=$result[0]['postal_address1'];
	$postal_address2=$result[0]['postal_address2'];
	$postal_suburb=$result[0]['postal_suburb'];
	$postal_city=$result[0]['postal_city'];
	$postal_state=$result[0]['postal_state'];
	$postal_post_code=$result[0]['postal_post_code'];
	
		
	$SMS_notifications=$result[0]['SMS_notifications'];
	$email_notifications=$result[0]['email_notifications'];
	$mail_notifications=$result[0]['mail_notifications'];
	
	
	
	$username=$result[0]['username'];
	$password=$result[0]['password'];
	$sent_email=$result[0]['sent_email'];
	
	$button="Update";
}else{	
	$first_name="";
	$last_name="";
	$landline_number="";
	$mobile_number="";
	$othere_number="";
	$partners_number="";
	$email="";
		
	$physical_address1="";
	$physical_address2="";
	$physical_suburb="";
	$physical_city="";
	$physical_state="";
	$physical_post_code="";
	
	$postal_address1="";
	$postal_address2="";
	$postal_suburb="";
	$postal_city="";
	$postal_state="";
	$postal_post_code="";
	
		
	$SMS_notifications=1;
	$email_notifications=1;
	$mail_notifications=0;
	
	$username="";
	$password="";
	$sent_email=0;
	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="customer"){
	
	$first_name=$_REQUEST['first_name'];
	$last_name=$_REQUEST['last_name'];
	$landline_number=$_REQUEST['landline_number'];
	$mobile_number=$_REQUEST['mobile_number'];
	$othere_number=$_REQUEST['othere_number'];
	$partners_number=$_REQUEST['partners_number'];
	$email=$_REQUEST['email'];
		
	$physical_address1=$_REQUEST['physical_address1'];
	$physical_address2=$_REQUEST['physical_address2'];
	$physical_suburb=$_REQUEST['physical_suburb'];
	$physical_city=$_REQUEST['physical_city'];
	$physical_state=$_REQUEST['physical_state'];
	$physical_post_code=$_REQUEST['physical_post_code'];
	
	$postal_address1=$_REQUEST['postal_address1'];
	$postal_address2=$_REQUEST['postal_address2'];
	$postal_suburb=$_REQUEST['postal_suburb'];
	$postal_city=$_REQUEST['postal_city'];
	$postal_state=$_REQUEST['postal_state'];
	$postal_post_code=$_REQUEST['postal_post_code'];	
		
	$SMS_notifications=(isset($_REQUEST['SMS_notifications']) && $_REQUEST['SMS_notifications']==1)?1:0;
	$email_notifications=(isset($_REQUEST['email_notifications']) && $_REQUEST['email_notifications']==1)?1:0;
	$mail_notifications=(isset($_REQUEST['mail_notifications']) && $_REQUEST['mail_notifications']==1)?1:0;
	
		
	$username=trim($_REQUEST['username']);
	$password=trim($_REQUEST['password']);
	$sent_email=(isset($_REQUEST['sent_email']) && $_REQUEST['sent_email']==1)?1:0;
	
		
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("customers","email",$email)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";
		}else if($db->already_exist_inset("customers","username",$username)){
			$_SESSION['msg']="Sorry, your specified username is already taken!";					
		}else if(trim($mobile_number) != NULL && $objdappaDogs->already_exist_mobile("customers","mobile_number",$mobile_number)){
			$_SESSION['msg']="Sorry, your specified mobile number is already taken!";			
		}else{			
			$data['first_name']=$first_name;
			$data['last_name']=$last_name;
			$data['landline_number']=$landline_number;
			$data['mobile_number']=$mobile_number;
			$data['othere_number']=$othere_number;
			$data['partners_number']=$partners_number;
			$data['email']=$email;
				
			$data['physical_address1']=$physical_address1;
			$data['physical_address2']=$physical_address2;
			$data['physical_suburb']=$physical_suburb;
			$data['physical_city']=$physical_city;
			$data['physical_state']=$physical_state;
			$data['physical_post_code']=$physical_post_code;
			
			$data['postal_address1']=$postal_address1;
			$data['postal_address2']=$postal_address2;
			$data['postal_suburb']=$postal_suburb;
			$data['postal_city']=$postal_city;
			$data['postal_state']=$postal_state;
			$data['postal_post_code']=$postal_post_code;
			
				
			$data['SMS_notifications']=$SMS_notifications;
			$data['email_notifications']=$email_notifications;
			$data['mail_notifications']=$mail_notifications;
			
			$data['username']=$username;
			$data['password']=$password;
			$data['sent_email']=$sent_email;
						
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];
			$data['created']='now()';
			
			
			$db->query_insert("customers",$data);	
			
			if($sent_email == 1){//*************  send email to dog's owner
				
				
			}
					
			
			$_SESSION['msg']="Customers information successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{			
		if($db->already_exist_update("customers","id",$_REQUEST['id'],"email",$email)){	
			$_SESSION['msg']="Sorry, your specified email address is already taken!";
		}else if($db->already_exist_update("customers","id",$_REQUEST['id'],"username",$username)){	
			$_SESSION['msg']="Sorry, your specified username is already taken!";	
		}else if(trim($mobile_number) != NULL && $objdappaDogs->already_exist_mobile_update("customers","id",$_REQUEST['id'],"mobile_number",$mobile_number)){
			$_SESSION['msg']="Sorry, your specified mobile number is already taken!";			
		}else{
			$data['first_name']=$first_name;
			$data['last_name']=$last_name;
			$data['landline_number']=$landline_number;
			$data['mobile_number']=$mobile_number;
			$data['othere_number']=$othere_number;
			$data['partners_number']=$partners_number;
			$data['email']=$email;
				
			$data['physical_address1']=$physical_address1;
			$data['physical_address2']=$physical_address2;
			$data['physical_suburb']=$physical_suburb;
			$data['physical_city']=$physical_city;
			$data['physical_state']=$physical_state;
			$data['physical_post_code']=$physical_post_code;
			
			$data['postal_address1']=$postal_address1;
			$data['postal_address2']=$postal_address2;
			$data['postal_suburb']=$postal_suburb;
			$data['postal_city']=$postal_city;
			$data['postal_state']=$postal_state;
			$data['postal_post_code']=$postal_post_code;
			
				
			$data['SMS_notifications']=$SMS_notifications;
			$data['email_notifications']=$email_notifications;
			$data['mail_notifications']=$mail_notifications;
			
			$data['username']=$username;
			$data['password']=$password;
			$data['sent_email']=$sent_email;
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			
			$db->query_update("customers",$data,"id='".$_REQUEST['id'] ."'");
			
			if($sent_email == 1){//*************  send email to dog's owner
				
				
			}
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Customers information successfully updated!";
			
		}
		$general_func->header_redirect($_SESSION['return_url']);
	}
}	

?>
<script language="JavaScript">
function validate(){	
			
	if(!validate_text(document.ff.first_name,1,"Please enter first name"))
		return false;
		
	if(!allLetter(document.ff.first_name,"First name must have alphabet characters only"))
		return false;		
		
	if(!validate_text(document.ff.last_name,1,"Please enter last name"))
		return false;
		
	if(!allLetter(document.ff.last_name,"Last name must have alphabet characters only"))
		return false;
	
	//if(document.ff.email_notifications.checked == true){		
		if(!validate_email(document.ff.email,1,"Enter email address"))
			return false;		
	//}	
	if(document.ff.SMS_notifications.checked == true){		
		if(!validate_text(document.ff.mobile_number,1,"Please enter your xxxxxxxx mobile number"))
			return false;
		
		if(!exact_length(document.ff.mobile_number,8,"Please enter your xxxxxxxx mobile number"))
			return false;				
	}
	
	if(!validate_text(document.ff.username,1,"Please enter username"))
		return false;
		
	if(!passid_validation(document.ff.username,6,12,"Username must be of length between"))
		return false;
		
	if(!validate_text(document.ff.password,1,"Please enter password"))
		return false;
		
	if(!passid_validation(document.ff.password,6,12,"Password must be of length between"))
		return false;			
					
		
}

function change(){
	if (document.ff.other_billing.checked == true){
		document.ff.postal_address1.value=document.ff.physical_address1.value
		document.ff.postal_address2.value=document.ff.physical_address2.value
		document.ff.postal_suburb.value=document.ff.physical_suburb.value
		document.ff.postal_city.value=document.ff.physical_city.value
		document.ff.postal_state.value=document.ff.physical_state.value
		document.ff.postal_post_code.value=document.ff.physical_post_code.value
	} else {
		document.ff.postal_address1.value="";
		document.ff.postal_address2.value="";
		document.ff.postal_suburb.value="";
		document.ff.postal_city.value="";
		document.ff.postal_state.value="";
		document.ff.postal_post_code.value="";		
	}
}
</script>




 <div class="breadcrumb">
      	<p><a href="customers/customers.php">Customers</a> &raquo; <?=$button?> </p>
</div>

<p style="color:#F00; font-size:14px; font-weight:bold; text-align:center;">No Programing (coding) has been made yet.<br />We are working on it.</p>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
    <li class="activeTab"><a style="cursor: pointer;">Add Pets</a></li>              
</ul>

<div class="tabPnlCont">
<div class="tabPnlContInr">
<div class="tableBgStyle" style="background:none;">
  <div class="row">
  	<div class="formTwoPnl">
      <h3>General Information:</h3>
              <ul class="formTwo">
                <li><span>Owner name: </span>
					<select name="customer_id">
                    <option value=""> Select One</option>
                    <?php 	
                    $sql_customer="select id,CONCAT(first_name,' ',last_name) as customer from customers order by first_name,last_name ASC";						
                    $result_customer=$db->fetch_all_array($sql_customer);
					$total_customer=count($result_customer);
					for($customer=0; $customer < $total_customer; $customer++ ){?>
						<option value="<?=$result_customer[$customer]['id']?>" <?=$result_customer[$customer]['id']==$customer_id?'selected="selected"':'';?>><?=$result_customer[$customer]['customer']?></option>
					<?php } ?>
                    </select>
				</li>
                <li><span>Pet name: </span><div style="float:left;"><input type="text" name="name" value="<?=$name?>">
                    <br class="clear" />
                    <div class="optDiv" style="display:block;">
                    	<a>Boxer</a><br />
                        <a>Bagle Hound</a><br />
                        <a>Bakharwal Dog</a><br />
                        <a>Bandogge Mastiff</a><br />
                    </div>
                  </div></li>
                <li><span>Type: </span><select name="grooming_id">
                    <option value=""> Select One</option>
                    <?php 	
                    $sql_type="select id,name from grooming order by name ASC";						
                    $result_type=$db->fetch_all_array($sql_type);
					$total_types=count($result_type);
					for($type=0; $type < $total_types; $type++ ){?>
						<option value="<?=$result_type[$type]['id']?>" <?=$result_type[$type]['id']==$grooming_id?'selected="selected"':'';?>><?=$result_type[$type]['name']?></option>
					<?php } ?>
                    </select></li>
                <li><span>Breed: </span>
                  <div style="float:left;">
                    <select name="breed_id">
                      <option value=""> Select One</option>
                      <?php 	
                    $sql_breed="select id,name from breed order by name ASC";						
                    $result_breed=$db->fetch_all_array($sql_breed);
					$total_breeds=count($result_breed);
					for($breed=0; $breed < $total_breeds; $breed++ ){?>
                      <option value="<?=$result_breed[$breed]['id']?>" <?=$result_breed[$breed]['id']==$breed_id?'selected="selected"':'';?>><?=$result_breed[$breed]['name']?></option>
                      <?php } ?>
                      </select><br /><b class="popup">Add new
                      <!--<div class="disPopup">
           	    <img src="images/cross.png" alt="" class="close" />
                	<h3>Add New</h3>
                    <input type="text" name="">
                    <input type="submit" name="save" value="" class="saveBtn">
                </div>-->
                      </b>
                      </div>
                </li>
                <li><span>Weight: </span><input type="text" name="weight" value="<?=$weight?>"></li>
                <li><span>D.O.B: </span><input type="text" name="date_of_birth" class="datepicker" style="width:100px;"></li>
                <li><span>Gender: </span><select name="gender">
                	 <option value=""> Select One</option>
                   <option value="1" <?=$gender==1?'selected="selected"':'';?>>Male</option>
                   <option value="2" <?=$gender==2?'selected="selected"':'';?>>Female</option>                    	
                </select></li>
                <li><span>Last visit: </span><input type="text" name="last_visit" class="datepicker" style="width:100px;"></li>
                <li>
                  <span>Comments: <br /><input type="text" name="" class="datepicker" style="width:80px;"></span><div style="float:left;">
                  <b>04/08/2013</b><br />
                  <textarea rows="" cols="" name=""></textarea><br /><b class="shwPreCmt">Show Previous Comments</b></div>
                  
                  <div class="shwPrvComt" style="display: none;">
                  <img src="../responsive_lightbox/close2.png" width="16" height="16" alt="" class="close" />
                  <div style="overflow:auto; height:350px; width:260px; padding:10px;">
                    <h6><strong>Dated:</strong> 22nd April 2013</h6>
                    <div class="shwPrvComtInr">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                    </div>
                    <h6><strong>Dated:</strong> 22nd April 2013</h6>
                    <div class="shwPrvComtInr">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                    </div>
                    <h6><strong>Dated:</strong> 22nd April 2013</h6>
                    <div class="shwPrvComtInr">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                    </div>
                  </div>
                  </div>
                  
                </li>
              </ul>
            </div>
            <div class="formTwoPnl">
              <h3>Grooming Information:</h3>
              <ul class="formTwoCbox">
                <li><input type="checkbox" name="burns_earily" value="1" <?=$burns_earily==1?'checked="checked"':'';?>><span>Burns earily</span></li>
                <li><input type="checkbox" name="scared_of_hair_dryer" value="1" <?=$scared_of_hair_dryer==1?'checked="checked"':'';?>><span>Scared of hair dryer</span></li>
                <li><input type="checkbox" name="sensitive_skin" value="1" <?=$sensitive_skin==1?'checked="checked"':'';?>><span>Sensitive Skin</span></li>
             </ul>
             <h4>Handling</h4>
             
             <ul class="formTwo">
                <li>
                	<input type="radio" name="handling_status" value="1" <?=$handling_status==1?'checked="checked"':'';?> style="margin-left:0;">Easy 
                	<input type="radio" name="handling_status" value="2" <?=$handling_status==2?'checked="checked"':'';?>>Average 
                	<input type="radio" name="handling_status" value="3" <?=$handling_status==3?'checked="checked"':'';?>>Challenging</li>
                </ul>
                <h3 style="margin:15px 0 20px; float:left; width:100%;"></h3>
                <ul class="formTwo">
                <li><span>Length: </span><input type="text" name="length" value="<?=$length?>"></li>
                <li><span>Color: </span><input type="text" name="color"  value="<?=$color?>"></li>
                <li><span>Texture: </span><input type="text" name="texture"  value="<?=$texture?>"></li>
                <li>
                  <span>Comments: <br /><input type="text" name="" class="datepicker" style="width:80px;"></span><div style="float:left;">
                  <b>04/08/2013</b><br />
                  <textarea rows="" cols="" name=""></textarea><br /><b class="shwPreCmt">Show Previous Comments</b></div>
                  
                  <div class="shwPrvComt"  style="display: none;">
                  <img src="../responsive_lightbox/close2.png" width="16" height="16" alt="" class="close" />
                  <div style="overflow:auto; height:350px; width:260px; padding:10px;">
                    <h6><strong>Dated:</strong> 22nd April 2013</h6>
                    <div class="shwPrvComtInr">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                    </div>
                    <h6><strong>Dated:</strong> 22nd April 2013</h6>
                    <div class="shwPrvComtInr">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                    </div>
                    <h6><strong>Dated:</strong> 22nd April 2013</h6>
                    <div class="shwPrvComtInr">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                    </div>
                  </div>
                  </div>
                  
                </li>
              </ul>
            </div>
  </div>
  <div class="row">
    <div class="formTwoPnl">
    <h3>Medical Information:</h3>
        <ul class="formTwo">
            <li><span>Vet: </span><select name="vet_id">
                    <option value=""> Select One</option>
                    <?php 	
                    $sql_vet="select id,name from vet order by name ASC";						
                    $result_vet=$db->fetch_all_array($sql_vet);
					$total_vet=count($result_vet);
					for($vet=0; $vet < $total_vet; $vet++ ){?>
						<option value="<?=$result_vet[$vet]['id']?>" <?=$result_vet[$vet]['id']==$vet_id?'selected="selected"':'';?>><?=$result_vet[$vet]['name']?></option>
					<?php } ?>
                    </select></li>
            <li><span>Breed Status: </span><select name="breeding_status_id">
                    <option value=""> Select One</option>
                    <?php 	
                    $sql_breeding_status="select id,name from breeding_status order by name ASC";						
                    $result_breeding_status=$db->fetch_all_array($sql_breeding_status);
					$total_breeding_status=count($result_breeding_status);
					for($breeding_status=0; $breeding_status < $total_breeding_status; $breeding_status++ ){?>
						<option value="<?=$result_breeding_status[$breeding_status]['id']?>" <?=$result_breeding_status[$breeding_status]['id']==$breeding_status_id?'selected="selected"':'';?>><?=$result_breeding_status[$breeding_status]['name']?></option>
					<?php } ?>
                    </select></li>
        </ul>
        <ul class="formTwoCbox">
            <li><input type="checkbox" name="diabetic" value="1" <?=$diabetic==1?'checked="checked"':'';?>><span>Diabetic</span></li>
            <li><input type="checkbox" name="deaf" value="1" <?=$deaf==1?'checked="checked"':'';?>><span>Deaf</span></li>
            <li><input type="checkbox" name="deceased" value="1" <?=$deceased==1?'checked="checked"':'';?>><span>Deceased</span></li>
            <li><input type="checkbox" name="blind" value="1" <?=$blind==1?'checked="checked"':'';?>><span>Blind</span></li>
            <li><input type="checkbox" name="heart_condition" value="1" <?=$heart_condition==1?'checked="checked"':'';?>><span>Heart Condition</span></li>
            <li><input type="checkbox" name="epileltic" value="1" <?=$epileltic==1?'checked="checked"':'';?>><span>Epileltic</span></li>
            <li><input type="checkbox" name="rabies_shot" value="1" <?=$rabies_shot==1?'checked="checked"':'';?>><span>Rabies Shot</span></li>
        </ul>
        <ul class="formTwo">
            <li><span>Vaccinations: </span><textarea rows="" cols="" name="vaccinations"><?=$vaccinations?></textarea></li>
            <li><span>Comments: <br /><input type="text" name="" class="datepicker" style="width:80px;"></span><textarea rows="" cols="" name=""></textarea></li>
        </ul>
        </div>
        <div class="formTwoPnl">
    <h3>Personal Information:</h3>
    <h4>Temperament</h4>
        <ul class="formTwoCbox">
            <li><input type="checkbox" name="aggresive_with_animals" value="1" <?=$aggresive_with_animals==1?'checked="checked"':'';?>><span>Aggresive with animals</span></li>
            <li><input type="checkbox" name="aggresive_with_people" value="1" <?=$aggresive_with_people==1?'checked="checked"':'';?>><span>Aggresive with people</span></li>
            <li><input type="checkbox" name="barker" value="1" <?=$barker==1?'checked="checked"':'';?>><span>Barker</span></li>
            <li><input type="checkbox" name="biter" value="1" <?=$biter==1?'checked="checked"':'';?>><span>Biter</span></li>
            <li><input type="checkbox" name="shy" value="1" <?=$shy==1?'checked="checked"':'';?>><span>Shy</span></li>
            <li><input type="checkbox" name="chews" value="1" <?=$chews==1?'checked="checked"':'';?>><span>Chews</span></li>
            <li><input type="checkbox" name="keep_leash_on" value="1" <?=$keep_leash_on==1?'checked="checked"':'';?>><span>Keep leash on</span></li>
         </ul>   
            <ul class="formTwo">
            <li><span>Comments: <br /><input type="text" name="" class="datepicker" style="width:80px;"></span><textarea rows="" cols="" name=""></textarea></li>
        </ul>
        </div>
  </div>
<div class="submitSection">
    <input type="submit" class="saveBtn" value="" name="save">					
    <input type="button" class="backBtn" onclick="location.href='<?=$_SESSION['return_url']?>'" value="Back" name="back">
    <input type="reset" class="cancelBtn" value="Cancel" name="Cancel">
</div>
</div> 
<br class="clear" />
</div>
</div>


<link rel="stylesheet" href="../responsive_lightbox/page.css" type="text/css">
<link rel="stylesheet" href="../responsive_lightbox/stylesheet.css" type="text/css" charset="utf-8">
<link rel="stylesheet" href="../responsive_lightbox/reveal.css" type="text/css">
<!--<script type="text/javascript" src="../responsive_lightbox/jquery-1.js"></script>
<script type="text/javascript" src="../responsive_lightbox/jquery.js"></script>-->

<?php
include("../foot.htm");
?>