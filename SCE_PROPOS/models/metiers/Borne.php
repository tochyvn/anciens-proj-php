<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Borne {
    
    private $etat;
    private $sommetAdjacent;
    private $sens;
    private $id;


    public function __construct($sens, $id) {
        $this->etat = FALSE;
        $this->sens = $sens;
        $this->id = $id;
        $this->sommetAdjacent = NULL;
    }
    
    function getId() {
        return $this->id;
    }
            
    function getEtat() {
        return $this->etat;
    }
    
    function getSommetAdj() {
        return $this->sommetAdjacent;
    }
    
    function getSens() {
        return $this->sens;
    }
    
    
    function setId($id) {
        $this->id = $id;
    }
            
    function setEtat($etat) {
        $this->etat = $etat;
    }
            
    function setSens($sens) {
        $this->sens = $sens;
    }
    
    function setSommetAdj($sommetAdj) {
        $this->sommetAdjacent = $sommetAdj;
    }
}

