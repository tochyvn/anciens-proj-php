<?php

/* 
 * Le composant lampe
 */
class MInterrupt extends MOSommet {
    
    function __construct($descr,$id,$sortes) {
        
        parent::__construct($descr, $id);
        $this->setEntres($sortes);
        
        $this->setEtat($sortes);
        $this->toRefresh();
        
    }
    //<editor-fold defaultstate="collapsed" desc="--- LES METHODES À REDEFINIR ---">
    public function toRefresh() {
        $this->setEtat($this->getSorties()[0]->getEtat());
    }

    public function toHTML() {
      $Attr=array("left"=>$this->getPosition()->getX(),
          'right'=> $this->getPosition()->getY(),
          'Widht'=> $this->getLarge(), 
          'Height'=> $this->getHauteur(),
          'name'=>'INTER.png');
        
        return $Attr;   
    }

    public function toMOVE() {
        
    }
   //</editor-fold>

}

