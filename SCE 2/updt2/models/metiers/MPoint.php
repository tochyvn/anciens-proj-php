<?php

/* 
 * Un point composé d'une abscisse et d'une ordonnée
 */
class MPoint {

    private $x,$y;
    
    function __construct($x,$y) {
        
        $this->x=$x;
        $this->y=$y;
        
    }

    //<editor-fold defaultstate="collapsed" desc="--- LES ACCESSEURS/MUTATEURS ---">
    
    function getX() {
        return $this->x;
    }

    function getY() {
        return $this->y;
    }

    function setX($x) {
        $this->x = $x;
    }

    function setY($y) {
        $this->y = $y;
    }
    
    //</editor-fold>

}

