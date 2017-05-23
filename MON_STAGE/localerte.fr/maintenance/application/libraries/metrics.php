<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of metrics
 *
 * @author Guillaume
 */
class metrics {
    
    // objet codeigniter
    public $CI;
    
    // metrics loaded
    // we save the metrics in a array to avoid requeting the database
    public $metrics = array();
    
    // bash_execution_id correspond to the execution of the script 
    public $bash_execution_id = false;
    
    public function __construct( $data = array() ) {
        $this->CI = &get_instance();
        $this->CI->load->database();
        
        // here we get the bash_execution_id 
        if( ! empty( $data ) ){
            $this->bash_execution_id = $data['bash_execution_id'];
        }
    }
    
    protected function save($name){
        // if the metric exists in database
        $sql = '
                SELECT nom, metric_id
                FROM metric 
                WHERE nom = "'.$this->CI->db->escape_like_str($name).'"
            ';
        $result = $this->CI->db->query($sql);
        if( $result->num_rows > 0 ){
            $metric = $result->row_array();
            $metric_id = $metric['metric_id'];
            $this->metrics[$metric_id] = $name;
        }
        // if the metric does'nt exists in database
        else{
            $sql = '
                    INSERT INTO metric 
                    (nom)
                    VALUES 
                    ("'.$this->CI->db->escape_like_str($name).'")
                ';
            $this->CI->db->query($sql);
            if( $this->CI->db->affected_rows() > 0 ){
                $metric_id = $this->CI->db->insert_id();
                $this->metrics[$metric_id] = $name;
            }
        }
        return $metric_id;
    }
    
    public function insert($name, $value){
        // if the metrics is not in memory we save it 
        $metric_id = array_search($name, $this->metrics);
        if( !$metric_id || $metric_id == 0){
            $metric_id = $this->save($name);
        }
        
        if($metric_id == 0){
            return false;
        }
        
        // log of the metrics in database
        $sql = '
                INSERT INTO bash_metrics 
                (bash_execution_id, metric_id, valeur, heure)
                VALUES
                ('.$this->bash_execution_id.' ,'.(int)$metric_id.', "'.$this->CI->db->escape_like_str($value).'", NOW())
            ';
        $this->CI->db->query($sql);
    }
}
