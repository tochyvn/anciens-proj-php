<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of region
 *
 * @author aicom
 */
class region extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function getAheadRegion($queryString){
        $regions = array();
        $sql = '
                SELECT r.identifiant, r.nom
                FROM region r 
                WHERE r.nom LIKE "%'.$this->db->escape_like_str($queryString).'%"
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $regions[] = $row;
            }
            return $regions;
        }
        return array('error' => true, 'msg' => "No records");
    }
    
    public function getRegionsByNomSlug($nom){
        $sql = '
                SELECT r.identifiant, r.nom
                FROM region r 
                WHERE r.nom_slug = "'.$this->db->escape_like_str($nom).'"
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            return $result->row_array(); 
        }       
        return array('error' => true, 'msg' => "No records");
    }
}
