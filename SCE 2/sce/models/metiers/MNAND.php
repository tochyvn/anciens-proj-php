<?php

/* 
 * La porte logique NAND
 */
class MNAND extends MIOSommet {

    function __construct($id,$descr,$entree1,$entree2) {
        
        parent::__construct($descr,$id);
        $this->setEntrees($entree1);
        $this->setEntrees($entree2);
        
        $sort=new MOut(0);
        $sort->setEtat(FALSE);
        $this->setSorties($sort);
        $this->toRefresh();
        
    }
    //<editor-fold defaultstate="collapsed" desc="---METHODE A REDEFINIR--">
    
    public function toRefresh() {
       
        $sortie=!($this->getEntrees()[0]->getEtat() && $this->getEntrees()[1]->getEtat());
        $this->getSorties()[0]->setEtat($sortie);
        
    }

    public function toHTML() {
      $Attr=array("left"=>$this->getPosition()->getX(),'right'=> $this->getPosition()->getY(),'Widht'=> $this->getLarge(), 'Height'=> $this->getHauteur(),'name'=>'NAND.png');
        
        return $Attr;   
    }

    public function toMOVE() {
        
    }
    
    //</editor-fold>

}

