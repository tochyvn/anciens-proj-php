<?php

/* 
 * La porte logique NOT
 */
class MNOT extends MIOSommet{

    
    function __construct($id,$descr,$entree) {
        
        parent::__construct($descr,$id);
        $this->setEntrees($entree);
        
        $sort=new MOut(0);
        $sort->setEtat(FALSE);
        $this->setSorties($sort);
        $this->toRefresh();
        
    }

    //<editor-fold defaultstate="collapsed" desc="--- LES METHODES À REDEFINIR ---">

    public function toRefresh() {
        
        $sortie = !$this->getEntrees()[0]->getEtat();
        $this->getSorties()[0]->setEtat($sortie);
        
    }

    public function toHTML() {
        $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'widht'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'NOT.png');
        return $attr;
    }

    public function toMOVE() {
        
    }

    //</editor-fold>

}

