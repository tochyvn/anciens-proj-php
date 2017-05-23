<?php

class Midentification extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * methode qui verifie que le login/mot de passe est correct
     * @param type $email
     * @param type $motpasse
     * @return array 
     */
    public function login( $email, $motpasse ){
        $sql = '
                SELECT u.utilisateur_id, u.email, u.password, u.statut_id, u.*
                FROM utilisateur u
                WHERE u.email = ?
            ';
        $result = $this->db->query($sql, array( $email ) );
        if($result->num_rows() > 0){
            $utilisateur = $result->row_array();
            if($utilisateur['password'] == $motpasse){
                return array(
                        'connected' => true,
                        'utilisateur' => $utilisateur
                    );
            }
            return array(
                'error' => true, 
                'msg'   => "Mauvais mot de passe",
                'code'  => 1,
                'connected' => false
            );
        }
        return array(
            'error' => true, 
            'msg'   => "Utilisateur inconnu",
            'code'  => 2,
            'connected' => false
        );
    }
    
    public function loginDiscret( $utilisateur_id ){
        $sql = '
                SELECT u.utilisateur_id, u.email, u.password, u.statut_id, u.*
                FROM utilisateur u
                WHERE u.utilisateur_id = ?
            ';
        $result = $this->db->query($sql, array( $utilisateur_id ) );
        if($result->num_rows() > 0){
            $utilisateur = $result->row_array();
            return array(
                'connected' => true,
                'utilisateur' => $utilisateur
            );
        }
    }
    
    /**
     * Methode d'inscription de l'utilisateur
     * si le param abonnement == oui, le tableau plus doit etre correctement
     * rempli est passe pour le bon deroulement du script
     * @param type $email
     * @param type $motpasse
     * @param type $motpasseConf
     * @return type
     */
    public function signin( $email, $motpasse, $motpasseConf, $pro = 0, $opts = array() ){
        // code d'erreur 1 
        // les mots de passe ne correspondent pas
        if( $motpasse != $motpasseConf ){
            return array(
                'error' => true, 
                'msg'   => 'Les mots de passe ne correspondent pas', 
                'code'  => 1
            );
        }
        // $utilisateur est un tableau contenant certaines informations de l'utilisateur
        $utilisateur_id = $this->utilisateur->insert( array(
                'email' => $email,
                'password' => $motpasse,
                'tel_portable' => isset( $opts['tel_portable'] ) ? $opts['tel_portable'] : '',
                'confirmation_tel' => 0,
                'confirmation_mail' => 0,
                'date_enregistrement' => date("Y-m-d H:i:s"),
                'nom' => isset( $opts['nom'] ) ? $opts['nom'] : '',
                'prenom' => isset( $opts['prenom'] ) ? $opts['prenom'] : '',
                'naissance' => '0000-00-00',
                'statut_id' => 0,
                'facebook_id' => 0,
                'contact_id' => 0,
                'identifiant' => 0,
                'agence_id' => 0
            ) 
        );
        if($utilisateur_id != false){ 
            return $utilisateur_id;
        }
        return false;     
    }
    
    public function ifExist( $email ){
        $sql = '
                SELECT u.utilisateur_id, u.email, u.password, u.statut_id, u.*
                FROM utilisateur u
                WHERE u.email = ?
            ';
        $result = $this->db->query($sql, array( $email ) );
        if($result->num_rows() > 0){
            return true;
        }
        return false;
    }
}
