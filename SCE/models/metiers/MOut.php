<?php

/* 
 * Cette Classe représente toutes les sorties : une sortie à uniquement besoin
 * de l'identité de destination... pas la peine de connaitre la classe d'origine car
 * de toute façon c'est cette classe qui héberge l'objet sorie.
 */
class MOut {

    private $cible;
    private $etat; // ceci decrit l'état de la sortie haut/bas
    private $id;
    
    function __construct($id) {
        
        $this->cible=NULL;
        $this->etat=FALSE;
        $this->id=$id;
        
    }
    
    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS DE CETTE LASSE ---">
    
    function getCible() {
        return $this->cible;
    }

    function getEtat() {
        return $this->etat;
    }
    
    function getId() {
        return $this->id;
    }
    
    function setCible($cible) {
        $this->cible = $cible;
    }

    function setEtat($etat) {
        $this->etat = $etat;
    }

    function setId($id) {
        $this->id = $id;
    }

        //</editor-fold>
    
}

