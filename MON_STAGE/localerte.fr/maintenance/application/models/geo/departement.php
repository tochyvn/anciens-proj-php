<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of departement
 *
 * @author aicom
 */
class departement extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 
     * @param sring $queryString
     * @return array
     */
    public function getAheadDepartement($queryString){
        $departement = array();
        $sql = '
                SELECT d.code, d.nom, d.identifiant  
                FROM departement d 
                WHERE d.nom LIKE "%'.$this->db->escape_like_str($queryString).'%"
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $departement[] = $row;
            }
            return $departement;
        }
        return array('error' => true, 'msg' => "No records");
    }
    
    /**
     * retourne le departement en fonction du code
     * @param string $code
     * @return array
     */
    public function getDepartmentByCode($code){
        $sql = '
                SELECT d.code, d.nom, d.identifiant  
                FROM departement d 
                WHERE d.code = "'.$this->db->escape_like_str($code).'"
                LIMIT 1
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            return $result->row_array(); 
        }       
        return array('error' => true, 'msg' => "No records");
    }
}
