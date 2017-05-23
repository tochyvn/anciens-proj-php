<?php

class Li extends ElementNonVide{

    function __construct(Noeud $txt,$id) {
        parent::__construct();
        $this->addElement($txt);
        $this->setAttribute('class', $id);
    }
    

}
