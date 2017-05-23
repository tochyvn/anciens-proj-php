<?php

/* 
 * Cette classe permet la personnalisation du pied de page
 * du site
 */
class Foot {
    
    function __construct() {
       
    }
    
    function getFoot() {
        $bloc_foot=new Footer();
        echo $bloc_foot->toHTML();
    }

}

