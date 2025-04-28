<?php
include_once("includes/configuration.php");


$salon_id=$_REQUEST['salon_id'];
$service_id=$_REQUEST['service_id'];
$type=$_REQUEST['type'];


if($type == "collect_services"){
	
	if(intval($salon_id) > 0){ ?>
	<div class="bnrFrmDyFlds">			
		<div class="bnrFormPnlRow">
     		<ul class="checkLstFrm">
	      	<?php      	
	      	$sql_services="select service_id,service_name,service_details";
			$sql_services .=" from salon_services ss left join service s on ss.service_id=s.id";
			$sql_services .=" where salon_id='" . $salon_id . "' and service_type=1 order by service_name";
							
			$result_services=$db->fetch_all_array($sql_services);
			$total_services=count($result_services);
			for($service=0; $service < $total_services; $service++ ){?>
				<li><input name="service_id" onclick="show_spa_services('<?=trim($salon_id)?>','<?=$result_services[$service]['service_id']?>','salon_spa_services','collect_spa')" type="radio" value="<?=$result_services[$service]['service_id']?>" <?=(trim($service_id) != NULL && trim($service_id)==$result_services[$service]['service_id'])?'checked="checked"':''; ?> /> <span><?=$result_services[$service]['service_name']?>
					<?php if(trim($result_services[$service]['service_details']) != NULL){?>
		               <a onmouseout="hideddrivetip();" onmouseover="ddrivetip('<?=addslashes($result_services[$service]['service_details'])?>')"><img src="images/i.png" alt="" /></a>
					<?php }?></span>
				</li>
			<?php }	?>
	     	</ul>
   		</div>	
		<h2>Spa Treatments</h2>
    	<div class="bnrFormPnlRow" id="salon_spa_services">
	    	<ul class="checkLstFrm">		
		   	<?php
	        	$sql_spa_service="select spa_service_name,spa_service_details from spa_service order by spa_service_name ASC";
	            $result_spa_service=$db->fetch_all_array($sql_spa_service);
				$total_spa_service=count($result_spa_service);
				for($spa_service=0; $spa_service < $total_spa_service; $spa_service++ ){//*****  service ?>
					<li><label><input name="" type="checkbox" disabled="disabled"  value="" /> <span style="color: #8D8F90;"><?=$result_spa_service[$spa_service]['spa_service_name']?></span></label>
					<?php if(trim($result_spa_service[$spa_service]['spa_service_details']) != NULL){?>
				          <a onmouseout="hideddrivetip()" onmouseover="ddrivetip('<?=addslashes($result_spa_service[$spa_service]['spa_service_details'])?>')"><img src="images/i.png" alt="" /></a>
					<?php }?></li>
			<?php } ?>    
		    </ul>  
    	</div>
    	<h2>Size of your pet</h2>
    	<div class="bnrFormPnlRow">
    		<ul class="checkLstFrm2">
        	<?php
        	$sql_available_sizes="select id,size_short_name,size_details from pet_available_sizes order by id + 0 ASC";
            $result_available_sizes=$db->fetch_all_array($sql_available_sizes);
			$total_available_sizes=count($result_available_sizes);
			for($available_sizes=0; $available_sizes < $total_available_sizes; $available_sizes++ ){//*****  service ?>
				<li><label><input name="pet_size"   type="radio" value="<?=$result_available_sizes[$available_sizes]['id']?>" /> <span><?=$result_available_sizes[$available_sizes]['size_short_name']?></span></label>
				<?php if(trim($result_available_sizes[$available_sizes]['size_details']) != NULL){?>
			    	<a onmouseout="hideddrivetip()" onmouseover="ddrivetip('<?=addslashes($result_available_sizes[$available_sizes]['size_details'])?>')"><img src="images/i.png" alt="" /></a>
				<?php }?>
				</li>
			<?php } ?>
  			</ul>
		</div>
  	</div>		
	<?php }else{?>
		<div class="bnrFrmDyFldsDis">                 
        	<div class="bnrFormPnlRow">
            	<ul class="checkLstFrm">
                <?php
                $sql_services="select service_name,service_details from service order by service_name ASC";
                $result_services=$db->fetch_all_array($sql_services);
				$total_services=count($result_services);
				for($service=0; $service < $total_services; $service++ ){//*****  service ?>
				<li><label><input name="services" disabled="disabled" type="radio" value="" /> <span><?=$result_services[$service]['service_name']?></span></label>
					<?php if(trim($result_services[$service]['service_details']) != NULL){?>
			        	<a onmouseout="hideddrivetip()" onmouseover="ddrivetip('<?=addslashes($result_services[$service]['service_details'])?>')"><img src="images/i.png" alt="" /></a>
					<?php }?></li>
				<?php } ?>
              	</ul>
                </div>
                <h2>Spa Treatments</h2>
                <div class="bnrFormPnlRow">
                	<ul class="checkLstFrm">
                    	<?php
                    	$sql_spa_service="select spa_service_name,spa_service_details from spa_service order by spa_service_name ASC";
                    	$result_spa_service=$db->fetch_all_array($sql_spa_service);
						$total_spa_service=count($result_spa_service);
						for($spa_service=0; $spa_service < $total_spa_service; $spa_service++ ){//*****  service ?>
						 <li><label><input name="" type="checkbox" disabled="disabled"  value="" /> <span><?=$result_spa_service[$spa_service]['spa_service_name']?></span></label>
						 	<?php if(trim($result_spa_service[$spa_service]['spa_service_details']) != NULL){?>
			                   <a onmouseout="hideddrivetip()" onmouseover="ddrivetip('<?=addslashes($result_spa_service[$spa_service]['spa_service_details'])?>')"><img src="images/i.png" alt="" /></a>
							<?php }?></li>
						<?php } ?>                    	
                    </ul>                     
                  	</div>                  
                    <h2>Size of your pet</h2>
              		<div class="bnrFormPnlRow">
              		<ul class="checkLstFrm2">
              		<?php
                    	$sql_available_sizes="select size_short_name,size_details from pet_available_sizes order by id + 0 ASC";
                    	$result_available_sizes=$db->fetch_all_array($sql_available_sizes);
						$total_available_sizes=count($result_available_sizes);
						for($available_sizes=0; $available_sizes < $total_available_sizes; $available_sizes++ ){//*****  service ?>
						<li><label><input name="" disabled="disabled"  type="radio" value="" /> <span  style="color:#8D8F90;"><?=$result_available_sizes[$available_sizes]['size_short_name']?></span></label>
						<?php if(trim($result_available_sizes[$available_sizes]['size_details']) != NULL){?>
			                   <a onmouseout="hideddrivetip()" onmouseover="ddrivetip('<?=addslashes($result_available_sizes[$available_sizes]['size_details'])?>')"><img src="images/i.png" alt="" /></a>
							<?php }?>
						</li>
					<?php } ?>
                	</ul>                
              	</div>              
             </div> 
	<?php }	
 }else if($type == "collect_spa"){?>
	<ul class="checkLstFrm">		
		<?php				
		$sql_spa_service="select s.id,spa_service_name,spa_service_details";
		$sql_spa_service .=" from salon_services ss left join spa_service s on ss.service_id=s.id";
		$sql_spa_service .=" where salon_id='" . $salon_id . "' and service_type=2 and s.id IN (select DISTINCT(spa_service_id) as spa_service_id from service_spa_service where service_id='" . $service_id . "') order by spa_service_name";
		
	    $result_spa_service=$db->fetch_all_array($sql_spa_service);
		$total_spa_service=count($result_spa_service);
		for($spa_service=0; $spa_service < $total_spa_service; $spa_service++ ){//*****  service ?>
			<li><input name="spa[]" type="checkbox" value="<?=$result_spa_service[$spa_service]['id']?>"><span><?=$result_spa_service[$spa_service]['spa_service_name']?>
	        	<?php if(trim($result_spa_service[$spa_service]['spa_service_details']) != NULL){?>
	            <a onmouseout="hideddrivetip();"  onmouseover="ddrivetip('<?=addslashes($result_spa_service[$spa_service]['spa_service_details'])?>')"><img src="images/i.png" alt="" /></a>
				<?php }?> </span>
			</li>
		<?php } ?>    
	</ul>
<?php  } ?>