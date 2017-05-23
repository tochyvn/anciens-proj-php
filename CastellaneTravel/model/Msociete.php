<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function voirSociete($param) {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM societe";
    $stmt = $conn->query($sql);
    $stmt->execute();
    $resultat = array();
    
    while ($row = $stmt->fetch()) {
        $resultat[$row['idSociete']] = array(
            $row['nomSociete'],
            $row['adrSociete'],
            $row['siteWebSociete'],
            $row['numTelSociete'],
            $row['descriptSocieteFR'],
            $row['descriptSocieteENG'],
            $row['descriptSocieteENG']
        );
        
    }
    
    return $resultat;
}

function insertSociete($param) {
        
    $sql = "INSERT INTO `societe` "
            . "VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);";
    
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    
    if (!$stmt->execute($param)) {
            return FALSE;
    }
    return TRUE;
}

function supprimerSociete($id) {
    $sql = "DELETE FROM societe "
            . "WHERE idSociete = ?";
    $conn = ConnexionPDO::$_connexionBdd;
    
    if (selectSociete($id)) {
        $stmt = $conn->prepare($sql);
        if (!$stmt->execute(array($id))) {
            return FALSE;
        }
        return TRUE;
    }
    
    return FALSE;
      
}

function selectSociete($id) {
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM societe "
            . "WHERE idSociete = ?";
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


function updateSociete($param) {
    
    $sql = "UPDATE societe "
            . "SET nomSociete = ?, "
            . "adrSociete = ?, "
            . "siteWebSociete = ?, "
            . "numTelSociete = ?, "
            . "descriptSocieteFR = ?, "
            . "descriptSocieteENG = ?, "
            . "idCateg = ?, "
            . "idQuartier = ? "
            . "WHERE idSociete = ?;";
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    
    if (selectSociete($param[8])) {
        if (!$stmt->execute($param)) {
            var_dump($stmt->errorInfo()); 
            return 'rrrrr';
        }
        return TRUE;
    }
    
    return 'tochhhhhh';
}

