<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../config/config.php';
include 'connexionPDO.php';

ConnexionPDO::getInstanceConnexion($config);

$conn = ConnexionPDO::$_connexionBdd;
//var_dump($conn);
$sql = "SELECT * FROM utilisateur "
            . "WHERE email = ? ";
    
    $stmt = $conn->prepare($sql);
    $email = "tochlionmy@gmail.com";
    $passwd = "lion";
    if ($stmt->execute(array($email))) {
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            if ($row['passwd'] == $passwd) {
                var_dump($row);
            }
            else{
                echo 'Le mot de passe entre n\'est pas valide';
            }
        }
        else {
            echo 'Ce nom d\'utilisateur n\'existe pas dans la bd';
        }
    }  
    else {
        echo 'Erreur dans la requete SQL';
    }
        