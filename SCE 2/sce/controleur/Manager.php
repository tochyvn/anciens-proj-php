<?php

/* 
 * Cette classe est un singleton qui lie le programme
 * à l'interface graphique
 */
class Manager {

    private static $manager=NULL;
    private $generator;
    
    private function __construct() {
       
        self::$manager=null;
        $this->generator=new TGenerator();
        
    }
    
    public static function getManager(){
       
        if(self::$manager==null){
            self::$manager=new Manager();
        }
        return self::$manager;
    }
    
    public function getSommets() {
       return $this->generator->getSommets();
    }

}

