<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



if (!isset($_REQUEST['action']) or $_REQUEST['action']== NULL) {
    
    include 'page/accueil.php';
    
}
else {
    $action = $_REQUEST['action'];
    switch ($action) {
        
        case 'societe':
            include 'page/societe.php';
            break;
        
        case 'evenement':
            require 'class/article.class.php';   
            $DB = new DB();
            $articlenews = new article($DB);
            $pathphoto = 'imgbdd/event/';
            include 'page/evenement.php';
            
            break;
        
        case 'decouvrir':
            include 'page/decouvrir.php';
            
            break;
        
        case 'moncompte':
            include $header_front;
            include 'page/compte.php';
            include $footer_front;
            break;
    }
    
}