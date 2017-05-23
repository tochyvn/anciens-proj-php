<?php
/**
* 
*/

class Text extends Noeud
{
    private $txt;

    function __construct($txt){
        parent::__construct();
        $this->txt=$txt;
    }

    function toHTML(){
	return $this->txt;
    }
}