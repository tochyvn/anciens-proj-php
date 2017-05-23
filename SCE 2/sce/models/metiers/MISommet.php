<?php

/* 
* Cette classe concerne tous les composant qui n'ont que des ENTREES
*/
abstract class MISommet extends MSommet {

   private $entres;
   
   function __construct($descr,$id) {
      
       parent::__construct($descr,$id);
       $this->entres[]=NULL;
       
    }

    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS ---">
    
    function getEntres() {
        $this->toRefresh();
        return $this->entres;
    }

    function setEntres($entre) {
        $this->entres[] = $entre;
    }

    //</editor-fold>
    
   }

