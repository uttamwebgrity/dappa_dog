<?php 
include_once("includes/header.php");

if(!isset($_SESSION['client_login']) || $_SESSION['client_login'] != "yes"){
	$_SESSION['client_msg']="Please login to view this page!";
	$_SESSION['client_redirect_to_page']=$_SERVER['HTTP_REFERER'];			
	$general_func->header_redirect("login.php");
}

if(!isset($_SESSION['choosed_salon_finder']) || $_SESSION['choosed_salon_finder'] != 1){		
	$_SESSION['client_msg']="Please choose your salon and its service to view this page!";	
	$general_func->header_redirect("index.php");	
}



?>
<div class="middilePnl">

<div class="bodyContentInr">
  <div class="mainDiv">
  		<p style="color:#ff0000; text-align: center; font-size: 22px;">Currently we are working on this page.</p>   
    	<h1>Add Pets</h1>
      <div class="tabPnl">
      	<div class="tabPnlCont">
      	  <div class="tabPnlContInr" style="background:url(images/regBg.png) no-repeat right bottom #fff; padding-bottom:50px;">
          	
            
            <div class="regPnl">
            	<h3>General Information:</h3>
            	<ul class="loginForm" style="margin:20px 0;">
                   <li><span>Owner name <b>*</b></span> <input type="text" value="" name="" class="regFild"></li>
                   <li><span>Pet Name <b>*</b></span> <input type="text" value="" name="" class="regFild"></li>
                   <li><span>Type</span> <select class="regFild">Select One</select></li>
                   <li><span>Breed</span> <input type="text" class="regFild" name=""></li>
                   <li><span>Weight</span> <input type="text" value="" name="" class="regFild"></li>
                   <li><span>D.O.B</span> <input type="text" value="" name="" class="regFild datepicker"></li>
                   <li><span>Gender <b>*</b></span><select class="regFild">Select One</select></li>
                   <li><span>Last visit</span><input type="text" value="" name="" class="regFild"></li>
                   <li><span>Comments</span><textarea name="" cols="" rows="" class="regFild"></textarea></li>
                </ul>           
            
            	<h3>Medical Information:</h3>
            	<ul class="loginForm" style="margin:20px 0;">
                  <li><span>Vet :</span><select class="regFild">Select One</select></li>
                  <li><span>Breed Status :</span><select class="regFild">Select One</select></li>
                </ul>
                <ul class="cBoxFrm">
                	<li><input name="" type="checkbox" value=""> Diabetic</li>
                    <li><input name="" type="checkbox" value=""> Deaf</li>
                    <li><input name="" type="checkbox" value=""> Deceased</li>
                    <li><input name="" type="checkbox" value=""> Blind</li>
                    <li><input name="" type="checkbox" value=""> Heart Condition</li>
                    <li><input name="" type="checkbox" value=""> Epileltic</li>
                    <li><input name="" type="checkbox" value=""> Rabies Shot</li>
                </ul>
                <ul class="loginForm" style="margin:20px 0;">
                  <li><span>Vaccinations :</span><textarea name="" cols="" rows="" class="regFild"></textarea></li>
				  <li><span>Comments :</span><textarea name="" cols="" rows="" class="regFild"></textarea></li>
                </ul>
            </div>
            <div class="regPnl">
            <h3>Grooming Information:</h3>
            	<ul class="cBoxFrm">
                	<li><input name="" type="checkbox" value=""> Burns earily</li>
                    <li><input name="" type="checkbox" value=""> Scared of hair dryer</li>
                    <li><input name="" type="checkbox" value=""> Sensitive Skin</li>
                </ul>
                <h4>Handling</h4>
                <ul class="cBoxFrm">
                	<li><input name="" type="radio" value=""> Easy</li>
                    <li><input name="" type="radio" value=""> Average</li>
                    <li><input name="" type="radio" value=""> Challenging</li>
                </ul>
                <h3></h3>
                <ul class="loginForm" style="margin:20px 0;">
                   <li><span>Length:</span> <input type="text" value="" name="" class="regFild"></li>
                   <li><span>Color:</span> <input type="text" value="" name="" class="regFild"></li>
                   <li><span>Texture:</span> <select class="regFild">Select One</select></li>
                   <li><span>Comments:</span><textarea name="" cols="" rows="" class="regFild"></textarea></li>
                </ul>
                <h3>Personal Information:</h3>
                <h4 style="padding-top:20px;">Temperament</h4>
                <ul class="cBoxFrm">
                	<li><input name="" type="checkbox" value=""> Aggresive with animals</li>
                    <li><input name="" type="checkbox" value=""> Barker</li>
                    <li><input name="" type="checkbox" value=""> Aggresive with people</li>
                    <li><input name="" type="checkbox" value=""> Biter</li>
                    <li><input name="" type="checkbox" value=""> Chews</li>
                    <li><input name="" type="checkbox" value=""> Shy</li>
                    <li><input name="" type="checkbox" value=""> Keep leash on</li>
                </ul>
                <ul class="loginForm" style="margin:20px 0;">
                	<li><span>Comments:</span><textarea name="" cols="" rows="" class="regFild"></textarea></li>
                </ul>
                
            </div>
            
           <!-- <div class="submitSection">
            	            	
       	   		<input type="button" class="confAppBtn" value="Back" name="back">
            	<input type="button" class="backBtn" value="Back" name="back">
                <input type="reset" class="cancelBtn" value="Cancel" name="Cancel">
           </div>-->
            <br class="clear">
          </div>
      	</div>
      </div>
  </div>
  </div>
</div>
<?php include_once("includes/footer.php"); ?>