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
	$sql="select p.*,s.name as size,c.name as colour,m.name as make,concat(su.first_name,' ',su.last_name) as supplier,salon_name from products p";
	$sql .=" left join product_size s on p.size_id=s.id left join product_colour c on p.colour_id=c.id left join product_make m on p.make_id=m.id left join product_supplier su on p.supplier_id=su.id";
	$sql .=" left join salons sa on p.salon_id=sa.id where p.id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	
	
	$salon_name=$result[0]['salon_name'];
	$product_name=$result[0]['product_name'];
	$barcode_code=$result[0]['barcode_code'];
	$wholesale_price=$result[0]['wholesale_price'];
	$retail_price=$result[0]['retail_price'];
	
	$auto_reorder=$result[0]['auto_reorder'];	
	$product_qty=$result[0]['product_qty'];
	$reorder_point=$result[0]['reorder_point'];
	$reorder_qty=$result[0]['reorder_qty'];
	
	$description=$result[0]['description'];
	$size=$result[0]['size'];
	$colour=$result[0]['colour'];
	$make=$result[0]['make'];
	$supplier=$result[0]['supplier'];
}
?>


 <div class="breadcrumb">
      	<p><a href="products/products.php">Products</a> &raquo; <?=$product_name?></p>
</div>


<ul class="tabBtn">
            	 
        			<?=$_SESSION['msg'];$_SESSION['msg']=""; ?>
            	
            	<li class="activeTab"><a style="cursor: pointer;">View Product</a></li>              
                
            </ul>
        
        
        
<div class="tabPnlCont">
<div class="tabPnlContInr">
<div class="tabcontArea" style="background:none;">

    <h3>General Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    <li>Salon Name <br><b><?=$salon_name?>&nbsp;</b></li>
     <li>Product Name <br><b><?=$product_name?>&nbsp;</b></li>
     <li>Barcode <br><b><?=$barcode_code?>&nbsp;</b></li>
      <li>Description <br><b><?=$description?>&nbsp;</b></li>
      
      
      <li>Size<br><b><?=$size?>&nbsp;</b></li>
      <li>Colour <br><b><?=$colour?>&nbsp;</b></li>
      <li>Make <br><b><?=$make?>&nbsp;</b></li>
      <li>Supplier <br><b><?=$supplier?>&nbsp;</b></li>
      
      
      <li>Wholesale Price <br><b>$<?=$wholesale_price?>&nbsp;</b></li>
      <li>Retail Price <br><b>$<?=$retail_price?>&nbsp;</b></li>
              
    </ul>
    </div>
    </div>
    <h3>Inventory Information:</h3>
    <div class="row">
    <div class="formCenter">
    <ul class="formOne">
    
    
     <li>Stock Quantity <br><b><?=$product_qty?>&nbsp;</b></li>
     <li style="width: 100%;">Auto Reorder: <?=$auto_reorder==1?'Yes':'No';?></li>
     <li>Reorder Point <br><b><?=$reorder_point?>&nbsp;</b></li>  
      <li>Reorder Quantity <br><b><?=$reorder_qty?>&nbsp;</b></li>             
    
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




           
            
<?php
include("../foot.htm");
?>