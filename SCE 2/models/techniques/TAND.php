<?php

/* 
 * La porte logique AND
 */
class TAND implements TSommet{

    private $porte_and;
    
    function __construct($id, $descr, $entree1, $entree2) {
        $this->porte_and=new MAND($id, $descr, $entree1, $entree2); 
    }

    function getPorte_and() {
        return $this->porte_and;
    }

    function setPorte_and($porte_and) {
        $this->porte_and = $porte_and;
    }

    public function toHTML() {
        
    }

    public function toMOVE() {
        
    }

}

