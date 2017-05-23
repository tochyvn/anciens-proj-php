<?php
class Label extends ElementNonVide {

    function __construct($attr) {
        parent::__construct();
        $this->setAttribute('for',$attr);
    }

}