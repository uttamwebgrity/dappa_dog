<?php include_once("includes/header.php"); 

if(isset($_REQUEST['enter']) && trim($_REQUEST['enter']) == "salon_finder"){
	$_SESSION['choosed_salon_finder']=1;	
	
	unset($_SESSION['salon_finder']);		
	$_SESSION['salon_finder']['salon_id']=$_REQUEST['salon_id'];
	$_SESSION['salon_finder']['service_id']=$_REQUEST['service_id'];
	$_SESSION['salon_finder']['spa']=$_REQUEST['spa'];
	$_SESSION['salon_finder']['pet_size']=$_REQUEST['pet_size'];	
	
	$general_func->header_redirect("calendar.php");		
}

//print_r ($_SESSION['salon_finder']);


?>
<script language="JavaScript">

//*******************  collect services ************************//
function show_services(salon_id,fld,type) {
	
	document.body.style.cursor='wait';
	chng = fld;
			
	if (window.XMLHttpRequest){
		liveReqp = new XMLHttpRequest();
	}else if (window.ActiveXObject) {
		liveReqp = new ActiveXObject("Microsoft.XMLHTTP");
	}
			
	var sURL = "show-services.php?salon_id="+salon_id+"&type="+type;
	
	liveReqp.onreadystatechange = receivercode;
	liveReqp.open("GET", sURL);		
	liveReqp.send(null);
}
	

function receivercode() {	
	if (liveReqp.readyState == 4) {
    	document.getElementById(chng).innerHTML=liveReqp.responseText;
	}
	document.body.style.cursor='auto';
}

//**********************  collect spa ********************************//

function show_spa_services(salon_id,service_id,fld,type) {
	
	document.body.style.cursor='wait';
	chng = fld;
			
	if (window.XMLHttpRequest){
		liveReqp1 = new XMLHttpRequest();
	}else if (window.ActiveXObject) {
		liveReqp1 = new ActiveXObject("Microsoft.XMLHTTP");
	}
			
	var sURL = "show-services.php?salon_id="+salon_id+"&service_id="+service_id+"&type="+type;
	
	liveReqp1.onreadystatechange = receivercode_spa;
	liveReqp1.open("GET", sURL);		
	liveReqp1.send(null);
}
	

function receivercode_spa() {	
	if (liveReqp1.readyState == 4) {
    	document.getElementById(chng).innerHTML=liveReqp1.responseText;
	}
	document.body.style.cursor='auto';
}

	
function salon_finder_validate(){				
	if(document.frm_salon_finder.salon_id.selectedIndex == 0){
		alert("Please select your salon");		
		document.frm_salon_finder.salon_id.focus();	
		return false;		
	}
	
	var service_checked=false;
	var service_id_array=document.frm_salon_finder.service_id;	
	var service_id_array_size=service_id_array.length;	
	
	for(var i=0; i <service_id_array_size; i++){
		if(service_id_array[i].checked == true){
			service_checked=true;
			break;
		}
	}
	
	if(service_checked == false){
		alert("Please select your service");		
		return false;
	}
		
	
	var pet_size=document.frm_salon_finder.pet_size;
	if(pet_size[0].checked == false && pet_size[1].checked == false && pet_size[2].checked == false && pet_size[3].checked == false){
		alert("Please choose a size of your pet");
		return false;		
	}
			
}
	
	
</script>



<div class="middilePnl">
<?php if(isset($_SESSION['client_msg']) && trim($_SESSION['client_msg']) != NULL ){?>
		<div class="row" style="margin-bottom:10px;">
		    <div class="errorPnl">
		      <?=$_SESSION['client_msg']; $_SESSION['client_msg']=""; ?>
		    </div>
 		</div>		
		
	<?php }
	
	if(isset($_SESSION['client_success_msg']) && trim($_SESSION['client_success_msg']) != NULL ){?>
		<div class="row" style="margin-bottom:10px;">
    <div class="succPnl">
      <?=$_SESSION['client_success_msg']; $_SESSION['client_success_msg']=""; ?>
    </div>
 </div>	
		
	<?php }?>
<div class="bannerPnl">
    	<div class="mainDiv">
    		<div class="bnrFormPnl">    			
    	<form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="frm_salon_finder" onsubmit="return salon_finder_validate()">
        <input type="hidden" name="enter" value="salon_finder" />
        
          	<div class="bnrFormPnlinr">
           	  <h1>Appointment Finder</h1>
              <div class="bnrFormPnlRow">
              	<select name="salon_id" onchange="show_services(this.value,'salon_services','collect_services')">
              		<option value="">Select your Salon</option>
              	<?php
       	 		$sql_salons="select id,salon_name from salons where id IN(select DISTINCT(salon_id) from salon_services) order by salon_name ASC"; 
       	 		$result_salons=$db->fetch_all_array($sql_salons);
				$total_salons=count($result_salons);
			
				for($salon=0; $salon < $total_salons; $salon++ ){//*****  salon ?>
					<option value="<?=$result_salons[$salon]['id']?>" <?=(isset($_SESSION['salon_finder']['salon_id']) && $_SESSION['salon_finder']['salon_id'] == $result_salons[$salon]['id'])?'selected="selected"':'';?> ><?=$result_salons[$salon]['salon_name']?></option>
				<?php } ?>		
              </select>
                
              </div>
              <!-- salon services spa and size div -->
              <div id="salon_services">              	
              	<?php if(isset($_SESSION['choosed_salon_finder']) && intval($_SESSION['choosed_salon_finder'])==1){?>
				<div class="bnrFrmDyFlds">			
					<div class="bnrFormPnlRow">
			     		<ul class="checkLstFrm">
				      	<?php      	
				      	$sql_services="select service_id,service_name,service_details";
						$sql_services .=" from salon_services ss left join service s on ss.service_id=s.id";
						$sql_services .=" where salon_id='" . $_SESSION['salon_finder']['salon_id'] . "' and service_type=1 order by service_name";
										
						$result_services=$db->fetch_all_array($sql_services);
						$total_services=count($result_services);
						for($service=0; $service < $total_services; $service++ ){?>
							<li><input name="service_id" onclick="show_spa_services('<?=trim($salon_id)?>','<?=$result_services[$service]['service_id']?>','salon_spa_services','collect_spa')" type="radio" value="<?=$result_services[$service]['service_id']?>" <?=(trim($_SESSION['salon_finder']['service_id']) != NULL && trim($_SESSION['salon_finder']['service_id'])==$result_services[$service]['service_id'])?'checked="checked"':''; ?> /> <span><?=$result_services[$service]['service_name']?>
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
							$sql_spa_service="select s.id,spa_service_name,spa_service_details";
							$sql_spa_service .=" from salon_services ss left join spa_service s on ss.service_id=s.id";
							$sql_spa_service .=" where salon_id='" . $_SESSION['salon_finder']['salon_id'] . "' and service_type=2 and s.id IN (select DISTINCT(spa_service_id) as spa_service_id from service_spa_service where service_id='" . $_SESSION['salon_finder']['service_id'] . "') order by spa_service_name";
							
						    $result_spa_service=$db->fetch_all_array($sql_spa_service);
							$total_spa_service=count($result_spa_service);
							for($spa_service=0; $spa_service < $total_spa_service; $spa_service++ ){//*****  service ?>
								<li><input name="spa[]" type="checkbox" value="<?=$result_spa_service[$spa_service]['id']?>" <?=in_array($result_spa_service[$spa_service]['id'],$_SESSION['salon_finder']['spa'])?'checked="checked"':'';?>  ><span><?=$result_spa_service[$spa_service]['spa_service_name']?>
						        	<?php if(trim($result_spa_service[$spa_service]['spa_service_details']) != NULL){?>
						            <a onmouseout="hideddrivetip();"  onmouseover="ddrivetip('<?=addslashes($result_spa_service[$spa_service]['spa_service_details'])?>')"><img src="images/i.png" alt="" /></a>
									<?php }?> </span>
								</li>
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
							<li><label><input name="pet_size"  <?=$_SESSION['salon_finder']['pet_size']==$result_available_sizes[$available_sizes]['id']?'checked="checked"':'';?>  type="radio" value="<?=$result_available_sizes[$available_sizes]['id']?>" /> <span><?=$result_available_sizes[$available_sizes]['size_short_name']?></span></label>
							<?php if(trim($result_available_sizes[$available_sizes]['size_details']) != NULL){?>
						    	<a onmouseout="hideddrivetip()" onmouseover="ddrivetip('<?=addslashes($result_available_sizes[$available_sizes]['size_details'])?>')"><img src="images/i.png" alt="" /></a>
							<?php }?>
							</li>
						<?php } ?>
			  			</ul>
					</div>
			  	</div>
				<?php }else{ ?>
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
				<?php }  ?>
                    	
            </div> 
           <!-- / salon services spa and size div --> 
          </div>            
            <input name="" type="submit" class="mainSubmit" value="Find Appointment" />
           </form>
           <br class="clear" />
       	  </div>    		       	
          <div class="bannerRight">
          	<img src="images/groomGur.jpg" alt="" class="grooGa" />
          	<h1>For happy tales!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur<br />adipisicing elit, sed do eiusmod tempor incididunt<br />ut labore et dolore magna aliqua.</p>
            <br class="clear" />
          <img src="images/dogBanner.png" alt="" class="dogBanner" /></div>
    	</div>
    </div>
  <div class="bodyContent">
  	<div class="mainDiv">  		
    	<h1><?=$dynamic_content['page_heading']?></h1>
    	<?=$dynamic_content['file_data']?>        
    </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>