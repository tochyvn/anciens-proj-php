<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../include/connect.php';


function selectProduit($id) {
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM produit "
            . "WHERE idProduit = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
    $resultat = array();
    
    if ($stmt->rowCount() > 0) {
        
        while ($row = $stmt->fetch()) {
            array_push($resultat, $row);
        }
    
        return $resultat[0];
       
    }
    
    return false;
       
}

if (isset($_GET['id'])) {
    
    $id = test_input($_GET['id']);
    if (selectProduit($id)) {
        $conn = ConnexionPDO::$_connexionBdd;
        $sql = $sql = "DELETE FROM produit "
            . "WHERE idProduit = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt->execute(array($id))) {
            return FALSE;
        }
        return TRUE;
    }      
}