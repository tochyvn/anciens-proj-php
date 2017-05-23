<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * 
 * @param type $conn
 * @param type $email
 * @param type $passwd
 * @return type
 */
/*
function login($conn, $email, $passwd) {
    
    $sql = "SELECT * FROM utilisateur "
            . "WHERE email = '$email'";
    //var_dump($conn);
    $query = $conn->query($sql);
    //var_dump($query);
    
    if ($query->num_rows > 0) {
        $resultat = $query->fetch_assoc();
        if ($resultat['passwd'] == $passwd) {
            return array(
                'connected' => TRUE,
                'code' => 0,
                'msg' => 'Vous êtes bien connectez',
                'informations' => $resultat
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
*/
function loginPDO($email, $passwd) {
    
    $conn = ConnexionPDO::$_connexionBdd;
    $sql = "SELECT * FROM utilisateur "
            . "WHERE email = ? ";
    
    $stmt = $conn->prepare($sql);
    if ($stmt->execute(array($email))) {
        
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            if ($row['passwd'] == $passwd) {
                return array(
                    'connected' => TRUE,
                    'code' => 0,
                    'msg' => 'Vous êtes bien connectez',
                    'informations' => $row
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

function signin() {
    
}

function updatePassword() {
    
}
