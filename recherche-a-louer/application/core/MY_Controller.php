<?php


class MY_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('layout');
        $this->layout->set_theme( 'admin' );
        $this->load->library('session');
        $this->load->library('user_agent');
        $this->load->library('form_validation');

        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('password');
        
        $this->load->model('boutique/Mboutique','boutique');
        $this->load->model('regie/Mregie','regie');
        $this->load->model('flux/Mflux','flux');
        $this->load->model('idee_cadeau/Midee_cadeau','idee_cadeau');
    }
}
