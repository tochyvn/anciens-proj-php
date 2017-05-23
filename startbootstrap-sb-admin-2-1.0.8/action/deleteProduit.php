<?php


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

if (isset($_POST['id'])) {
    
    $id = test_input($_POST['id']);
    if (selectProduit($id)) {
        $conn = ConnexionPDO::$_connexionBdd;
        $sql = $sql = "DELETE FROM produit "
            . "WHERE idProduit = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt->execute(array($id))) {
            return json_encode(array(
                'code' => 1,
                'error' => FALSE,
                'msg' => 'erreur dans l\'execution de la requête'
            ));
        }
        return json_encode(array(
            'code' => 0,
            'error' => FALSE,
            'message' => 'suppression effectuée avec succès'
        ));
    } 
    
    return json_encode(array(
        'code' => 2,
        'error' => TRUE,
        'message' => 'suppression effectuée avec succès'
    ));
    
}