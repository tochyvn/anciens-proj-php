<?php

/* 
 * La porte logique NAND
 */
class TAND implements TSommet{

    private $porte_or;
    
    function __construct($id, $descr, $entree1, $entree2) {
        $this->porte_or=new MOR($id, $descr, $entree1, $entree2); 
    }

    function getPorte_or() {
        return $this->porte_or;
    }

    function setPorte_or($porte_or) {
        $this->porte_or = $porte_or;
    }

    public function toHTML() {
        
    }

    public function toMOVE() {
        
    }

}

