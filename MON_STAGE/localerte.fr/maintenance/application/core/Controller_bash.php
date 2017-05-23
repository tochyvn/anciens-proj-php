<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Controller_bash extends CI_Controller
{
    protected $bashClassName;
    
    protected $bash_id;

    protected $bash_execution_id;

    protected $debug = false;
    
    protected $bash_name = '';


    public function __construct(){
        
         parent::__construct();
         $debug = $this->input->get( 'debug' );
         if( isset($debug) && $debug == 'on' ){
             $this->debug = 'on';
         }
         
         $this->load->model('bash_backend', 'cron');
         $this->bashClassName = $this->uri->uri_string;
         
         $this->bash_id = $this->saveInformationsAboutExecution();

         $this->load->library('logger', array( 'context' => $this->bashClassName, 'debug' => 1 ) );
         $this->bash_execution_id = $this->cron->insertBashExecution( $this->bash_id );
         $this->load->library( 'metrics', array( 'bash_execution_id' => $this->bash_execution_id ) );
    }   
     
     public function setCharset(){
         echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
     }
     
     public function saveInformationsAboutExecution(){
         return $this->cron->saveBashExecution( $this->bashClassName, $this->bash_name );
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