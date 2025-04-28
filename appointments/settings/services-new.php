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
	$sql="select * from service where id=" . (int) $_REQUEST['id'] . "  limit 1";
	$result=$db->fetch_all_array($sql);	
	
	$grooming_id=$result[0]['grooming_id'];	
	$service_name=$result[0]['service_name'];	
	$service_details=$result[0]['service_details'];
		
	
	$sql_services="select pet_size_id,time_required  from service_time  where service_id =" . (int) $_REQUEST['id'] . " and service_type=1 ";
	$result_services=$db->fetch_all_array($sql_services);	
	$total_services=count($result_services);
	
	$service_lengths=array();
	
	for($service=0; $service<$total_services; $service++){
		$service_lengths[$result_services[$service]['pet_size_id']]=$result_services[$service]['time_required'];	
	}
			
	$button="Update";
}else{	
	$grooming_id="";	
	$service_name="";	
	$service_details="";		
	$service_lengths=array();	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="services"){	
	
	$grooming_id=trim($_REQUEST['grooming_id']);	
	$service_name=trim($_REQUEST['service_name']);
	$service_details=trim($_REQUEST['service_details']);	
	
	$service_length=array();	
	$service_length=$_REQUEST['service_length'];

	
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("service","service_name",$service_name,"grooming_id",$grooming_id)){
			$_SESSION['msg']="Sorry, your specified service is already taken!";	
		}else{			
			$data['grooming_id']=$grooming_id;			
			$data['service_name']=$service_name;
			$data['service_details']=$service_details;					
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];
			$data['created']='now()';		
			
			$service_id=$db->query_insert("service",$data);			
			
			if(count($service_length)> 0){
				$service_data = "INSERT INTO `service_time` (`service_id`, `pet_size_id`,`time_required`) VALUES ";	
				foreach($service_length as $size_id=>$time_required){
					$service_data .="('" . $service_id ."', '" . $size_id ."', '" . $time_required ."'), ";					
				}
				
				$service_data = substr($service_data,0,-2);
				$service_data .=";";
				
				$db->query($service_data);				
			}				
			
			$_SESSION['msg']="Service successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{			
		if($db->already_exist_update("service","id",$_REQUEST['id'],"service_name",$service_name,"grooming_id",$grooming_id)){	
			$_SESSION['msg']="Sorry, your specified service is already taken!";
		}else{
			$data['grooming_id']=$grooming_id;			
			$data['service_name']=$service_name;
			$data['service_details']=$service_details;
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			
			$db->query_update("service",$data,"id='".$_REQUEST['id'] ."'");
			
					
			$db->query("delete from service_time where service_id='" . $_REQUEST['id'] . "'");			
			
			if(count($service_length)> 0){
				$service_data = "INSERT INTO `service_time` (`service_id`, `pet_size_id`,`time_required`) VALUES ";	
				foreach($service_length as $size_id=>$time_required){
					$service_data .="('" . $_REQUEST['id']  ."', '" . $size_id ."', '" . $time_required ."'), ";					
				}
				
				$service_data = substr($service_data,0,-2);
				$service_data .=";";
				
				$db->query($service_data);				
			}				
						
						
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Service successfully updated!";
			
			$general_func->header_redirect($_SESSION['return_url']);
		}
	}
}	

?>
<script language="JavaScript">
function validate(){
	if(document.ff.grooming_id.selectedIndex == 0){
		alert("Please choose a grooming type");
		document.ff.grooming_id.focus();
		return false;
	}

	if(!validate_text(document.ff.service_name,1,"Please enter service name"))
		return false;
			
			
	var service_length=parseInt(document.ff.service_length.length);	
	
	for(var i=0;i<service_length;i++){
		if(!validate_numeric(document.ff.service_length[i],1,"Please enter a valid service length (in minute)"))
			return false;
			
		if(parseInt(document.ff.service_length[i].value)<=0){
			alert("Please enter a valid service length (in minute)");
			document.ff.service_length[i].select();
			return false;	
		}		
	 }	
}


</script>
 <div class="breadcrumb">
      	<p><a href="settings/services.php">Services</a> &raquo; <?=$button?> </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;"><?=$button?> Service</a></li>             
                
            </ul>
         <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="services" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
            <input name="submit" type="hidden" value="<?=$button?>" />       
        
              <div class="tabPnlCont">
<div class="tabPnlContInr">

       
   <div class="tabcontArea" style="background:none;">
          	 <h3>General Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">                   
                   <li>Pet Type <span class="star">*</span><br>
					<select name="grooming_id">
                    <option value=""> Select One</option>
                    <?php              
                    $sql_grooming="select id,name from grooming order by display_order + 0 ASC";						
                    $result_grooming=$db->fetch_all_array($sql_grooming);
					$total_grooming=count($result_grooming);
					for($grooming=0; $grooming < $total_grooming; $grooming++ ){?>
						<option value="<?=$result_grooming[$grooming]['id']?>" <?=$result_grooming[$grooming]['id']==$grooming_id?'selected="selected"':'';?>><?=$result_grooming[$grooming]['name']?></option>
					<?php } ?>
                    </select>					
					</li>                  
                   <li style="width: 100%;">Service Name <span class="star">*</span><br><input name="service_name" value="<?=$service_name?>" type="text" /></li>
                  <li style="width: 100%;">Service Details <br>
                  	<textarea name="service_details" style="height: 100px;"><?=$service_details?></textarea>
                  	</li> 
                  </ul>
               </div>
             </div>
             <h3>Service Length:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">   
                 	 <?php              
                    $sql_available_sizes="select id,size_name from pet_available_sizes order by id + 0 ASC";						
                    $result_available_sizes=$db->fetch_all_array($sql_available_sizes);
					$total_available_sizes=count($result_available_sizes);
					for($available_sizes=0; $available_sizes < $total_available_sizes; $available_sizes++ ){?>
						<li style="display: block;"><?=$result_available_sizes[$available_sizes]['size_name']?> (in minute) <span class="star">*</span> <br/><input name="service_length[<?=$result_available_sizes[$available_sizes]['id']?>]" id="service_length" value="<?=$service_lengths[$result_available_sizes[$available_sizes]['id']]?>" type="text"  style="width: 100px;" /></li>
					<?php } ?>                                                
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
           
            
<?php
include("../foot.htm");
?>