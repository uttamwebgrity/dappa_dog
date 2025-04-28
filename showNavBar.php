<?php


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

echo "<TABLE border=0 width=100%>\n";
echo "<TR>\n";


if($view == "month")
	echo "<TD align=center><b>Month</b></TD>\n";
else
	echo "<TD align=center><A HREF=\"showCalendarMonth.php?".Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")."\"><b>Month</b></A></TD>\n";

if($view == "week")
	echo "<TD align=center><b>Week</b></TD>\n";
else
	echo "<TD align=center><A HREF=\"showCalendarWeek.php?".Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")."\"><b>Week</b></A></TD>\n";

if($view == "day")
	echo "<TD align=center><b>Day</b></TD>\n";
else
	echo "<TD align=center><A HREF=\"showCalendarDay.php?".Date_Calc::dateFormat($year,$month,$day,"year=%Y&month=%m&day=%d")."\"><b>Day</b></A></TD>\n";

echo "</TR>\n";
echo "</TABLE>\n";


?>
