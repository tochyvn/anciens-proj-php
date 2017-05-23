<?php
require 'includes/connexion_mysqli.php';
//var_dump($_SERVER);

foreach ($_SERVER as $key => $value) {
    //echo $key . " => " . $value . "<br/><br/>";
}


//$adresse  = $_SERVER['SERVER_NAME'] . '/index.php?step=ERREUR_SAISIE';
//var_dump($adresse);

$lien  = $_SERVER['SERVER_NAME'].'/actions/confirm_subscription.php?token='.  time();
var_dump($lien);

$date = date('d-m-Y h:i:s');
var_dump($date);