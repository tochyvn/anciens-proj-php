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

function ajaxVilles($term) {
    $sql = "SELECT ville_nom_reel, ville_code_postal, ville_id FROM villes_france_free "
            . "WHERE ville_nom_reel LIKE ? OR ville_code_postal LIKE ? "
            . "ORDER BY ville_nom_reel ASC ";
    
    $sql1 = "SELECT * FROM ville "
            . "WHERE nomVille LIKE ? OR codePostal LIKE ?";
    
    $sql2 = "SELECT * FROM ville "
            . "WHERE nomVille = ?";
    
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array('%'.$term.'%', '%'.$term.'%'))) {
        if ($stmt->rowCount() > 0) {
            $villes = $stmt->fetchAll();
            $result = array();
            foreach ($villes as $ville) {
                array_push($result, $ville['ville_code_postal']. ' '. $ville['ville_nom_reel']. ' '. $ville['ville_id']);
            }
            
            return $result;
        }
        return FALSE;
    }
}