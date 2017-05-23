<?php

/* 
 * Le composant lampe
 */
class MLampe extends MISommet {
    
    function __construct($descr,$id,$entree) {
        
        parent::__construct($descr, $id);
        $this->setEntrees($entree);
        //$this->toRefresh();
        
    }

    //<editor-fold defaultstate="collapsed" desc="--- METHODES A REDEFINIR ---">
    
    public function toRefresh() {
        //$this->setEtat($this->getEntrees()[0]->getEtat()); 
    }

    public function toHTML() {
        $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'widht'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'LAMPE.png');
        return $attr;
    }

    public function toMOVE() {
        
    }

    //</editor-fold>
    
}

