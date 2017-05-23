<?php
session_start();

include '../includes/form_validation.inc.php';
require '../includes/connexion_mysqli.php';
$_SESSION['auth'] = array();
$_SESSION['errors']  = array();
$_SESSION['populate_value'] = array();
$_SESSION['form_active'] = 'login';
$_SESSION['flash'] = array();

$validation = true;
if(isset($_POST['mail'], $_POST['password'])) {
    $mail = test_input($_POST['mail']);
    $password = test_input($_POST['password']);
    if (!validate_email($mail) || !validate_password($password)) {
        $validation = FALSE;
        //Si l'email est valide alors le mot de passe est forcement invalide
        if(validate_email($mail)) {
            //Pour repeupler le champ email, pour eviter à l'utilisateur de le remplir à nouveau
            $_SESSION['populate_value']['mail'] = $mail;
            $_SESSION['errors']['password'] = "Le mot de passe doit contenir au moins 6 caractères.";
        }else {
            $_SESSION['populate_value']['password'] = $password;
            $_SESSION['errors']['mail'] = "Le format de l'email que vous avez saisie est invalide.";
        }
    }else {
        $sql = "SELECT * FROM users WHERE email = '$mail' AND password = '" . md5($password) . "' ";
        $query = $connexion->query($sql);
        if ($query) {
            if ($query->num_rows > 0) {
                $row = $query->fetch_assoc();
                //Si le compte a été activé
                if ($row['statut'] == 1) {
                    $_SESSION['auth']['mail'] = $row['email'];
                    $_SESSION['auth']['password'] = $row['password'];
                    $_SESSION['auth']['pseudonyme'] = $row['pseudonyme'];
                    header('location:../pages/sujets.php');
                }elseif ($row['statut'] == 0) {
                    
                    $_SESSION['flash']['error'] = "Votre compte n'a pas encore &eacute;t&eacute; activ&eacute;. Veillez v&eacute;rifier votre adresse email, un lien d'activation vous a &eacute;t&eacute; envoy&eacute;.";
                    header('location:../forum.php');

                }else {

                    //Redirection avec affichage du message, verifiez votre boite email pour pour plus d'infos sur la suspension
                    $_SESSION['flash']['error'] = "Compte momentan&eacute;ment suspendu. Pour plus de details veillez consulter votre boite email ou contactez l'administrateur du site." ;
                    header('location:../forum.php');
                
                }
            }else {
                //Redirection vers la page de connexion
                $validation = FALSE;
                $_SESSION['errors']['auth'] = "L'email ou le mot de passe est incorrect";
                header('location:../forum.php');
            }
        }else {
            //Redirection vers la page de d'erreur problÃ¨me de connexion
            echo "Redirection vers la page de d'erreur problÃ¨me de connexion";
        }
    }
}else {
    $validation = FALSE;
    $_SESSION['errors']['required'] = "Certains obligatoires n'ont pas &eacute;t&eacute; renseign&eacute;s";
    if(validate_email($_POST['mail'])) {
        $_SESSION['populate_value']['mail'] = $_POST['mail'];
    }else {
        $_SESSION['errors']['mail'] = "Le format de l'email que vous avez saisie est invalide."; 
    }
    
    if (!validate_password($_POST['password'])) {
        $_SESSION['errors']['password'] = TRUE;
    }
    
}
if (!$validation) {
    header('location:../forum.php');
}

