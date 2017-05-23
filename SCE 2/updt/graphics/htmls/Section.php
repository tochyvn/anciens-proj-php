<?php

class Section extends ElementNonVide{

    function __construct() {
        parent::__construct();
    }
    
    function addSection(Noeud $noeud) {
        
        $this->addElement($noeud);
        
    }
    
    function addSections(array $neuds) {
        
        foreach ($neuds as $val) {
            $this->addElement($val);
        }
    }

}
