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
	$sql="select * from products where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);	


	$salon_id=$result[0]['salon_id'];
	$product_name=$result[0]['product_name'];
	$barcode_code=$result[0]['barcode_code'];
	$wholesale_price=$result[0]['wholesale_price'];
	$retail_price=$result[0]['retail_price'];
	
	$reorder_qty=$result[0]['reorder_qty'];
	$product_qty=$result[0]['product_qty'];
	$reorder_point=$result[0]['reorder_point'];
	$auto_reorder=$result[0]['auto_reorder'];
	
	
	$description=$result[0]['description'];
	$size_id=$result[0]['size_id'];
	$colour_id=$result[0]['colour_id'];
	$make_id=$result[0]['make_id'];
	$supplier_id=$result[0]['supplier_id'];
	
	
	
	$button="Update";
}else{
	$salon_id="";		
	$product_name="";
	$barcode_code="";
	$wholesale_price="";
	$retail_price="";
	
	$reorder_qty="";
	$product_qty="";
	$reorder_point="";
	
	$description="";
	$size_id="";
	$colour_id="";
	$make_id="";
	$supplier_id="";
	$auto_reorder=0;	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="product"){
		
	$salon_id=trim($_REQUEST['salon_id']);
	$product_name=trim($_REQUEST['product_name']);
	$barcode_code=trim($_REQUEST['barcode_code']);
	$wholesale_price=trim($_REQUEST['wholesale_price']);
	$retail_price=trim($_REQUEST['retail_price']);
	
	$reorder_qty=trim($_REQUEST['reorder_qty']);
	$product_qty=trim($_REQUEST['product_qty']);
	$reorder_point=trim($_REQUEST['reorder_point']);
	
	$description=trim($_REQUEST['description']);
	$size_id=trim($_REQUEST['size_id']);
	$colour_id=trim($_REQUEST['colour_id']);
	$make_id=trim($_REQUEST['make_id']);
	$supplier_id=trim($_REQUEST['supplier_id']);
	
	$auto_reorder=(isset($_REQUEST['auto_reorder']) && $_REQUEST['auto_reorder']==1)?1:0;
			
		
	
	
	
	if($_POST['submit']=="Add New"){		
		if($db->already_exist_inset("products","barcode_code",$barcode_code,"salon_id",$salon_id)){
			$_SESSION['msg']="Sorry, your specified barcode is already taken in your specified salon!";			
		}else{				
			$data['salon_id']=$salon_id;				
			$data['product_name']=$product_name;
			$data['barcode_code']=$barcode_code;
			$data['wholesale_price']=$wholesale_price;
			$data['retail_price']=$retail_price;
			$data['reorder_qty']=$reorder_qty;
			$data['product_qty']=$product_qty;
			$data['reorder_point']=$reorder_point;	
			
			$data['description']=$description;
			$data['size_id']=$size_id;
			$data['colour_id']=$colour_id;
			$data['make_id']=$make_id;
			$data['supplier_id']=$supplier_id;	
			$data['auto_reorder']=$auto_reorder;	
			
						
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];
			$data['created']='now()';
			
			
			$db->query_insert("products",$data);			
			
			$_SESSION['msg']="Product successfully added!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{			
		if($db->already_exist_update("products","id",$_REQUEST['id'],"barcode_code",$barcode_code,"salon_id",$salon_id)){	
			$_SESSION['msg']="Sorry, your specified barcode is already taken in your specified salon!";					
		}else{
			$data['salon_id']=$salon_id;			
			$data['product_name']=$product_name;
			$data['barcode_code']=$barcode_code;
			$data['wholesale_price']=$wholesale_price;
			$data['retail_price']=$retail_price;
			$data['reorder_qty']=$reorder_qty;
			$data['product_qty']=$product_qty;
			$data['reorder_point']=$reorder_point;
			
			$data['description']=$description;
			$data['size_id']=$size_id;
			$data['colour_id']=$colour_id;
			$data['make_id']=$make_id;
			$data['supplier_id']=$supplier_id;
			$data['auto_reorder']=$auto_reorder;				
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			
			$db->query_update("products",$data,"id='".$_REQUEST['id'] ."'");
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Product successfully updated!";
			
			$general_func->header_redirect($_SESSION['return_url']);
		}
	}
}	

?>
<script language="JavaScript">
function validate(){	
		
		
	if(document.ff.salon_id.selectedIndex == 0){
		alert("Please choose a salon");
		document.ff.salon_id.focus();
		return false;
	}
		
			
	if(!validate_text(document.ff.barcode_code,1,"Please enter barcode"))
		return false;
		
	
	if(!validate_text(document.ff.product_name,1,"Please enter product name"))
		return false;		
		
	
	
	if(document.ff.colour_id.selectedIndex == 0){
		alert("Please choose a colour");
		document.ff.colour_id.focus();
		return false;
	}
	
	if(document.ff.make_id.selectedIndex == 0){
		alert("Please choose a make");
		document.ff.make_id.focus();
		return false;
	}
	
	if(document.ff.supplier_id.selectedIndex == 0){
		alert("Please choose a supplier");
		document.ff.supplier_id.focus();
		return false;
	}
	
	

	if(!validate_numeric(document.ff.wholesale_price,1,"Please enter a valid wholesale price")){
		document.ff.wholesale_price.select();
		return false;
	}
	if(parseInt(document.ff.wholesale_price.value) <= 0){
		alert("Please enter a valid wholesale price");
		document.ff.wholesale_price.select();
		return false;
	}
	
	if(!validate_numeric(document.ff.retail_price,1,"Please enter a valid retail price")){
		document.ff.retail_price.select();
		return false;
	}
	if(parseInt(document.ff.retail_price.value) <= 0){
		alert("Please enter a valid retail price");
		document.ff.retail_price.select();
		return false;
	}
	
	
	if(!allnumeric(document.ff.product_qty,"Please enter a valid  stock quantity")){
		document.ff.product_qty.select();
		return false;
	}
	
	if(parseInt(document.ff.product_qty.value) <= 0){
		alert("Please enter a valid  product quantity");
		document.ff.product_qty.select();
		return false;
	}	
	
	
	if(document.ff.auto_reorder.checked == true){
		if(!allnumeric(document.ff.reorder_point,"Please enter a valid reorder point quantity")){
			document.ff.reorder_point.select();
			return false;
		}
		if(parseInt(document.ff.reorder_point.value) <= 0){
			alert("Please enter a valid reorder point quantity");
			document.ff.reorder_point.select();
			return false;
		}	
		
		if(!allnumeric(document.ff.reorder_qty,"Please enter a valid reorder quantity")){
			document.ff.reorder_qty.select();
			return false;
		}
		if(parseInt(document.ff.reorder_qty.value) <= 0){
			alert("Please enter a valid reorder quantity");
			document.ff.reorder_qty.select();
			return false;
		}
		
	}	
	
}
</script>
 <div class="breadcrumb">
      	<p><a href="products/products.php">Products</a> &raquo; <?=$button?> </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;"><?=$button?> Product</a></li>             
                
            </ul>
         <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="product" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
       
            <input name="submit" type="hidden" value="<?=$button?>" />
        
    <div class="tabPnlCont">
<div class="tabPnlContInr">    
              <div class="tabcontArea" style="background:none">
          	 <h3>General Information:</h3>
             <div class="row">
               <div class="formCenter">
                 <ul class="formOne">
                 	<li>Choose a Salon <span class="star">*</span><br>
                  	<select name="salon_id">
                    <option value=""> Select One</option>
                    <?php 	
                    $sql_salon="select id,salon_name from salons order by salon_name ASC";						
                    $result_salon=$db->fetch_all_array($sql_salon);
					$total_salon=count($result_salon);
					for($salon=0; $salon < $total_salon; $salon++ ){?>
						<option value="<?=$result_salon[$salon]['id']?>" <?=$result_salon[$salon]['id']==$salon_id?'selected="selected"':'';?>><?=$result_salon[$salon]['salon_name']?></option>
					<?php } ?>
                    </select></li>
                 	                   
                   <li>Barcode (Unique ID)<span class="star">*</span><br><input name="barcode_code" value="<?=$barcode_code?>" type="text" /></li>
                   <li>Product Name <span class="star">*</span><br><input name="product_name" value="<?=$product_name?>" type="text" /></li>
                   <li style="clear:both; width:100%;">Description <br><textarea name="description" rows="10" cols="50"><?=$description?></textarea></li>
                  
                  <li>Size <span class="star">*</span><br>
                  	<select name="size_id">
                    <option value=""> Select One</option>
                    <?php 	
                    $sql_size="select id,name from product_size order by display_order + 0 ASC";						
                    $result_size=$db->fetch_all_array($sql_size);
					$total_size=count($result_size);
					for($size=0; $size < $total_size; $size++ ){?>
						<option value="<?=$result_size[$size]['id']?>" <?=$result_size[$size]['id']==$size_id?'selected="selected"':'';?>><?=$result_size[$size]['name']?></option>
					<?php } ?>
                    </select></li>
                  <li>Colour <span class="star">*</span><br>
                  	<select name="colour_id">
                    <option value=""> Select One</option>
                    <?php 	
                    $sql_color="select id,name from product_colour order by display_order + 0 ASC";						
                    $result_color=$db->fetch_all_array($sql_color);
					$total_color=count($result_color);
					for($color=0; $color < $total_color; $color++ ){?>
						<option value="<?=$result_color[$color]['id']?>" <?=$result_color[$color]['id']==$colour_id?'selected="selected"':'';?>><?=$result_color[$color]['name']?></option>
					<?php } ?>
                    </select></li>
                  <li>Make <span class="star">*</span><br>
                  <select name="make_id">
                  	<option value=""> Select One</option>
                    <?php 	
                    $sql_make="select id,name from product_make order by display_order + 0 ASC";						
                    $result_make=$db->fetch_all_array($sql_make);
					$total_make=count($result_make);
					for($make=0; $make < $total_make; $make++ ){?>
						<option value="<?=$result_make[$make]['id']?>" <?=$result_make[$make]['id']==$make_id?'selected="selected"':'';?>><?=$result_make[$make]['name']?></option>
					<?php } ?>
                    </select></li>
                  <li>Supplier <span class="star">*</span><br>
                  	<select name="supplier_id">
                    <option value=""> Select One</option>
                    <?php 	
                    $sql_supplier="select id,concat(first_name,' ',last_name) as name from product_supplier order by first_name ASC";						
                    $result_supplier=$db->fetch_all_array($sql_supplier);
					$total_supplier=count($result_supplier);
					for($supplier=0; $supplier< $total_supplier; $supplier++ ){?>
						<option value="<?=$result_supplier[$supplier]['id']?>" <?=$result_supplier[$supplier]['id']==$supplier_id?'selected="selected"':'';?>><?=$result_supplier[$supplier]['name']?></option>
					<?php } ?>
                    </select> 
                  </li>                  
                   <li>Wholesale Price <span class="star">*</span><br><input name="wholesale_price" value="<?=$wholesale_price?>" type="text" style="background:url(images/dollar.jpg) no-repeat left center #fff; padding-left:12px; width:150px;"  /></li>
                   <li>Retail Price <span class="star">*</span><br><input name="retail_price" value="<?=$retail_price?>" type="text" style="background:url(images/dollar.jpg) no-repeat left center #fff; padding-left:12px; width:150px;" /></li>
                          
                 </ul>
               </div>
             </div>
            <h3>Inventory Information:</h3>
            <div class="row">
              <div class="formCenter">
                <ul class="formOne">                 	                 
                  <li>Stock Quantity <span class="star">*</span><br><input name="product_qty" value="<?=$product_qty?>" type="text" /></li>
                   <li style="width: 100%;"><input name="auto_reorder" value="1" type="checkbox" <?=$auto_reorder==1?'checked="checked"':'';?> /> Auto reorder</li>
                  <li>Reorder Point<br><input name="reorder_point" value="<?=$reorder_point?>" type="text" /></li>              
                  <li>Reorder Quantity<br><input name="reorder_qty" value="<?=$reorder_qty?>" type="text" /></li>
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