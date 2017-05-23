<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of stats
 *
 * @author Guillaume
 */
class statistiques extends CI_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
       
    
    public function allopassJour(){
        $stats = array();
        $sql = '
                SELECT SUM(a.prix) as sum_prix, DATE(a.enregistrement) as temporel
                FROM allopass a
                GROUP BY DATE(a.enregistrement)
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $stats[] = $row;
            }
            return $stats;
        }
        return array('error' => true, 'msg' => "No stats");
    }
    
    public function allopassMois(){
        $stats = array();
        $sql = '
                SELECT SUM(a.prix) as sum_prix, CONCAT( MONTH(a.enregistrement), "-" ,YEAR(a.enregistrement)) as temporel
                FROM allopass a
                GROUP BY CONCAT(YEAR(a.enregistrement), MONTH(a.enregistrement))
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $stats[] = $row;
            }
            return $stats;
        }
        return array('error' => true, 'msg' => "No stats");
    }
    
    public function allopassAn(){
        $stats = array();
        $sql = '
                SELECT SUM(a.prix) as sum_prix, YEAR(a.enregistrement) as temporel
                FROM allopass a
                GROUP BY YEAR(a.enregistrement)
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $stats[] = $row;
            }
            return $stats;
        }
        return array('error' => true, 'msg' => "No stats");
    }
}
