<?php
// Section from the generic update program with everything but the goback function
// to allow for complex computations after the data is saved.
$id=$_POST["id"];
if($id=='') $id=0;
$table=$_POST["table"];
if($table=='') $table=$_SESSION["table"];
if($table=='') goback("Error: Table not set in update - notify MEL.");
$prefix=($id>0 ? "update" : "insert into");
$suffix=($id>0 ? " where id='$id'" : "");
$query="$prefix $table set ";
// Note use of addslashes() function below needed to deal with quotes inside text fields
foreach ($_POST as $key=>$value){
	$value=trim($db->quote($value));
	if(substr($key,-5) == "_Date") $_SESSION["lastdate"]="'$value'"; // use last date entered as default
	if($value=="'on'") $value="'1'";
	if ($key<>"id" and $key<>"table") $query .= $key."=$value, ";
}
$query=substr($query,0,-2); // Trim off the final comma and space
$query .= $suffix;
$qStatus=$db->exec($query);
$error=$db->errorInfo();
if(!empty($error[2])){
	$error=$db->errorInfo();
	$reply="<div class='info-error'>Error: ".$error[2]." with ". $query . "</div>";
}else{
	if($id==0) $id=$db->lastInsertId();
	$reply = "<div class='info-success'>Success with $prefix $table record for ID: $id </div>";
}
