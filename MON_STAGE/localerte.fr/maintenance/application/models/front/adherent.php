<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adherent
 *
 * @author aicom
 */
class adherent extends CI_Model{
        
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('front/abonnement', 'abonnement');
        $this->load->helper('password');
    }
    
    /**
     * Insertion d'un adherent en bdd 
     * @param type $email
     * @param type $password
     * @param type $abonnement
     * @param type $plus peut contenir des informations supplementaire a inserer en bdd
     * @return type
     */
    public function insert($email, $password, $abonnement, $plus = array()){
        
        // en fonction de la valeur d'abonnement on met a jour ou pas les champs suivants 
        // penser a echapper les valeurs en fonction de leur type 
        // date_abonnement
        switch($abonnement){
            case $this->abonnement->ABONNEMENT_POSITIF:
                $date_abonnement = "NOW()";
            break;
            default :
                $date_abonnement = null;
            break;
        }
        $sql = '
                INSERT INTO adherent 
                (email, pass, abonne, enregistrement, abonnement)
                VALUES 
                (
                    "'.$this->db->escape_like_str($email).'",
                    "'.$this->db->escape_like_str($password).'",
                    "'.$this->db->escape_like_str($abonnement).'",
                    "'.$date_abonnement.'"    
                    NOW()
                )
            ';
        $this->db->query($sql);
        // creation du compte avec success
        if($this->db->affected_rows() == 1){
            // on recup l'id insere
            $utilisateur_id = $this->db->insert_id();
            // si abonnement == oui
            if($abonnement == $this->abonnement->ABONNEMENT_POSITIF){
                $this->abonnement->insert($utilisateur_id, 0);
            }
            return array(
                // l'id de l'utilisateur insere
                'utilisateur_id' => $utilisateur_id
            );
        }           
        return array(
            'error' => true,
            'msg'   => 'erreur lors de l\'enregistrement de l\'utilisateur',
            'code'  => 1
        );
    }
    
    /**
     * Check l'unicite de l'email en bdd
     * renvoie true si il y a pas de mail identique, false sinon
     * @param string $email
     * @return boolean
     */
    public function checkMailUnicite($email){
        $sql = '
                SELECT a.email, a.identifiant 
                FROM adherent a
                WHERE a.email = "'.$this->db->escape_like_str($email).'"
                LIMIT 1
            ';
        $result = $this->db->query($sql);
        if($result->num_rows() == 0){
            return array('statut' => true);
        }
        return array('statut' => false, 'adherent' => $result->row_array());
    }
    
    /**
     * cree un compte adherent de maniere automatique
     * (lorsque ce dernier demande a etre inscrit a une alerte par exemple)
     * envoie du mot de passe par mail en fonction du param sendmail
     * @param string $email
     * @param bool sendmail
     */
    public function creationCompteAutomatique($email, $sendmail){
        $mot_passe = genPassword();
        $sql = '
                INSERT INTO adherent
                (email, passe, abonnement)
                VALUES
                ("'.$this->db->escape_like_str($email).'", "'.md5($mot_passe).'",NOW())
            ';
        $this->db->query($sql);
        if($this->db->affected_rows() > 0){
            if($sendmail == true){
                $this->sendEmailInscriptionAutomatique($email, $mot_passe);
            }
            return array('statut' => true, 'adherent' => $this->db->insert_id());
        }
        return array('error' => true, 'msg' => 'erreur insertion adherent');
    }
    
    
    /**
     * 
     * @param string $email
     * @param string $mot_passe
     */
    public function sendEmailInscriptionAutomatique($email, $mot_passe){
        $config['protocol'] = 'mail';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->load->library('email');

        $this->email->initialize($config);

        $this->email->from('guillaume.cozic@aicom.fr', 'Locamax');
        $this->email->to($email); 

        $this->email->subject("Inscription");
        $tableau = array(
                    'description' => 'Votre mot de passe : '.$mot_passe
                );

        $string = $this->load->view("template/inscription_automatique.php", $tableau, true);
        $this->email->message($string);	

        $this->email->send();
        
    }
}
