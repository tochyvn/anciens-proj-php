<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function voirCatalogue() {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM produit";
    $stmt = $conn->query($sql);
    $stmt->execute();
    $resultat = array();
    
    while ($row = $stmt->fetch()) {
        $resultat[$row['idProduit']] = array(
            $row['nomProduitFR'],
            $row['nomProduitENG'],
            $row['prixProduit'],
            $row['descriptProduitFR'],
            $row['descriptProduitENG'],
            $row['idSociete']
        );
        
    }
    
    return $resultat;
}

function voirCatalogue1() {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM produit";
    $stmt = $conn->query($sql);
    $stmt->execute();
    $resultat = array();
    
    if ($stmt->rowCount() > 0) {
        
        while ($row = $stmt->fetch()) {
            $resultat[] = $row;
        }
    
        return $resultat;
       
    }
    
    return false;
}


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

function insertProduit($nomFR, $nomEN, $prix, $descFR, $descEN, $idSoc) { 
    
    $conn = ConnexionPDO::$_connexionBdd;
    
    $sql = "INSERT INTO produit "
            . "(nomProduitFR, nomProduitENG, prixProduit, descriptProduitFR, descriptProduitENG, idSociete) "
            . "VALUES(?, ?, ?, ?, ?, ?)";
    
    //Preparation de ma requête
    $statement = $conn->prepare($sql);
    
    //Pour le mode developpement
    if (!$statement->execute(array($nomFR, $nomEN, $prix, $descFR, $descEN, $idSoc))) {
        var_dump($statement->errorInfo()); 
        return array(
            "error" => TRUE,
            "code" => 1,
            "msg" => "Une erreur est survenue lors de la preparation de la requête sql"
        );
    }
    
    //if ($statement->rowCount() >)
    return array(
            "error" => FALSE,
            "code" => 0,
            "msg" => "Insertion reussie",
            
        ); 
    
}

function supprimerProduit($id) {
    $sql = "DELETE FROM produit "
            . "WHERE idProduit = ?";
    $conn = ConnexionPDO::$_connexionBdd;
    
    if (selectProduit($id)) {
        $stmt = $conn->prepare($sql);
        if (!$stmt->execute(array($id))) {
            return FALSE;
        }
        return TRUE;
    }
    
    return FALSE;
      
}

function updateProduit($param) {
    
    $sql = "UPDATE produit "
            . "SET nomProduitFR = ?, "
            . "nomProduitENG = ?, "
            . "prixProduit = ?, "
            . "descriptProduitFR = ?, "
            . "descriptProduitENG = ?, "
            . "idSociete = ? "
            . "WHERE idProduit = ?;";
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    
    if (selectProduit($param[6])) {
        if (!$stmt->execute($param)) {
            return FALSE;
        }
        return TRUE;
    }
    
    return FALSE;
}