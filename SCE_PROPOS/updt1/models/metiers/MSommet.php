<?php

/* 
 * C'est la classe de base pour tous les composants : chaque composant possède :
 * - des coordonnées (x,y) qui permettent de la placer dans une zone
 * - Nom : qui permet sa description simple
 * - Etat: qui permet de savoir si le composant est actif ou pas
 * - Dimensions(largeur, hauteur) : qui permettent de décrire graphiquement le composant.
 * - ID : qui identifie le composant d'une façon unique. 
 */
abstract class MSommet {

    private $position;
    private $description;
    private $etat;
    private $large,$hauteur;
    private $id;
    
    function __construct($desc,$id) {
        
        $this->position=new MPoint(0,0);
        $this->etat=false;
        $this->description=$desc;
        $this->large=25;
        $this->hauteur=25;
        $this->id=$id;
        
    }
    
    //<editor-fold defaultstate="collapsed" desc="--- LES METHODES À REDEFINIR ---">
    
    public abstract function toRefresh(); //--- permet de prendre en charge les nouvelles valeurs
    public abstract function toHTML(); //--- description de l'objet au format html
    public abstract function toMOVE(); //-- Redefinition de la position de l'objet

    //</editor-fold>
    
    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS DE CETTE LASSE ---">
     
    function getPosition() {
        return $this->position;
    }

    function getDescription() {
        return $this->description;
    }

    function getEtat() {
        return $this->etat;
    }

    function getLarge() {
        return $this->large;
    }

    function getHauteur() {
        return $this->hauteur;
    }
    function getId() {
        return $this->id;
    }
    function setPosition($position) {
        $this->position = $position;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setEtat($etat) {
        $this->etat = $etat;
    }

    function setLarge($large) {
        $this->large = $large;
    }

    function setHauteur($hauteur) {
        $this->hauteur = $hauteur;
    }
    
    function setId($id) {
        $this->id=$id;
    }
    
    //</editor-fold>
      
}


