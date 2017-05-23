<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of email
 *
 * @author Guillaume
 */
include_once(dirname(__FILE__).'/../../system/libraries/Email.php');
class MY_Email extends CI_Email {
    //put your code here
    
    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->helper('file');
    }
    
    public function loadTemplate($path, $tableau){
        $string = read_file($path);
        foreach($tableau as $key => $value){
            $string = str_replace('%'.$key.'%', $value, $string);
        }
        return $string;
    }
}
