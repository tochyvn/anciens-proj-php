<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class MISommet extends MSommet {
    
    
    function __construct($id, $pathImg, $nbreEntree) {
        parent::__construct($id, $pathImg);
        $this->buildBorneEntree($nbreEntree);
    }
    /**
     * Permet de construire les bornes d'entrées du sommet
     * @param type $nbre nombre de bornes d'entrée
     */
    private function buildBorneEntree($nbre) {
        
        for ($index = 0; $index < $nbre; $index++) {
            $this->setBornes(new Borne(FALSE, $index));
        }
        
    }
}
