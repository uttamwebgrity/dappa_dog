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
	$sql="select * from spa_service where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	
	
	$spa_service_name=$result[0]['spa_service_name'];	
	$spa_service_details=$result[0]['spa_service_details'];
		
	$services=array();
		
	$sql_service="select service_id from service_spa_service where spa_service_id='" . $_REQUEST['id'] . "' and service_type=2";
	$result_service=$db->fetch_all_array($sql_service);
	$total_service=count($result_service);
		
	
	for($service=0; $service<$total_service; $service++){
		$services[]=$result_service[$service]['service_id'];	
	}
	
	
	$sql_services="select pet_size_id,time_required  from service_time  where service_id =" . (int) $_REQUEST['id'] . " and service_type=2";
	$result_services=$db->fetch_all_array($sql_services);	
	$total_services=count($result_services);
	
	$service_lengths=array();
	
	for($service=0; $service<$total_services; $service++){
		$service_lengths[$result_services[$service]['pet_size_id']]=$result_services[$service]['time_required'];	
	}
	
	
			
	$button="Update";
}else{	
	$spa_service_name="";	
	$spa_service_details="";
	$services=array();		
	$service_lengths=array();	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="services"){	
	$spa_service_name=trim($_REQUEST['spa_service_name']);
	$spa_service_details=trim($_REQUEST['spa_service_details']);
		
	$service_length=array();	
	$service_length=$_REQUEST['service_length'];
	
	$services=array();	
	$services=$_REQUEST['services'];

	
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("spa_service","spa_service_name",$spa_service_name)){
			$_SESSION['msg']="Sorry, your specified spa treatment is already taken!";	
		}else{			
			$data['spa_service_name']=$spa_service_name;
			$data['spa_service_details']=$spa_service_details;			
							
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];
			$data['created']='now()';		
			
			$spa_service_id=$db->query_insert("spa_service",$data);			
			
			//*************  Dog sizes service length *************************//
			if(count($service_length)> 0){
				$service_data = "INSERT INTO `service_time` (`service_id`, `pet_size_id`,`time_required`,`service_type`) VALUES ";	
				foreach($service_length as $size_id=>$time_required){
					$service_data .="('" . $spa_service_id ."', '" . $size_id ."', '" . $time_required ."',2), ";					
				}
				
				$service_data = substr($service_data,0,-2);
				$service_data .=";";
				
				$db->query($service_data);				
			}
			
			//*************  services *************************//
			if(count($services)> 0){
				$spa_services_id_data = "INSERT INTO `service_spa_service` (`service_id`, `spa_service_id`) VALUES ";
				
				for($p=0; $p<count($services); $p++){
					$spa_services_id_data .="('" . $services[$p] ."', '" . $spa_service_id ."'), ";
				}
				
				$spa_services_id_data = substr($spa_services_id_data,0,-2);
				$spa_services_id_data .=";";
				
				$db->query($spa_services_id_data);
			}
			
						
			
			$_SESSION['msg']="Spa treatment successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{			
		if($db->already_exist_update("spa_service","id",$_REQUEST['id'],"spa_service_name",$spa_service_name)){	
			$_SESSION['msg']="Sorry, your specified spa treatment is already taken!";
		}else{
			$data['spa_service_name']=$spa_service_name;
			$data['spa_service_details']=$spa_service_details;
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			
			
				//*************  services *************************//
			$db->query_update("spa_service",$data,"id='".$_REQUEST['id'] ."'");
			
			$db->query("delete from service_spa_service where spa_service_id='" . $_REQUEST['id'] . "'");	
			if(count($services)> 0){
				$spa_services_id_data = "INSERT INTO `service_spa_service` (`service_id`, `spa_service_id`) VALUES ";
				
				for($p=0; $p<count($services); $p++){
					$spa_services_id_data .="('" . $services[$p] ."', '" . $_REQUEST['id'] ."'), ";
				}
				
				$spa_services_id_data = substr($spa_services_id_data,0,-2);
				$spa_services_id_data .=";";
				
				$db->query($spa_services_id_data);
			}
						
			//*************  Dog sizes service length *************************//		
			$db->query("delete from service_time where service_id='" . $_REQUEST['id'] . "' and service_type=2");			
			
			if(count($service_length)> 0){
				$service_data = "INSERT INTO `service_time` (`service_id`, `pet_size_id`,`time_required`,`service_type`) VALUES ";	
				foreach($service_length as $size_id=>$time_required){
					$service_data .="('" . $_REQUEST['id'] ."', '" . $size_id ."', '" . $time_required ."',2), ";					
				}
				
				$service_data = substr($service_data,0,-2);
				$service_data .=";";
				
				$db->query($service_data);			
			}	
				
			if($db->affected_rows > 0)
				$_SESSION['msg']="Spa treatment successfully updated!";
			
			$general_func->header_redirect($_SESSION['return_url']);
		}
	}
}	

?>
<script language="JavaScript">
function validate(){
	
	if(!validate_text(document.ff.spa_service_name,1,"Please enter spa treatment name"))
		return false;		
		
	var services_total=parseInt(document.ff.services.length);
	var services_checked=false;
	
	for(var index=0; index < services_total; index++){
		if(document.ff.services[index].checked == true){
			services_checked = true;
			break;			
		}
	}
	
	if(services_checked == false){
		alert("Please choose at least a service");	
		return false;	
	}	
		
			
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
      	<p><a href="settings/spa-treatments.php">Spa Treatments</a> &raquo; <?=$button?></p>
      	
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;"><?=$button?> Spa Treatment</a></li>             
                
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
                 	 <li style="width: 100%;">Spa Treatment Name <span class="star">*</span><br><input name="spa_service_name" value="<?=$spa_service_name?>" type="text" /></li>
                  <li style="width: 100%;">Spa Treatment Details <br>
                  	<textarea name="spa_service_details" style="height: 100px;"><?=$spa_service_details?></textarea>
                  	</li>                  
                 
                  <li style="width: 100%;">Services <span class="star">*</span><br>
                  	 <ul class="formTwoCbox">                 	
                  	<?php
                   	$sql_service="select id,service_name from service";
					$result_service=$db->fetch_all_array($sql_service);
					$total_service=count($result_service);					
					for($service=0; $service < $total_service; $service++ ){?>
	               	<li><input type="checkbox" name="services[]" id="services" <?=in_array($result_service[$service]['id'],$services)?'checked="checked"':'';?>  value="<?=$result_service[$service]['id']?>" >
	                        <span><?=$result_service[$service]['service_name']?></span>	</li>				
	                        <?php }	?>
                  	</ul>
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
                <input name="Cancel" type="reset" value="Cancel" class="cancelBtn" />
            </div>
          </div>
          
   <br class="clear" />
</div>
</div>       
          
          
          </form>
           
            
<?php
include("../foot.htm");
?>