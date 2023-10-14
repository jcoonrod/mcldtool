<?php

$page=new Thpglobal\Classes\Page;
$page->start("Contents of the uploaded json file");
$json_string=file_get_contents($_FILES['userfile']['tmp_name']);
echo("<p>JSON String: $json_string</p>");
$data=json_decode($json_string,TRUE);

// do 3 things in this loop:
// 1. put everything in one table
// 2. prepare the insert query list of columns
// 3. prepare the insert query list of values

$fieldnames=["date","program","name","a1","a2","a3","a4","a5","a6","b1","b2","c1","c2","c3","c4","c5","d1","d2","d3","e1","e2","f1","f2","f3","f4","g1","h1","h2","h3","i1","i2","i3","i4","lang","na1","na2","na3","na4","na5","na6","nb1","nb2","nc1","nc2","nc3","nc4","nc5","nd1","nd2","nd3","ne1","ne2","nf1","nf2","nf3","nf4","ng1","nh1","nh2","nh3","ni1","ni2","ni3","ni4","organization","orgtype","region","stage"];
$n=sizeof($fieldnames);

$columns="";
$values='';

for($i=0;$i<$n;$i++) {
    $field=$fieldnames[$i];
    $value=$data[$field];
    if($field=="name" || $field=="date") $field="e".$field; // deal with mysql reserved words
    $row=[$field,$value];
    $columns.=$field.", ";
    $values.="'$value'".", ";
    $table[]=$row;
}
$query="insert into comdata (".substr($columns,0,-2).") values (".substr($values,0,-2).")";
// echo("<p>q: $query</p>\n");
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/root.php"); // change user to root
$db->exec($query);
// Now create the query that inserts the data
// Directly for now - later convert to a prepare statement

$_SESSION["contents"]=$table;
echo("<p><a href=dump>Show data</a></p>");
$page->end();