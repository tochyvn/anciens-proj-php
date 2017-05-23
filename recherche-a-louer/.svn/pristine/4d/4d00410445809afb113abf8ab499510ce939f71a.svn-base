<?php

class Front extends CI_Controller{
    
    // ALL THE VIEW FILES
    const VIEW_ACCUEIL = 'front/accueil/accueil.php';
    
    const VIEW_DETAILS = 'front/annonce/details.php';
    const VIEW_ANNONCE_LISTE = 'front/annonce/liste.php';
    
    const VIEW_SAVOIR_PLUS = 'front/accueil/savoirplus.php';
    
    public $url_facebook;
    public $loadFacebookUrl = true;
    public $show_filter = false;
    public function __construct() {
        parent::__construct();
        $this->load->library( 'layout' );
        $this->load->library( 'session' );
        
        $this->load->helper( 'url' );
        $this->load->helper( 'form' );
        $this->load->helper( 'cookie' );
        $this->load->helper( 'statdate' );
        $this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->load->helper( 'email' );
    }
    
    
    protected function loadFacebookUrl(){
        if( $this->loadFacebookUrl ){
            $this->url_facebook = $this->facebook->getUrlLogin();
            $this->layout->setVar( 
                array(
                    "url_facebook" => $this->url_facebook
                )
            );
        }
    }
    
    protected function setMetaDefault(){
        
    }
    
    protected function loginDiscret( $utilisateur_id ){
        $login = $this->identification->loginDiscret( $utilisateur_id );
        $this->session->set_userdata( $login );
    }

    protected function redirectToUrl(){
        $redirection_interne = $this->session->userdata( 'redirect_url' );
        if( isset($redirection_interne) && $redirection_interne != ''){
            redirect( $redirection_interne );
        }
        redirect(  );
    }
    
    public function sendEmail( $param, $template, $opt = false ){
        $config['protocol'] = 'mail';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = isset( $opt['mailtype'] ) ? $opt['mailtype'] : 'html';
        $config['mailpath'] = '/usr/sbin/sendmail.postfix';
        $this->load->library('email');

        $this->email->initialize($config);
        $param['email_contact'] = isset( $param['email_contact'] ) ? $param['email_contact'] : 'contact@logemax.fr';
        $param['nom_contact'] = isset( $param['nom_contact'] ) ? $param['nom_contact'] : 'Logemax';
        $this->email->from( $param['email_contact'], $param['nom_contact'] );
        $this->email->to( $param['email'] ); 

        $this->email->subject( $param['subject'] );
 
        $string = $this->load->view( $template, $param, true );
        $this->email->message( $string );	
        //echo $string;
        $result = $this->email->send( false );
        $this->email->print_debugger(array('headers'));
        return $result;
    }
}
