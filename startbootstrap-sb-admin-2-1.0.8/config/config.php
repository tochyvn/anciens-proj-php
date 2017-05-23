<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//Configuration de la connexion à la base de données
$config = array();
$dconfig = array();

#$config['dsn'] = "mysql:host=localhost;dbname=POPCORN";
$config['dsn'] = "mysql:host=localhost;dbname=POPCORN4";
$config['host'] = "localhost";
$config['password'] = "root";
$config['user'] = "root";
$config['dbname'] = "POPCORN3";


//Ensemble des fichiers à inclure
$dconfig['includes'][] = "include/connexionPDO.php";
$dconfig['includes'][] = "fonctions/form_validation.php";
$dconfig['includes'][] = "fonctions/generate_url.php";


