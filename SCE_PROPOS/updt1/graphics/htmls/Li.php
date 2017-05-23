<?php

class Li extends ElementNonVide{

    function __construct(Noeud $txt) {
        parent::__construct();
        $this->addElement($txt);
    }
    

}
