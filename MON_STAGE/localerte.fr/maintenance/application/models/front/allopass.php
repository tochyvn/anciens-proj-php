<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of allopass
 *
 * @author aicom
 */
class allopass extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * methode d'insertion d'une transaction allopass en bdd
     * @param string $adherent
     * @param int $reference
     * @param float $prix
     * @return array|boolean
     */
    public function insert($adherent, $reference, $prix){
        $sql = '
                INSERT INTO allopass
                (reference, adherent, enregistrement, prix)
                VALUES 
                (
                    "'.$this->db->escape_like_str($reference).'",
                    '.(int)$adherent.',
                    NOW(),
                    "'.(float)$prix.'",
                )
            ';
        $this->db->query($sql);
        if($this->db->affected_rows() == 1){
            return true;
        }  
        return array(
            'error'  => true,
            'msg'    => "Erreur insertion allopass"
        );
    }
}
