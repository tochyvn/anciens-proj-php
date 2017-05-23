<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



/*
include 'model/Marticle.php';
$insert = insertArticle($conn, "voiture", 20000.00, "/Applications/MAMP");
echo $insert['msg'];
*/

include 'include/connexion_bd.php';
include 'model/Midentification.php';


////// Methode pour eviter l'injection sql mysqli_real_escape_string($escapestr);
$email = "tochlion@yahoo.fr";
$passwd = "toch";
$resultat = login($conn, $email, $passwd);
var_dump($resultat);

