<?php
	/**
	* 
	*/
        
	abstract class ElementNonVide extends Element
	{
		private $elements;
                
		function __construct()
		{
                    parent::__construct();
                    $this->elements=[];
                }
                function addElement(Noeud $obj)
                {
                    $this->elements[]=$obj;
                }
                function addElements(Array $obj)
                {
                    foreach ($obj as $value) {
                        $this->elements[]=$value;
                    }
                }
                /**
                 * @return string
                 * Retourne le Tag ouvrant d'une balise
                 */
                function openTag() {
                    
                    $str="<";
                    $str.=strtolower(get_class($this));
                    
                    //-- Si l'élement comporte des propriétés --//
                    
                    if(count($this->getAttributes()>0)){
                       foreach ($this->getAttributes() as $k=>$v)
                        {
                           if($v<>NULL){
                                $str.=" $k='$v'";   
                           }  
                           else {
                               $str.=" $k"; 
                           }
                        } 
                    }
                    
                    $str.=">\n";
                    
                    return $str;
                }
                
                function closeTag() {
                    
                    return "</".strtolower(get_class($this)).">\n";
                    
                }
                function toHTML()
                {
                    $str="";
                    $str.=$this->openTag();
                    
                    if(count($this->elements)>0){
                        foreach ($this->elements as $e)
                        {
                            $str.="     ".$e->toHTML()."\n";
                        }
                    }
                    
                    $str.=$this->closeTag();
                    
                    return $str;
                }
                
	}