<?php
include_once( APPPATH.'/core/Front.php' );
class Accueil extends Front{
    
    public function __construct() {
        parent::__construct();
    }
    
    // fonction qui affichera la page d'accueil
    public function index(){
        $this->load->library('layout');
        $this->layout->set_theme('home');
        $this->layout->view( 'accueil/accueil.php');
    }
}
