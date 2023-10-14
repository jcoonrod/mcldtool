<?php
$page=new Thpglobal\Classes\Page;
$page->start("Upload a json file of data");

echo("<form action=unjson enctype='multipart/form-data' method='post'>"); 
echo("<input name='userfile' type='file'>\n");
echo("<input type=submit value='Upload JSON File'>\n");
echo("</form>\n");

$page->end();
