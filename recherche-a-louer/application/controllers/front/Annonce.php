<?php

include_once( APPPATH.'/core/Front.php' );
class Annonce extends Front{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function lister(){
        $this->load->library('layout');
        $this->layout->set_theme('front');
        $this->layout->view( 'liste/liste.php');
    }    
}
