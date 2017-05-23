<?php

/* 
* Cette classe concerne tous les composant qui n'ont que des ENTREES
*/
abstract class MISommet extends MSommet {

   private $entres;
   
   function __construct($descr,$id) {
      
       parent::__construct($descr,$id);
       $this->entres=[];
       
    }

    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS ---">
    
    function getEntrees() {
        $this->toRefresh();
        return $this->entres;
    }

    function setEntrees($entre) {
        $this->entres[] = $entre;
    }
    
    function getSorties() {
        //$this->toRefresh();
        return FALSE;
    }
    //</editor-fold>
    
   }

