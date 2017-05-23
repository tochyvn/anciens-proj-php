<?php

/* 
 * Cette classe va permettre la gestion du contenu de la page
 */
class Middle {

    
    function __construct() {
        
    }
    
    function getContents(){
        
        //-- Container du milieu ----
        $content=new Div();
        $content->setAttribute('class', 'middle');
        //---- Ce bloc va permettre d'afficher les différents composant
        //---- de base : portes logiques
        $left_bloc=new Aside();
        $content->addElement($left_bloc);
        
        //--- On crée la section pour la zone de conception ---
        $concept=new Section();
        $content->addElement($concept);
        echo $content->toHTML();
    }
}

