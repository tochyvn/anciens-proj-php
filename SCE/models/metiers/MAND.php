<?php

/* 
 * La porte logique AND
 */
class MAND extends MIOSommet{

    
    function __construct($id,$descr) {
        
        parent::__construct($descr,$id);
        
        $ent1=new MIn(0);
        $ent2=new MIn(1);
        
        $this->setEntrees($ent1);
        $this->setEntrees($ent2);
        
        $sort=new MOut(0);
        $sort->setEtat(FALSE);
        $this->setSorties($sort);
        $this->toRefresh();
        
        $this->setCode_objet(3);
        
    }

    //<editor-fold defaultstate="collapsed" desc="--- LES METHODES À REDEFINIR ---">

    public function toRefresh() {
        
        $sortie = $this->getEntrees()[0]->getEtat() && $this->getEntrees()[1]->getEtat();
        $this->getSorties()[0]->setEtat($sortie);
        
    }

    public function toHTML() {
        $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'width'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'AND.png','code'=>$this->getCode_objet(),'e1'=>'FALSE','e2'=>'FALSE','s'=>'FALSE');
        return $attr;
    }

    public function toMOVE() {
        
    }

    //</editor-fold>

}

