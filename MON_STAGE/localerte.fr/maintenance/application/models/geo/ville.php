<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ville
 *
 * @author aicom
 */
class ville extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
     
    
    public function getVilles($limit = true){
        if($limit == true){
            $limit = "LIMIT 100";
        }
        $villes = array();
        $sql = '
                SELECT v.identifiant, v.code_postal, v.nom 
                FROM ville v     
                '.$limit.'
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $villes[] = $row;
            }
            return $villes;
        }
        return array('error' => true, 'msg' => "No records");
    }
    
    /**
     * Recherche les villes en fonction du string passe en parametre
     * @param type $queryString : string ville recherche
     * @param type $limit : nombre de resultat a recuperer
     * @return array
     */
    public function getVillesRecherche($queryString, $limit = 20){
        $villes = array();
        $sql = '
                SELECT vr.identifiant, v.latitude, v.longitude, vr.designation, v.ville_nom_reel, v.code_postal
                FROM ville_recherche vr
                INNER JOIN ville v ON v.identifiant = vr.identifiant
                WHERE vr.designation LIKE "%'.$this->db->escape_like_str($queryString).'%"
                AND vr.designation != 0
                ORDER BY v.ville_population DESC
                LIMIT '.(int)$limit.'
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $villes[] = $row;
            }
            return $villes;
        }
        return array('error' => true, 'msg' => "No records");
    }
    
    /**
     * obtenir la vill par le code postal
     * @param string $cp
     */
    public function getVilleByCP($cp = false, $ville = false, $type = 1){
        switch($type){
            case 1:
               $condition = 'WHERE code_postal = "'.$this->db->escape_like_str($cp).'"';     
            break;
            case 2:
                $condition = 'WHERE nom like "%'.$this->db->escape_like_str($ville).'%" AND code_postal LIKE "'.$this->db->escape_like_str($cp).'%"';    
            break; 
            case 3:
                $condition =  'WHERE nom like "%'.$this->db->escape_like_str($ville).'%"';   
            break;
        }
        $sql = '
                SELECT 
                    identifiant, 
                    departement, 
                    nom, 
                    code_postal, 
                    nom_accent, 
                    longitude, 
                    latitude                    
                FROM ville
                '.$condition.'
                LIMIT 1
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            $ville = $result->row_array();
            return $ville;
        }
        return array('error' => true, 'msg' => "No records");
    }
}
