<?php

include '../include/connect.php';

$param = array(
    test_input($_POST['nomSoc']),
    test_input($_POST['adrSoc']),
    test_input($_POST['site']),
    test_input($_POST['tel']),
    test_input($_POST['descrFR']),
    test_input($_POST['descrEN']),
    test_input($_POST['cat']),
    test_input($_POST['quart'])
);

$sql = "INSERT INTO `societe` "
            . "VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?);";
    
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    
    if (!$stmt->execute($param)) {
        echo 'echec insert';
    }
    else {
        echo 'echo insertion reussie';
    }
