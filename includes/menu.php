<?php
// Set up the menu as a multidimensional array
// first put in the bits for everyone
$warning="<span title='Under Construction' class='fa fa-warning'></span>";

// *****Default Menu Layout*****
$menu=array(
	"MCLD Home"=>"/",
	'Select'=>'select',
	"Compare"=>'compare',
	"Upload"=>"upload",
	"Data"=>"dump",
	"Charts"=>"charts",
	"Admin"=>"query",
	"Logout"=>"/_gcp_iap/clear_login_cookie"
);
$_SESSION["menu"]=$menu;
