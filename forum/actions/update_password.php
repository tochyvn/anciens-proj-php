<?php
session_start();
require '../includes/connexion_mysqli.php';
include '../includes/form_validation.inc.php';
$_SESSION['errors'] = array();
$_SESSION['populate_value'] = array();

$_SESSION['populate_value'] = array();
$validation = true;
if (!empty($_POST['email_update'])  && !empty($_POST['passwd_update']) && !empty($_POST['passwd_conf_update'])) {
    $email_update = test_input($_POST['email_update']);
    $passwd_update = test_input($_POST['passwd_update']);
    if (!validate_email($email_update) || !validate_password($passwd_update) || !isEquals('passwd_update', 'passwd_conf_update')) {
        $validation = FALSE;
        //Si l'email est valide alors le mot de passe est forcement invalide
        if(validate_email($email_update)) {
            //Pour repeupler le champ email, pour eviter à l'utilisateur de le remplir à nouveau
            $_SESSION['populate_value']['email_update'] = $email_update;
            $_SESSION['errors']['passwd_update'] = TRUE;
            echo 'email invalide';
        }else{
            $_SESSION['errors']['email_update'] = "Le format de l'email rentr&eacute;e est invalide";
        }
        
        if (!validate_password($passwd_update) ||  !isEquals('passwd_update', 'passwd_conf_update')) {
            $_SESSION['errors']['passwd_update'] = "Les mots de passe doivent contenir au moins 6 caract&agrave;res et &ecirc;tre identiques";
        }
    }else {
        echo 'Formulaire valide';
        var_dump($passwd_update, $email_update);
        
    }
}else {
    $validation = FALSE;
    $_SESSION['errors']['required'] = "Tous les champs doivent &ecirc;tre obligatoirement renseign&eacute;s.";
    if (!empty($_POST['email_update'])) {
        if(validate_email($_POST['email_update']) ) {
            //Pour repeupler le champ email, pour eviter à l'utilisateur de le remplir à nouveau s'il est valide
            $_SESSION['populate_value']['email_update'] = $_POST['email_update'];
            $_SESSION['errors']['passwd_update'] = "Les mots de passe doivent contenir au moins 6 caract&agrave;res et &ecirc;tre identiques";
        }else {
            $_SESSION['errors']['email_update'] = "Le format de l'email rentr&eacute;e est invalide";
        }
    }else {
        $_SESSION['errors']['email_update'] = "Le format de l'email rentr&eacute;e est invalide";
    }
    //if (!empty($_POST['passwd_update']))
}

if (!$validation) {
    header("location:".$_SERVER['HTTP_REFERER']);
}



