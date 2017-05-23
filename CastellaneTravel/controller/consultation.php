<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



if (!isset($_REQUEST['action'])) {
    include 'model/Mproduit.php';
    $produits = voirCatalogue1();
    include 'view/contenu/Vproduits.php';
    /*
    include 'model/Mproduit.php';
    $produits = voirCatalogue1();
    include 'view/VlisteProduits.php';
     * 
     */
}
else {
    $action = $_REQUEST['action'];
    switch ($action) {
        
        case 'produits':
            include 'model/Mproduit.php';
            $produits = voirCatalogue1();
            include 'view/contenu/Vproduits.php';
            /*
            include 'model/Mproduit.php';
            $produits = voirCatalogue1();
            include 'view/VlisteProduits.php';
             * 
             */
            break;
        
        case 'produit':
            include 'model/Mproduit.php';
            $id = test_input($_GET['id']);
            $produit = selectProduit($id);
            include 'view/Vproduit.php';
            break;
        
        
        case 'voirhistoire' :
            #include $header_front;
            #include 'controller/gestion_societe.php';
            #include $footer_front;
            break;
        
        case 'voirsociete' :
            include 'model/Msociete.php';
            #include 'controller/gestion_societe.php';
            break;

        default:
            break;
    }
    
}