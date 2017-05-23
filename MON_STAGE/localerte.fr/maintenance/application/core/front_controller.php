<?php

/*
 * Controlleur personnel (pas propre a codeigniter) 
 * Ce controlleur doit etre utilise pour tout les controlleurs du front
 *
 */

/**
 * Description of front_controller
 *
 * @author Guillaume
 */
class front_controller extends CI_Controller{
    
    const VIEW_ACCUEIL = 'front/accueil/accueil.php';
    
    public function __construct(){
        parent::__construct();
        $this->load->library('layout');
        $this->load->helper('url');
    }
}
