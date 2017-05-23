<?php
session_start();
include '../includes/form_validation.inc.php';
require '../includes/connexion_mysqli.php';

$_SESSION['form_active'] = "popup_update";
$_SESSION['errors'] = array();
$validation = true;

if  (isset($_POST['email_update'])) {
    $email = $_POST['email_update'];
    if (validate_email($email)) {
        
        $sql = "SELECT * FROM users  "
                . "WHERE email = '". $email ."'";
        $query = $connexion->query($sql);
        //Si cet email existe deja dans la base de données
        if ($query->num_rows > 0) {
            $row = $query->fetch_assoc();
            $hash = $row['hashage'];
            $id = $row['id_user'];
            if ($row['statut'] != 3) {
                $subject = "Modification de mot passe";
                $lien = 'http://'.$_SERVER['SERVER_NAME'].'/pages/update_password.php?hash='. $hash .'&id='. $id. '&token='. time();
                $message = "Vous avez recemment demandé un changement de mot de passe. \r\n"
                . "Cliquez sur le lien suivant pour reinitialiser votre mot de passe: ". $lien;
                sendMail($email, $subject, $message);
                $_SESSION['flash'] = "verifiez votre boite email, vous avez recu un mail de reinitialisation de mot de passe";
                header('location:../forum.php');
            }else {
                //Redirection avec affichage du message, verifiez votre boite email pour pour plus d'infos sur la suspension
                //header('location:../forum.php');
                echo "Compte momentanément suspendu. Pour plus de details"
                . "sur votre suspension, veillez consulter votre boite email." ;
            }
        }else {
           $_SESSION['errors']['update_email'] = "L'utilisateur saisie n'existe pas";
        }
        
    }else {
        $validation = false;
        $_SESSION['errors']['update_email'] = "Le format de l'email que vous rentre&eacute; est invalide";
    }
}else {
    $validation = false;
    $_SESSION['errors']['update_email'] =  'ce champ ne peut etre vide, veuillez le renseigner';
}

header('location:../forum.php#Modal_mdp');
