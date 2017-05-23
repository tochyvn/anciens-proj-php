<?php

/* 
 * Cette Classe représente toutes les ENTREES : une ENTREE à uniquement besoin
 * de l'identité de l'origine... pas la peine de connaitre la classe de destination car
 * de toute façon c'est cette classe qui héberge l'objet ENTREE.
 */
class MIn {

    private $origine;
    private $etat;
    private $id;
    
    function __construct($id) {
        
        $this->origine=NULL;
        $this->etat=FALSE;
        $this->id=$id;
        
    }
    
    public function toString(){
        return $this->origine;
    }
    
    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS DE CETTE LASSE ---">
    
    function getOrigine() {
        return $this->origine;
    }

    function getEtat() {
        return $this->etat;
    }
    
    function getId() {
        return $this->id;
    }

    function setOrigine($origine) {
        $this->origine = $origine;
    }

    function setEtat($etat) {
        $this->etat = $etat;
    }
    
    function setId($id) {
        $this->id = $id;
    }
    
    //</editor-fold>

}

