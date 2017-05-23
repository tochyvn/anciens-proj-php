<?php

/**
 * Description of identification
 *
 * @author aicom
 */
class identification extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('regex_helper');
        $this->load->model('front/adherent', 'adherent');
    }
    
    /**
     * methode qui verifie que le login/mot de passe est correct
     * @param type $email
     * @param type $motpasse
     * @return array 
     */
    public function login($email, $motpasse){
        $sql = '
                SELECT a.pass, a.email 
                FROM adherent a
                WHERE a.email = "'.$this->db->escape_like_str($email).'"
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() > 0){
            $utilisateur = $result->row_array();
            if($utilisateur['pass'] == $motpasse){
                return array(
                        'connected' => true,
                        'utilisateur' => $utilisateur
                    );
            }
            return array(
                'error' => true, 
                'msg'   => "Mauvais mot de passe",
                'code'  => 1
            );
        }
        return array(
            'error' => true, 
            'msg'   => "Utilisateur inconnu",
            'code'  => 2
        );
    }
    
    
    /**
     * Methode d'inscription de l'utilisateur
     * si le param abonnement == oui, le tableau plus doit etre correctement
     * rempli est passe pour le bon deroulement du script
     * @param type $email
     * @param type $motpasse
     * @param type $motpasseConf
     * @param type $abonnement
     * @param type $plus
     * @return type
     */
    public function signin($email, $motpasse, $motpasseConf, $abonnement, $plus = array()){
        // code d'erreur 1 
        // les mots de passe ne correspondent pas
        if($motpasse != $motpasseConf){
            return array(
                'error' => true, 
                'msg'   => 'Mot de passe ne correspondent pas', 
                'code'  => 1
            );
        }
        // code d'erreur 2 
        // l'email n'est pas valide
        if(!isEmailValid($email)){
            return array(
                'error' => 'true',
                'msg'   => 'l\'email n\'est pas valide',
                'code'  => 2
            );
        }
        // code erreur3
        // l'email est deja present en BDD
        if(!$this->adherent->checkEmailUnicite($email)){
            return array(
                'error' => 'true',
                'msg'   => 'l\'email est déjà présent en BDD',
                'code'  => 3
            );
        }
        // $utilisateur est un tableau contenant certaines informations de l'utilisateur
        $utilisateur = $this->adherent->insert($email, $motpasse, $abonnement, $plus);
    }
}
