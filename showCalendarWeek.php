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



$week_cal = Date_Calc::getCalendarWeek($day,$month,$year,"%E");
$view = "week";

?>
<CENTER>
<TABLE border=0 cellspacing=0 width=80%>

<TR>
<TD align=center bgcolor=#d0d0d0>
<?php include("showNavBar.php"); ?>
</TD>
</TR>
<TR>
<TD>
</TD>
</TR>


<TR bgcolor=#e0e0e0>
<TD align=center>
<A href="<?php echo $PHP_SELF."?".Date_Calc::beginOfPrevWeek($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>">&lt;&lt;</A>
&nbsp;
<?php 	echo "Week " . Date_Calc::weekOftheYear($day,$month,$year);
?>

&nbsp;
<A href="<?php echo $PHP_SELF."?".Date_Calc::beginOfNextWeek($day,$month,$year,"year=%Y&month=%m&day=%d"); ?>">&gt;&gt;</A>
&nbsp;<?php 	echo Date_Calc::beginOfWeek($day,$month,$year,"<b>%B %e - ")
			.Date_Calc::endOfWeek($day,$month,$year,"%B %e, %Y</b>%n");
?>

</TD>
</TR>

<?php

$curr_day = Date_Calc::dateNow("%Y%m%d");
$curr_month = Date_Calc::dateNow("%m");

for($row = 0; $row < 7; $row++)
{

	if(Date_Calc::daysToDate($week_cal[$row],"%Y%m%d") == $curr_day)
		$fontColor = "#a00000";
	elseif(Date_Calc::daysToDate($week_cal[$row],"%m") != $curr_month)
		$fontColor = "#777777";
	else
		$fontColor = "#0000ff";


	echo "<TR><TD bgcolor=#d3d3d3>\n";
	echo "<FONT color=$fontColor>\n";
			$week_year = Date_Calc::daysToDate(($week_cal[$row]),"%Y");
			$week_month = Date_Calc::daysToDate(($week_cal[$row]),"%m");
			$week_day = Date_Calc::daysToDate(($week_cal[$row]),"%d");			
			echo Date_Calc::dateFormat($week_day,$week_month,$week_year,"%A, %B %e, %Y%n");
	echo "</FONT>\n";
	echo "</TD></TR>\n";

	echo "<TR><TD bgcolor=#e0e0e0>\n";
	echo "<br>\n";
	echo "</TD></TR>\n";
	
}

?>
</TABLE>


</CENTER>
