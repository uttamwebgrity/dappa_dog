<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/

$data=array();
$return_url=$_REQUEST['return_url'];

if(isset($_REQUEST['action']) && $_REQUEST['action']=="VIEW"){
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
	
}
?>


 <div class="breadcrumb">
      	<p><a href="products/suppliers.php">Suppliers</a> &raquo; <?=$first_name?> <?=$last_name?> </p>
</div>


<ul class="tabBtn">
            	 
        			<?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
            	
            	<li class="activeTab"><a style="cursor: pointer;">View Supplier</a></li>              
                
            </ul>
         <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="supplier" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
           <input type="hidden" name="return_url" value="<?=$return_url?>" />
 <div class="tabPnlCont">
<div class="tabPnlContInr">      
        
              <div class="tabcontArea" style="background:none;">       
        

    <h3>Personal Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    <li>First Name<br><b><?=$first_name?> &nbsp;</b></li>
    <li>Last Name <br><b><?=$last_name?>&nbsp;</b></li>
    <li>Landline Number<br><b><?=$landline_number?>&nbsp;</b></li>
    <li>Mobile Number (SMS Numbe)<br><b><?=trim($mobile_number) != NULL?''.trim($mobile_number):'&nbsp;'?></b></li>
   	<li>Email<br><b><?=$email?>&nbsp;</b></li>             
    </ul>
    </div>
    </div>
    <h3>Physical Address:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    <li>Address line 1<br><b><?=$physical_address1?>&nbsp;</b></li>
    <li>Address line 2<br><b><?=$physical_address2?>&nbsp;</b></li>
    <li>Suburb<br><b><?=$physical_suburb?>&nbsp;</b></li>
    <li>City<br><b><?=$physical_city?>&nbsp;</b></li>
    <li>State<br><b><?=$physical_state?>&nbsp;</b></li>
    <li>Post code<br><b><?=$physical_post_code?>&nbsp;</b></li>
    
    </ul>
    </div>
    </div>
    <h3> Postal Address:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    <li>Address line 1<br><b><?=$postal_address1?>&nbsp;</b></li>
    <li>Address line 2<br><b><?=$postal_address2?>&nbsp;</b></li>
    <li>Suburb<br><b><?=$postal_suburb?>&nbsp;</b></li>
    <li>City<br><b><?=$postal_city?>&nbsp;</b></li>
    <li>State<br><b><?=$postal_state?>&nbsp;</b></li>
    <li>Post code<br><b><?=$postal_post_code?>&nbsp;</b></li>
    
    </ul>
    </div>
    </div>
   
    <div class="submitSection">            	
    <input name="back" type="button" value="Back" onclick="location.href='<?=$return_url?>'" class="backBtn" />

</div>
</div>

<br class="clear" />
</div>
</div>


</form>
           
            
<?php
include("../foot.htm");
?>