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
    
    /**
     * 
     * @return type
     * Elle retourne une instance de type Manager
     * après l'avoir crée s'elle n'existait pas.
     */
    public static function getManager(){
       
        if(self::$manager==null){
            self::$manager=new Manager();
        }
        return self::$manager;
    }
    
    public function getSommets() {
       return $this->generator->getSommets();
    }
    
    public function getSommetByName($name) {
        return $this->generator->getSommetByName($name);
    }

}

