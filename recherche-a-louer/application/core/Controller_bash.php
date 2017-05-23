<?php


abstract class Controller_bash extends CI_Controller
{
    protected $bashClassName;
    
    protected $bash_id;

    protected $bash_execution_id;

    protected $debug = false;
    
    protected $bash_name = '';


    public function __construct(){
        
        parent::__construct();
        $this->load->helper( 'compression' );

        // mode de debug pour voir si le script fonctionne
        $debug = $this->input->get( 'debug' );        
        if( isset($debug) && $debug == 'on' ){
            $this->debug = 'on';
        }
        
        // model enregistrement de l'execution du flux
        $this->load->model('bash/Mbash', 'bash');

        $this->bashClassName = $this->uri->uri_string;

        // recuperation de l'id du bash en cours d'execution
        $this->bash_id = $this->saveInformationsAboutExecution();
        // on insert une ligne dans la table d'execution des bash
        $this->bash_execution_id = $this->bash->insertBashExecution( $this->bash_id );
        
        // chargement du logger
        $this->load->library('logger', array( 
            'bash_execution_id' => $this->bash_execution_id, 
            'context' => $this->bashClassName, 
            'debug' => 1 ) 
        );
        
        $this->load->library( 'metrics', array( 'bash_execution_id' => $this->bash_execution_id ) );
        $this->setCharset();
    }   
     
    public function index(){
        
    }
    
    public function setCharset(){
         echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
     }
     
     public function saveInformationsAboutExecution(){
         $url = $this->input->server('PATH_INFO');
         return $this->bash->saveBashExecution( $this->bashClassName, $this->bash_name, $url );
     }
     
     
     public function debug(){
         $this->logger->log('Lancement du script debug', logger::LOG_LEVEL_IMPORTANT);
         sleep(5);
     }
     
     public function run(){
        set_time_limit(-1);
        $this->logger->log('Lancement '.$this->bash_name.' ', logger::LOG_LEVEL_IMPORTANT);
        $this->benchmark->mark('mark_start');
        if( $this->debug == true ){
            $this->debug();
        }
        else{
            $this->execute();
        }
        $this->benchmark->mark('mark_end');
        $elapsed_time = $this->benchmark->elapsed_time('mark_start', 'mark_end');
        $this->logger->log('FIN en : '.$elapsed_time.' Sec', logger::LOG_LEVEL_IMPORTANT);
        $this->logger->saveLogs($this->bash_execution_id, $elapsed_time);
     }
}