<?php

// Modification of the one from classes to test out multilayer radars
// note -- apparently is faster to simply echo data rather than compile a string

function radar2($title,$data1,$data2,$max=100){
    chartstart($title);
    foreach($data1 as $key=>$value) $labels[]=$key;
    radargrid($labels,$max);
    radarlayer($data1,'rgb(0,255,0,0.3)',$max);
    radarlayer($data2,'rgb(0,0,255,0.3)',$max);
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
for($i=0;$i<$nrows;$i++) {
    $t[$_SESSION["contents"][$i][0]]=$_SESSION["contents"][$i][1];
    $u[$_SESSION["contents"][$i][0]]=$_SESSION["contents"][$i][2];
}

$page=new Thpglobal\Classes\Page;

$page->start("Charts for ".$t["organization"]." ".$t["date"]);
// Pull data from $_SESSION contents into dimesions
$data=["A"=>floor( ($t['a1']+$t['a2']+$t['a3']+$t['a4']+$t['a5']+$t['a6']+$t['a7'])*100.0/28.0),
    "B"=>floor( ($t['b1']+$t['b2'])*100.0/8.0),
    "C"=>floor(($t['c1']+$t['c2']+$t['c3']+$t['c4']+$t['c5'])*100.0/20.0),
    "D"=>floor(($t['d1']+$t['d2'])*100.0/8.0),
    "E"=>floor(($t['e1']+$t['e2'])*100.0/8.0),
    "F"=>floor(($t['f1']+$t['f2'])*100.0/8.0),
    "G"=>floor($t['g1']*100.0/4.0),
    "H"=>floor(($t['h1']+$t['h2']+$t['h3'])*100.0/12.0),
    "I"=>floor(($t['i1']+$t['i2']+$t['i3'])*100.0/12.0)];

$data2=["A"=>floor( ($u['a1']+$u['a2']+$u['a3']+$u['a4']+$u['a5']+$u['a6']+$u['a7'])*100.0/28.0),
    "B"=>floor( ($u['b1']+$u['b2'])*100.0/8.0),
    "C"=>floor(($u['c1']+$u['c2']+$u['c3']+$u['c4']+$u['c5'])*100.0/20.0),
    "D"=>floor(($u['d1']+$u['d2'])*100.0/8.0),
    "E"=>floor(($u['e1']+$u['e2'])*100.0/8.0),
    "F"=>floor(($u['f1']+$u['f2'])*100.0/8.0),
    "G"=>floor($u['g1']*100.0/4.0),
    "H"=>floor(($u['h1']+$u['h2']+$u['h3'])*100.0/12.0),
    "I"=>floor(($u['i1']+$u['i2']+$u['i3'])*100.0/12.0)];
echo("<p>Data: ".print_r($data,TRUE)."</p>\n");
echo("<section>\n");
$ctitle="Scores by Dimension";

radar2($ctitle,$data,$data2,100);

$ctitle="Dimension A";
$data=['A1'=>25*$t['a1'],'A2'=>25*$t['a2'],'A3'=>25*$t['a3'],'A4'=>25*$t['a4'],'A5'=>25*$t['a5'],'A6'=>25*$t['a6'],'A7'=>25*$t['a7']];
$data2=['A1'=>25*$u['a1'],'A2'=>25*$u['a2'],'A3'=>25*$u['a3'],'A4'=>25*$u['a4'],'A5'=>25*$u['a5'],'A6'=>25*$u['a6'],'A7'=>25*$u['a7']];
radar2($ctitle,$data,$data2,100);

$ctitle="Dimension C";
$data=['A1'=>25*$t['a1'],'A2'=>25*$t['a2'],'A3'=>25*$t['a3'],'A4'=>25*$t['a4'],'A5'=>25*$t['a5'],'A6'=>25*$t['a6'],'A7'=>25*$t['a7']];
$data2=['A1'=>25*$u['a1'],'A2'=>25*$u['a2'],'A3'=>25*$u['a3'],'A4'=>25*$u['a4'],'A5'=>25*$u['a5'],'A6'=>25*$u['a6'],'A7'=>25*$u['a7']];
radar2($ctitle,$data,$data2,100);

$ctitle="Dimensions B, D, E, F, G";
$data=['B1'=>25*$t['b1'],'B2'=>25*$t['b2'],'D1'=>25*$t['d1'],'D2'=>25*$t['d2'],'E1'=>25*$t['e1'],'E2'=>25*$t['e2'],'F1'=>25*$t['f1'],'F2'=>25*$t['f2'],'G1'=>25*$t['g1']];
$data2=['B1'=>25*$u['b1'],'B2'=>25*$u['b2'],'D1'=>25*$u['d1'],'D2'=>25*$u['d2'],'E1'=>25*$u['e1'],'E2'=>25*$t['e2'],'F1'=>25*$t['f1'],'F2'=>25*$t['f2'],'G1'=>25*$t['g1']];
radar2($ctitle,$data,$data2,100);

$ctitle="Dimensions H and I";
$data=['H1'=>25*$t['h1'],'H2'=>25*$t['h2'],'H3'=>25*$t['h3'],'I1'=>25*$t['i1'],'I2'=>25*$t['i2'],'I3'=>25*$t['i3']];
$data=['H1'=>25*$u['h1'],'H2'=>25*$u['h2'],'H3'=>25*$u['h3'],'I1'=>25*$u['i1'],'I2'=>25*$u['i2'],'I3'=>25*$u['i3']];
radar2($ctitle,$data,$data2,100);

echo("</section>\n");

$page->end();