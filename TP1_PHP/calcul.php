<?php

require 'fonctions.php';

start_page("Calcul");

$op1 = $_POST['op1'];
$op2 = $_POST['op2'];
$op  = $_POST['op'];

if('*' == $op) {
   $result = $op1 * $op2;
   echo $result;
}
elseif('+' == $op) {
    $result = $op1 + $op2;
    echo $result;
} else {
    echo '<br/><strong>opérateur ' . $op . ' non géré </strong>';
}
    
end_page();
