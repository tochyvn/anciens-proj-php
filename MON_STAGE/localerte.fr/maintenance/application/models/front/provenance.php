<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of provenance
 *
 * @author Guillaume
 */
class provenance extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function getByCode($code){
        $sql = '
                SELECT identifiant, code, designation, accueil, classification
                FROM provenance
                WHERE code = "'.$this->db->escape_like_str($code).'"
                LIMIT 1
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            $row = $result->row_array();
            $provenance = $row;         
            return $provenance;
        }
        return array('error' => true, 'msg' => "No records");
    }
    public function get(){
        $provenances = array();
        $sql = '
                SELECT identifiant, code, designation, accueil, classification
                FROM provenance
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $provenances[$row['code']] = $row;
            }
            return $provenances;
        }
        return array('error' => true, 'msg' => "No records");
    }
}
