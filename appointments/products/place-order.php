<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


if($_SESSION['admin_access_level'] != 1 && ! in_array(11,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


$data=array();
	
if(isset($_REQUEST['return_url']) && trim($_REQUEST['return_url']) != NULL){
	$_SESSION['return_url']=trim($_REQUEST['return_url']);	
}
	

if(isset($_POST['enter']) && $_POST['enter']=="place_order"){
	
	$id=$_REQUEST['id'];
	$order_id=$_REQUEST['order_id'];
	
	$created_date=$general_func->display_date(trim($_POST['created_date']),11);
	$order_state=trim($_POST['order_state']);
	$comments=trim($_POST['comments']);
	
	$ordered_qty=trim($_POST['ordered_qty']);
	$received_qty=trim($_POST['received_qty']);
	$qty_status=trim($_POST['qty_status']);
	
	$order_subtotal=trim($_POST['order_subtotal']);
	$shipping_total=trim($_POST['shipping_total']);
	$order_total=trim($_POST['order_total']);
	
	$closed_date=trim($_POST['closed_date']);
	
	
	if(trim($_POST['submit']) == "save_order" ){//*** save_order
		$data['product_id']=$id;
		$data['created_date']=$created_date;
		
		if(trim($closed_date)== NULL){
			if($ordered_qty == $received_qty)
				$data['closed_date']=date("m-d-Y");	
		}else{
			$data['closed_date']=$general_func->display_date($closed_date,11);			
		}
		
		
		if($ordered_qty == $received_qty){
			$data['order_state']=2;
			//************* update product qty ****************//
			$db->query("update products set product_qty=product_qty + '" . $received_qty . "' where id='". $id ."'");
		}else	
			$data['order_state']=$order_state;		
		
			
		$data['comments']=$comments;
		$data['ordered_qty']=$ordered_qty;
		$data['received_qty']=$received_qty;
		$data['qty_status']=$qty_status;
		$data['order_subtotal']=$order_subtotal;
		$data['shipping_total']=$shipping_total;
		$data['order_total']=$order_total;
		
			
		if(intval(trim($order_id)) > 0 ){//***********  update	
			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			$data['created_by']=$_SESSION['admin_id'];
			$db->query_update("product_orders",$data,"id='". $order_id ."'");
			$_SESSION['msg']="Your order has been updated!";				
			
		}else{//*************** insert
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['created']='now()';			
			$data['created_by']=$_SESSION['admin_id']; 			
			$db->query_insert("product_orders",$data);	
			$_SESSION['msg']="Your order has been placed!";			
		}
		
	}else{//*****************************************  save_close
		$data['product_id']=$id;
		$data['created_date']=$created_date;
		
		if(trim($closed_date)== NULL){			
			$data['closed_date']=date("m-d-Y");	
		}else{
			$data['closed_date']=$general_func->display_date($closed_date,11);			
		}
		
		
		$data['order_state']=2;
		
			
		$data['comments']=$comments;
		$data['ordered_qty']=$ordered_qty;
		$data['received_qty']=$received_qty;
		$data['qty_status']=$qty_status;
		$data['order_subtotal']=$order_subtotal;
		$data['shipping_total']=$shipping_total;
		$data['order_total']=$order_total;
			
		
		if(intval(trim($order_id)) > 0 ){//***********  update			
			$data['modified_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['modified']='now()';
			$data['created_by']=$_SESSION['admin_id'];
			$db->query_update("product_orders",$data,"id='". $order_id ."'");			
			$_SESSION['msg']="Your order has been updated and closed!";				
		}else{//*************** insert
			$data['created_ip']=$_SERVER['REMOTE_ADDR'];			
			$data['created']='now()';			
			$data['created_by']=$_SESSION['admin_id']; 			
			$db->query_insert("product_orders",$data);	
			$_SESSION['msg']="Your order has been placed and closed!";		
		}
		
		//************* update product qty ****************//
		$db->query("update products set product_qty=product_qty + '" . $received_qty . "' where id='". $id ."'");		
		
	} 

	$general_func->header_redirect($_SESSION['return_url']);

}	




	

					
$sql="select salon_name,opening_time,closing_time,address1,product_name,barcode_code,wholesale_price,reorder_qty,first_name,last_name,landline_number,mobile_number,email,physical_address1 from products p left join product_supplier s on p.supplier_id=s.id  left join salons sa on p.salon_id=sa.id where p.id='" .$_REQUEST['id']. "'";
$result=$db->fetch_all_array($sql);		
	
$product_id=$_REQUEST['id'];	

//***************  salon info ***********************//
$salon_name=$result[0]['salon_name'];
$opening_time=$result[0]['opening_time'];
$closing_time=$result[0]['closing_time'];
$address1=$result[0]['address1'];

//***************  product info ***********************//
$product_name=$result[0]['product_name'];
$barcode_code=$result[0]['barcode_code'];
$wholesale_price=$result[0]['wholesale_price'];
	
//***************  supplier info ***********************//
$supplier_name=$result[0]['first_name']." ".$result[0]['last_name'];
$supplier_email=$result[0]['email'];
$supplier_mobile_number=trim($result[0]['mobile_number']) != NULL?''.trim($result[0]['mobile_number']):'';
$supplier_landline_number=$result[0]['landline_number'];
$supplier_physical_address1=$result[0]['physical_address1'];

//***************  order info ***********************//
if(isset($_REQUEST['order_id']) && trim($_REQUEST['order_id']) != NULL){
	$sql_order="select * from product_orders where product_id='" .$_REQUEST['id']. "' and id='" .$_REQUEST['order_id']. "'";
	$result_order=$db->fetch_all_array($sql_order);	
	$created_date=$general_func->display_date($result_order[0]['created_date'],7);
	$order_state=$result_order[0]['order_state']; 
	$closed_date=trim($result_order[0]['closed_date'])!= NULL?$general_func->display_date($result_order[0]['closed_date'],7):'';
	$comments=$result_order[0]['comments'];
	$ordered_qty=$result_order[0]['ordered_qty'];
	$received_qty=$result_order[0]['received_qty'];
	$qty_status=$result_order[0]['qty_status'];
	$order_subtotal=$ordered_qty * $wholesale_price; 
	$shipping_total=$result_order[0]['shipping_total'];
	$order_total=$order_subtotal + $shipping_total;	
	
}else{	
	$created_date=date("m-d-Y");
	$order_state=1; 
	$closed_date="";
	$comments="";
	$ordered_qty=$result[0]['reorder_qty'];
	$received_qty=0; 
	$qty_status=0; 
	$order_subtotal=$ordered_qty * $wholesale_price; 
	$shipping_total=0.00;
	$order_total=$order_subtotal + $shipping_total;			
}
//************************************************//   	

	
	  

?>


<script language="JavaScript">
function validate(){		
		
	if(!validate_text(document.ff.ordered_qty,1,"Please enter Qty Ordered"))
		return false;
		
	if(parseInt(document.ff.ordered_qty.value) < 1){
		alert("Please enter a valid order qty");
		document.ff.ordered_qty.focus();
		return false;
	}	
	
	
	if(parseInt(document.ff.received_qty.value) < 0){
		alert("Please enter a valid received qty");
		document.ff.received_qty.focus();
		return false;
	}
		
		
		
	if(parseInt(document.ff.received_qty.value) > parseInt(document.ff.ordered_qty.value)){
		alert("Received qty must be less than ordered qty");
		document.ff.received_qty.focus();
		return false;
	}

	if(parseInt(document.ff.received_qty.value) == 0){
		document.ff.qty_status.selectedIndex=0;
	}else if(parseInt(document.ff.received_qty.value) == parseInt(document.ff.ordered_qty.value)){
		document.ff.qty_status.selectedIndex=2;
	}else{
		document.ff.qty_status.selectedIndex=1;
	}
	
	//***************  calculate order subtotal **********************//	
	
	var order_qty=parseInt(document.ff.ordered_qty.value);	
	
	
	var order_subtotal=order_qty * <?=$wholesale_price?>;	
	document.ff.order_subtotal.value=order_subtotal.toFixed(2);
	
	var shipping=parseFloat(document.ff.shipping_total.value);
	
	if(isNaN(shipping))
		shipping=0;
	
	var order_total= order_subtotal + shipping;	
	document.ff.order_total.value=order_total.toFixed(2);
	
	
}		
</script>
<div class="breadcrumb">
      	<p><a href="products/products.php">Products</a> &raquo; Place Order</p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
		<ul class="tabBtn">
            	<li class="activeTab"><a style="cursor: pointer;"><?=$result[0]['product_name']?></a></li>              
            </ul>
             <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="place_order" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
        <input type="hidden" name="order_id" value="<?=$_REQUEST['order_id']?>" />
        
<div class="tabPnlCont">
<div class="tabPnlContInr">
        <div class="tableBgStyle" style="background:none;">
          <div class="row">
            <div class="formTwoPnl">
              <h3>Order Information:</h3>
              <ul class="formTwo">
                <li><span>Date Created: </span><input name="created_date" readonly="readonly" class="datepicker" type="text" style="width:90px;"  value="<?=$created_date?>" /></li>
                <li><span>Status: </span><select name="order_state" style="width:115px;" >
                	<option value="1" <?=$order_state==1?'selected="selected"':'';?>>Open</option>
                	<option value="2" <?=$order_state==2?'selected="selected"':'';?>>Closed</option>
                </select></li>
                <li><span>Date closed: </span><input name="closed_date" readonly="readonly" class="datepicker" style="width:90px;"  type="text" value="<?=$closed_date?>" /></li>
                <li><span>Comments: </span><textarea name="comments" cols="" rows=""><?=$comments?></textarea></li>
              </ul>
            </div>
            <div class="formTwoPnl">
              <h3>Supplier Information:</h3>
              <ul class="formTwoDply">
                <li><span>Supplier's Name: </span><b><?=$supplier_name?></b></li>
                <li><span>Email Address: </span><b><?=$supplier_email?></b></li>
                <li><span>Mobile Number: </span><b><?=$supplier_mobile_number?></b></li>
                <li><span>Landline Number: </span><b><?=$supplier_landline_number?></b></li>
                <li><span>Address line 1: </span><b> <?=$supplier_physical_address1?></b></li>
               <!-- <li><span>Photo: </span> <img src="../images/logo.png" alt="" /></li>-->
              </ul>
            </div>
          </div>
          <div class="row">
          	  <div class="formTwoPnl">
              <h3>Product Information:</h3>
              <ul class="formTwoDply">
              	<li><span>Salon Name: </span><b><?=$salon_name?></b></li>
              	<li><span>Salon Address: </span><b><?=$address1?></b></li>
                <li><span>Product Name: </span><b><?=$product_name?></b></li>
                <li><span>Bancode: </span><b><?=$barcode_code?></b></li>
                <li><span>Wholesale price: </span><b>$<?=$wholesale_price?></b></li>
              </ul>
              <ul class="formTwo">
                <li><span>Qty Ordered: </span><input name="ordered_qty"  onkeyup="validate();"  onkeypress="validate();" type="text" value="<?=$ordered_qty?>" style="width:80px;" /></li>
                <li><span>Qty Received: </span><input name="received_qty" type="text" onkeyup="validate();"  onkeypress="validate();"  value="<?=$received_qty?>" style="width:80px;" /></li>
                <li><span>Status: </span><select name="qty_status" style="width:110px;" >
                	<option value="0" <?=$qty_status==0?'selected="selected"':'';?>>Processing</option>
                	<option value="1" <?=$qty_status==1?'selected="selected"':'';?>>Incomplete</option>
                	<option value="2" <?=$qty_status==2?'selected="selected"':'';?>>Completed</option>
                </select></li>
               
              </ul>
              </div>
              <div class="formTwoPnl">
              	
              	              	
              	<h3>Payment Information:</h3>
            
              <ul class="formTwo">
               
                <li><span>Order Subtotal: </span><input type="text" style="background:url(images/dollar.jpg) no-repeat left center #fff; padding-left:16px; width:64px;" readonly="readonly" value="<?=number_format($order_subtotal,2)?>" name="order_subtotal" ></li>
                <li><span>Shipping: </span><input type="text" style="background:url(images/dollar.jpg) no-repeat left center #fff; padding-left:16px; width:64px;" value="<?=number_format($shipping_total,2)?>" name="shipping_total" onkeyup="validate();"  onkeypress="validate();"></li>
                <li><span>Total: </span><input type="text" style="background:url(images/dollar.jpg) no-repeat left center #fff; padding-left:16px; width:64px;" readonly="readonly" value="<?=number_format($order_total,2)?>" name="order_total"></li>
              </ul>
              </div>	
              
              
          </div>
          <div class="submitSection">
        <input name="back" type="button" value="Back" onclick="location.href='<?=$_SESSION['return_url']?>'" class="backBtn" />
          <input type="submit" class="saveCloBtn" name="submit" value="save_close">
          <input type="submit" class="saveOdrBtn" name="submit" value="save_order">
            </div>
        </div>
<br class="clear" />
</div>
</div>
</form>
            
<?php
include_once("../foot.htm");
?>