<?php


include_once( APPPATH.'/core/Front.php' );
class Espace extends Front{
    
    const PROVENANCE_LOCAMAX = 44;
    
    const VIEW_PRINCIPALE = 'espace/espace.php';
    const VIEW_CONSULTER_ALERTES = 'espace/consulteralerte.php';
    const VIEW_AJOUTER_ALERTE = 'espace/ajouteralerte.php';
    const VIEW_FAVORIS = 'espace/selection.php';
    const VIEW_PARAM = 'espace/parametre.php';
    const VIEW_AJOUTERANNONCE = 'espace/ajouterannonce.php';
    const VIEW_GERERANNONCE = 'espace/gererannonce.php';
    
    public $menu = array();
    public $adherent_id = ''; 
    public function __construct() {
        parent::__construct();
        $this->load->library('layout');
        $this->getMenu();
    }
    
    
    protected function getMenu(){
        $this->menu = array(
                'accueil' => array(
                    'state' => 'inactive',   
                    'class' => 'glyphicon glyphicon-home',               
                    'url' => site_url( ),          
                    'label' => 'Page d\'accueil du site'
                ),
                'selection' => array(
                    'state' => 'inactive', 
                    'class' => 'glyphicon glyphicon-bookmark',            
                    'url' => site_url( 'ma-selection' ),          
                    'label' => 'Ma sélection'
                ),
                'consultation_alerte' => array(
                    'state' => 'inactive', 
                    'class' => 'glyphicon glyphicon-envelope', 
                    'url' => site_url( 'consulter-mes-alertes' ),       
                    'label' => 'Mes alertes emails'
                ),
                'ajouter_alerte' => array(
                    'state' => 'inactive', 
                    'class' => 'glyphicon glyphicon-plus', 
                    'url' => site_url( 'ajouter-une-alerte' ),       
                    'label' => 'Ajouter une alerte mail'
                ),
                'parametre' => array(
                    'state' => 'inactive', 
                    'class' => 'glyphicon glyphicon-cog',        
                    'url' => site_url( 'mes-parametres' ),      
                    'label' => 'Mes paramètres'
                ),   
                'premium' => array(
                    'state' => 'inactive', 
                    'class' => 'glyphicon glyphicon-shopping-cart',        
                    'url' => site_url( 'premium' ),      
                    'label' => 'Premium'
                ),    
            );
    }
    
    public function ajouteralerte(){
        $param = array(
                'vue_action' => self::VIEW_AJOUTER_ALERTE
            );
        $this->menu['ajouter_alerte']['state'] = "active";
        $this->layout->view( self::VIEW_PRINCIPALE, $param );
    }
    
    public function consulteralerte(){
        $alertes = array();
        $param = array(
                'vue_action' => self::VIEW_CONSULTER_ALERTES, 
                'alertes' => $alertes
            );
        $this->menu['consultation_alerte']['state'] = "active";
        $this->layout->view( self::VIEW_PRINCIPALE, $param );
    }
    
    public function supprimeralerte($alerte_immo_ville_id){       
        $this->alerte->delete($alerte_immo_ville_id);
        redirect('consulter-mes-alertes');
    }
    
    public function supprimerFavoris($utilisateur_annonce_favoris_id){
        $param['utilisateur_annonce_favoris_id'] = $utilisateur_annonce_favoris_id;
        $param['adherent_id'] = $this->adherent_id;
        $this->annonce->deleteAnnonceFromFavori($param);
        redirect('mes-annonces-favorites');
    }
    
    public function setAnnonceFavori(){
        $annonce = $this->input->post('annonce');
        $param['adherent_id'] = $this->adherent_id;
        $param['annonce_id'] = $annonce;
        $this->annonce->setAnnonceFavori( $param );
        echo json_encode($annonce);
    }
    
    public function consulterselection(){
        $param['adherent_id'] = $this->adherent_id;
        $this->menu['selection']['state'] = "active";
        $favoris = array();
         $param = array(
                'vue_action' => self::VIEW_FAVORIS, 
                'favoris' => $favoris
            );
        
        $this->layout->view( self::VIEW_PRINCIPALE, $param );
    }
    
    public function parametre(){
        
    }

}
