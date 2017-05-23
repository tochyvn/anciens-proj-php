<?php

class abonnement extends CI_Model{
    
    const ABONNEMENT_POSITIF = "OUI";
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert($adherent_id, $delai){
        $sql = '
                INSERT INTO abonnement
                (adherent, delai, enregistrement, premiere_utilisation)
                VALUES 
                (
                    '.(int)$adherent_id.',
                    '.(int)$delai.',
                    NOW(),
                    NOW()
                )
            ';
        $this->db->query($sql);
        if($this->db->affected_rows() == 1){
            return true;
        }  
        return array(
            'error'  => true,
            'msg'    => "Erreur insertion abonnement"
        );
    }
}