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
        $ent2=new MIn(1);
        
        //-- Création des ENTREES et de la porte AND ---
        
        $and=new MAND(0,"AND",$ent1,$ent2);
        $this->sommets[]=$and;
        //-----------------
        
        //-- Création de la porte NAND ---
        $nand=new MNAND(0,"NAND",$ent1,$ent2);
        $this->sommets[]=$nand;
        //-----------------
        
        //-- Création de la porte OR ---
        $or=new MOR(0,"OR",$ent1,$ent2);
        $this->sommets[]=$or;
        //-----------------
        
        //-- Création de la porte NOR ---
        $nor=new MNOR(0,"NOR",$ent1,$ent2);
        $this->sommets[]=$nor;
        //-----------------
        
        //-- Création de la porte NOT ---
        $not=new MNOT(0,"NOT",$ent1,$ent2);
        $this->sommets[]=$not;
        //-----------------
        
        //-- Création de la porte XOR ---
        $xor=new MXOR(0,"XOR",$ent1,$ent2);
        $this->sommets[]=$xor;
        //-----------------
        
        //-- Création de la porte XNOR ---
        $xnor=new MXNOR(0,"XNOR",$ent1,$ent2);
        $this->sommets[]=$xnor;
        //-----------------
        
        //--- Création de la lampe ----
        $lamp=new MLampe("LAMPE", 0, $ent1);
        $this->sommets[]=$lamp;
        //----------------
        
        //---- Création de l'Interrupteur ----
        $sortie=new MOut(0);
        $interrupt=new MInterrupt("INTER", 0,$sortie);
        $this->sommets[]=$interrupt;
        
        //--- Création du Timer ---
        $time=new MTimer("TIMER", 0, $sortie);
        $this->sommets[]=$time;
        
    }
   
    public function getSommets(){
        $html=[];
        foreach ($this->sommets as $sommet) {
            $html[]=$sommet->toHTML();
        }
        
        return $html;
    }
    
    public function getSommetByName($name) {
    
        foreach ($this->sommets as $sommet) {
            if($sommet->getDescription()==$name){
                
                $proprieties=array('Description'=>$sommet->getDescription(),
                'Etat'=>$sommet->getEtat(),
                'ID'=>$sommet->getId(),
                'Nombre entrées'=>$sommet->getEntrees()?count($sommet->getEntrees()):0,
                'Nombre sorties'=>$sommet->getSorties()?count($sommet->getSorties()):0);
                return $proprieties;
            }
        }
            
    }
    
}

