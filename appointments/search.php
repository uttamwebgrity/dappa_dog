<?php
include_once("../includes/configuration.php");

$keywords=trim($_REQUEST['keywords']);
$type=$_REQUEST['type'];



if(strtolower(trim($type)) == "customersearch"){//************  collect all respective customers
	$order_by="first_name ASC,last_name ASC";
	$query="where 1";				
		
	if(isset($_REQUEST['keywords']) && trim($_REQUEST['keywords']) != NULL){
		$keyword=trim($_REQUEST['keywords']);
	
		$query .=" and (first_name LIKE '%" .$keywords . "%' ";	
		$query .=" OR last_name LIKE '%" . $keywords . "%' ";
		$query .=" OR landline_number LIKE '%" . $keywords . "%' ";
		$query .=" OR mobile_number LIKE '%" . $keywords . "%' ";
		$query .=" OR othere_number LIKE '%" . $keywords . "%' ";
		$query .=" OR partners_number LIKE '%" . $keywords . "%' ";
		$query .=" OR email LIKE '%" . $keywords . "%' ";
		$query .=" OR physical_address1 LIKE '%" . $keywords . "%' ";
		$query .=" OR physical_address2 LIKE '%" . $keywords . "%' ";
		$query .=" OR physical_suburb LIKE '%" . $keywords . "%' ";
		$query .=" OR physical_city LIKE '%" . $keywords . "%' ";
		$query .=" OR physical_state LIKE '%" . $keywords . "%' ";
		$query .=" OR physical_post_code LIKE '%" . $keywords . "%' ";
		$query .=" OR postal_address1 LIKE '%" . $keywords . "%' ";
		$query .=" OR postal_address2 LIKE '%" . $keywords . "%' ";
		$query .=" OR postal_suburb LIKE '%" . $keywords . "%' ";
		$query .=" OR postal_city LIKE '%" . $keywords . "%' ";
		$query .=" OR postal_state LIKE '%" . $keywords . "%' ";
		$query .=" OR postal_post_code LIKE '%" . $keywords . "%' ";	
		$query .=")";
	}				
		
				
	$sql="select id,first_name,last_name,landline_number,mobile_number,email,physical_address1 from customers $query order by $order_by";
	$result=$db->fetch_all_array($sql);
	$total_customers=count($result);
	
	if($total_customers == 0){?>
		<p style="font:normal 13px/25px Arial, Helvetica, sans-serif; color:#C00; text-align:center; clear:both; padding: 30px 0 0 0;">No records found!</p>
		
	<?php }else{
	 ?>
	<table>
	<thead>
            <tr>
                <th width="15%">First Name</th>
                 <th width="15%">Last Name</th>
                <th width="20%">Email</th>              
                <th width="10%">Mobile No.</th>
                 <th width="10%">Landline No.</th>
                <th width="20%">Physical Address line 1</th>               
                <th width="10%" style="text-align:center">Action</th>
            </tr>
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
                <td><?=$result[$j]['first_name']?></td>
                <td><?=$result[$j]['last_name']?></td>
                <td><?=$result[$j]['email']?></td>
                <td><?=trim($result[$j]['mobile_number']) != NULL?''.trim($result[$j]['mobile_number']):'&nbsp;'?></td>
                <td><?=$result[$j]['landline_number']?></td>
                <td><?=$result[$j]['physical_address1']?></td>
                <td  style="text-align:center">
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>customers/customers-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>customers/customers-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
          			<?php if($_SESSION['admin_access_level'] == 1 || in_array(4,$_SESSION['access_permission'])){?>          			
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['name']?>')" style="cursor:pointer;" />
          			<?php } ?>
               </td>
            </tr>
           	
           <?php }?>
           
           
            </tbody>
        </table>
      
	<?php
		
	}
}else if(strtolower(trim($type)) == "suppliersearch"){//************  collect all respective suppliers
	
	$order_by="first_name ASC,last_name ASC";
	$query="where 1";
	
		
	if(isset($_REQUEST['keywords']) && trim($_REQUEST['keywords']) != NULL){
		$keyword=trim($_REQUEST['keywords']);
		
		$query .=" and (first_name LIKE '%" .$keyword. "%' ";
		
		$query .=" OR last_name LIKE '%" .$keyword. "%' ";
		$query .=" OR landline_number LIKE '%" .$keyword. "%' ";
		$query .=" OR mobile_number LIKE '%" .$keyword. "%' ";	
		$query .=" OR email LIKE '%" .$keyword. "%' ";
		$query .=" OR physical_address1 LIKE '%" .$keyword. "%' ";
		$query .=" OR physical_address2 LIKE '%" .$keyword. "%' ";
		$query .=" OR physical_suburb LIKE '%" .$keyword. "%' ";
		$query .=" OR physical_city LIKE '%" .$keyword. "%' ";
		$query .=" OR physical_state LIKE '%" .$keyword. "%' ";
		$query .=" OR physical_post_code LIKE '%" .$keyword. "%' ";
		$query .=" OR postal_address1 LIKE '%" .$keyword. "%' ";
		$query .=" OR postal_address2 LIKE '%" .$keyword . "%' ";
		$query .=" OR postal_suburb LIKE '%" .$keyword. "%' ";
		$query .=" OR postal_city LIKE '%" .$keyword. "%' ";
		$query .=" OR postal_state LIKE '%" .$keyword. "%' ";
		$query .=" OR postal_post_code LIKE '%" .$keyword. "%' ";	
		$query .=")";
	}				
			
					
	$sql="select id,CONCAT(first_name,' ',last_name) as name,landline_number,mobile_number,email,physical_address1 from product_supplier $query order by $order_by";
		
	$result=$db->fetch_all_array($sql);
	$total_customers=count($result);
	
	if($total_customers == 0){?>
		<p style="font:normal 13px/25px Arial, Helvetica, sans-serif; color:#C00; text-align:center; clear:both; padding: 30px 0 0 0;">No records found!</p>
		
	<?php }else{
		?>
		
			<table>
<thead>
            <tr>
                <th width="23%">Name</th>
                <th width="22%">Email</th>              
                <th width="14%">Mobile No.</th>
                 <th width="13%">Landline No.</th>
                <th width="19%">Physical Address line 1</th>               
                <th width="9%" style="text-align:center">Action</th>
            </tr>
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
                <td><?=$result[$j]['name']?></td>
                <td><?=$result[$j]['email']?></td>
                <td><?=trim($result[$j]['mobile_number']) != NULL?''.trim($result[$j]['mobile_number']):'&nbsp;'?></td>
                <td><?=$result[$j]['landline_number']?></td>
                <td><?=$result[$j]['physical_address1']?></td>
                <td>
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>products/suppliers-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>products/suppliers-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['name']?>')" style="cursor:pointer;" />
               </td>
            </tr>
           	
           <?php }?>
           
           
            </tbody>
        </table>
		
		<?php 
		
	}	
}else if(strtolower(trim($type)) == "productssearch"){//************  collect all respective products


	$order_by="product_name ASC";
	$query="where 1";
				
	
	
	if(isset($_REQUEST['keywords']) && trim($_REQUEST['keywords']) != NULL){
		$keyword=trim($_REQUEST['keywords']);
		
		$query .=" and (product_name LIKE '%" .$keyword. "%' ";
		
		$query .=" OR barcode_code LIKE '%" .$keyword. "%' ";
		$query .=" OR wholesale_price LIKE '%" .$keyword. "%' ";
		$query .=" OR retail_price LIKE '%" .$keyword. "%' ";
		$query .=" OR reorder_qty LIKE '%" .$keyword. "%' ";
		$query .=" OR product_qty LIKE '%" .$keyword. "%' ";
		$query .=" OR reorder_point LIKE '%" .$keyword. "%' ";
		$query .=" OR salon_name LIKE '%" .$keyword. "%' ";	
		$query .=")";
	}				
			
					
	$sql="select p.id,product_name,barcode_code,wholesale_price,retail_price,product_qty,salon_name from products p left join salons s on p.salon_id=s.id $query order by $order_by";
				
		
	$result=$db->fetch_all_array($sql);
	$total_customers=count($result);
	
	if($total_customers == 0){?>
		<p style="font:normal 13px/25px Arial, Helvetica, sans-serif; color:#C00; text-align:center; clear:both; padding: 30px 0 0 0;">No records found!</p>
		
	<?php }else{?>
		<table>
<thead>
            <tr>                
                <th width="15%">Salon Name</th>
                <th width="15%">Product Name</th>
                <th width="15%">Barcode</th>              
                <th width="15%">Wholesale Price</th>
                 <th width="15%">Retail Price</th>
                <th width="10%">Stock Qty</th>               
                <th width="15%" style="text-align:center">Action</th>
            </tr>
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
               <td><?=$result[$j]['salon_name']?></td>
                <td><?=$result[$j]['product_name']?></td>
                <td><?=$result[$j]['barcode_code']?></td>
                <td>$<?=$result[$j]['wholesale_price']?></td>
                <td>$<?=$result[$j]['retail_price']?></td>
                <td ><?=$result[$j]['product_qty']?></td>
                <td  style="text-align:center">
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>products/products-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>products/products-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
          			<?php if($_SESSION['admin_access_level'] == 1 || in_array(10,$_SESSION['access_permission'])){?>    
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['product_name']?>')" style="cursor:pointer;" />&nbsp;&nbsp;&nbsp;
          			<?php } if($_SESSION['admin_access_level'] == 1 || in_array(11,$_SESSION['access_permission'])){?>    
          			<img src="images/place_order.png" onclick="location.href='<?=$general_func->admin_url?>products/place-order.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="Place Order" alt="Place Order" />
          			<?php } ?>
               </td>
            </tr>
           	
           <?php }?>
           
           
            </tbody>
        </table>
		
		
	<?php }
}else if(strtolower(trim($type)) == "orderssearch"){//************  collect all respective orders
	$order_by="order_state ASC";
	$query="where 1";
					
			
	if(isset($_REQUEST['keywords']) && trim($_REQUEST['keywords']) != NULL){
		$keyword=trim($_REQUEST['keywords']);
		
		$query .=" and (product_name LIKE '%" .$keyword . "%' ";	
		$query .=" OR barcode_code LIKE '%" .$keyword. "%' ";
		$query .=" OR salon_name LIKE '%" .$keyword. "%' ";
		
		$query .=")";
	}				
			
					
	$sql="select o.id as order_id,product_id,product_name,barcode_code,created_date,order_state,ordered_qty,received_qty,order_total,salon_name";
	$sql .=" from product_orders o left join products p on o.product_id=p.id left join salons s on p.salon_id=s.id  $query order by $order_by";
					
	
	$result=$db->fetch_all_array($sql);
	$total_customers=count($result);
	if($total_customers == 0){?>
		<p style="font:normal 13px/25px Arial, Helvetica, sans-serif; color:#C00; text-align:center; clear:both; padding: 30px 0 0 0;">No records found!</p>
		
	<?php }else{
		?>
		<table>
<thead>
            <tr>
                <th width="15%">Salon Name</th>
                <th width="15%">Product Name</th>
                <th width="10%">Barcode</th>              
                <th width="15%">Order Created</th>
                 <th width="10%">Ordered Qty </th>
                <th width="10%">Received Qty</th> 
                 <th width="10%">Status</th>    
                <th width="10%">Order Total</th>              
                <th width="5%">Action</th>
            </tr>    
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
                <td><?=$result[$j]['salon_name']?></td>
                <td><?=$result[$j]['product_name']?></td>
                <td><?=$result[$j]['barcode_code']?></td>
                <td><?=$general_func->display_date($result[$j]['created_date'],10)?></td>
                <td><?=$result[$j]['ordered_qty']?></td>
                <td><?=$result[$j]['received_qty']?></td>
                <td><?=$result[$j]['order_state']==1?'Open':'Closed';?></td>
                <td>$<?=$result[$j]['order_total']?></td>
                <td  >	 
                	<?php if($result[$j]['order_state']==1){?>
                		<img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>products/place-order.php?id=<?=$result[$j]['product_id']?>&order_id=<?=$result[$j]['order_id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
						
                		<?php }?>
                    
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['order_id']?>')" style="cursor:pointer;" />&nbsp;&nbsp;&nbsp;
          			
               </td>
            </tr>
           	
           <?php }?>
           
           
            </tbody>
        </table>
		
		
		
		<?php
		}
	
}else if(strtolower(trim($type)) == "servicessearch"){//************  collect all respective orders
	$order_by="name,service_name";
	$query="where 1";
					
		
	if(isset($_REQUEST['keywords']) && trim($_REQUEST['keywords']) != NULL){
		$keyword=trim($_REQUEST['keywords']);
		
		$query .=" and (service_name LIKE '%" .$keyword . "%' ";	
		$query .=" OR name LIKE '%" .$keyword. "%' ";
		
		$query .=")";
	}				
						
			
	$sql="select s.id,service_name,name as groming_type from service s left join grooming g on s.grooming_id=g.id  $query order by $order_by";
	
	
	$result=$db->fetch_all_array($sql);
	$total_customers=count($result);
	if($total_customers == 0){?>
		<p style="font:normal 13px/25px Arial, Helvetica, sans-serif; color:#C00; text-align:center; clear:both; padding: 30px 0 0 0;">No records found!</p>
		
	<?php }else{
		?>
		<table>
<thead>
            <tr>
                <th width="35%">Grooming Type</th>
                <th width="35%">Service name</th>             
                                    
                <th width="30%" style="text-align:center">Action</th>
            </tr>                    
                   
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
                <td><?=$result[$j]['groming_type']?></td>
                <td><?=$result[$j]['service_name']?></td>                    
                <td style="text-align:center">
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>settings/services-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>settings/services-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['service_name']?>')" style="cursor:pointer;" />
               </td>
            </tr>           	
           <?php }?>
            </tbody>
        </table>
		<?php
		}
	
}else if(strtolower(trim($type)) == "staffssearch"){//************  collect all respective orders
	$order_by="staff_name ASC";
	$query="where 1";
					
		
			
	if(isset($_REQUEST['keywords']) && trim($_REQUEST['keywords']) != NULL){
		$keyword=trim($_REQUEST['keywords']);
		
		$query .=" and (staff_name LIKE '%" .$keyword. "%' ";
		
		$query .=" OR email_address LIKE '%" .$keyword. "%' ";
		$query .=" OR landline_no LIKE '%" .$keyword. "%' ";
		$query .=" OR mobile_no LIKE '%" .$keyword. "%' ";
		$query .=" OR address1 LIKE '%" .$keyword. "%' ";
		$query .=" OR address2 LIKE '%" .$keyword. "%' ";
		$query .=" OR city LIKE '%" .$keyword. "%' ";	
		$query .=" OR state LIKE '%" .$keyword. "%' ";	
		$query .=" OR zip LIKE '%" .$keyword. "%' ";	
		$query .=")";
	}				
			
					
	$sql="select id,staff_name,email_address,mobile_no,address1,state from staffs $query order by $order_by";
		
	
	
	$result=$db->fetch_all_array($sql);
	$total_customers=count($result);
	if($total_customers == 0){?>
		<p style="font:normal 13px/25px Arial, Helvetica, sans-serif; color:#C00; text-align:center; clear:both; padding: 30px 0 0 0;">No records found!</p>
		
	<?php }else{
		?>
		<table>
<thead>
            <tr>
                <th width="20%">Name</th>
                <th width="20%">Email Address</th>              
                <th width="15%">Mobile</th>
                 <th width="15%">Address line 1</th>
                <th width="15%">State</th>               
                <th width="15%" style="text-align:center">Action</th>
            </tr>
                       
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
                <td><?=$result[$j]['staff_name']?></td>
                <td><?=$result[$j]['email_address']?></td>
                <td><?=$result[$j]['mobile_no']?></td>
                <td><?=$result[$j]['address1']?></td>
                <td><?=$result[$j]['state']?></td>
                <td style="text-align:center">
                	<?php if($_SESSION['admin_access_level'] == 1 || in_array(21,$_SESSION['access_permission'])){?>
                	<img src="images/services.png" onclick="location.href='<?=$general_func->admin_url?>settings/staff-services.php?staff_id=<?=$result[$j]['id']?>'" style="cursor:pointer;"  title="Services" alt="Services" />&nbsp;&nbsp;&nbsp;
                	<?php }if($_SESSION['admin_access_level'] == 1 || in_array(20,$_SESSION['access_permission'])){?>                	
                	<img src="images/hours.png" onclick="location.href='<?=$general_func->admin_url?>settings/staff-roster.php?staff_id=<?=$result[$j]['id']?>'" style="cursor:pointer;"  title="Working Hours" alt="Working Hours" />&nbsp;&nbsp;&nbsp;                	
                	<?php } if($_SESSION['admin_access_level'] == 1 || in_array(18,$_SESSION['access_permission'])){?>
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>settings/staffs-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>settings/staffs-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
          			<?php } if($_SESSION['admin_access_level'] == 1){?>  
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['staff_name']?>')" style="cursor:pointer;" />
              		<?php } ?>
               </td>
            </tr>
           	
           <?php }?>
           
           
            </tbody>
        </table>
		
		<?php
		}
	
}else if(strtolower(trim($type)) == "salonssearch"){//************  collect all respective orders
	$order_by="salon_name ASC";
	$query="where 1";
					
	if((int)$_SESSION['admin_access_level'] == 2){
		$link_name = "Your Salon";	
		$query .=" and id='" . $_SESSION['admin_user_id'] . "'";
	}		
			
		
	if(isset($_REQUEST['keywords']) && trim($_REQUEST['keywords']) != NULL){
		$keyword=trim($_REQUEST['keywords']);
		
		$query .=" and (salon_name LIKE '%" .$keyword. "%' ";
		
		$query .=" OR email_address LIKE '%" .$keyword. "%' ";
		$query .=" OR landline_no LIKE '%" .$keyword. "%' ";
		$query .=" OR mobile_no LIKE '%" .$keyword. "%' ";
		$query .=" OR address1 LIKE '%" .$keyword. "%' ";
		$query .=" OR address2 LIKE '%" .$keyword. "%' ";
		$query .=" OR city LIKE '%" .$keyword. "%' ";	
		$query .=" OR state LIKE '%" .$keyword. "%' ";	
		$query .=" OR zip LIKE '%" .$keyword. "%' ";	
		$query .=")";
	}				
			
					
	$sql="select id,salon_name,email_address,mobile_no,address1,state from salons $query order by $order_by";
			
	
	$result=$db->fetch_all_array($sql);
	$total_customers=count($result);
	if($total_customers == 0){?>
		<p style="font:normal 13px/25px Arial, Helvetica, sans-serif; color:#C00; text-align:center; clear:both; padding: 30px 0 0 0;">No records found!</p>
		
	<?php }else{
		?>
	<table>
<thead>
            <tr>
                <th width="16%">Name</th>
                <th width="22%">Email Address</th>              
                <th width="14%">Mobile </th>
                 <th width="13%">Address line 1</th>
                <th width="9%">State</th>               
                <th width="26%" style="text-align:center">Action</th>
            </tr>
                       
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
                <td><?=$result[$j]['salon_name']?></td>
                <td><?=$result[$j]['email_address']?></td>
                <td><?=$result[$j]['mobile_no']?></td>
                <td><?=$result[$j]['address1']?></td>
                <td><?=$result[$j]['state']?></td>
                <td style="text-align:center">                	
                	<?php if($_SESSION['admin_access_level'] == 1 || in_array(17,$_SESSION['access_permission'])){?>
                	<img src="images/services.png" onclick="location.href='<?=$general_func->admin_url?>settings/salons-services.php?salon_id=<?=$result[$j]['id']?>'" style="cursor:pointer;"  title="Services" alt="Services" />&nbsp;&nbsp;&nbsp;
                	<?php } if($_SESSION['admin_access_level'] == 1 || in_array(16,$_SESSION['access_permission'])){?>
                	<img src="images/holidays.png" onclick="location.href='<?=$general_func->admin_url?>settings/salons-holidays.php?salon_id=<?=$result[$j]['id']?>'" style="cursor:pointer;"  title="Holidays" alt="Holidays" />&nbsp;&nbsp;&nbsp;
                	<?php } if($_SESSION['admin_access_level'] == 1 || in_array(14,$_SESSION['access_permission'])){?>
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>settings/salons-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <?php }  if($_SESSION['admin_access_level'] == 1 || in_array(15,$_SESSION['access_permission'])){ ?>
                    <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>settings/salons-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
          			<?php } if($_SESSION['admin_access_level'] == 1){?>          			
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['salon_name']?>')" style="cursor:pointer;" />
               		<?php } ?>
               </td>
            </tr>
           	
           <?php }?>
           
           
            </tbody>
        </table>
		
		
		<?php
		}
	
}else if(strtolower(trim($type)) == "spaservicessearch"){//************ 
	$order_by="spa_service_name";
	$query="where 1";
					
	if(isset($_REQUEST['keywords']) && trim($_REQUEST['keywords']) != NULL){
		$keyword=trim($_REQUEST['keywords']);	
		$query .=" and (spa_service_name LIKE '%" . $keyword . "%' ";			
		$query .=")";
	}				
	
					
	$sql="select id,spa_service_name from spa_service  $query order by $order_by";
		
		
	$result=$db->fetch_all_array($sql);
	$total_customers=count($result);
	if($total_customers == 0){?>
		<p style="font:normal 13px/25px Arial, Helvetica, sans-serif; color:#C00; text-align:center; clear:both; padding: 30px 0 0 0;">No records found!</p>
		
	<?php }else{
		?>
		<table>
<thead>
            <tr>
                <th width="70%">Spa Treatment </th>
                <th width="30%" style="text-align:center">Action</th>
            </tr>                    
                   
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
                <td><?=$result[$j]['spa_service_name']?></td>                                            
                <td style="text-align:center">                	 
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>settings/spa-treatment-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />&nbsp;&nbsp;&nbsp;
                    <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>settings/spa-treatment-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
          			<img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['spa_service_name']?>')" style="cursor:pointer;" />
               </td>
            </tr>
           	
           <?php }?>
           
           
            </tbody>
    </table>
		
		<?php
		}
	
}







?>