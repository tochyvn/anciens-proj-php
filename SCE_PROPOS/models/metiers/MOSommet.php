<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class MOSommet extends MSommet {
    
    public function __construct($id, $pathImg, $nbreSortie) {
        parent::__construct($id, $pathImg);
        $this->buildBorneSortie($nbreSortie);
    }
    /**
     * Permettant de construire les bornes de sorties du sommet
     * @param type $nbre nombre de bornes de sorties
     */
    private function buildBorneSortie($nbre) {
        
        for ($index = 0; $index < $nbre; $index++) {
            $this->setBornes(new Borne(TRUE, $index));
        }
    }
}
