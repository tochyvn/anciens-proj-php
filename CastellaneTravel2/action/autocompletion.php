<?php

include '../include/connect.php';

function ajaxVilles($term) {
    $sql = "SELECT nomVille, cpVille, idVille FROM VILLE "
            . "WHERE nomVille LIKE ? OR cpVille LIKE ? "
            . "ORDER BY nomVille ASC ";
    
    $sql1 = "SELECT * FROM ville "
            . "WHERE nomVille LIKE ? OR codePostal LIKE ?";
    
    $sql2 = "SELECT * FROM ville "
            . "WHERE nomVille = ?";
    
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array('%'.$term.'%', '%'.$term.'%'))) {
        if ($stmt->rowCount() > 0) {
            $villes = $stmt->fetchAll();
            $result = array();
            foreach ($villes as $ville) {
                array_push($result, $ville['cpVille']. ' '. $ville['nomVille']. ' '. $ville['idVille']);
            }
            
            return $result;
        }
        return FALSE;
    }
}

$term = test_input($_GET['term']);
$villes = ajaxVilles($term);
echo json_encode($villes);

