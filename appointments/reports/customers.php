<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


if($_SESSION['admin_access_level'] != 1 && ! in_array(8,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}
		
				
$sql="select * from customers"; 				

	
$result=$db->fetch_all_array($sql);
$total_customers=count($result);

?>
 <div class="breadcrumb">
      	<p><a style="list-style-type:none; ">Reports</a> &raquo; Customers</p>
</div>
<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
         <!--<ul class="tabBtn">
            	<li class="activeTab"><a style="cursor: pointer;">Customers</a></li>              
         </ul>-->
         <p style="color:#F00; font-size:14px; font-weight:bold; text-align:center;">No Programing (coding) has been made yet.<br>We are working on it.</p>
               <div class="tabPnlCont">
    <div class="tabPnlContInr">
      <div class="tabcontArea" style="background:none;">
            <?php for($j=0; $j<$total_customers; $j++){?>
           
        	<div class="row">
            <h5><?=$result[$j]['first_name']?></h5>
  	<div class="formTwoPnl">
    
<ul class="formTwoDply">
                <li><span>First Name: </span> <?=$result[$j]['first_name']?></li>
                 <li><span>Last Name: </span> <?=$result[$j]['last_name']?></li>
                <li><span>Landline No.: </span><?=$result[$j]['landline_number']?></li>
                <li><span>Mobile No.: </span><?=$result[$j]['mobile_number']?></li>
                <li><span>Email: </span><?=$result[$j]['email']?></li>
        
              </ul>
            </div>
            <div class="formTwoPnl">
              <ul class="formTwoDply">
               <li><span>Appointments: </span> 0</li>
                <li><span>Services: </span>0</li>
                <li><span>Products: </span>0</li>               
              </ul>
            </div>
  </div>
  <div class="row">
  	<div class="formTwoPnl">
    <h3 style="border-bottom: none;">Physical Address</h3>
<ul class="formTwoDply">
                <li><span>Address line 1: </span><?=$result[$j]['physical_address1']?></li>
                <li><span>Address line 2: </span><?=$result[$j]['physical_address2']?></li>
                <li><span>Suburb: </span><?=$result[$j]['physical_suburb']?></li>
                <li><span>City: </span><?=$result[$j]['physical_city']?></li>
          		<li><span>State: </span><?=$result[$j]['physical_state']?></li>
                <li><span>Postal code: </span><?=$result[$j]['physical_post_code']?></li>
              </ul>
            </div>
            <div class="formTwoPnl">
            <h3 style="border-bottom: none;">Postal Address</h3>
              <ul class="formTwoDply">
                <li><span>Address line 1: </span><?=$result[$j]['postal_address1']?></li>
                <li><span>Address line 2: </span><?=$result[$j]['postal_address2']?></li>
                <li><span>Suburb: </span><?=$result[$j]['postal_suburb']?></li>
                <li><span>City: </span><?=$result[$j]['postal_city']?></li>
          		<li><span>State: </span><?=$result[$j]['postal_state']?></li>
                <li><span>Postal code: </span><?=$result[$j]['postal_post_code']?></li>
              </ul>
            </div>
            <?php  	if( $j + 1 != $total_customers){
            	echo '<div style="float:left; width:100%; height:0px; margin:5px 0;"></div>';
			   }            
            ?>        
            
  			</div>
            <?php	}?> 
             </div>
              <br class="clear" />
             </div>
            
             </div>
       

            
<?php
include_once("../foot.htm");
?>