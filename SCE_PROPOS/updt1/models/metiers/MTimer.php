<?php

/* 
 * Le composant lampe
 */
class MTimer extends MOSommet {
    
    function __construct($descr,$id,$sortes) {
        
        parent::__construct($descr, $id);
        $this->setSorties($sortes);
        //$this->toRefresh();
        
    }

    //<editor-fold defaultstate="collapsed" desc="---- METHODES A REDEFINIR ---">
    
    public function toRefresh() {
        //$this->setEtat($this->getSorties()[0]->getEtat());
    }

    public function toHTML() {
       $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'widht'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'TIMER.png');
        return $attr; 
    }

    public function toMOVE() {
        
    }

    //</editor-fold>
    
}

