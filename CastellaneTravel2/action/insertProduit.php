<?php
include '../include/connect.php';

/*
$conn = ConnexionPDO::$_connexionBdd;
    
    $sql = "INSERT INTO PRODUIT "
            . "(nomProduitFR, nomProduitENG, prixProduit, stockProduit, descriptProduitFR, descriptProduitENG, idSociete) "
            . "VALUES(?, ?, ?, ?, ?, ?, ?)";
    
    //Preparation de ma requête
    $statement = $conn->prepare($sql);
    
    //Pour le mode developpement
    if (!$statement->execute(array($nomFR, $nomEN, $prix, $stock, $descFR, $descEN, $idSoc))) {
        var_dump($statement->errorInfo()); 
    }
    else {
        echo 'insertion reusssie';
    }
 * 
 */
    
function ajouterProduit($nomFR, $nomEN, $prix, $stock, $descFR, $descEN, $titreFR, $titreENG, $alt, $lien, $idSoc) {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "INSERT INTO PRODUIT "
            . "(nomProduitFR, nomProduitENG, prixProduit, stockProduit, descriptProduitFR,"
            . " descriptProduitENG, titrePhotoFR, titrePhotoENG, altPhoto, lienPhoto, idSociete) "
            . "VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //Preparation de ma requête
    $statement = $conn->prepare($sql);
    //Pour le mode developpement
    if (!$statement->execute(array($nomFR, $nomEN, $prix, $stock, $descFR, $descEN, $titreFR, $titreENG, $alt, $lien, $idSoc))) {
        return array(
            'code' => 1,
            'error' => TRUE,
            'msg' => 'Erreur dans l\'execution de la requête AJAX:  '.$statement->errorInfo()
        );
    }
    else {
        return array(
            'code' => 0,
            'error' => FALSE,
            'msg' => 'Insertion reussie'
        );
    }
}

$nomFR = test_input($_POST['nomFR']);
$nomEN = test_input($_POST['nomEN']);
$prix = test_input($_POST['prix']);
$stock = test_input($_POST['stock']);
$descFR = test_input($_POST['descrFR']);
$descEN = test_input($_POST['descrEN']);
$idSoc = test_input($_POST['soc']);
$titreFR = test_input($_POST['titreFR']);
$titreENG = test_input($_POST['titreEN']);
$alt = test_input($_POST['alt']);

$file = $_FILES['photo_to_upload'];
$tmpFileName=$file['tmp_name'];
$name = $file['name'];

$tab = explode('.', $name);
$length = count($tab);
$extension = $tab[$length-1];

$repertoire = mkdir('../upload/produits/produit__'.$nomFR);
//Rennomage du fichier
$nom = md5(uniqid(rand(), true)).'.'.$extension;

$dest = '../upload/produits/produit__'.$nomFR.'/'.$nom;
//Deplacemment du fichier
move_uploaded_file($tmpFileName, $dest);

$lien = $nom;

$resultat = ajouterProduit($nomFR, $nomEN, $prix, $stock, $descFR, $descEN, $titreFR, $titreENG, $alt, $lien, $idSoc);

echo json_encode($resultat);
