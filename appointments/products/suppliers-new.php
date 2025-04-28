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
	$sql="select * from product_supplier where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	
	$first_name=$result[0]['first_name'];
	$last_name=$result[0]['last_name'];
	$landline_number=$result[0]['landline_number'];
	$mobile_number=$result[0]['mobile_number'];	
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
	
	$button="Update";
}else{	
	$first_name="";
	$last_name="";
	$landline_number="";
	$mobile_number="";	
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
	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="supplier"){
	
	$first_name=$_REQUEST['first_name'];
	$last_name=$_REQUEST['last_name'];
	$landline_number=$_REQUEST['landline_number'];
	$mobile_number=$_REQUEST['mobile_number'];
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
		
	
	
	if($_POST['submit']=="Add New"){		
		if(trim($email) != NULL && $db->already_exist_inset("product_supplier","email",$email)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";				
		}else if(trim($mobile_number) != NULL && $objdappaDogs->already_exist_mobile("product_supplier","mobile_number",$mobile_number)){
			$_SESSION['msg']="Sorry, your specified mobile number is already taken!";			
		}else{			
			$data['first_name']=$first_name;
			$data['last_name']=$last_name;
			$data['landline_number']=$landline_number;
			$data['mobile_number']=$mobile_number;			
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
			
						
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];
			$data['created']='now()';
			
			
			$db->query_insert("product_supplier",$data);			
			
			$_SESSION['msg']="Supplier information successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{			
		if(trim($email) != NULL && $db->already_exist_update("product_supplier","id",$_REQUEST['id'],"email",$email)){	
			$_SESSION['msg']="Sorry, your specified email address is already taken!";
		}else if(trim($mobile_number) != NULL && $objdappaDogs->already_exist_mobile_update("product_supplier","id",$_REQUEST['id'],"mobile_number",$mobile_number)){
			$_SESSION['msg']="Sorry, your specified mobile number is already taken!";			
		}else{
			$data['first_name']=$first_name;
			$data['last_name']=$last_name;
			$data['landline_number']=$landline_number;
			$data['mobile_number']=$mobile_number;
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
			
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			
			$db->query_update("product_supplier",$data,"id='".$_REQUEST['id'] ."'");
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Supplier information successfully updated!";
			
			$general_func->header_redirect($_SESSION['return_url']);
		}
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
	
	if(document.ff.email.value != ""){		
		if(!validate_email(document.ff.email,1,"Enter email address"))
			return false;		
	}	
	if(document.ff.mobile_number.value != ""){		
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
</script>
 <div class="breadcrumb">
      	<p><a href="products/suppliers.php">Suppliers</a> &raquo; <?=$button?> </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;"><?=$button?> Supplier</a></li>              
                
            </ul>
         <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="supplier" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
      
            <input name="submit" type="hidden" value="<?=$button?>" />
  <div class="tabPnlCont">
<div class="tabPnlContInr">      
        
              <div class="tabcontArea" style="background:none;">
          	 <h3>Personal Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">
                   
                   <li>First Name <span class="star">*</span><br><input name="first_name" value="<?=$first_name?>" type="text" /></li>
                   <li>Last Name <span class="star">*</span><br><input name="last_name" value="<?=$last_name?>" type="text" /></li>
                   <li>Landline Number<br><input name="landline_number" value="<?=$landline_number?>" type="text" /></li>
                   <li>Mobile Number (SMS Number)<br><input name="mobile_number" value="<?=$mobile_number?>" type="text" style="background:#fff; width:281px;" /></li>
                   <li>Email<br><input name="email" value="<?=$email?>"  type="text" /></li>             
                 </ul>
               </div>
             </div>
            <h3>Physical Address:</h3>
            <div class="row">
              <div class="formCenter">
                <ul class="formOne">
                  <li>Address line 1<br><input name="physical_address1" value="<?=$physical_address1?>" type="text" /></li>
                  <li>Address line 2<br><input name="physical_address2" value="<?=$physical_address2?>" type="text" /></li>
                  <li>Suburb<br><input name="physical_suburb"   value="<?=$physical_suburb?>" type="text" /></li>
                  <li>City<br><input name="physical_city"  value="<?=$physical_city?>" type="text" /></li>
                  <li>State<br><input name="physical_state"  value="<?=$physical_state?>" type="text" /></li>
                  <li>Post code<br><input name="physical_post_code"  value="<?=$physical_post_code?>" type="text" /></li>
                  
                </ul>
              </div>
            </div>
            <h3> Postal Address:</h3>
            <div class="row">
              <div class="formCenter">
                <ul class="formOne">
                  <li style="width:100%;"><input type="checkbox" name="other_billing" value="1" onclick="change();"  /> Same as Physical Address</li>
                  <li>Address line 1<br><input name="postal_address1" value="<?=$postal_address1?>" type="text" /></li>
                  <li>Address line 2<br><input name="postal_address2" value="<?=$postal_address2?>" type="text" /></li>
                  <li>Suburb<br><input name="postal_suburb"   value="<?=$postal_suburb?>" type="text" /></li>
                  <li>City<br><input name="postal_city"  value="<?=$postal_city?>" type="text" /></li>
                  <li>State<br><input name="postal_state"  value="<?=$postal_state?>" type="text" /></li>
                  <li>Post code<br><input name="postal_post_code"  value="<?=$postal_post_code?>" type="text" /></li>
                  
                </ul>
              </div>
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
            
            <br class="clear" />
</div>
</div>
            
          </div>
          
          
          
          
          
          </form>
           
       <script>
	document.ff.first_name.focus();
	
</script>     
<?php
include("../foot.htm");
?>