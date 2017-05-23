<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of redirection
 *
 * @author Guillaume
 */
class redirection extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert($annonce_id, $adherent_id, $ip){
        $sql = '
                INSERT INTO redirection
                (annonce_id, adherent_id, ip, heure)
                VALUES 
                ('.(int)$annonce_id.', '.(int)$adherent_id.', "'.$this->db->escape_like_str($ip).'", NOW())
            ';
        echo $sql;
        $this->db->query($sql);
        if($this->db->affected_rows() > 0 ){
            return true;
        }
        return array('error' => true, 'msg' => "Problème d'insertion du tracking");
    }
}
