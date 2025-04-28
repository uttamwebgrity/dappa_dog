<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


if($_SESSION['admin_access_level'] != 1){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$data=array();
	$data['option_value']=$_REQUEST['site_title'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='site_title'");
	
	$data=array();
	$data['option_value']=$_REQUEST['admin_recoed_per_page'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='admin_recoed_per_page'");
	
	$data=array();
	$data['option_value']=$_REQUEST['global_meta_title'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='global_meta_title'");
	
	$data=array();
	$data['option_value']=$_REQUEST['global_meta_keywords'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='global_meta_keywords'");
	
	$data=array();
	$data['option_value']=$_REQUEST['global_meta_description'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='global_meta_description'");
	
	$data=array();
	$data['option_value']=$_REQUEST['address'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='address'");
	
	$data=array();
	$data['option_value']=$_REQUEST['phone'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='phone'");
	
	$data=array();
	$data['option_value']=$_REQUEST['email'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='email'");
	
	$data=array();
	$data['option_value']=$_REQUEST['facebook'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='facebook'");
	
	
	$data=array();
	$data['option_value']=$_REQUEST['opening_time'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='opening_time'");
	
	$data=array();
	$data['option_value']=$_REQUEST['closing_time'];
	$db->query_update("tbl_options",$data,"admin_id=1 and option_name='closing_time'");
	 
		
	$size_details=array();	
	$size_details=$_REQUEST['size_details'];
	
	
	
	if(count($size_details)> 0){		
		foreach($size_details as $size_id=>$details){
			$db->query("UPDATE `pet_available_sizes` set `size_details`='" . $details ."' where id='" . $size_id ."'");					
		}		
	}	
		
	$_SESSION['msg']="General settings successfully saved!";
	
	
	$general_func->header_redirect($_SERVER['PHP_SELF']);
}




$sql="select option_name,option_value from tbl_options where admin_id=1 and (option_name='site_title' or option_name='admin_recoed_per_page' or option_name='global_meta_title' or";
$sql .=" option_name='opening_time' or option_name='closing_time' or ";
$sql .=" option_name='global_meta_keywords' or option_name='global_meta_description' or option_name='address' or option_name='phone' or option_name='email' or option_name='facebook')";



$result=$db->fetch_all_array($sql);

if(count($result) > 0){
	for($i=0; $i <count($result); $i++){
		$$result[$i]['option_name']=trim($result[$i]['option_value']);
	}
}else{
	$site_title="";
	$admin_recoed_per_page="";
	$global_meta_title="";
	$global_meta_keywords="";
	$global_meta_description="";
	$address="";
	$phone="";
	$email="";
	$facebook="";
	$opening_time="540";
	$closing_time="1140";
}

?>
<script language="javascript" type="text/javascript"> 
function validate(){
	if(!validate_text(document.ff.site_title,1,"Site title should not be blank"))
		return false;	
	

	if(!validate_text(document.ff.phone,1,"Phone should not be blank"))
		return false;
		
				
	if(!validate_text(document.ff.email,1,"Email should not be blank"))
		return false;	
		
		
		
	if(!validate_integer(document.ff.admin_recoed_per_page,1,"Admin recoed per page should not be blank and must be a valid [0-9] number"))
		return false;
	
	
	 	
	if(parseInt(document.ff.opening_time.value) >= parseInt(document.ff.closing_time.value)){
		alert("Closing time must be greater than opening time");
		document.ff.closing_time.focus();
		return false;			
	}	
		
			
		
	if(!validate_text(document.ff.address,1,"Address should not be blank"))
		return false;
		
	
	var size_details=parseInt(document.ff.size_details.length);	
	
	for(var i=0;i<size_details;i++){
		if(!validate_text(document.ff.size_details[i],1,"Pet size information should not be blank"))
			return false;
	}	
		
	if(!validate_text(document.ff.global_meta_title,1,"Global meta title should not be blank"))
		return false;		
			
}
</script>

<div class="breadcrumb">
      	<p>Settings &raquo; General Settings</p>
</div>
<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>

<ul class="tabBtn">
 <?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
  <li class="activeTab"><a style="cursor: pointer;">General Settings</a></li>              
                
            </ul>
        <form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="ff" onsubmit="return validate()">
    <input type="hidden" name="enter" value="yes" /> 
        
        		<div class="tabPnlCont">
<div class="tabPnlContInr">
              <div class="tabcontArea" style="background:none">
          	 <h3>General Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">                   
                   <li>Site Title <span class="star">*</span><br><input name="site_title" type="text" value="<?=$site_title?>" /></li>                  
                   <li>Phone <span class="star">*</span><br><input name="phone" value="<?=$phone?>" type="text" /></li>
                   <li>Email <span class="star">*</span><br><input name="email" value="<?=$email?>" type="text" /></li>
                   <li>Recoed per page <span class="star">*</span><br><input name="admin_recoed_per_page" value="<?=$admin_recoed_per_page?>" type="text" />&nbsp;&nbsp;<small>(Admin Panel)</small></li>
                  
                    <li>Opening Time (24 hours)<span class="star">*</span><br>
                    	<select name="opening_time">
                    	<?php for ($i = 15; $i <= 1430; $i += 15) {
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
                    	<?php for ($i = 15; $i <= 1430; $i += 15) {
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
                    <li>Facebook<br><input name="facebook" value="<?=$facebook?>" type="text" /></li>
                     <li style="width: 100%;">Address <span class="star">*</span><br><textarea  name="address" style="width: 300px; height: 100px;"><?=$address?></textarea></li>     
                 </ul>
               </div>
             </div>
             
              <h3>Pet Size Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">   
                 	 <?php              
                    $sql_available_sizes="select id,size_name,size_details from pet_available_sizes order by id + 0 ASC";						
                    $result_available_sizes=$db->fetch_all_array($sql_available_sizes);
					$total_available_sizes=count($result_available_sizes);
					for($available_sizes=0; $available_sizes < $total_available_sizes; $available_sizes++ ){?>
						<li style="display: block;"><?=$result_available_sizes[$available_sizes]['size_name']?><span class="star"> *</span> <br/>
							<textarea name="size_details[<?=$result_available_sizes[$available_sizes]['id']?>]" id="size_details" style="width: 300px; height: 100px;"><?=$result_available_sizes[$available_sizes]['size_details']?></textarea>
						</li>
					<?php } ?>                                                
                 </ul>
               </div>
             </div> 
             
             
            <h3>Meta Information (for SEO):</h3>
            <div class="row">
              <div class="formCenter">
                <ul class="formOne">
                  <li>Title <span class="star">*</span><br><input name="global_meta_title" value="<?=$global_meta_title?>" type="text" /></li>
                  <li>Keywords<br><input name="global_meta_keywords" value="<?=$global_meta_keywords?>" type="text" /></li>
                  <li>Description<br><input name="global_meta_description"   value="<?=$global_meta_description?>" type="text" /></li>
                  
                  
                </ul>
              </div>
            </div>            
            <div class="submitSection">
            	  <input name="update" type="submit" value="<?=$button?>" class="updateBtn" />
            	<input name="back" type="button" value="Back" onclick="location.href='home.php'" class="backBtn" />
                
            </div>
          </div>
          
          <br class="clear" />
</div>
</div>
          </form>
           
            
<?php
include("../foot.htm");
?>