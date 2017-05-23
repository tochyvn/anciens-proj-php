<?php

/* 
 * Cette classe represente tous les composants qui ont à la fois des
 * ENTREES et des SORTIES.
 */
abstract class MIOSommet extends MSommet {

    private $entrees;
    private $sorties;
    
    function __construct($descr,$id) {
       
        parent::__construct($descr,$id);
        $this->entrees = null;
        $this->sorties = null;
        
    }
    
    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS ---">
    
    function getEntrees() {
        return $this->entrees;
    }

    function getSorties() {
        //$this->toRefresh();
        return $this->sorties;
    }

    function setEntrees($entree) {
        $this->entrees[] = $entree;
    }

    function setSorties($sortie) {
        $this->sorties[] = $sortie;
    }

    //</editor-fold>
    

}

