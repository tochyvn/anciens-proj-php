<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * 
 * @param type $designation
 * @param type $prixU
 * @param type $image
 * @return type
 */
function insertProduit($designation, $prixU, $image) { 
    
    $conn = ConnexionPDO::$_connexionBdd;
    
    $sql = "INSERT INTO article "
            . "(desig_art, img_art, pu_art) "
            . "VALUES(?, ?, ?)";
    
    //Preparation de ma requête
    $statement = $conn->prepare($sql);
    if (!$statement->execute(array())) {
        return array(
            "error" => TRUE,
            "code" => 1,
            "msg" => "Une erreur est survenue lors de la preparation de la requête sql"
        );
    }
    
    
        
}


function deleteArticle() {
    
}


function updateArticle() {
    
}


