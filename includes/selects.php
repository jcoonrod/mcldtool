<?php


$filter=new  Thpglobal\Classes\Filter;
$filter->start($db);
$year1=$filter->range("year1",2008,$maxyear); // First get Year1 as that will limit Year2
$mm=12;
if($year1==$maxyear) $mm=$maxmonth;
$month1=$filter->range("month1",1,$mm);

$year2=$filter->range("year2",$year1,$maxyear); // Second, get Year 2 Month 2
$mm=12;
if($year2==$maxyear) $mm=$maxmonth;
$month2=$filter->range("month2",1,$mm);
// Finally, compute the date range
	
$day1 = $year1 . "-" . $_COOKIE["month1"] . "-01";
$day2 = date('Y-m-t', strtotime($year2 . "-" . $_COOKIE["month2"] . "-15"));
$when = " between '" . $day1 . "' and '" . $day2 . "'";
$filter->end();

