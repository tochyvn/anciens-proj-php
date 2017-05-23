<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

include '../config/config.php';
include '../include/connexionPDO.php';
ConnexionPDO::getInstanceConnexion($config);
//set_time_limit(0);
//ini_set('memory_limit', '1024M');

/**
 * TEST MODEL Mville*/
 include 'Mville.php';
$ville = '130';
var_dump(ajaxVilles($ville));


/*
include 'Midentification.php';

$nom = 'Stanford';
$username = 'tochyvn80';
$password = 'DASSSSS';
$email = 'Stanley@gmail.com';
$adr = '65 Avenue du Prado';
$nomVille = 'paris';
var_dump(signin($nom, $username, $password, $email, $adr, $nomVille));
 * 
 */

//include 'Mproduit.php';
//include 'Msociete.php';
/*
$nomFR = "TV TOSHIBA";
$nomEN = "TOSHIBA TV";
$prix = 600;
$descrFR = "sfkjdhgfjhskfghsfjkghksghkjsh";
$descrEN = "skfjvhkshfklsdhfiiurzjhekfdsf";
$idSoc = 1;
$resultat = insertProduit($nomFR, $nomEN, $prix, $descrFR, $descrEN, $idSoc);
echo 'insertion';

/*
$resultat = voirCatalogue1();
var_dump($resultat);

/*
$id = 2;
$produit = selectProduit($id);

//var_dump($produit);
var_dump($_SESSION);
*/
/*
$resultat = supprimerProduit(9);
var_dump($resultat);
 * 
 */
/*
"SET nomProduitFR = ?, "
            . "nomProduitENG = ?, "
            . "prixProduit = ?, "
            . "descriptProduitFR = ?, "
            . "descriptProduitENG = ?, "
            . "idSociete = ? "
            . "WHERE idProduit = ?;";
*/

/*
$param = array(
    "BOLLINGER RD 2005",
    "BOLLINGER RD 2005",
    230,
    "Champagne Blanc | 12°",
    "Champagne Blanc | 12°",
    1,
    1
);

$resultat = updateProduit($param);
var_dump($resultat);
 * 
 */
/*
$param = array(
    "DIPAS RICOH SARL",
    "56 PLACE VALBONNE",
    "www.dipas_ricoh.com",
    "04 45 87 98 09",
    "sfihjkdfjdkhkfjdshds",
    "vbnccnvxvjkjhhfjfslkjsf",
    1,
    1
);

$resultat = insertSociete($param);
var_dump($resultat);
 * 
 */
/*
$resultat = selectSociete(1);
var_dump($resultat);
 * 
 */
/*
$resultat = supprimerSociete(3);
var_dump($resultat);
 * 
 */
/*
$sql = "UPDATE societe "
            . "SET nomSociete = ?, "
            . "adrSociete = ?, "
            . "siteWebSociete = ?, "
            . "numTelSociete = ?, "
            . "descriptSocieteFR = ?, "
            . "descriptSocieteENG = ?, "
            . "idCateg = ?, "
            . "idQuartier = ?,"
            . "WHERE idSociete = ?;";
 * 
 */
/*
$param = array(
    "XEROX_FRANCE",
    "65 AVENUE DU VALBONNE",
    "www.zerox_eu.fr",
    "04 45 87 98 09",
    "sfihjkdfjdkhkfjdshds",
    "vbnccnvxvjkjhhfjfslkjsf",
    1,
    1,
    2
);

$resultat = updateSociete($param);
var_dump($resultat);
 * 
 */

