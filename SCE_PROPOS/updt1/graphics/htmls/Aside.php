<?php

/* 
 * Pour les colonnes des cotés
 */
class Aside extends ElementNonVide {
    
    function __construct() {
        
        parent::__construct();
        
        //-- On recupère les composants depuis les Manager --
        
        $components=new Div();
        $h=new H3();
        $h->addElement(new Text('X'));
        
        $hg=new Hgroup();
        $hg->setAttribute('id', 'local');
        
        $hg->addElement($h);
        foreach (Manager::getManager()->getSommets() as $sommet) {
            
            $desc=  explode(".", $sommet['name']);
            $img=new Figure();
            $capt=new Text($desc[0]);
            $img->add('graphics/upload/'.$sommet['name'],$capt);
            $components->addElement($img);
            
        }
        $hg->addElement($components);
        $this->addElement($hg);
        
        //---- Ce container va contenir les propriétés de chaque element
        
        $div_prop=new Div();
        $hp=new H3();
        $hp->addElement(new Text('X'));
        
        $div_prop->setAttribute('class', 'prop');
        $hg_prop=new Hgroup();
        
        //--- On ajoute un titre aux propriétés ---
        //-- Ce span va conteni la description de l'objet --
        $sp_desc=new Span();
        $sp_desc->setAttribute('id', 'desc');
        $sp_desc->addElement(new Text('Description : aucune'));
        $div_prop->addElement($sp_desc);
        
        //-- Ce span va contenir l'etat de l 'objet ---
        $sp_etat=new Span();
        $sp_etat->setAttribute('id', 'etat');
        $sp_etat->addElement(new Text('Etat : aucune'));
        $div_prop->addElement($sp_etat);
        
        //--- Ce span va contenir l'ID de l'objet 
        $sp_id=new Span();
        $sp_id->setAttribute('id', 'Id');
        $sp_id->addElement(new Text('Reférence : aucune'));
        $div_prop->addElement($sp_id);
        
        //--- Ce span va contenir le nombre d'entrées --
        $sp_enter=new Span();
        $sp_enter->setAttribute('id', 'entree');
        $sp_enter->addElement(new Text('Nombre d\'entrées : aucune'));
        $div_prop->addElement($sp_enter);
        
        //-- Ce span va contenir le nombre sortie --
        $sp_sortie=new Span();
        $sp_sortie->setAttribute('id', 'sortie');
        $sp_sortie->addElement(new Text('Nombre sorties : aucune'));
        $div_prop->addElement($sp_sortie);
        
        $hg_prop->addElement($hp);
        $hg_prop->addElement($div_prop);
        
        //--- On ajoute ce div dans le contanaire principal
        $this->addElement($hg_prop);
        
    }

}

