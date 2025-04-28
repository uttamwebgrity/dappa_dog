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
<div class="bodyContentInr">
  <div class="mainDiv">
    	<h1>Salon Finder</h1>
      	<div class="tabPnl">
       	  
          <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="customer" />
          <div class="tabPnlCont">
          	<div class="tabPnlContInr" style="background:url(images/regBg.png) no-repeat right bottom #fff;">
              <div class="slnSerch">
                <h3>Find your Salon</h3>
                <div class="slnSerchPnl" style="margin-top:15px;">
                	<select><option>Select Salon</option></select>
                    <h5>Services</h5>
                    <ul>
                    	<li><input name="" type="radio" value="" /><strong>Full Groom</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>Wash &amp; Blow Dry</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>Mini Groom</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>Nail Trim</strong><img alt="" src="images/i.png" /></li>
                    </ul>
                </div>
                <div class="slnSerchPnl">
                	<h5>Spa Treatments</h5>
                    <ul>
                    	<li><input name="" type="checkbox" value="" /><strong>Top Dog</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="checkbox" value="" /><strong>Kissable Dog</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="checkbox" value="" /><strong>Facial</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="checkbox" value="" /><strong>Calming Canine</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="checkbox" value="" /><strong>Citrus Sensation</strong><img alt="" src="images/i.png" /></li>
                    </ul>
                    <h5>Size of your pet</h5>
                    <ul class="xl">
                    	<li><input name="" type="radio" value="" /><strong>S</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>M</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>L</strong><img alt="" src="images/i.png" /></li>
                        <li><input name="" type="radio" value="" /><strong>XL</strong><img alt="" src="images/i.png" /></li>
                    </ul>
                    <br class="clear">
                    <input name="" type="submit" value="" />
                </div>
              </div>
            
            
            
            
                <br class="clear">
            </div>
          </div>
          </form>
      	</div>
  </div>
</div>
</div>
<?php include_once("includes/footer.php"); ?>