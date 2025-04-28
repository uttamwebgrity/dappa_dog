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
	
	
	$password="";
	$sent_email=1;
	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="customer"){
	
	$first_name=ucfirst($_REQUEST['first_name']);
	$last_name=ucfirst($_REQUEST['last_name']);
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
	
		
	
	$password=trim($_REQUEST['password']);
	$sent_email=(isset($_REQUEST['sent_email']) && $_REQUEST['sent_email']==1)?1:0;
	
		
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("customers","email",$email) && trim($email) != NULL){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";							
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
			
			$data['password']=$general_func->genTicketString();
			$data['sent_email']=$sent_email;
						
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];
			$data['created']='now()';
			
			
			$db->query_insert("customers",$data);	
			
			$_SESSION['msg']="Customer's information successfully added";
			
			if($sent_email == 1 && trim($email) != NULL){//*************  send email to dog's owner				
				$sql_email_template="select template_subject,template_content from email_template where id=6 limit 1";
				$result_email_template = $db -> fetch_all_array($sql_email_template);
					
				if(count($result_email_template) == 1){
					$message_content=$result_email_template[0]['template_content'];	
							
					$message_content=str_replace("#dog_owner_name#",$first_name . " " . $last_name,$message_content);
					$message_content=str_replace("#email_address# ",$email,$message_content);
					$message_content=str_replace("#password#",$data['password'],$message_content);	
					
					$message_content=str_replace("#customer_login_link#",$general_func->site_url."login.php",$message_content);	
					$message_content=str_replace("#contact_link#",$general_func->site_url."contact.php",$message_content);	
											
					$receiver_info = array();
					$receiver_info['subject'] = $result_email_template[0]['template_subject'];	
					$receiver_info['content'] = $message_content;
					$receiver_info['email'] = $email;
					$sendmail -> register_welcome_to_user($receiver_info, $general_func -> admin_email_id, $general_func -> site_title, $general_func -> site_url);				
				}
				
				
				$_SESSION['msg'] .= " and login information has been sent to the specified email address!";
			}				
			
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{			
		if($db->already_exist_update("customers","id",$_REQUEST['id'],"email",$email)  && trim($email) != NULL){	
			$_SESSION['msg']="Sorry, your specified email address is already taken!";	
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
			
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			
			$db->query_update("customers",$data,"id='".$_REQUEST['id'] ."'");
			
			$_SESSION['msg']="Customer's information successfully updated";
			
			if($sent_email == 1  && trim($email) != NULL){//*************  send email to dog's owner
				$sql_email_template="select template_subject,template_content from email_template where id=6 limit 1";
				$result_email_template = $db -> fetch_all_array($sql_email_template);
					
				if(count($result_email_template) == 1){
					$message_content=$result_email_template[0]['template_content'];	
							
					$message_content=str_replace("#dog_owner_name#",$first_name . " " . $last_name,$message_content);
					$message_content=str_replace("#email_address# ",$email,$message_content);
					$message_content=str_replace("#password#",$password,$message_content);	
					
					$message_content=str_replace("#customer_login_link#",$general_func->site_url."login.php",$message_content);	
					$message_content=str_replace("#contact_link#",$general_func->site_url."contact.php",$message_content);	
											
					$receiver_info = array();
					$receiver_info['subject'] = $result_email_template[0]['template_subject'];	
					$receiver_info['content'] = $message_content;
					$receiver_info['email'] = $email;
					$sendmail -> register_welcome_to_user($receiver_info, $general_func -> admin_email_id, $general_func -> site_title, $general_func -> site_url);				
				}
				
				
				$_SESSION['msg'] .= " and login information has been sent to the specified email address!";			
				
				
				
			}
			
			
			
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
	
	
	if(document.ff.SMS_notifications.checked == true){		
		if(!validate_text(document.ff.mobile_number,1,"Please enter your xxxxxxxx mobile number"))
			return false;
		
		if(!exact_length(document.ff.mobile_number,8,"Please enter your xxxxxxxx mobile number"))
			return false;				
	}
	

		
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

document.ff.first_name.focus();

</script>

<div class="breadcrumb">
  <p>Ticket Information<?php /*?>&raquo;
    <?=$button?><?php */?>
  </p>
</div>
<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
<div class="row">
  <div class="errorMsg">
    <?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
  </div>
</div>
<?php } ?>

<form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
  <input type="hidden" name="enter" value="customer" />
  <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
  <input type="hidden" name="password" value="<?=$password?>" />
  <input name="submit" type="hidden" value="<?=$button?>" />
  <div class="tabPnlCont">
    <div class="tabPnlContInr">
      <div class="tabcontArea" style="background:none;">
       <?php if($button !="Add New"){?>
      
      <?php } ?>
      
      
      
    <div class="row">
        <div class="formTwoPnl">
        	<h3>Ticket Information</h3>
        	<p class="formTwoDplyTwo">
        	Ticket ID  :  <span>A001</span> Ticket Status  :  <span>Open</span><br />
        	Date Created  :  <span>03.04.2013</span></p>
            <div class="adProdTkt"><span>Add Product (s) to Ticket</span>
            	<div>
                	<ul>
                        <li><input name="" type="checkbox" value="" /> Deshedding</li>
                        <li><input name="" type="checkbox" value="" /> Calming Canine</li>
                        <li><input name="" type="checkbox" value="" /> Citrus Sensation</li>
                        <li><input name="" type="checkbox" value="" /> Exceptional Ears</li>
                        <li><input name="" type="checkbox" value="" /> Colour me Pretty</li>
                        <li><input name="" type="checkbox" value="" /> Perfect Pedicure</li>
                        <li><input name="" type="checkbox" value="" /> Kissable</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="formTwoPnl">
        	<h3>Customer Information</h3>
        	<img src="images/ticketIcon.png" alt="" class="tktIco" />
            <p class="formTwoDplyTwo">
            Client ID  :  <span>1001</span><br />
            Name  :  <span>Alexender Popov</span><br />
            Balance  :  <span>$ 10.00</span></p>
        </div>
    <br class="clear" />
    </div>
  <div class="row">
  		<div class="ticketBot">
        	<div class="ticketPnlOne">
            	<h5>Totals</h5>
                <p>Subtotal  :$ 105.00</p>
                <p><span style="color:#f3811f">Total : $ 105.00</span><br />
                <span style="color:#3d93b8">Tender  :$ 105.00</span><br />
                <span>Due  :$ 0.00</span></p>
            </div>
            <div class="ticketPnlTwo">
            	<h5>Tender</h5>
                <ul class="ticktForm">
                    <li><span>Type of Payment 1  :</span> <select><option>Cash</option></select></li>
                    <li><span>Comment  :</span> <input name="" type="text" /></li>
                    <li><span>Tender Amount  :</span> <input name="" type="text" /></li>
                    <li><span><input name="" type="submit" class="tktBtn" value="Save Ticket" /></span><input name="" type="submit" class="tktBtn2" value="Save & Close Ticket" /></li>
                </ul>
            </div>
  		</div>
  </div>

        
        
        
        <br class="clear" />
      </div>
      <br class="clear" />
    </div>
  </div>
</form>
<script>
	document.ff.first_name.focus();
	
</script>
<?php
include("../foot.htm");
?>