<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$infos = array(array("nom"=>"tochap", "prenom"=>"lionel", "pays"=>"cameroun"),  array("nom"=>"sofara", "prenom"=>"moctar", "pays"=>"mali"));
echo $_SERVER['DOCUMENT_ROOT'].'pigetestt/mon-fichier.csv';
$file = fopen($_SERVER['DOCUMENT_ROOT'].'/pigetestt/mon-fichier.csv', 'a');
foreach ($infos as $line) {
    fputcsv($file, $line, '+', '"');
}
fclose($file);

