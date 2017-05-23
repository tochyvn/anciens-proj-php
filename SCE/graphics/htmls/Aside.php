<?php

/* 
 * Pour les colonnes des cotés
 */
class Aside extends ElementNonVide {
    
    function __construct() {
        
        parent::__construct();
        
        //-- On ajoute un attribut à ce tag ----
        $this->setAttribute('class', 'aside');
        $this->addElement($this->getPalette());
        $this->addElement($this->getProprieties());
        $this->addElement($this->getGroupe());
    }
    
    function getPalette() {
        //-- On recupère les composants depuis les Manager --
        
        $components=new Div();
        $components->setAttribute('class', 'comp');
        $components->setAttribute('id', 'closecomp');
        $h=new H3();
        $h->addElement(new Text('X'));
        $h->setAttribute('id', 'closecomp');
        
        $hg=new Hgroup();
        $hg->setAttribute('id', 'local');
        
        $hg->addElement($h);
        foreach (Manager::getManager()->getSommets() as $sommet) {
            
            $desc=  explode(".", $sommet['name']);
            $img=new Figure();
            $prop=[];
            $prop['src']='graphics/upload/'.$sommet['name'];
            $prop['capt']=new Text($desc[0]);
            $prop['code']=$sommet['code'];
            $prop['width']=$sommet['width'];
            $prop['height']=$sommet['height'];
            if(isset($sommet['e1'])){$prop['e1']=$sommet['e1'];}
            if(isset($sommet['e2'])){$prop['e2']=$sommet['e2'];}
            if(isset($sommet['s'])){$prop['s']=$sommet['s'];}
            if(isset($sommet['inter'])){$prop['inter']=$sommet['inter'];}
            if(isset($sommet['lampe'])){$prop['lampe']=$sommet['lampe'];}
            
            $img->add($prop);
            $components->addElement($img);
            
        }
        $hg->addElement($components);
        //$this->addElement($hg);
        return $hg;
    }
    
    function getProprieties() {
        //---- Ce container va contenir les propriétés de chaque element
        
        $div_prop=new Div();
        $hp=new H3();
        $hp->addElement(new Text('X'));
        $hp->setAttribute('id', 'closeprop');
        
        $div_prop->setAttribute('class', 'prop');
        $hg_prop=new Hgroup();
        $hg_prop->setAttribute('id', 'propriete');
        
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
        
        return $hg_prop;
        //--- On ajoute ce div dans le contanaire principal
        //$this->addElement($hg_prop);
    }
    
    function getGroupe() {
        //--- LES TOPICS POUR LE GROUPE ----
        
        $hg_topics=new Hgroup();
        $hg_topics->setAttribute('class', 'suppr');
        $h_group=new H3();
        $h_group->addElement(new Text('X'));
        $h_group->setAttribute('id', 'closeImg');
        
        $hg_topics->addElement($h_group);
        $div_group=new Div();
        $div_group->setAttribute('class', 'group');
        
        //-- Figure pour Hassen ----
        $hass=new Figure();
        $hass->add(Array('src'=>'graphics/upload/hassen.jpg', 'capt'=>new Text('Chater'), 0));
        $div_group->addElement($hass);
        
        //-- Figure pour Tochap ----
        $tochap=new Figure();
        $tochap->add(Array('src'=>'graphics/upload/tochap.jpg', 'capt'=>new Text('Tochap'), 0));
        $div_group->addElement($tochap);
        
        //-- Figure pour Chafik ----
        $chafik=new Figure();
        $chafik->add(Array('src'=>'graphics/upload/chafik.jpg', 'capt'=>new Text('Sfaxi'), 0));
        $div_group->addElement($chafik);
        
        //-- Figure pour Kader ----
        $ben=new Figure();
        $ben->add(Array('src'=>'graphics/upload/kader.png', 'capt'=>new Text('Kader'), 0));
        $div_group->addElement($ben);
        
        //--- Figure pour Idjabou --
        $idj=new Figure();
        $idj->add(Array('src'=>'graphics/upload/idjabou.png', 'capt'=>new Text('Idjabou'), 0));
        $div_group->addElement($idj);
        
        $hg_topics->addElement($div_group);
        
        return $hg_topics;
        //$this->addElement($hg_topics);
    }

}

