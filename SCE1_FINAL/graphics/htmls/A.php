<?php

class A extends ElementNonVide{

    function __construct(Noeud $el,$url) {
        parent::__construct();
        $this->addElement($el);
        $this->setAttribute('href', $url);
    }
    

}
