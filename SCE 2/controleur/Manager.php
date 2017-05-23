<?php

/* 
 * Cette classe est un singleton qui lie le programme
 * à l'interface graphique
 */
class Manager {

    private static $manager=NULL;
    private $components;
    
    private function __construct() {
       
        self::$manager=null;
        
    }
    public static function getManager(){
       
        if(self::$manager==null){
            self::$manager=new Manager();
        }
        return self::$manager;
    }
    public function getComponents() {
       foreach($this->components as $comp){
          $comp->toHTML(); 
       }
    }

}

