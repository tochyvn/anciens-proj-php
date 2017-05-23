<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function getIdVilleByName($ville) {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM ville "
            . "WHERE nomVille = ? ";
    
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($ville))) {
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            return $row['idVille'];
        }
        return FALSE;
    }
}