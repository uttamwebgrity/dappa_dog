<?php include_once("includes/header.php");
$result_salon_info=$db->fetch_all_array("select salon_name,content from  salons where id='" . $_REQUEST['id']. "'");


 ?>
<div class="middilePnl">
<div class="bodyContentInr">
  <div class="mainDiv">
    	<h1><?=$result_salon_info[0]['salon_name']?></h1>
    	<?=$result_salon_info[0]['content']?>
    </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>