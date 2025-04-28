<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


if((int)$_SESSION['admin_access_level'] == 3){		
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if(isset($_REQUEST['staff_id']) && trim($_REQUEST['staff_id']) != NULL){
	$_SESSION['staff_id']=trim($_REQUEST['staff_id']);	
}


if($_SESSION['admin_access_level'] == 2 &&  !$objdappaDogs->his_own_salon_staff($_SESSION['admin_user_id'],$_SESSION['staff_id'])){
	$_SESSION['msg']="Sorry, you do not have the permission to access this staff!";
	$general_func->header_redirect($general_func->admin_url."home.php");	
} 


$data=array();

if(isset($_POST['enter']) && $_POST['enter']=="staff_services"){	
	$staff_salon_service=array();
	$staff_salon_service=$_REQUEST['staff_salon_service'];
	$total_staff_salon_service=count($staff_salon_service);	
	
	$staff_salon_spa_service=array();
	$staff_salon_spa_service=$_REQUEST['staff_salon_spa_service'];
	$total_staff_salon_spa_service=count($staff_salon_spa_service);	
	
	
	$db->query("delete from staff_salon_services where staff_id='" . $_SESSION['staff_id'] . "'");
	
	if($total_staff_salon_service > 0 || $total_staff_salon_spa_service > 0){
			
		$services_data = "INSERT INTO `staff_salon_services` (`service_id`, `salon_id`, `staff_id`,`service_type`) VALUES ";
		
		for($s=0; $s<$total_staff_salon_service; $s++){
			$splited_staff_salon_service=array();	
			$splited_staff_salon_service=explode("~_~",$staff_salon_service[$s]);//********  0-salon/1-service				
			$services_data .="('" . $splited_staff_salon_service[1] ."', '" . $splited_staff_salon_service[0] ."', '" . $_SESSION['staff_id'] ."',1), ";
		}
		
		for($ss=0; $ss<$total_staff_salon_spa_service; $ss++){
			$splited_staff_salon_spa_service=array();	
			$splited_staff_salon_spa_service=explode("~_~",$staff_salon_spa_service[$ss]);//********  0-salon/1-service				
			$services_data .="('" . $splited_staff_salon_spa_service[1] ."', '" . $splited_staff_salon_spa_service[0] ."', '" . $_SESSION['staff_id'] ."',2), ";
		}
				
		$services_data = substr($services_data,0,-2);
		$services_data .=";";	
	
					
		$db->query($services_data);
		
		$_SESSION['msg']="Your selected services has been added to staff -'" . $objdappaDogs->staff_name($_SESSION['staff_id']). "'";
		$general_func->header_redirect($_SERVER['PHP_SELF']);
	}	
}	


$staff_salon_services_query .=" where staff_id='" . $_SESSION['staff_id'] . "'";

if((int)$_SESSION['admin_access_level'] == 2){
	$staff_salon_services_query .=" and salon_id='" . $_SESSION['admin_user_id'] . "'";
}	

$sql_added_services="select CONCAT(salon_id,'~_~',service_id) as salon_service,service_type from staff_salon_services $staff_salon_services_query";
$result_added_services=$db->fetch_all_array($sql_added_services);
$total_added_services=count($result_added_services);
	
$salon_services=array();
$salon_spa_services=array();
	
for($service=0; $service<$total_added_services; $service++){	
	if($result_added_services[$service]['service_type'] == 1)
		$salon_services[]=$result_added_services[$service]['salon_service'];
	else
		$salon_spa_services[]=$result_added_services[$service]['salon_service'];		
}

?>
 <div class="breadcrumb">
      	 	<p><a href="settings/staffs.php">Staff</a>  &raquo; List of Services </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
 
        <ul class="tabBtn">
            	<li class="activeTab"><a style="cursor: pointer;"><?=$objdappaDogs->staff_name($_SESSION['staff_id'])?></a></li>              
 		</ul>
        <div class="tabPnlCont">
<div class="tabPnlContInr">
        <div class="tableBgStyle" style="background:none;">
        <div class="row">
        <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" >
        <input type="hidden" name="enter" value="staff_services" />       	 
       	 	<?php     	 	
       	 	$staff_salon_query .=" where staff_id='" . $_SESSION['staff_id']. "'";
			
			if((int)$_SESSION['admin_access_level'] == 2){
				$staff_salon_query .=" and salon_id='" . $_SESSION['admin_user_id'] . "'";
			}	
       	 	       	 	
       	 	$sql_attached_salons="select id,salon_name from salons where id IN(select DISTINCT(salon_id) from staff_salon $staff_salon_query) "; //attached salon
       	 	$result_attached_salons=$db->fetch_all_array($sql_attached_salons);
			for($salons=0; $salons < count($result_attached_salons); $salons++ ){?>
            <table cellpadding="0" cellspacing="0" class="staffServ">
				<tr>
                	<td width="100%" colspan="4" align="left" valign="top"><h3><?=$result_attached_salons[$salons]['salon_name']?></h3></td>
            	</tr>
            	<tr>
                	<td width="2%" align="left" valign="top">&nbsp;</td>
               	  <td width="49%" align="left" valign="top"><h4>Service name</h4></td>
              </tr> 
              <tr>
	                	<td width="2%" align="left" valign="top"></td>
           	      		<td width="49%" align="left" valign="top" class="core-ser">
	           	      		<ul>             	
							<?php 
							$sql_salons_services="select service_id,service_name,service_details";
							$sql_salons_services .=" from salon_services ss left join service s on ss.service_id=s.id";
							$sql_salons_services .=" where salon_id='" . $result_attached_salons[$salons]['id'] . "' and service_type=1 order by service_name";
							
							$result_salons_services=$db->fetch_all_array($sql_salons_services);
							$total_salons_services=count($result_salons_services);
							
							
							for($services=0; $services < $total_salons_services; $services++ ){				 
								$value_salons_service=$result_attached_salons[$salons]['id']."~_~".$result_salons_services[$services]['service_id'];
								?>				
								
				           	      			<li> <input type="checkbox" name="staff_salon_service[]" id="staff_salon_service" <?=in_array($value_salons_service,$salon_services)?'checked="checked"':'';?>  value="<?=$value_salons_service?>" ><span><?=$result_salons_services[$services]['service_name']?></span>
				                 				<?php if(trim($result_salons_services[$services]['service_details']) != NULL){?> 
				                 					<a onmouseout="hideddrivetip()" ;="" onmouseover="ddrivetip('<?=$result_salons_services[$services]['service_details']?>')"><img src="images/i.png" alt="" /></a>
				                 		 		<?php } ?>                 		 
				                 		 	</li>           	      		
				           	      		
							<?php } //************  End of services
							?>
							</ul>
          				</td> 
            		</tr>
            		<tr>
                		<td width="2%" align="left" valign="top">&nbsp;</td>
               	  		<td width="49%" align="left" valign="top"><h4>Spa Treatments</h4></td>
              		</tr> 
              		<tr>
	                	<td width="2%" align="left" valign="top"></td>
           	      		<td width="49%" align="left" valign="top" class="core-ser">
	           	      		<ul> 
		           	      		<?php 
								$sql_salons_spa_services="select service_id,spa_service_name,spa_service_details";
								$sql_salons_spa_services .=" from salon_services ss left join spa_service s on ss.service_id=s.id";
								$sql_salons_spa_services .=" where salon_id='" . $result_attached_salons[$salons]['id'] . "' and service_type=2 order by spa_service_name";
								
								$result_salons_spa_services=$db->fetch_all_array($sql_salons_spa_services);
								$total_salons_spa_services=count($result_salons_spa_services);
								
								
								for($spa=0; $spa < $total_salons_spa_services; $spa++ ){				 
									$value_salons_spa_service=$result_attached_salons[$salons]['id']."~_~".$result_salons_spa_services[$spa]['service_id'];
									?>				
										<li><input type="checkbox" name="staff_salon_spa_service[]" id="staff_salon_spa_service" <?=in_array($value_salons_spa_service,$salon_spa_services)?'checked="checked"':'';?>  value="<?=$value_salons_spa_service?>" ><span><?=$result_salons_spa_services[$spa]['spa_service_name']?></span>
					                 		<?php if(trim($result_salons_services[$spa]['spa_service_details']) != NULL){?> 
					                 				<a onmouseout="hideddrivetip();" onmouseover="ddrivetip('<?=$result_salons_services[$spa]['spa_service_details']?>');"><img src="images/i.png" alt="" /></a>
					                 		 <?php } ?>                 		 
					                 	</li>
								<?php } //************  End of spa services
								?>  
	           	      		</ul>
          				</td> 
            		</tr>
            		<tr>
                		<td width="100%" height="20px;" colspan="4" align="left" valign="top"></td>
            		</tr>
            	</table>
			<?php } ?> 
       	 <div class="submitSection">
            	<?php if($total_added_services == 0 ){?>
	       <input name="save" type="submit" value="" class="saveBtn" />					
            	<?php }else{?>            		
					 <input name="update" type="submit" value="" class="updateBtn" />
            	<?php }?> 
            	<input name="back" type="button" value="Back" onclick="location.href='settings/staffs.php'" class="backBtn" />                
            </div>       	 
       	 </form>
        </div>
        </div>
<br class="clear" />
</div>
</div>

<?php
include_once("../foot.htm");
