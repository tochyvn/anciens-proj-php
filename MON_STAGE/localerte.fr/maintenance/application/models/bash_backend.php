<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bash_backend
 *
 * @author guillaume
 */
class bash_backend extends CI_Model
{
    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function saveBashExecution( $classname, $bashname )
    {
        $sql = '
                SELECT id
                FROM bash_informations
                WHERE name = "'.$bashname.'"
            ';
        $result = $this->db->query($sql)->row();
        if(empty($result)){
            $sql = '
                    INSERT INTO bash_informations
                    (date_derniere_execution, classname, name)
                    VALUES
                    (NOW(), "'.$classname.'", "'.$bashname.'")
                ';
            $this->db->query($sql);
            $id = $this->db->insert_id();
        }
        else
        {
            $id = $result->id;
        }
        $sql = '
                UPDATE bash_informations
                SET date_derniere_execution = NOW()
                WHERE id = '.(int)$id.'
            ';
        $this->db->query($sql);
        return $id;
    }
    
    public function insertBashExecution($bash_id){
        $sql = '
                INSERT INTO bash_informations_execution
                (date_execution, bash_id)
                VALUES
                (NOW(), '.(int)$bash_id.')
            ';
        $this->db->query($sql);
        if( $this->db->affected_rows() > 0 ){
            return $this->db->insert_id();
        }
    }
    public function saveLogs($bash_execution_id, $logs, $is_critical, $elapsedTime){
        $sql = '
                UPDATE bash_informations_execution SET
                logs = "'.addslashes($logs).'", 
                is_critical_error = '.(int)$is_critical.', 
                elapsed_time = "'.$elapsedTime.'",
                is_finish = 1    
                WHERE bash_informations_execution = '.$bash_execution_id.'
             ';
        $this->db->query($sql);
    }
    
    public function rapport($message, $priorite){
        $sql = '
                INSERT INTO rapport 
                (message, priorite)
                VALUES 
                ("'.$this->db->escape_like_str($message).'", '.(int)$priorite.' )
            ';
        $this->db->query($sql);
    }
    
    public function avancement( $param ){
        $sql = '
                UPDATE bash_informations_execution
                SET avancement = "'.$param['avancement'].'"
                WHERE bash_informations_execution = "'.$param['bash_informations_execution'].'"
            ';
        $this->db->query($sql);
    }
}
