<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of import
 *
 * @author Guillaume
 */
class import extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * inserer les statistiques dans la table de stats de locamax
     * @param string $fichier
     * @param int $importe_rejete_exclu_taille_errone
     * @param int $rejete_exclu_tailleerronne
     * @param int $ajoute
     * @param int $photo_manquant
     * @return boolean|array(error|msg) 
     */
    public function insertStatAnnonce($fichier, $importe_rejete_exclu_taille_errone, $rejete_exclu_tailleerronne, $ajoute, $photo_manquant){
        $sql = '
                INSERT INTO statistiques_import
                VALUES
                (
                        NOW(),
                        "'.$this->db->escape_like_str($fichier).'",
                        '.(int)$importe_rejete_exclu_taille_errone.',
                        '.(int)$rejete_exclu_tailleerronne.',
                        '.(int)$ajoute.',
                        '.(int)$photo_manquant.'
                )
            ';
        $this->db->query($sql);
        if($this->db->affected_rows() > 0){
            return true;
        }
        return array('error' => true, 'msg' => 'Erreur insertions stats dans la table statistiques_import');
    }
}
