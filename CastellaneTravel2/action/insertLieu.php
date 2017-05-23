<?php

include '../include/connect.php';

$param = array(
    test_input($_POST['nomLieu']),
    test_input($_POST['adrLieu']),
    test_input($_POST['quart']),
    test_input($_POST['cat'])
);

$sql = "INSERT INTO `LIEU` "
            . "VALUES (NULL, ?, ?, ?, ?);";
    
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    
    if (!$stmt->execute($param)) {
        var_dump($stmt->errorInfo()); 
        echo 'echec insert';
    }
    else {
        echo 'insertion reussie';
    }
