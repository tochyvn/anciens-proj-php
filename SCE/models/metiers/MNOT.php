<?php

/* 
 * La porte logique NOT
 */
class MNOT extends MIOSommet{

    
    function __construct($id,$descr) {
        $ent1=new MIn(0);
        
        parent::__construct($descr,$id);
        /*
        $this->setEntrees($ent1);
        */
        $sort=new MOut(0);
        $sort->setEtat(FALSE);
        $this->setSorties($sort);
        //$this->toRefresh();
        
        $this->setCode_objet(2); //--- Ce code représente le nbr de pattes
        
    }

    //<editor-fold defaultstate="collapsed" desc="--- LES METHODES À REDEFINIR ---">

    public function toRefresh() {
        if(isset($this->getEntrees()[0]) && isset($this->getSorties()[0])){
            
            $sortie = false;
            if($this->getEntrees()[0]->getEtat()){
                $sortie=false;
            }else{
                $sortie=true;
            }
            //$this->getSorties()[0]->setEtat($sortie);
            return "KO ".($this->getEntrees()[0]->getEtat());
        }
        
        //echo $this->getSorties()[0]->getEtat();
        
    }

    public function toHTML() {
        //echo $this->getEntrees()[0]->getEtat();
        $attr=array('left'=>$this->getPosition()->getX(),'right'=>  $this->getPosition()->getY(),'width'=>  $this->getLarge(),'height'=>  $this->getHauteur(),'name'=>'NOT.png','code'=>$this->getCode_objet(),'e1'=>'false','s'=>'false');
        return $attr;
    }

    public function toMOVE() {
        
    }

    //</editor-fold>

}

