<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class logger
{
    protected $CI;
    
    protected $recordSQl = true;
    protected $displayLogToScreen = true;
    protected $recordInFile = true;
    
    protected $context = ""; 
    protected $logs = array();
    
    protected $is_critical = false;
    
    protected $bash_execution_id = false;


    const LOG_LEVEL_CRITICAL    = 1;
    const LOG_LEVEL_ERROR       = 1.5;
    const LOG_LEVEL_IMPORTANT   = 2;
    const LOG_LEVEL_NOTICE      = 3;
    const LOG_LEVEL_DEFAULT     = 0;
    const LOG_LEVEL_RESULT      = 0.5;
    const LOG_LEVEL_DEBUG       = 0;
    
    CONST MSG_CRITICAL = 'CRITICAL';

    
    const COLOR_CRITICAL        = "rgba(255,0,0,0.8)";
    const COLOR_ERROR           = "rgba(200,0,0,0.8)";
    const COLOR_IMPORTANT       = "rgba(255,0,0,0.4)";
    const COLOR_NOTICE          = "rgba(255,0,0,0.2)";
    const COLOR_DEFAULT         = "rgba(0,0,255,0.4)";
    const COLOR_DEBUG           = "rgba(0,0,200,0.4)";
    const COLOR_RESULT          = "rgba(0,255,0,0.4)";
    
    public function __construct($data = array()){
        if( !empty( $data ) ){
            $this->context = $data['context'];
            $this->debug = $data['debug'];
            $this->bash_execution_id = $data['bash_execution_id'];
        }
        $this->CI = &get_instance();
        $this->CI->load->model('bash/Mbash', 'bash');
    }
    
    public function set_bash_id_execution( $bash_execution_id ){
        $this->bash_execution_id = $bash_execution_id;
    }
    
    public function saveInFile( $message ){
        $handle = fopen( APPPATH.'/logs/logger/'.$this->bash_execution_id.'.html', 'a+' );
        fwrite( $handle, $message );
        fclose( $handle );        
    }
    
    public function defineDisplay($msg, $level_color)
    {
        return '<div style="border-radius:2px; margin-left: 5%;margin-bottom:5px; padding : 10px; width : 90%; min-height : 25px;background-color : '.$level_color.'">'
                . '<span><strong>'.$msg.'</strong></span></div>';
    }
    
    public function getLevelFunctionnality($msg, $level)
    {
        $msg = 'Script : '.$this->CI->input->server('PATH_INFO').' >>>> '.$msg;
        
        switch ( $level ){
            case self::LOG_LEVEL_CRITICAL: 
                log_message('error', 'CRITICAL : '.$msg );
                $this->is_critical = true;
                $color = self::COLOR_CRITICAL;
            break;
            case self::LOG_LEVEL_IMPORTANT: 
                log_message('info', 'Important : '.$msg );
                $color = self::COLOR_IMPORTANT;
            break;
            case self::LOG_LEVEL_NOTICE: 
                log_message('info', 'Notice : '.$msg );
                $color = self::COLOR_NOTICE;
            break;
            case self::LOG_LEVEL_RESULT: 
                log_message('info', 'Result : '.$msg );
                $color = self::COLOR_RESULT;
            break;
            case self::LOG_LEVEL_DEBUG:
                log_message('info', 'Debug : '.$msg );
                $color = self::COLOR_DEBUG;
            break;
            default : 
                $color = self::COLOR_DEFAULT;
            break;
        }
        $html = $this->defineDisplay( $msg, $color );                
        if( $this->recordInFile ){
            $this->saveInFile( $this->defineDisplay( utf8_decode( $msg ), $color ) );
        }
        
        return $html;
    }
    
    public function log($msg, $level = self::LOG_LEVEL_DEFAULT){
        if( $this->recordSQl ){
            if($level == self::LOG_LEVEL_CRITICAL || $level == self::LOG_LEVEL_IMPORTANT) {
                $this->logs[] = array($msg, $level);
            }
        }
        $this->displayToUser($this->getLevelFunctionnality($msg, $level));    
    }
    
    public function displayToUser($msg){
        if($this->displayLogToScreen){
            echo $msg;
        }
    }
    
    public function getLogs(){
        return $this->logs;
    }
    
    public function saveLogs($bash_execution_id, $elapsed_time){
        $logs = json_encode($this->getLogs());
        $this->CI->bash->saveLogs($bash_execution_id, $logs, $this->is_critical, $elapsed_time);
    }
    
    public function rapport($msg, $priorite){
        $this->CI->bash->rapport($msg, $priorite);
    }
}