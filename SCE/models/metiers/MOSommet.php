<?php

/* 
 * Cette classe concerne tous les composant qui n'ont que des sorties
 */
abstract class MOSommet extends MSommet{

    private $sorties; //--- C'est un tableau de sorties ---
    
    function __construct($descr,$id) {
        parent::__construct($descr,$id);
        $this->sorties = [];
        $this->setCode_objet(2);
    }

    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS ---">
    
    function getSorties() {
        //$this->toRefresh();
        return $this->sorties;
    }

    function setSorties($sortie) {
        $this->sorties[] = $sortie;
    }
    
    function getEntrees() {
        //$this->toRefresh();
        return FALSE;
    }
    //</editor-fold>

}


