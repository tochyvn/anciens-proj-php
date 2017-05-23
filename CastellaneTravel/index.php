<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

//Header et footer par defaut
$header_front = 'include/header1.php';
$footer_front = 'include/footer1.php';
$header_back = 'include/header_back.php';
$footer_back = 'include/footer_back.php';


include 'config/config.php';

for ($index = 0; $index < count($dconfig['includes']); $index++) {
    include $dconfig['includes'][$index];
}

//Creation de l'unique instance de la connexion PDO
ConnexionPDO::getInstanceConnexion($config);

if (!isset($_REQUEST['use_case'])) {
    
    include 'include/header_front.php';
    include 'view/contenu/Vaccueil.php';
    include 'include/footer_front.php';
     
}
else {
    $use_case = test_input($_REQUEST['use_case']);
    switch ($use_case) {
        
        case 'accueil' :
            include 'include/header_front.php';
            include 'view/contenu/Vaccueil.php';
            include 'include/footer_front.php';
            /*
            include $header_front;
            include 'view/Vaccueil.php';
            include $footer_front;
             * 
             */
            break;
        
        case 'auth' :
            include 'controller/gestion_auth.php';
            break;
        
        case 'gererpanier' :
            include 'include/header_front.php';
            include 'controller/gestion_panier.php';
            include 'include/footer_front.php';
            /*
            include $header_front;
            
            include $footer_front;
             * 
             */
            break;
        
        case 'administrer' :
            include $header_back;
            include 'controller/administration.php';
            include $footer_back;
            break;
        
        case 'consulter' :
            include 'include/header_front.php';
            include 'controller/consultation.php';
            include 'include/footer_front.php';
            /*
            include $header_front;
            include 'controller/consultation.php';
            include $footer_front;
             * 
             */
            break;
        
        default : 
            echo 'Vous n\'avez pas spécifié de cas d\'utilisation';
        
    }
}

