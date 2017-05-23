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
function insertArticle($conn, $designation, $prixU, $image) { 
    
    //include 'include/connexion_bd.php';
    
    $sql = "INSERT INTO article "
            . "(desig_art, img_art, pu_art) "
            . "VALUES(?, ?, ?)";
    
    //Preparation de ma requête
    $statement = $conn->prepare($sql);
    if (!$statement) {
        return array(
            "error" => TRUE,
            "code" => 1,
            "msg" => "Une erreur est survenue lors de la preparation de la requête sql"
        );
    }
    
    if (!$statement->bind_param("ssd", $designation, $image, $prixU)) {
        return array(
            "error" => TRUE,
            "code" => 2,
            "msg" => "Une erreur est survenue lors de l'alliage des paramètres"
        );
    }
    
    if (!$statement->execute()) {
        return array(
            "error" => TRUE,
            "code" => 2,
            "msg" => "Une erreur est survenue lors de l'execution de la requête"
        );
    }
    $res = $statement->get_result();
    $row = $res->fetch_assoc();
    var_dump($row);
    $statement->close();
    return array(
            "error" => FALSE,
            "code" => 0,
            "msg" => "Insertion réussie"
        );
        
}

/**
 * 
 * @param type $id
 */
function deleteArticle($id) {
    
}



