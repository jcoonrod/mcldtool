<?php

// Modification of the one from classes to test out multilayer radars
// note -- apparently is faster to simply echo data rather than compile a string

function radar2($title,$data1,$data2,$max=100){
    chartstart($title);
    foreach($data1 as $key=>$value) $labels[]=$key;
    radargrid($labels,$max);
    radarlayer($data1,'rgb(0,255,0,0.3)',$max);
    if(sizeof($data2))radarlayer($data2,'rgb(0,0,255,0.3)',$max);
    chartend();
}


function putXY($r, $i, $n) { // convert radius and index in spider to x,y pair
    $a = (2 * pi() * $i) / $n;
    $x = floor(200 + $r * sin($a));
    $y = floor(200 - $r * cos($a));
   echo( ' '.floor($x).','.floor($y));
}

function chartstart($title){
    echo("<div><h3>$title</h3>\n");    
}

function chartend(){
    echo("</svg></div>\n");
}

function radargrid($labels=['A','B','C'],$max=100){
    // put in the right number of lines, labels and ticks
    $tick=10; 
    if($max<50) $tick=5; 
    if($max<10) $tick=1;
    $ny=ceil($max/$tick);
    $ytick=floor(180/$ny); // compared to bars, this is half due to center point
    $n=sizeof($labels);
    echo('<svg viewBox="0 0 400 400" width="400" height="400" xmlns="http://www.w3.org/2000/svg">'."\n");
    echo('<style>.n {font: 10px sans-serif; fill: black;}</style>'."\n");
    for ($j=1;$j<=$ny;$j++) { // first layout the grid
        $r=$j*$ytick;
      $y = 200 - $r;
      echo('<text x="200" y="'.$y.'">'.($j*$tick).'</text>');
      echo('<polygon points="');
      for ($i = 0; $i < $n; $i++) putXY($r, $i, $n);
      echo('" fill="none" stroke="blue" /></polygon>'."\n");
    }
    for ($i = 0; $i < $n; $i++) {
        $a = (2 * pi() * $i) / $n;
        $x = floor(200 + 180 * sin($a));
        $y = floor(200 - 180 * cos($a));
        echo('<text text-anchor="middle" x="'.$x.'" y="'.$y.'">'.$labels[$i].'</text>'."\n");
      }
  
}
function radarlayer($data,$fill,$max=100){
    $tick=10; 
    if($max<50) $tick=5; 
    if($max<10) $tick=1;
    $ny=ceil($max/$tick);
    $ytick=floor(180/$ny); // compared to bars, this is half due to center point
    $n=sizeof($data);
    echo('<polygon points="');
    $i=0;
    foreach($data as $value) {putXY(floor($value*$ytick/$tick), $i, $n);$i++;}
    echo('" fill="'.$fill.'" stroke="darkgreen"></polygon>');
    // Next put the labels in the appropriate points
}

// MAIN PAGE START

// Copy $t out of $_SESSION["contents];
$nrows=sizeof($_SESSION["contents"]);
$ncols=sizeof($_SESSION["contents"][0]);
$u=[]; $data2=[]; //defaults if only one column of data
$twocols=($ncols==3);
for($i=0;$i<$nrows;$i++) $t[$_SESSION["contents"][$i][0]]=$_SESSION["contents"][$i][1];
if($twocols){for($i=0;$i<$nrows;$i++) $u[$_SESSION["contents"][$i][0]]=$_SESSION["contents"][$i][2];}

$page=new Thpglobal\Classes\Page;

$page->start("Charts for ".$t["organization"]." ".$t["date"]);
// Pull data from $_SESSION contents into dimesions
const lengths = [6, 2, 5, 3, 2, 4, 1, 3, 4]; // number of sub-elements in each
$data=["A"=>floor( ($t['a1']+$t['a2']+$t['a3']+$t['a4']+$t['a5']+$t['a6'])/6.0),
    "B"=>floor( ($t['b1']+$t['b2'])/2.0),
    "C"=>floor(($t['c1']+$t['c2']+$t['c3']+$t['c4']+$t['c5'])/5.0),
    "D"=>floor(($t['d1']+$t['d2'])/2.0),
    "E"=>floor(($t['e1']+$t['e2'])/2.0),
    "F"=>floor(($t['f1']+$t['f2'])/2.0),
    "G"=>$t['g1'],
    "H"=>floor(($t['h1']+$t['h2']+$t['h3'])/3.0),
    "I"=>floor(($t['i1']+$t['i2']+$t['i3'])/3.0)];
if($twocols){
  $data2=["A"=>floor( ($u['a1']+$u['a2']+$u['a3']+$u['a4']+$u['a5']+$u['a6']+$u['a7'])/6),
    "B"=>floor( ($u['b1']+$u['b2'])/2.0),
    "C"=>floor(($u['c1']+$u['c2']+$u['c3']+$u['c4']+$u['c5'])/5.0),
    "D"=>floor(($u['d1']+$u['d2'])/2.0),
    "E"=>floor(($u['e1']+$u['e2'])/2.0),
    "F"=>floor(($u['f1']+$u['f2'])/2.0),
    "G"=>$u['g1'],
    "H"=>floor(($u['h1']+$u['h2']+$u['h3'])/3.0),
    "I"=>floor(($u['i1']+$u['i2']+$u['i3'])/3.0)];
}
echo("<p>Data: ".print_r($data,TRUE)."</p>\n");
echo("<section>\n");
$ctitle="Scores by Dimension";

radar2($ctitle,$data,$data2,100);

$ctitle="Dimension A";
$data=['A1'=>$t['a1'],'A2'=>$t['a2'],'A3'=>$t['a3'],'A4'=>$t['a4'],'A5'=>$t['a5'],'A6'=>$t['a6']];
if($twocols) $data2=['A1'=>$u['a1'],'A2'=>$u['a2'],'A3'=>$u['a3'],'A4'=>$u['a4'],'A5'=>$u['a5'],'A6'=>$u['a6']];
radar2($ctitle,$data,$data2,100);

$ctitle="Dimension B & C";
$data=['B1'=>$t['b1'],'B2'=>$t['b2'],'C1'=>$t['c1'],'C2'=>$t['c2'],'C3'=>$t['c3'],'C4'=>$t['c4'],'C5'=>$t['c5']];
if($twocols) $data2=['B1'=>$u['b1'],'B2'=>$u['b2'],'C1'=>$u['c1'],'C2'=>$u['c2'],'C3'=>$u['c3'],'C4'=>$u['c4'],'C5'=>$u['c5']];
radar2($ctitle,$data,$data2,100);

$ctitle="Dimensions D, E, F, G";
$data=['D1'=>$t['d1'],'D2'=>$t['d2'],'E1'=>$t['e1'],'E2'=>$t['e2'],'F1'=>$t['f1'],'F2'=>$t['f2'],'G1'=>$t['g1']];
if($twocols) $data2=['D1'=>$u['d1'],'D2'=>$u['d2'],'E1'=>$u['e1'],'E2'=>$t['e2'],'F1'=>$t['f1'],'F2'=>$t['f2'],'G1'=>$t['g1']];
radar2($ctitle,$data,$data2,100);

$ctitle="Dimensions H and I";
$data=['H1'=>$t['h1'],'H2'=>$t['h2'],'H3'=>$t['h3'],'I1'=>$t['i1'],'I2'=>$t['i2'],'I3'=>$t['i3']];
if($twocols)$data2=['H1'=>$u['h1'],'H2'=>$u['h2'],'H3'=>$u['h3'],'I1'=>$u['i1'],'I2'=>$u['i2'],'I3'=>$u['i3']];
radar2($ctitle,$data,$data2,100);

echo("</section>\n");

$page->end();