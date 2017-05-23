<?php

/* 
 * Le composant lampe
 */
class MInterrupt extends MOSommet {
    
    function __construct($descr,$id,$sortes) {
        
        parent::__construct($descr, $id);
        $this->setSorties($sortes);
        //$this->toRefresh();
        
    }

    //<editor-fold defaultstate="collapsed" desc="---- METHODES A REDEFINIR ---">
    
    public function toRefresh() {
        //$this->getSorties()[0]->setEtat($this->getSorties()[0]->getEtat());
    }

    public function toHTML() {
       $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'widht'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'INTER.png');
        return $attr; 
    }

    public function toMOVE() {
        
    }

    //</editor-fold>
    
}

