<?php
//Generation d'une sortie XML
header('Content-Type: text/xml');
//Creation de l'entete XML
echo '<? xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

echo '<response>';

//Obtenir le nom de l'utilisateur.
$name = $_GET['name'];
//Generer une sortie qui depend du nom d'utilisateur re�u du client
$userNames = array('YODA', 'IMANE', 'TOCHAP', 'CRISTIAN');
if (in_array(strtoupper($name), $userNames)) {
    echo'Bonjour ma�tre '.htmlentities($name).' !';
} elseif (trim($name) == '') {
    echo 'Etranger, daigne donner ton nom !';
} else {
    echo htmlentities($name). ', je ne vous connais pas';
}

echo '</response>';

?>