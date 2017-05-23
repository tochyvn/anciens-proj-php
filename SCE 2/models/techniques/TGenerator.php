<?php

/* 
 * Cette classe va gérer la création 
 * de chaque composant demandé
 */
class TGenerator {

    private $sommets;
    
    function __construct() {
        $this->sommets=null;
    }
    
    public function load(){
        
        //-- Création des ENTREES et de la porte AND ---
        $ent1=new MIn(0);
        $ent1->setEtat(FALSE);
        $ent2=new MIn(1);
        $ent2->setEtat(TRUE);
        
        $and=new TAND(0,"comp",$ent1,$ent2);
        $this->sommets[]=$and;
        //-----------------
        
        //-- Création de la porte NAND ---
        $nand=new TNAND(0,"comp",$ent1,$ent2);
        $this->sommets[]=$nand;
        //-----------------
        
        //-- Création de la porte OR ---
        $or=new TOR(0,"comp",$ent1,$ent2);
        $this->sommets[]=$or;
        //-----------------
        
        //-- Création de la porte NOR ---
        $nor=new TNOR(0,"comp",$ent1,$ent2);
        $this->sommets[]=$nor;
        //-----------------
        
        
        
        
        //$this->components[]=$mio;
    }

}

