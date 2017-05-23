<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class MIOSommet extends MSommet {
    
    public function __construct($id, $pathImg, $nbreSortie, $nbreEntree) {
        parent::__construct($id, $pathImg);
        $this->buildBorne($nbreEntree, $nbreSortie);
    }
    /**
     * permettant de construire les bornes d'entrées et de sorties du sommet
     * @param type $nbreEntree nombre de bornes d'entrée
     * @param type $nbreSortie nombre de bornes de sorties
     */
    private function buildBorne($nbreEntree, $nbreSortie) {
        
        for ($index = 0; $index < $nbreEntree; $index++) {
            $this->setBornes(new Borne(FALSE, $index));
        }
        
        for ($index = 0; $index < $nbreSortie; $index++) {
            $this->setBornes(new Borne(TRUE, $index));
        }
        
    }
}

