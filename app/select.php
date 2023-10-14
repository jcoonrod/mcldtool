<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/reader.php"); // change user to root

$page=new Thpglobal\Classes\Page;
$page->start("Select one of more records to analyze");
$grid=new Thpglobal\Classes\Table;
echo("<form action=analyze method=POST>");

$grid->start($db);
$grid->query("select id,edate,program,ename from comdata");

$nrows=sizeof($grid->contents);
$grid->contents[0][4]="Select";
for($i=1;$i<$nrows;$i++) $grid->contents[$i][4]="<input type=checkbox name=c".$grid->contents[$i][0].">";

$grid->show();
echo("<input type=submit value='Analyze'></form>\n");

$page->end();
