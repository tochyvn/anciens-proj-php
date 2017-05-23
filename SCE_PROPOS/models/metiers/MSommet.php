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
    private $pathImg;
    private $large, $hauteur;
    private $id;
    private $bornes;
            
    function __construct($id, $pathImg) {
        $this->id = $id;
        $this->large = 40;
        $this->hauteur = 50;
        $this->pathImg = $pathImg;
        $this->bornes = [];
    }
    
    //<editor-fold defaultstate="collapse" desc="---LES ACCESSEURS---">
    
    function getPosition() {
        return $this->position;
    }
    
    function getPathImg() {
        return $this->pathImg;
    }
    
    function getLarge() {
        return $this->large;
    }
    
    function getHauteur() {
        return $this->hauteur;
    }
    
    function getBornes() {
        return $this->bornes;
    }


    //</editor-fold>
    
    //<editor-fold defaultstate="collapsed" desc="---LES MUTATEURS---">  
    
    function setPosition($position) {
        $this->position = $position;
    }
    
    function setPathImg($pathImg) {
        $this->pathImg = $pathImg;
    }
    
    function setLarge($large) {
        $this->large = $large;
    }
    
    function setHauteur($hauteur) {
        $this->hauteur = $hauteur;
    }
    /**
     * Permet d'ajouter une borne
     * @param type $borne La borne à ajouter
     */
    function setBornes(Borne $borne) {
        $this->bornes[] = $borne;
    }


    //</editor-fold>
     /**
      * Cette methode permet de renvoyer sous forme de tableau toutes les informations 
      * necessaire pour afficher un sommet (composant)
      */
    function toHTML() {
        
    }
    
    abstract function toMove();
    
    abstract function toRefresh();
    
}

