<?php

class Figure extends ElementNonVide{

    function __construct() {
        parent::__construct();
    }
    
    function addImg($prop) {
        
        $sr=new Img();
        $sr->setAttribute('src', $prop['src']);
        $sr->setAttribute('class', 'items');
        if(isset($prop['code'])){$sr->setAttribute('code', $prop['code']);}
        if(isset($prop['width'])){$sr->setAttribute('width', $prop['width']);}
        if(isset($prop['height'])){$sr->setAttribute('height', $prop['height']);}
        if(isset($prop['e1'])){$sr->setAttribute('e1',$prop['e1']);}
        if(isset($prop['e2'])){$sr->setAttribute('e2',$prop['e2']);}
        if(isset($prop['s'])){$sr->setAttribute('s',$prop['s']);}
        if(isset($prop['inter'])){$sr->setAttribute('inter',$prop['inter']);}
        if(isset($prop['lampe'])){$sr->setAttribute('lampe',$prop['lampe']);}
            
        if(preg_match("#.*/(.*)\..*#", $prop['src'],$matches)){
            $sr->setAttribute('id', $matches[1]);
        }
        $this->addElement($sr);
          
    }
    
    function addCaption($ct) {
        
        $capt=new FigCaption();
        $capt->addElement($ct);
        $this->addElement($capt);
        
    }
    
    function add(Array $prop) {
        
        $this->addImg($prop);
        $this->addCaption($prop['capt']);
       
    }

}
