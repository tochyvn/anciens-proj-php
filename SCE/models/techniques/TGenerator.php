<?php

/* 
 * Cette classe va gérer la création 
 * de chaque composant demandé
 */
class TGenerator {

    private $sommets;
    private $schema;
    private $interrupt;
    private $lien_object;
    private $lien_patte;
    private $nbr_sommets=0;
    private $gr_interne;
    private $graph;
    private $gr;
    
    function __construct() {
        $this->sommets=[];
        $this->schema=[];
        $this->lien_object=[];
        $this->load();
        
        //---- Initialisation du graph ----
        $this->graph.="\r\n";
        $this->graph.="digraph G {\r\n";
        $this->graph.="\r\n";
        $this->graph.="\t edge [color=red, arrowsize=1];\r\n"; 
        $this->graph.="\t node [color=lightyellow2, style=filled];\r\n";
        $this->graph.="\r\n";
    }
    
    public function load(){
       
        //-- Création des ENTREES et de la porte AND ---
        
        $and=new MAND(0,"AND");
        $this->sommets[]=$and;
        //-----------------
        
        //-- Création de la porte NAND ---
        $nand=new MNAND(0,"NAND");
        $this->sommets[]=$nand;
        //-----------------
        
        //-- Création de la porte OR ---
        $or=new MOR(0,"OR");
        $this->sommets[]=$or;
        //-----------------
        
        //-- Création de la porte NOR ---
        $nor=new MNOR(0,"NOR");
        $this->sommets[]=$nor;
        //-----------------
        
        //-- Création de la porte NOT ---
        $not=new MNOT(0,"NOT");
        $this->sommets[]=$not;
        //-----------------
        
        //-- Création de la porte XOR ---
        $xor=new MXOR(0,"XOR");
        $this->sommets[]=$xor;
        //-----------------
        
        //-- Création de la porte XNOR ---
        $xnor=new MXNOR(0,"XNOR");
        $this->sommets[]=$xnor;
        //-----------------
        
        //--- Création de la lampe ----
        $lamp=new MLampe("LAMPE", 0);
        $this->sommets[]=$lamp;
        //----------------
        
        //---- Création de l'Interrupteur ----
        $interrupt=new MInterrupt("INTER", 0);
        $this->sommets[]=$interrupt;
        
        //--- Création du Timer ---
        $time=new MTimer("TIMER", 0);
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
    
    public function newSommet(array $tab) {
        
        $this->createElement($tab);
        return $this->graphics();
        
    }
    
    
    /**
     * 
     * @param array $prop
     * Cette méthode va créer un objet selon la valeur du tagName
     * 
     */
    private function createElement(array $tab) {
        //$newObjet=null;
        $entree1=new MIn(0);
        $entree2=new MIn(1);
        $sortie=new MOut(0);
        
        foreach ($tab as $prop) {
            
            $pos=new MPoint($prop['left'], $prop['top']);
            
            if($prop['name']=='AND'){$newObjet=new MAND($prop['id'], $prop['name'], $entree1, $entree2); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='NAND'){$newObjet=new MNAND($prop['id'], $prop['name'], $entree1, $entree2); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='NOR'){$newObjet=new MNOR($prop['id'], $prop['name'], $entree1, $entree2); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='OR'){$newObjet=new MOR($prop['id'], $prop['name'], $entree1, $entree2); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='NOT'){$newObjet=new MNOT($prop['id'], $prop['name'], $entree1); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='XOR'){$newObjet=new MXOR($prop['id'], $prop['name'], $entree1, $entree2); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='XNOR'){$newObjet=new MXNOR($prop['id'], $prop['name'], $entree1, $entree2); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='TIMER'){$newObjet=new MTimer($prop['name'], $prop['id'], $sortie); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='LAMPE'){$newObjet=new MLampe($prop['name'], $prop['id'], $entree1); $newObjet->setSrc($prop['src']);}
            if($prop['name']=='INTER'){$newObjet=new MInterrupt($prop['name'], $prop['id'], $sortie); $newObjet->setSrc($prop['src']);}
        
            $newObjet->setPosition($pos);
            $lien= preg_replace("#\s+#","",$prop['lien']);
            if(strlen($lien)>0){
               $l=  explode(" ",$prop['lien']);
               $t=[];
               foreach ($l as $v) {
                   $t[]=  explode(":", $v)[0];
               }
               $this->lien_object[$prop['id']]=$t; 
            }
            
            $this->schema[]=$newObjet;
        }
     
        //--- On genère les noeuds fils -----
        $this->genereChild();
    }
    
    /**
     * Cette fonction va créer les objets, leur donner leurs valeur pour permettre
     * la simulation ----
     */
    function createSimule(array $obj) {
        $vr=$this->create($obj);
        for ($i=0;$i<count($this->schema); $i++) {
            $this->propagation($this->schema[$i]);
        }
        return $vr;
    }
    function create($tab) {
       //$newObjet=null;
        $retour=null;
        //print_r($tab);
        foreach ($tab as $prop) {
            $entree1=new MIn(0);
            $entree2=new MIn(1);
            $sortie=new MOut(0);
            
            if(isset($prop['e1'])){$entree1->setEtat($prop['e1']);}
            if(isset($prop['e2'])){$entree2->setEtat($prop['e2']);}
            if(isset($prop['s'])){$sortie->setEtat($prop['s']);}
            
            if($prop['name']=='AND'){
                $newObjet=new MAND($prop['id'], $prop['name']);
                $newObjet->setEntrees($entree1);
                $newObjet->setEntrees($entree2);
            }
            if($prop['name']=='NAND'){
                $newObjet=new MNAND($prop['id'], $prop['name']);
                $newObjet->setEntrees($entree1);
                $newObjet->setEntrees($entree2);
            }
            if($prop['name']=='NOR'){
                $newObjet=new MNOR($prop['id'], $prop['name']);
                $newObjet->setEntrees($entree1);
                $newObjet->setEntrees($entree2);
            }
            if($prop['name']=='OR'){
                $newObjet=new MOR($prop['id'], $prop['name']);
                $newObjet->setEntrees($entree1);
                $newObjet->setEntrees($entree2);
            }
            if($prop['name']=='NOT'){
                $newObjet=new MNOT($prop['id'], $prop['name']);
                $newObjet->setEntrees($entree1);
            }
            if($prop['name']=='XOR'){
                $newObjet=new MXOR($prop['id'], $prop['name']);
                $newObjet->setEntrees($entree1);
                $newObjet->setEntrees($entree2);
            }
            if($prop['name']=='XNOR'){
                $newObjet=new MXNOR($prop['id'], $prop['name']);
                $newObjet->setEntrees($entree1);
                $newObjet->setEntrees($entree2);
            }
            if($prop['name']=='TIMER'){
                $newObjet=new MTimer($prop['name'], $prop['id']);
                $newObjet->setSorties($sortie);
            }
            if($prop['name']=='LAMPE'){
                $newObjet=new MLampe($prop['name'], $prop['id']);
                $newObjet->setEntrees($entree1);
            }
            if($prop['name']=='INTER'){
                $newObjet=new MInterrupt($prop['name'], $prop['id']);
                $newObjet->setSorties($sortie);
                //$retour=$newObjet->getSorties()[0]->getEtat();
                $this->interrupt[]=$newObjet;
            }

            $lien= preg_replace("#\s+#","",$prop['lien']);
            if(strlen($lien)>0){
               $l=  explode(" ",$prop['lien']);
               $t=[];
               foreach ($l as $v) {
                   $s=explode(":", $v);
                   $t[]=$s[0];
                   $newObjet->setPatte_child($s[0], $s[1]);
               }
               $this->lien_object[$prop['id']]=$t;
            }
            $this->schema[]=$newObjet;
        }
     
        //--- On genère les noeuds fils -----
        $this->genereChild(); 
        
        //return $retour;
    }
    function propagation($pointEntree) {
        
        if(count($pointEntree->getChilds())>0){
            
            /*echo $pointEntree->getDescription()." --> ".
                    $pointEntree->getChilds()[0]->getDescription()." : ".
                    $pointEntree->getSorties()[0]->getEtat().
                    " || ";*/
            for ($i=0;$i<count($pointEntree->getChilds()); $i++) {
                //--- On recupère la patte utilisée ---
                //echo $pointEntree->getSorties()[0]->getEtat();
                $patte=$pointEntree->getPatte_child($pointEntree->getChilds()[$i]->getId());
                //print_r($patte);
                foreach ($patte as $v) {
                    $pointEntree->getChilds()[$i]->getEntrees()[$v]->setEtat($pointEntree->getSorties()[0]->getEtat());
                    echo $pointEntree->getChilds()[$i]->toRefresh();
                    //if(isset($pointEntree->getChilds()[$i]->getSorties()[0])){
                       //echo $pointEntree->getDescription()." --> ".$pointEntree->getSorties()[0]->getEtat()." || ";
                    //}
                }
                
                $this->propagation($pointEntree->getChilds()[$i]);
                
                //if($pointEntree->getChilds()[$i]->getSorties()[0]!==null){
                    //echo $pointEntree->getDescription()." --> ".$pointEntree->getChilds()[$i]->getEntrees()[0]->getEtat();
                //}
            }
            
        }
        
    }
    /**
     * Cette finction va créer le code graph Viz
     */
    private function graphics() {

        $this->gr_interne="";
        
        foreach ($this->schema as $sch) {
            $this->gr="";
            $this->gr.=$this->graph;
            //if(!$sch->getEtat()){
               if(count($sch->getChilds())>0){
                    foreach ($sch->getChilds() as $child) {
                        //echo $sch->getId();
                        
                        $this->gr_interne.="\t ".$sch->getId()." -> ".$child->getId()."\r\n";
                    } 
                }
                
            //}  
        }
        $this->gr.=$this->parcours($sch);
        
        $this->gr.="}";      

        return $this->gr;
        
    }
    private function parcours($sch) { 
        
        foreach ($this->schema as $sch) {
            
            $this->nbr_sommets++;
            //--- Assignation des liens parents-fils ----
            $this->gr_interne.="\r\n";
            $this->gr_interne.="\t S".$this->nbr_sommets." [label=\"".$sch->getDescription()."\"];\r\n";
            $this->gr_interne.="\t S".$this->nbr_sommets." [width=\"".$sch->getLarge()."\", height=\"".$sch->getHauteur()."\"];\r\n";
            $this->gr_interne.="\t S".$this->nbr_sommets." [top=\"".$sch->getPosition()->getY()."\", left=\"".$sch->getPosition()->getX()."\"];\r\n";

        }
        
        return $this->gr_interne;
    }
    function getObject($id) {
        foreach ($this->schema as $value) {
            if($value->getId()===$id){
                return $value;
            }
        }
    }
    function genereChild() {
        
        foreach ($this->lien_object as $key => $child) {
            $me=$this->getObject($key);
            foreach ($child as $val) {
                if(!is_null($this->getObject($val))){
                    $me->addChild($this->getObject($val));
                }
            }
        }
    }
    
    
}

