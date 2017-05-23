<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header("content-type : text/html; charset=utf-8");

/**
 * CONNEXION A LA BD SUR LE SERVEUR
 */
define('SERVERNAME', '127.0.0.1');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DATABASE', 'france');

$connexion = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
if ($connexion->connect_error) {
    die(utf8_decode('Echec de connexion à MYSQL : ('.$connexion->connect_errno.') '.$connexion->connect_error.'<br/>')) ;
}

//echo 'Connexion réussie vers : '.$connexion->host_info.'<br/>';

/**
 * EXECUTION DE LA REQUETE
 */
$query = "SELECT ville_departement, ville_nom, ville_code_postal, ville_code_commune FROM villes_france_free ORDER BY ville_nom ASC";

//CREATION DU FICHIER DE STCKAGE DES EXPRESSIONS RECUPEREES
$curseur = fopen('formatage_villes.txt', 'w');

if ($connexion->query($query)) {
    $result = $connexion->query($query);
    //echo 'Requete executée avec succès !!!';
    //On va parcourir le resultat de l'execution de la requête ci-dessus
    while ($row = mysqli_fetch_assoc($result)) {
        $formate_nom_ville = utf8_decode(strtolower(str_replace(array("'"," "), "-", $row['ville_nom'])));
        echo '&lt;valeur&gt;'. $formate_nom_ville. '-'. $row['ville_departement']. '-'.$row['ville_code_postal']. '&lt;/valeur&gt;<br/>';
        $str = '<valeur>'. $formate_nom_ville. '-'. $row['ville_departement']. '-'.$row['ville_code_postal']. '</valeur>'
                . '';
        fwrite($curseur, $str);
        //file_put_contents('formatage_villes.txt', $str);
    }
}

fclose($curseur);





