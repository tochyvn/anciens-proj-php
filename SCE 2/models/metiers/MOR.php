<?php

/* 
 * La porte logique OR
 */
class MOR extends MIOSommet{

    
    function __construct($id,$descr,$entree1,$entree2) {
        
        parent::__construct($descr,$id);
        $this->setEntrees($entree1);
        $this->setEntrees($entree2);
        
        $sort=new MOut(0);
        $sort->setEtat(FALSE);
        $this->setSorties($sort);
        $this->toRefresh();
        
    }

    //<editor-fold defaultstate="collapsed" desc="--- LES METHODES À REDEFINIR ---">
    
    public function toHTML(){
        
    }

    public function toMOVE(){
        
    }

    public function toRefresh() {
        
        $sortie = $this->getEntrees()[0]->getEtat() || $this->getEntrees()[1]->getEtat();
        $this->getSorties()[0]->setEtat($sortie);
        
    }

    //</editor-fold>

}

