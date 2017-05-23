<?php

/* 
 * Cette classe va gérer la création 
 * de chaque composant demandé
 */
class TGenerator {

    private $sommets;
    
    
    function __construct() {
        $this->sommets=[];
        
        $this->load();
    }
    
    public function load(){
        
        $ent1=new MIn(0);
        $ent1->setEtat(FALSE);
        $ent2=new MIn(1);
        $ent2->setEtat(FALSE);
        
        
        //-- Création des ENTREES et de la porte AND ---
        
        $and=new MAND(0,"ET",$ent1,$ent2);
        $this->sommets[]=$and;
        //-----------------
        
        //-- Création de la porte NAND ---
        $nand=new MNAND(0,"NON-ET",$ent1,$ent2);
        $this->sommets[]=$nand;
        //-----------------
        
        //-- Création de la porte OR ---
        $or=new MOR(0,"OU",$ent1,$ent2);
        $this->sommets[]=$or;
        //-----------------
        
        //-- Création de la porte NOR ---
        $nor=new MNOR(0,"NON-OU",$ent1,$ent2);
        $this->sommets[]=$nor;
        //-----------------
        
        //-- Création de la porte NOT ---
        $not=new MNOT(0,"NON",$ent1,$ent2);
        $this->sommets[]=$not;
        //-----------------
        
        //-- Création de la porte XOR ---
        $xor=new MXOR(0,"OU-EXC",$ent1,$ent2);
        $this->sommets[]=$xor;
        //-----------------
        
        //-- Création de la porte XNOR ---
        $xnor=new MXNOR(0,"NON-OU-EXC",$ent1,$ent2);
        $this->sommets[]=$xnor;
        //-----------------
        
        
    }
    public function parcours($sommet) {
        
        $this->html.=$sommet->toHTML();
        echo "Av - ".$sommet->getPorte()->getEtat()." > ";
        $sommet->getPorte()->setEtat(TRUE);
        
        if(count($sommet->getChilds())>0){
            
            foreach ($sommet->getChilds as $child) {
                if(count($child->getChilds())>0){
                    $this->html.=$this->parcours($child);
                } 
            }
            
        }
        
        return $this->html;
    }
    //returner 
    public function getSommets(){
        $html=[];
        foreach ($this->sommets as $sommet) {
           // $this->html.=$this->parcours($sommet);
            //echo "Ap - ".$sommet->getPorte()->getEtat()." > ";
            $html[]=$sommet->toHTML();
        }
        
        return $html;
    }
    
}

