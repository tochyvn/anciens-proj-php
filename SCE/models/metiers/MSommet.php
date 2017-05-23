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

    private $code_objet;
    private $position;
    private $description;
    private $etat;
    private $large,$hauteur;
    private $src;
    private $style;
    private $id;
    private $child;
    private $patte_child;
    
    function __construct($desc,$id) {
        
        $this->position=new MPoint(0,0);
        $this->etat=FALSE;
        $this->description=$desc;
        $this->large=25;
        $this->hauteur=25;
        $this->id=$id;
        $this->patte_child=[];
        
    }
    
    //<editor-fold defaultstate="collapsed" desc="--- LES METHODES À REDEFINIR ---">
    
    public abstract function toRefresh(); //--- permet de prendre en charge les nouvelles valeurs
    public abstract function toHTML(); //--- description de l'objet au format html
    public abstract function toMOVE(); //-- Redefinition de la position de l'objet

    //</editor-fold>
    
    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS DE CETTE LASSE ---">
     
    function getCode_objet() {
        return $this->code_objet;
    }

    function setCode_objet($code_objet) {
        $this->code_objet = $code_objet;
    }

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
    
    function getSrc() {
        return $this->src;
    }

    function getStyle() {
        return $this->style;
    }

    function setSrc($src) {
        $this->src = $src;
    }

    function setStyle($style) {
        $this->style = $style;
    }

    function getChilds() {
        return $this->child;
    }

    function addChild($child) {
        $this->child[] = $child;
    }
    
    function getPatte_child($child) {
        return $this->patte_child[$child];
    }
    function setPatte_child($child,$patte) {
        $drapeau=false;
        foreach ($this->patte_child as $key => $value) {
            if($key===$child){
                $value[]=$patte;
                $this->patte_child[$child]=$value;
                $drapeau=true;
            }
        }
        if(!$drapeau){
            $this->patte_child[$child] = Array($patte);
        }
        //print_r($this->patte_child);
    }

        
    //</editor-fold>
      
}


