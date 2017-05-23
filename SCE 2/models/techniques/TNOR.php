<?php

/* 
 * La porte logique NOR
 */
class TAND implements TSommet{

    private $porte_nor;
    
    function __construct($id, $descr, $entree1, $entree2) {
        $this->porte_nor=new MOR($id, $descr, $entree1, $entree2); 
    }

    function getPorte_nor() {
        return $this->porte_nor;
    }

    function setPorte_nor($porte_nor) {
        $this->porte_nor = $porte_nor;
    }

    public function toHTML() {
        
    }

    public function toMOVE() {
        
    }

}

