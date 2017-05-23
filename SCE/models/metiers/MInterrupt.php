<?php

/* 
 * Le composant lampe
 */
class MInterrupt extends MOSommet {
    
    function __construct($descr,$id) {
        
        parent::__construct($descr, $id);
        //$sortie=new MOut(0);
        //$this->setSorties($sortie);
        $this->setCode_objet(1);
        
    }

    //<editor-fold defaultstate="collapsed" desc="---- METHODES A REDEFINIR ---">
    
    public function toRefresh() {
        //$this->getSorties()[0]->setEtat($this->getSorties()[0]->getEtat());
    }

    public function toHTML() {
       $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'width'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'INTER.png','code'=>$this->getCode_objet(),'s'=>'FALSE','inter'=>'inter');
        return $attr; 
    }

    public function toMOVE() {
        
    }

    //</editor-fold>
    
}

