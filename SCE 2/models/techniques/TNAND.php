<?php

/* 
 * La porte logique NAND
 */
class TAND implements TSommet{

    private $porte_nand;
    
    function __construct($id, $descr, $entree1, $entree2) {
        $this->porte_nand=new MNAND($id, $descr, $entree1, $entree2); 
    }

    function getPorte_nand() {
        return $this->porte_nand;
    }

    function setPorte_nand($porte_nand) {
        $this->porte_nand = $porte_nand;
    }

    public function toHTML() {
        
    }

    public function toMOVE() {
        
    }

}

