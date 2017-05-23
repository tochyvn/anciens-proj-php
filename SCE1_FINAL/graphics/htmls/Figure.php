<?php

class Figure extends ElementNonVide{

    function __construct() {
        parent::__construct();
    }
    
    function addImg($src) {
        
        $sr=new Img();
        $sr->setAttribute('src', $src);
        $sr->setAttribute('class', 'items');
        if(preg_match("#.*/(.*)\..*#", $src,$matches)){
            $sr->setAttribute('id', $matches[1]);
        }
        $this->addElement($sr);
          
    }
    
    function addCaption($ct) {
        
        $capt=new FigCaption();
        $capt->addElement($ct);
        $this->addElement($capt);
        
    }
    
    function add($src, $ct) {
        
        $this->addImg($src);
        $this->addCaption($ct);
       
    }

}
