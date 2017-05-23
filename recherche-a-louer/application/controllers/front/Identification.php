<?php

include_once( APPPATH.'/core/Front.php' );
class Identification extends Front{
    
    const VIEW_PASSEOUBLIE = 'identification/motpasseoublie.php';
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('password');
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect();
    }
    
    public function login(){
        
        $statut_connexion = $this->session->userdata('connected');
        
        // si l'utilisateur est connecte
        if( $statut_connexion == true ){
            //redirect();
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // si le mail n'a pas ete renseigne
        if( !isset( $email ) ){
            echo json_encode( array( 'statut' => false, 'erreur' => 'mail' ) );
        }
        
        // si le mdp n'a pas ete renseigne
        if( !isset( $password ) ){
            echo json_encode( array( 'statut' => false, 'erreur' => 'password' ) );
        }
        
        $login = $this->identification->login( $email, md5( $password ) );
        $this->session->set_userdata($login);
               
    }
    
    public function signup(){
        
    }
        
    public function motpasseoublie(){
        $this->form_validation->set_rules('email', 'email', 'required');
        
        if ( $this->form_validation->run() == FALSE )
        {                        
            $this->layout->view(self::VIEW_PASSEOUBLIE);
        }
        else
        {
            $email = $this->input->post('email');  
            $utilisateur = $this->utilisateur->getByEmail( array( 'email' => $email ) );
            if( $utilisateur == false ){
                $return = array("error" => true, 'Email inconnu', 'code' => 1);
                $this->layout->view(self::VIEW_PASSEOUBLIE, array('message' => 'Cet email n\'est associé à aucun compte.'));
                return;
            }           
            $mot_passe = genPassword();
            $param = array( 'email' => $email, 'password' => $mot_passe, 'subject' => 'Mot de passe oublié' );
            $this->sendEmail( $param, 'template_mail/motdepasse_oublie.php');
            $this->utilisateur->updatePassword( array(
                'utilisateur_id' => $utilisateur['utilisateur_id'],
                'password' => $mot_passe
            ));
            $this->layout->view(self::VIEW_PASSEOUBLIE, array('message' => 'Un nouveau mot de passe vous a été envoyé par mail.'));
        } 
    }
}
