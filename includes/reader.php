<?php
if(LOCAL) {
	$db=new PDO('mysql:host=localhost;dbname=mcld','reader','SDG2030');
	$email="john@mcld.org";
	$name='Local admin';
	$user=$email;
	setcookie('user',$user,0,'/');$_COOKIE['user']=$user; 
	setcookie('name',$name,0,'/');$_COOKIE['name']=$name; 
} else {
	$db = new PDO("mysql:unix_socket=/cloudsql/mcldtime:us-central1:mcld;dbname=mcld","reader","SDG2030");
	$email=strtolower($_SERVER['HTTP_X_APPENGINE_USER_EMAIL']);
	$user=$email;
	$name=$_SERVER['HTTP_X_APPENGINE_USER_NICKNAME'];
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
