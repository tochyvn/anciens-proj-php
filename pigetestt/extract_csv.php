<?php

header("content-type : text/html; charset=utf-8");

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$filename = 'liste_villescsv/fichier.csv';
$file_csv = fopen($filename, 'r');
//$row = 0;
$count = 0;

if (!$file_csv) {
    die('Erreur lors de la lecture du fichier csv');
}

$str = " CREATE TABLE maps_dept_code \r\n (
   nom varchar(255) NOT NULL default '' ,\r\n
   code varchar(255) NOT NULL default '' ,\r\n
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ; \r\n" ;

//CREATION D'UN FICHIER SCRIPT SQL
$script_file = fopen("villes_dept.sql", "w");
fwrite($script_file, $str);
fclose($script_file);

//RECUPERATION DES COLONNES ET AJOUT DANS NOTRE SCRIPT
$villes_dept = array();
while (($row = fgetcsv($file_csv, 1000, ";")) !==FALSE) {
    //var_dump($row);
    //echo utf8_decode($row[4]).'------'.utf8_decode($row[6]).'<br/><br/>';
    if (!array_key_exists($row[4], $villes_dept)) {
        $villes_dept[utf8_decode($row[4])] = utf8_decode($row[6]);
    }
}

foreach ($villes_dept as $key => $value) {
    echo $key.' => '.$value.'<br/>';
}
