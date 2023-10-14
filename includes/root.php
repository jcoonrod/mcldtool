<?php
// this script is included in any script that needs to write to the database
$db=NULL; // Close the old connection
if(!CAN_EDIT) Die("Noth authorized to write the database");
if(php_sapi_name()=='cli-server') {
	$db=new PDO('mysql:host=localhost;dbname=mcld','johncoonrod','Vision2050');
} else {
	$db = new PDO("mysql:unix_socket=/cloudsql/thpbudget:us-east1:thpbudget;dbname=mcld","root","Vision2050");
}
