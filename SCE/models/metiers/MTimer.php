<?php

/* 
 * Le composant lampe
 */
class MTimer extends MOSommet {
    
    function __construct($descr,$id) {
        
        parent::__construct($descr, $id);
        $sortie=new MOut(0);
        
        $this->setSorties($sortie);
        $this->setCode_objet(1); //--- Ce code représente le nbr de pattes
        
    }

    //<editor-fold defaultstate="collapsed" desc="---- METHODES A REDEFINIR ---">
    
    public function toRefresh() {
        //$this->setEtat($this->getSorties()[0]->getEtat());
    }

    public function toHTML() {
       $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'width'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'TIMER.png','code'=>$this->getCode_objet(),'s'=>'FALSE');
        return $attr; 
    }

    public function toMOVE() {
        
    }

    //</editor-fold>
    
}

