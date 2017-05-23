<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

$header_front= 'include/header.php';
$footer_front= 'include/footer.php';
//$header_back = 'include/header_back.php';
//$header_back = 'include/footer_back.php';

require 'class/db.class.php';
$DB = new DB();

if(!isset($_REQUEST['use_case']) or $_REQUEST['use_case']== NULL){
    include $header_front;
    include 'page/accueil.php';
    include $footer_front;
}else
{
    $use_case = $_REQUEST['use_case'];
    switch($use_case){
        case 'auth' :
            include 'controller/gestion_auth.php';
            break;
        
        case 'gererpanier' :
            include $header_front;
            include 'controller/gestion_panier.php';
            include $footer_front;
            
            break;
        
        case 'administrer' :
            include $header_back;
            include 'controller/administration.php';
            include $footer_back;
            break;
        
        case 'consulter' :
            include $header_front;
            include 'controller/consultation.php';
            include $footer_front;
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