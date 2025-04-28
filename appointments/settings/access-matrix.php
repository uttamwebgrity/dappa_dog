<?php
$path_depth="../../";
include_once("../head.htm");
$link_name = "Welcome";


/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/




$order_by="id + 0 ASC";
				
$sql="select * from access_matrix order by $order_by";
$result=$db->fetch_all_array($sql);
$total_customers=count($result);


?>
<style type="text/css">
/* 
Generic Styling, for Desktops/Laptops 
*/
table { 
  width: 100%; clear:both; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #ffffff; 
}
tr:nth-of-type(even) { 
  background: #f1fbfd; 
}

th { 
  background: #86cee0; 
  color:#3a6c79; 
  font-family: 'proxima_nova_rgregular';
  font-weight: bold; 
  font-size:15px;
  line-height:16px;
  padding:7px 0;
}
td, th { 
  padding: 8px; 
  /*border: 1px solid #66bdf0; */
  font-family: 'proxima_nova_rgregular';
  text-align: left; 
  font-size:13px;
}
/* 
Max width before this PARTICULAR table gets nasty
This query will take effect for any screen smaller than 760px
and also iPads specifically.
*/
@media 
only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { /*border: 1px solid #66bdf0;*/ }
	
	td { 
		/* Behave  like a "row" */
		border: none;
		/*border-bottom: 1px solid #66bdf0; */
		position: relative;
		padding-left: 50%; 
		text-align:left !important;
	}
	
	td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	
	/*
	Label the data
	*/
	td:nth-of-type(1):before { content: "Can Access"; }
	td:nth-of-type(2):before { content: "Salon Admin"; }
	td:nth-of-type(3):before { content: "Staff"; }	
	
	
	
	
}

</style>


 <div class="breadcrumb">
      	<p><a>Staff / Salon Admin Access </a> &raquo; Access Matrix</p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>

        <div class="tableBgStyle" >
		<table>
<thead>
            <tr>
                <th width="50%" style="text-align: left;">Can Access</th>
                <th width="25%"  style="text-align: center;">Salon Admin </th>              
                <th width="25%"  style="text-align: center;">Staff</th>                          
               
            </tr>                    
                   
            </thead>
            <tbody>
           <?php for($j=0; $j<$total_customers; $j++){?>
          	<tr>
                <td  style="text-align: left;"><?=$result[$j]['option_name']?></td>
                <td  style="text-align: center;"><?=$result[$j]['salon_admin_access']==1?'<img src="images/tick1.png">':'&nbsp;';?></td>
                <td  style="text-align: center;"><?=$result[$j]['staff_access']==1?'<img src="images/tick1.png">':'&nbsp;';?></td>
            </tr>
           	
           <?php }?>
           
           
            </tbody>
        </table>
       
            
<?php
include_once("../foot.htm");
?>