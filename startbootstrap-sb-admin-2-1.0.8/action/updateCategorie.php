<?php

include '../include/connect.php';


$nomFR = test_input($_POST['nomFR']);
$nomEN = test_input($_POST['nomEN']);

function updateCategorie($nomFR, $nomEN) {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "UPDATE CATEGORIELIEU "
            . "SET "
            . "nomCategFR = ?, "
            . "nomCategENG = ?";
        
    
    //Preparation de ma requête
    $statement = $conn->prepare($sql);
    
    //Pour le mode developpement
    if (!$statement->execute(array($nomFR, $nomEN))) {
        
        return array(
            'code' => 1,
            'error' => TRUE,
            'msg' => 'erreur  dans la requête d\'insertion :'.var_dump($statement->errorInfo())
        );
    }  
    return array(
        'code' => 0,
        'error' => FALSE,
        'msg' => 'insertion de l\'utilisateur reussie'
    );
    
}

$resultat = updateCategorie($nomFR, $nomEN);
echo json_encode($resultat);