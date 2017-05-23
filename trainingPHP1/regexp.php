<?php

echo dirname(__FILE__).'<br/>';
$file_content = file_get_contents('index.html');
//echo htmlentities($file_content);

function test_reference(&$tab, $x, $y) {
    $tab = array();
    //$x = 3; $y = 5;
    $tab['addition'] = $x+$y;
    $tab['difference'] = $x-$y;
    $tab['produit'] = $x*$y;
    $tab['modulo'] = $y%$x;  
}
test_reference($toch, 6, 3);

var_dump($tab);

$bool = 1;

echo (bool)$bool;


?>