<?php

abstract class ElementVide extends Element{

    function __construct() {
        parent::__construct();
    }
    
    function toHTML()
    {
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
        $str.=" />";
        return $str;
    }
}