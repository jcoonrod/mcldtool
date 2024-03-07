<?php
define("LOCAL",php_sapi_name()=='cli-server');
define("ADMIN",TRUE);
define("CAN_EDIT",TRUE);
require_once(__DIR__."/root.php"); // define $db

// All variables must be defined to a default

function zero_cookie($name) {
	if($name) {
		setcookie($name,'',time()-1000); 
		setcookie($name,'',time()-1000,'/'); 
		$_COOKIE[$name]='';
		}
	}
function check_cascade(array $keys=[]){
	$nkeys=sizeof($keys);
	$check_msg="Check cascade $nkeys";
	// if one changes, the next one goes to zero 
	foreach($_GET as $key=>$value) {
		$check=array_search($key,$keys);
		if(!($check===FALSE) and $check<($nkeys-1)) 
		{$z=$keys[$check+1]; zero_cookie($z); $check_msg.=" G $z, ";}
	}
	foreach($keys as $key) { if(!array_key_exists($key,$_COOKIE)) zero_cookie($key);}
	
	for($i=0;$i<($nkeys-1);$i++){
		$key=$keys[$i]; $key2=$keys[$i+1];
		if(!$_COOKIE[$key]) {zero_cookie($key2); $check_msg.=" z $key2,";}
	}
	setcookie("cascade",$check_msg,0,'/'); // for debugging purposes
}
function check_toggle($key){
	if(!isset($_COOKIE[$key])) {setcookie($key,'on',0,'/'); $_COOKIE[$key]='on';}
}

// make certain any cookies referenced here are defined
if(!array_key_exists("contents",$_SESSION)) $_SESSION["contents"]=[];

// Make sure the date ranges make sense
$time_start = microtime(true);   // use to track execution time in end_page.php

// Routines to process GET and callbacks
foreach($_GET as $key=>$value) {
	setcookie($key,$value,0,'/'); // set cookies across the whole domain!
	$_COOKIE[$key]=$value;
}
function goback($reply){ // hack to deal with incomplete session to cookie transfer
	$back=getcookie("back"); // keep this here for now - probably not ideal and maybe it should be added as a hidden field in the form...	
	if(!$back) $back="/";
	if(getcookie("debug")) {echo("<p>$reply <a href=$back>Click here to continue</a></p>\n");} 
	else header("Location: $back");
}
$year=getcookie("year");
$country=getcookie("country");


$user_email = $user;
$email=$user_email;
//Set Edit privilege - NO reason to have this be a function - and no reason to do it during session.


function debug($msg,$x) {
	if(getcookie("debug")) {
    	echo("<p>Debug $msg: ");print_r($x);echo("</p>\n");
    }
}
