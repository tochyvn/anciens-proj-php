<?php

include '../include/connect.php';


$username = test_input($_POST['nom']);
$email = test_input($_POST['email']);
$adr = test_input($_POST['adresse']);
$passwd = test_input($_POST['passwd']);
$passwd1 = test_input($_POST['passwd1']);
//$cp = test_input($_POST['cp']);
$ville = test_input($_POST['id_ville']);
$role = test_input($_POST['role']);


function insertUser($username, $email, $passwd, $adr, $role, $ville) {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "INSERT INTO UTILISATEUR "
        . "(nomUtilisateur, adrMailUtilisateur, mdpUtilisateur,"
        . " adrUtilisateur,"
        . " admin, idVille) "
            . "VALUES(?, ?, ?, ?, ?, ?)";
    
    //Preparation de ma requête
    $statement = $conn->prepare($sql);
    
    //Pour le mode developpement
    if (!$statement->execute(array($username, $email, $passwd, $adr, $role, $ville))) {
        
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

$resultat = insertUser($username, $email, $passwd, $adr, $role, $ville);
echo json_encode($resultat);