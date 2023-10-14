<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/includes/reader.php"); // change user to root

$ncol=1;
foreach($_POST as $key=>$value) {
    $id=substr($key,1);
    $result=$db->query("select * from comdata where id='$id'")->fetch(\PDO::FETCH_ASSOC);
    $i=0;
    foreach($result as $k=>$cell) {
        if($ncol==1) $table[$i][0]=$k;
        $table[$i][$ncol]=$cell;
        $i++;
    }
    $ncol++;
}
$_SESSION["contents"]=$table;
header("Location:dump");