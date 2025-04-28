<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

if($_SESSION['admin_access_level'] != 1 && ! in_array(12,$_SESSION['access_permission'])){	
    $_SESSION['msg']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}

if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	
	$data=array();
	
	$data['title']=$_REQUEST['title'];
	$data['keyword']=$_REQUEST['keyword'];
	$data['description']=$_REQUEST['description'];	
	$data['file_data']=$_REQUEST['file_data'];
	
		
	$db->query_update("static_pages",$data,"id='".$_REQUEST['s'] ."'");
	
	if($db->affected_rows > 0)
		$_SESSION['msg']="Page content successfully updated!";		
			
	$general_func->header_redirect("static-pages.php?s=".$_REQUEST['s']);
	
}



$s=(isset($_REQUEST['s']) && (int)$_REQUEST['s'] >0)?(int)$_REQUEST['s'] :1;


$sql="select * from static_pages where id='" . $s . "'";
$result=$db->fetch_all_array($sql);
$file_id=$result[0]['id'];
$file_data=$result[0]['file_data'];
$link_name=$result[0]['link_name'];

$title=$result[0]['title'];
$description=$result[0]['description'];
$keyword=$result[0]['keyword'];

$photo_name=$result[0]['photo_name'];

?>
<script language="JavaScript">
function validate(){	
			
	if(!validate_text(document.ff.title,1,"Please enter page title"))
		return false;	
	
}
</script>
 <div class="breadcrumb">
      	<p><a>Static Pages</a> &raquo; <?=$link_name?> </p>
</div>

<?php if(isset($_SESSION['msg']) & trim($_SESSION['msg']) != NULL){?>
	<div class="row">
	<div class="errorMsg"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></div>	
	</div>
<?php } ?>
 
<ul class="tabBtn">
            	
            	<li class="activeTab"><a style="cursor: pointer;">CONTENT FOR - [ <?=$link_name?> ] </a></li>             
                
            </ul>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="ff" onsubmit="return validate()" >
<input type="hidden" name="enter" value="yes" />
<input type="hidden" name="s" value="<?=$s?>" />  

<div class="tabPnlCont">
<div class="tabPnlContInr">    
<div class="tabcontArea" style="background:none">
<h3>Meta Information:</h3>
<div class="row">
<div class="formCenter">
<ul class="formOne">                   
<li>Title <span class="star">*</span><br><input name="title" value="<?=$title?>" type="text" /></li>
<li style="width: 100%;">Keywords <br><textarea name="keyword"  AUTOCOMPLETE=OFF class="form_textarea" cols="90" rows="5"><?=$keyword?></textarea></li>
<li style="width: 100%;">Description <br><textarea name="description"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="5"><?=$description?></textarea></li>
</ul>
</div>
</div>
<h3>Content Information:</h3>
<div class="row">
<div class="formCenter">
<ul class="formOne">                
<li style="width: 100%;"><?php
include("../fckeditor/fckeditor.php") ;
$sBasePath ="fckeditor/";
$oFCKeditor = new FCKeditor('file_data') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Height = '400' ;
$oFCKeditor->width = '400' ;
$oFCKeditor->Value		= $file_data;
$oFCKeditor->Create();
?></li> 
</ul>
</div>
</div> 
<div class="submitSection">
<input name="update" type="submit" value="" class="updateBtn" />            	
<input name="back" type="button" value="Back" onclick="location.href='home.php'" class="backBtn" />

</div>
</div>
 <br class="clear" />
</div>
</div>  
</form>          
            
<?php
include("../foot.htm");
?>