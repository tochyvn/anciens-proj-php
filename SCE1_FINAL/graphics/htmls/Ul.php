<?php

class Ul extends ElementNonVide{
    
    function __construct() {
        parent::__construct();
    }
    
    function addLi(Li $li) {
        
        $this->addElement($li);
        
    }
    
    function addLis(Array $lis) {
        
        foreach ($lis as $val) {
        
            $this->addElement($val);
        
        }
    
    }

}
