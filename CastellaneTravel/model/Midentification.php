<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function login($email, $passwd) {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM utilisateur "
            . "WHERE adrMailUtilisateur = ? ";
    
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($email))) {
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            if ($row['mdpUtilisateur'] === $passwd) {
                
                $_SESSION['email'] = $row['adrMailUtilisateur'];
                $droit = "";
                if ($row['priority'] == 0) {
                    $droit = "normal";
                }
                else {
                    $droit = "admin";
                }
                return array(
                    'connected' => TRUE,
                    'code' => 0,
                    'msg' => 'Vous êtes bien connectez',
                    'droit' => $droit
                );
            }
            return array(
                'connected' => FALSE,
                'code' => 2,
                'msg' => 'Le mot de passe que vous avez rentré n\'est pas valide'
            );
        }
        return array(
            'connected' => FALSE,
            'msg' => 'Cet utilisateur n\'existe pas dans la base de données',
            'code' => 1
        );
        
    }
    
}

function signin($array) {
    
    include 'Mville.php';
    //SI CET EMAIL N'EST PAS UTILISÉE
    if (!existEmail($array['email'])) {
        $conn = ConnexionPDO::$_connexionBdd;
        $sql1 = "INSERT INTO utilisateur "
            . "(nomUtilisateur, adrMailUtilisateur, mdpUtilisateur) "
            . "VALUES (?, ?, ?)";
    
        $sql2 = "INSERT INTO client "
            . "(adrClient, idUtilisateur, idVille, nom) "
            . "VALUES (?, ?, ?, ?)";
        //INSERTION D'UN NOUVEL UTILISATEUR
        $stmt1 = $conn->prepare($sql1);
        if (!$stmt1->execute(array($array['nom'], $array['email'], $array['passwd']))) {
            return array(
                'code' => 2,
                'msg' => 'erreur dans l\'insertion de l\'utilisateur associé',
                'status' => FALSE
            );
        }
        //INSERTION DU CLIENT ASSOCIÉ AU USER CREER PLUS HAUT
        $idUser = existEmail($array['email']);
        //$idVille = getIdVilleByName($nomVille);
        
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2->execute(array($array['adresse'], $idUser, $array['idVille'], $array['nom']))) {
            deleteUser($idUser);
            return array(
                'code' => 3,
                'msg' => 'erreur dans l\'insertion du client',
                'status' => FALSE
            );
        }
        
        return array(
            'code' => 0,
            'msg' => 'Insertion du client reussie',
            'status' => TRUE
        );
        
    }
    
    return array(
        'code' => 1,
        'msg' => 'L\'adresse email est déja utilisée',
        'status' => FALSE
    );
    
}

function updatePassword() {
    
}
/**
 * Methode permettant de récuperer l'id du utilisateur à partir de email
 * @param type $email
 * @return boolean
 */
function existEmail($email) {
    
    $sql = "SELECT * FROM utilisateur "
            . "WHERE adrMailUtilisateur = ? ";
    
    $conn = ConnexionPDO::$_connexionBdd; 
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($email));
    if($stmt->rowCount() > 0){
        $row = $stmt->fetch();
        return $row['idUtilisateur'];
    }
    return false;
    
}

function deleteUser($id) {
    $sql = "DELETE FROM utilisateur "
            . "WHERE idUtilisateur = ?";
    $conn = ConnexionPDO::$_connexionBdd;
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
}
