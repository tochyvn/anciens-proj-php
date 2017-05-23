<?php

/* 
 * Pour les colonnes des cotés
 */
class Aside extends ElementNonVide {
    
    function __construct() {
        
        parent::__construct();
        
        //-- On recupère les composants depuis les Manager --
        
        $components=new Div();
        foreach (Manager::getManager()->getSommets() as $sommet) {
            
            $desc=  explode(".", $sommet['name']);
            $img=new Figure();
            $capt=new Text($desc[0]);
            $img->add('graphics/upload/'.$sommet['name'],$capt);
            $components->addElement($img);
            
        }
        $this->addElement($components);
        
        //---- Ce container va contenir les propriétés de chaque element
        
        $div_prop=new Div();
        $div_prop->setAttribute('class', 'prop');
        
        //-- Ce span va conteni la description de l'objet --
        $sp_desc=new Span();
        $sp_desc->setAttribute('id', 'desc');
        $div_prop->addElement($sp_desc);
        
        //-- Ce span va contenir l'etat de l 'objet ---
        $sp_etat=new Span();
        $sp_etat->setAttribute('id', 'etat');
        $div_prop->addElement($sp_etat);
        
        //--- Ce span va contenir l'ID de l'objet 
        $sp_id=new Span();
        $sp_id->setAttribute('id', 'Id');
        $div_prop->addElement($sp_id);
        
        //--- Ce span va contenir le nombre d'entrées --
        $sp_enter=new Span();
        $sp_enter->setAttribute('id', 'entree');
        $div_prop->addElement($sp_enter);
        
        //-- Ce span va contenir le nombre sortie --
        $sp_sortie=new Span();
        $sp_sortie->setAttribute('id', 'sortie');
        $div_prop->addElement($sp_sortie);
        
        //--- On ajoute ce div dans le contanaire principal
        $this->addElement($div_prop);
        
    }

}

