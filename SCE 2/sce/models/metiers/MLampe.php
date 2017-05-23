<?php

/* 
 * Le composant lampe
 */
class MLampe extends MISommet {
    
    function __construct($descr,$id,$entree) {
        
        parent::__construct($descr, $id);
        $this->setEntres($entree);
        
        $this->setEtat($entree);
        $this->toRefresh();
        
    }
     //<editor-fold defaultstate="collapsed" desc="--- LES METHODES À REDEFINIR ---">
    public function toRefresh() {
        $this->setEtat($this->getEntres()[0]->getEtat()); 
    }

    public function toHTML() {
     $Attr=array("left"=>$this->getPosition()->getX(),'right'=> $this->getPosition()->getY(),'Widht'=> $this->getLarge(), 'Height'=> $this->getHauteur(),'name'=>'MLAMP.png');
        
        return $Attr;    
    }

    public function toMOVE() {
        
    }
    //</editor-fold>
}

