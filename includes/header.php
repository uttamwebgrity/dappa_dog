<?php
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

$REQUEST_URI=@explode("/",$_SERVER['REQUEST_URI']);
$path_depth="";	
include_once($path_depth ."includes/configuration.php");
$q_string=basename($_SERVER['QUERY_STRING']);
$dynamic_content=$objdappaDogs->static_page_content(basename($_SERVER['PHP_SELF']),$q_string);

$REQUEST_URI=explode("/",$_SERVER['REQUEST_URI']);

$book_appointment_will_not_be_shown=array();
$book_appointment_will_not_be_shown[]="index.php";
$book_appointment_will_not_be_shown[]="calendar.php";
$book_appointment_will_not_be_shown[]="calender-date-view.php";
$book_appointment_will_not_be_shown[]="calender-week-view.php";
$book_appointment_will_not_be_shown[]="add-pets.php";
$book_appointment_will_not_be_shown[]="login.php";
$book_appointment_will_not_be_shown[]="register.php";






//print_r ($dynamic_content);
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<title><?=$dynamic_content['page_title']?></title>
<meta name="keywords" content="<?=$dynamic_content['page_keywords']?>" />
<meta name="description" content="<?=$dynamic_content['page_description']?>" />
<link href="reset.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/tooltip.js"></script>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<script language="javascript" type="text/javascript" src="includes/validator.js"></script>

<!-- date picker -->
<link rel="stylesheet" href="date_picker/main.css">
<script type="text/javascript" language="javascript" src="date_picker/prototype-1.js"></script>
<script type="text/javascript" language="javascript" src="date_picker/prototype-base-extensions.js"></script>
<script type="text/javascript" language="javascript" src="date_picker/prototype-date-extensions.js"></script>
<script type="text/javascript" language="javascript" src="date_picker/behaviour.js"></script>
<script type="text/javascript" language="javascript" src="date_picker/datepicker.js"></script>
<link rel="stylesheet" href="date_picker/datepicker.css">
<script type="text/javascript" language="javascript" src="date_picker/behaviors.js"></script>
<!-- // date picker -->
</head>
<body>
<div class="headerPnl">
  <div class="mainDiv">
  	<div id="logo"><a href="index.php"><img src="images/logo.png" alt="" /></a></div>
    <div class="headerRight">
    	<ul class="topLink">
    		<?php /*?><?php if(isset($_SESSION['choosed_salon_finder']) && $_SESSION['choosed_salon_finder']==1){ ?>
    			<li class="calender"><a href="calendar.php">My Calendar</a></li>	
			<li><a href="my-apointment.php">My Appointment(s)</a> |
    	<?php }	?><?php */?>
        	<li>
        	<?php if(isset($_SESSION['client_login']) && $_SESSION['client_login'] == "yes")
        			echo '<a href="logout.php">Logout</a>';	
        		else
        			echo '<a href="login.php">Log In</a> |  <a href="register.php">Register</a>'; ?>
        		</li>
            <li class="faceIco"><a target="_blank" href="<?=$general_func->facebook?>"><img src="images/faceIcon.png" alt="" />Facebook</a></li>
        </ul>
      <div class="menuPnl">
      	<ul>
        	<li><a href="#url"><span>Menu</span></a>
                <ul>
                    <li <?=basename($_SERVER['PHP_SELF'])=="index.php"?'class="current"':''?>><a href="index.php">Home</a></li>
                    <li <?=basename($_SERVER['PHP_SELF'])=="services.php"?'class="current"':''?>><a href="services.php">Services</a></li>
                    <li <?=basename($_SERVER['PHP_SELF'])=="opportunities.php"?'class="current"':''?>>Opportunities
                    	<ul>
                        	<li <?=basename($_SERVER['PHP_SELF'])=="services.php"?'class="current"':''?>><a href="franchiseenquiry.php">Franchise Enquiry</a></li>
                            <li <?=basename($_SERVER['PHP_SELF'])=="services.php"?'class="current"':''?>><a href="vancancies.php">Vacancies</a></li>
                        </ul>
                    </li>
                    <li <?=basename($_SERVER['PHP_SELF'])=="salon-finder.php"?'class="current"':''?>>Salon Finder
                    	<ul>
                    		<?php
                    		$sql_salons="select id,salon_name from salons order by salon_name";
							$result_salons=$db->fetch_all_array($sql_salons);
							$total_salons=count($result_salons);
							for($salon=0; $salon<$total_salons; $salon++){?>
								<li><a href="salon-finder.php?id=<?=$result_salons[$salon]['id']?>"><?=$result_salons[$salon]['salon_name']?></a></li>
							<?php } ?>
                    		
                    	</ul>	
                    	
                    	
                    </li>
                    <li <?=basename($_SERVER['PHP_SELF'])=="guarantee.php"?'class="current"':''?>><a href="guarantee.php">Guarantee</a></li>
                    <li <?=basename($_SERVER['PHP_SELF'])=="faq.php"?'class="current"':''?>><a href="faq.php">FAQ's</a></li>
                    <li <?=basename($_SERVER['PHP_SELF'])=="contact.php"?'class="current"':''?>><a href="contact.php">Contact</a></li>
                </ul>
            </li>
        </ul>
      </div>
      <?php if(!in_array(basename($_SERVER['PHP_SELF']),$book_appointment_will_not_be_shown)){?>
      	<div class="bookAppBtn"><a href="<?=$general_func->site_url?>">Book Apointment</a></div>	
      <?php } ?>
      
      
    </div>
  </div>
  
</div>