<?php

include '../include/connect.php';

function updateProduit($param) {
    
    $sql = "UPDATE PRODUIT "
            . "SET nomProduitFR = ?, "
            . "nomProduitENG = ?, "
            . "prixProduit = ?, "
            . "stockProduit = ?, "
            . "descriptProduitFR = ?, "
            . "descriptProduitENG = ?, "
            . "titrePhotoFR = ?, "
            . "titrePhotoENG = ?, "
            . "altPhoto = ?, "
            . "lienPhoto = ?, "
            . "idSociete = ? "
            . "WHERE idProduit = ?;";
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    
    if (selectProduit($param[7])) {
        if (!$stmt->execute($param)) {
            return array(
                'code' => 1,
                'error' => TRUE,
                'msg' => 'erreur requete'
            );
        }
        return array(
            'code' => 0,
            'error' => FALSE,
            'msg' => 'succes'
        );
    }
    return array(
        'code' => 2,
        'error' => TRUE,
        'msg' => 'produit inexistant'
    );
}

function selectProduit($id) {
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM PRODUIT "
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

//var_dump($_POST);

if (isset($_POST['id'])) {
    $id = test_input($_POST['id']);
    
        $parameters = array(
            test_input($_POST['nomFR']),
            test_input($_POST['nomEN']),
            test_input($_POST['prix']),
            test_input($_POST['stock']),
            test_input($_POST['descrFR']),
            test_input($_POST['descrEN']),
            test_input($_POST['titreFR']),
            test_input($_POST['titreEN']),
            test_input($_POST['alt']),
            test_input($_POST['lien']),
            test_input($_POST['soc']),
            $id
        );
        $resultat = updateProduit($parameters);
        echo json_encode($resultat);
}








