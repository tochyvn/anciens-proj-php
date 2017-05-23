<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'model/Mpanier.php';

$action = test_input($_GET['action']);
//echo $action.'<br/>';
    switch ($action) {
    
        case 'voir' : 
            
            $articlesPanier = voirProduitPanier();
            include 'view/VlistePanier.php';
           
            break;
    
        case 'ajout' :
            /*
            $article_id = test_input($_GET['artId']);
            $articlesPanier = ajoutProduitPanier($article_id);
            include 'view/VlistePanier.php';
             * 
             */
            //$produits = $_POST;
            //var_dump($_POST);
            //SI LES DONNEES SUR LE PRODUIT ONT ETE ENVOYE EN POST
            if (count($_POST) > 0) {
                ajoutProduitPanier1($_POST);
            }
            $articlesPanier = voirProduitPanier();
            include 'view/VlistePanier.php';
            
            break;
    
        case 'suppr' :
            $article_id = test_input($_REQUEST['artId']);
            $articlesPanier = suppProduitPanier($article_id);
            include 'view/VlistePanier.php';
            break;
        
        case 'vider' :
            $articlesPanier = viderPanier();
            include 'view/VlistePanier.php';
            break;
        
        case 'ajoutQte' :
            
            break;
    }


