<?php

/* 
 * Cette classe va permettre la gestion du contenu de la page
 */
class Middle {

    
    function __construct() {
        
    }
    
    function getContents(){
        
        //---- Ce bloc va permettre d'afficher les différents composant
        //---- de base : portes logiques
        $left_bloc=new Aside();
        echo $left_bloc->toHTML();
        
        
        
    }
}

