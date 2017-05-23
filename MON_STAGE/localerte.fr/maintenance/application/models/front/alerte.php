<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of alerte
 *
 * @author aicom
 */
class alerte extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Verifie qu'une alerte existe ou pas
     * @param int $adherent_id
     * @param int $ville_id
     * @param int $immobilier_id
     * @return type
     */
    public function ifAlerteExists($adherent_id, $ville_id, $immobilier_id){
        $sql = '
                SELECT aiv.alerte_immo_ville_id, aiv.immobilier_id, aiv.adherent_id, 
                aiv.ville_id, aiv.enregistrement, aiv.active, aiv.modification
                FROM alerte_immo_ville aiv
                WHERE aiv.immobilier_id = '.(int)$immobilier_id.'
                AND aiv.adherent_id = '.(int)$adherent_id.'
                AND aiv.ville_id = '.(int)$ville_id.'
                AND aiv.active = "OUI"
                LIMIT 1
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            return array('statut' => false, 'alerte' => $result->row_array());
        }
         return array('statut' => true);
    }
    
    /**
     * Méthode d'insertion des alertes 
     * @param type $adherent_id
     * @param type $designation
     * @param type $ville_id
     * @param type $immobilier_id
     * @return array
     */
    public function insert($adherent_id, $ville_id, $immobilier_id){
       $alerte = $this->ifAlerteExists($adherent_id, $ville_id, $immobilier_id);
        if($alerte['statut'] == false){
            return array('statut' => 'false', 'msg' => 'une alerte de meme type existe deja'); 
        }
        $sql = '
                INSERT INTO alerte_immo_ville
                (adherent_id, enregistrement, modification, ville_id, immobilier_id)
                VALUES
                (
                    '.(int)$adherent_id.', 
                    NOW(), 
                    NOW(), 
                    '.(int)$ville_id.',
                    '.(int)$immobilier_id.'    
                )
            ';
        $this->db->query($sql);
        // creation du compte avec success
        if($this->db->affected_rows() == 1){
            // on recup l'id insere
            $alerte_id = $this->db->insert_id();
           
            return array(
                // l'id de l'utilisateur insere
                'alerte_id' => $alerte_id
            );
        }
        return array(
            'error' => true,
            'msg'   => 'Erreur insertion de l\'alerte'
        );
    }
    
    /**
     * recupere la liste des alertes de l'adherent
     * @param type $adherent_id
     * @return array
     */
    public function getByAdherent($adherent_id){
        $alerte = array();
        $sql = '
                SELECT a.alerte_immo_ville_id, a.ville_id, a.immobilier_id
                FROM alerte_immo_ville a
                WHERE adherent_id = '.(int)$adherent_id.'   
                AND a.active = "OUI"    
                ORDER BY a.modification
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $alerte[] = $row;
            }
            return $alerte;
        }
        return array('error' => true, 'msg' => "No records");
    }
    
    /**
     * Obtenir la liste des alertes des adherents 
     * @return array
     */
    public function getGroupeAdherent(){
        $alerte = array();
        $sql = '
                SELECT a.identifiant, a.ville_id, a.immobilier_id
                FROM alerte_immo_ville a
                GROUP BY a.adherent, DATE(a.modification)
                ORDER BY a.modification
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $alerte[] = $row;
            }
            return $alerte;
        }
        return array('error' => true, 'msg' => "No records");
    }
    
    
    public function desabonner($adherent){
        $sql = '
                UPDATE alerte
                SET 
                active = 0
                WHERE adherent = '.(int)$adherent.'
            ';
        $this->db->query($sql);
        if($this->db->affected_rows() > 1){
            return true;
        }
        return array(
            'error' => 'true',
            'msg'   => '',
        );
    }
    
    
    public function getPoolAlerte($nombre_jour_alerte_enregistrement){
        $sql = '
                SELECT aiv.alerte_immo_ville_id, aiv.immobilier_id, aiv.adherent_id, aiv.ville_id, aiv.enregistrement, aiv.active, a.email,
                aiv.modification, DATEDIFF( DATE(NOW()), DATE(aiv.enregistrement))
                FROM alerte_immo_ville aiv
                INNER JOIN adherent a ON a.identifiant = aiv.adherent_id
                WHERE aiv.active = "OUI"
                AND DATEDIFF( DATE(NOW()), DATE(aiv.modification)) < '.(int)$nombre_jour_alerte_enregistrement.'
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            foreach($result->result_array() as $row){
                $alerte[] = $row;
            }
            return $alerte;
        }
        return array('error' => true, 'msg' => "No records");
    }
}
