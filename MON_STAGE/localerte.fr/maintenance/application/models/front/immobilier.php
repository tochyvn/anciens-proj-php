<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of immobilier
 *
 * @author aicom
 */
class immobilier extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Selectionne les differents types d'immoblier
     */
    public function getTypeImmobilier(){
        $immobilier = array();
        $sql = '
                SELECT 
                    t.identifiant,
                    t.designation,
                    t.synonyme
                FROM type t
                WHERE t.position IS NOT NULL 
                ORDER BY position ASC
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $immobilier[] = $row;
            }
            return $immobilier;
        }
        return array('error' => true, 'msg' => "No records");
    }   
    
    public function getTypeImmoByDesignation($designation){
        $sql = '
                SELECT 
                    t.identifiant,
                    t.designation,
                    t.synonyme,
                    t.parent
                FROM type t
                WHERE t.designation = "'.$this->db->escape_like_str($designation).'"
                LIMIT 1
            ';
        $result = $this->db->query($sql);
         if($result->num_rows() > 0){
            $immobilier = $result->row_array();             
            return $immobilier;
        }
        return array('error' => true, 'msg' => "No records");
    }
}
