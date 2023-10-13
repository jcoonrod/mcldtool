<?php
$query="select name as Epicenter, Celebration_Date, datediff($today,Celebration_Date) as In_Days 
from epicenter where datediff($today,Celebration_Date) between 0 and 7";
$contents=dbarray($con,$query);
$nrows=sizeof($contents);
if($nrows<2) {
	echo("<h3>Admin: No celebration dates within the last week</h3>");
}else{
	echo("<h3>Admin ALERT: These celebration dates passed within the last week:</h3>");
	show($contents);
}

?>
