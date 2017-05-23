<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConnexionPDO {

    public static $_connexionBdd = null;
    private static $_instanceConnexion = null;
     
    private static $_host = null;
    private static $_bdd = null;
    private static $_login = null;
    private static $_pswd = null;
     
    private function __construct($config=false)
    {
         
        self::$_host = $config['host'];
        self::$_bdd = $config['dbname'];
        self::$_login = $config['user'];
        self::$_pswd = $config['password'];
         
        //connexion
        try
        {
            $options = array(
                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                        );
            self::$_connexionBdd=new PDO($config['dsn'],$config['user'],$config['password'], $options);
            self::$_connexionBdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        }
        //gestion des erreurs
        catch(PDOException $e)
        {
            echo 'Erreur de connexion au serveur MySQL ! <br /> Erreur détectée : '.$e->getMessage();
            exit();
        }
    }
    
    //lancement de la connexion
    public static function getInstanceConnexion($config)
    {
        //si la propriété $_instanceConnexion vaut null, créée la connexion, sinon renvoit sa valeur
        if (is_null(self::$_instanceConnexion))
        {
            self::$_instanceConnexion = new ConnexionPDO($config);
        }
        return self::$_instanceConnexion;
    }
    
}