<?php

include '../include/connect.php';


$nomFR = test_input($_POST['nomFR']);
$nomEN = test_input($_POST['nomEN']);

function insertCategorie($nomFR, $nomEN) {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "INSERT INTO CATEGORIELIEU "
        . "(nomCategFR, nomCategENG) "
            . "VALUES(?, ?)";
    
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

$resultat = insertCategorie($nomFR, $nomEN);
echo json_encode($resultat);