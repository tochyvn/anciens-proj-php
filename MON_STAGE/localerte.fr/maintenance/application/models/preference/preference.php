<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of preference
 *
 * @author Guillaume
 */
class preference extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get(){
        $sql = '
                SELECT * 
                FROM preference
                LIMIT 1
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            $preference = $result->row_array();            
            return $preference;
        }
        return array('error' => true, 'msg' => "No preference");
    }
}
