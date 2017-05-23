<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();


//Header et footer par defaut
$header = 'include/header1.php';
$footer = 'include/footer1.php';

if (isset($_REQUEST['backend'])) {
    $header = 'include/header2.php';
}
//ob_start();
include $header;


include 'config/config.php';

for ($index = 0; $index < count($dconfig['includes']); $index++) {
    include $dconfig['includes'][$index];
}

//Creation de l'unique instance de la connexion PDO
ConnexionPDO::getInstanceConnexion($config);

if (!isset($_REQUEST['use_case'])) {
    include 'view/v_accueil.php';
    $use_case = "accueil";
}
else {
    $use_case = test_input($_REQUEST['use_case']);
    switch ($use_case) {
        
        case 'accueil' :
            include 'view/v_accueil.php';
            break;
        
        case 'auth' :
            //ob_clean();
            include 'controller/gestion_auth.php';
            break;
        
        case 'produit' :
            #include 'controller/....';
            break;
        
        case 'societe' :
            #include 'controller/...';
    }
}

if (isset($_REQUEST['backend'])) {
    $footer = 'include/footer1.php';
}
//ob_start();
include $footer;
//ob_clean();