<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reimporterAnnonce
 *
 * @author Guillaume
 */
    class reimporterannonce extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    public function doit(){
        $time = time() - 86400*10;
        $sql = '
                SELECT a.identifiant, a.provenance, a.ville, a.type, a.descriptif, a.enregistrement, a.modification, a.parution,
                a.loyer, a.statut, a.ville, a.image, a.url, a.provenance
                FROM  annonce a
                LEFT JOIN liste l ON l.identifiant = a.identifiant 
                WHERE DATE( a.parution ) >= "'.date('Y-m-d', $time).'"  
                AND etat = "VALIDE"
                AND l.identifiant IS NULL 
		ORDER BY DATE( a.enregistrement ) DESC
                LIMIT 48632
            ';
        $result = $this->db->query($sql);
        echo $result->num_rows().'<br/>';

        foreach( $result->result_array() as $key => $data ){
            $prix_no_null = false;

            if(!isset($data['ville']) || $data['ville'] == ''){
                continue;
            }
            $sql = '
                    SELECT * FROM ville
                    WHERE identifiant = '.$data['ville'].'
                    LIMIT 1
                ';
            
            $ville = $this->db->query($sql);
            $ville = $ville->row_array();
            $sql = '
                    SELECT * FROM provenance
                    WHERE identifiant = '.$data['provenance'].'
                ';
            $provenance = $this->db->query($sql);
            $provenance = $provenance->row_array();
            
            $sql = '
                    SELECT * FROM type WHERE
                    identifiant = '.$data['type'].'
                ';
            $type = $this->db->query($sql);
            $type = $type->row_array();
            
            $sql = '
                    INSERT INTO liste
                    	(identifiant, descriptif, enregistrement, modification, parution, loyer, statut, meuble, 
                         ville_identifiant, code_postal, ville_nom, 
                        image, url, type_identifiant, type_designation, provenance_identifiant, 
                        provenance_designation)
                    VALUES(
                        '.(int)$data['identifiant'].', '
                    . '"'.$this->db->escape_like_str($data["descriptif"]).'",'
                    . 'NOW(), '
                    . 'NOW(), '
                    . '"'.$data["parution"].'", '
                    . '"'.$data["loyer"].'", '
                    . '"'.$data["statut"].'", 
                        "0", '                    
                    . '"'.$this->db->escape_like_str($data['ville']).'", '
                    . '"'.$ville['code_postal'].'",  '
                    . '"'.$ville['nom'].'" ,  '
                    . '"'.$data['image'].'", '
                    . '"'.$data['url'].'", '
                    . '"'.$data['type'].'", '
                    . '"'.$type['designation'].'" , 
                        "'.$data['provenance'].'", '
                    . '"'.$provenance['designation'].'"   
                    )    
                ';
            $this->db->query($sql);
        }
    }
}
