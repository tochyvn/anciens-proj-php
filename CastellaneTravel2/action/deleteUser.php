<?php


include '../include/connect.php';


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

if (isset($_POST['id'])) {
    
    $id = test_input($_POST['id']);
    if (selectUser($id)) {
        $conn = ConnexionPDO::$_connexionBdd;
        $sql = $sql = "DELETE FROM UTILISATEUR "
            . "WHERE idUtilisateur = ?";
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