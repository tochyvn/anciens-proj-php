<?php

include '../include/connect.php';

function updateProduit($param) {
    
    $sql = "UPDATE UTILISATEUR "
            . "SET nomUtilisateur = ?, "
            . "adrMailUtilisateur = ?, "
            . "mdpUtilisateur = ?, "
            . "adrUtilisateur = ?, "
            . "admin = ?, "
            . "idVille = ? ";
    
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);

    if (selectUser($param[5])) {
        
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

function selectUser($id) {
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM UTILISATEUR "
            . "WHERE idUtilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
    
    if ($stmt->rowCount() > 0) {
        
    $row = $stmt->fetch();
        
       return $row;
    }
    
    return false;
       
}

//var_dump($_POST);

if (isset($_POST['id'])) {
    $id = test_input($_POST['id']);
    
        $parameters = array(
            test_input($_POST['nom']),
            test_input($_POST['email']),
            test_input($_POST['passwd']),
            test_input($_POST['adresse']),
            test_input($_POST['role']),
            $id
        );
        $resultat = updateProduit($parameters);
        echo json_encode($resultat);
}









