<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paypal
 *
 * @author thomas
 */
class Paypal {
    private $user = 't.werner.g4-facilitator_api1.gmail.com';
    private $pwd = 'B6TDPG5PP7X7XU65';
    private $signature = 'ArkScMJXJY04cxmTXZWxfdtCllq1Aepwnv0.1J-mP8UlAYqrjmbldOeX';
    //Dev
    private $endpoint = 'https://api-3T.sandbox.paypal.com/nvp';
    //Production
    //public $endpoint = 'https://api-3T.paypal.com/nvp';
    public $errors = array ();
    
    public function __construct($user = false, $pwd = false, $signature = false) {
        if($user){
            $this->user = $user;
        }
        if($pwd){
            $this->pwd = $pwd;
        }
        if($signature){
            $this->signature = $signature;
        }
    }
    
    public function request($method, $params){
        $params = array_merge($params, array(
                            'METHOD' => $method,
                            'VERSION' => '124.0',
                            'USER' => $this->user,
                            'SIGNATURE' => $this->signature,
                            'PWD' => $this->pwd
        ));
        $params = http_build_query($params);
        $curl= curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL=> $this->endpoint,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST=> FALSE,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_VERBOSE => 1 
        ));
        $response = curl_exec($curl);
        $responseArray = array();
        parse_str($response, $responseArray);
        if(curl_errno($curl)){
            $this->errors = curl_error($curl);
            curl_close($curl);
            return false;
        }else{
            if($responseArray['ACK'] == 'Success'){
                curl_close($curl);
                return $responseArray;
            }else{
                $this->errors = $responseArray;
                curl_close($curl); 
                return false;
            }
        }
    }
}
