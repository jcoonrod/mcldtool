<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
$errors=$_COOKIE["errors"]??"off";
if($errors=="on") {error_reporting(E_ALL & ~E_NOTICE);} else {error_reporting(E_ERROR | E_PARSE);};

function getcookie($x) {
	if( array_key_exists($x,$_COOKIE)) return $_COOKIE[$x];
	return "";
}
if( !array_key_exists("primary",$_COOKIE)) {setcookie("primary","navy",0,'/'); $_COOKIE["primary"]="teal";}
if( !array_key_exists("secondary",$_COOKIE)) {setcookie("secondary","darkgreen",0,'/'); $_COOKIE["secondary"]="turquoise";}

require_once __DIR__.'/includes/thpsecurity.php';
require_once __DIR__.'/includes/menu.php';


$url=$_SERVER['REQUEST_URI'];
$path=parse_url($url, PHP_URL_PATH);
$generics=['/cookies', '/dump', '/export',  '/list', '/logout',  '/query', '/update']; // standard routines defined in the classes

// modify to run locally with a local database without logging in!

if(in_array($path,$generics)){
	include("./vendor/jcoonrod/classes/app$path.php");
}elseif($path=='/') {
	include("./app/index.php");
}else{	
	$success=include("./app$path.php");
	if(!$success) Header("Location:/?reply=Error+Command+$path+Not+Found");
}

