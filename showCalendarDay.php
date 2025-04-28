<?php
error_reporting(0);
/**
 * Example use of the Calendar class
 * Copyright (c): 1999-2000 ispi, all rights reserved

 * This source file is subject to version 2.02 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is
 * available at through the world-wide-web at
 * http://www.php.net/license/2_02.txt.
 * If you did not receive a copy of the PHP license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@php.net so we can mail you a copy immediately.
 *
 * Copyright (c) 1999, 2000 ispi
 *
 * @access public
 *
 * @version 1.1
 * @author Monte Ohrt <monte@ispi.net>
 */


require("Calc.php");

//print_r ($_REQUEST);

if(isset($_REQUEST['date']) || isset($_REQUEST['month']) || isset($_REQUEST['day'])){
	$year_array=explode("=",$_REQUEST['date']);
	$year = $year_array[1];
	$month =$_REQUEST['month'];
	$day = $_REQUEST['day'];
}else{		
	$year = Date_Calc::dateNow("%Y");
	$month = Date_Calc::dateNow("%m");
	$day = Date_Calc::dateNow("%d");
}

$day_cal = Date_Calc::getCalendarWeek($day,$month,$year);
$view = "day";

?>
<TABLE border=0 bgcolor=#1e1e1e cellspacing=1 width=80%>

<TR>
<TD align=center bgcolor=#d0d0d0>
<?php include("showNavBar.php"); ?>
</TD>
</TR>

<TR bgcolor=#e0e0e0>
<TD align=center>
<A href="<?php echo $PHP_SELF."?".Date_Calc::prevDay($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>">&lt;&lt;</A>
&nbsp;
<?php	
echo Date_Calc::toDaysName($day,$month,$year);
?>

&nbsp;
<A href="<?php echo $PHP_SELF."?date=".Date_Calc::nextDay($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>">&gt;&gt;</A>
</TD>
</TR>

<?php

$curr_day = Date_Calc::dateNow();

for($hour = 8; $hour < 18; $hour++)
{
	echo "<TR><TD bgcolor=#f1f1f1>\n";
		if($hour < 13)
			echo "$hour:00";
		else
			echo ($hour - 12).":00";
	echo "</TD></TR>\n";
	
}

?>
</TABLE>


