<?php

/* 
 * Le composant lampe
 */
class MLampe extends MISommet {
    
    function __construct($descr,$id) {
        
        parent::__construct($descr, $id);
        $ent1=new MIn(0);
        
        $this->setEntrees($ent1);
        $this->setCode_objet(1);
        
    }

    //<editor-fold defaultstate="collapsed" desc="--- METHODES A REDEFINIR ---">
    
    public function toRefresh() {
        //$this->setEtat($this->getEntrees()[0]->getEtat()); 
    }

    public function toHTML() {
        $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'width'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'LAMPE.png','code'=>$this->getCode_objet(),'e1'=>'FALSE','lampe'=>'lampe');
        return $attr;
    }

    public function toMOVE() {
        
    }

    //</editor-fold>
    
}

