<?php
session_start();

include '../includes/form_validation.inc.php';
require '../includes/connexion_mysqli.php';
$_SESSION['auth'] = array();
$_SESSION['populate_value'] = array();
//Pour savoir le formulaire soumis sur la page d'accueil
$_SESSION['form_active'] = 'subscribe';

$validation = true;
if(isset($_POST['mail1'], $_POST['password1']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pseudo']) && !empty($_POST['password1_conf'])) {
    //Eviter la faille XSS
    $nom = test_input($_POST['nom']);
    $prenom = test_input($_POST['prenom']);
    $mail = test_input($_POST['mail1']);
    $password = test_input($_POST['password1']);
    $pseudo = test_input($_POST['pseudo']);
    //Pour pouvoir repeupler les zone (nom, prenom, pseudo)
    $_SESSION['populate_value']['nom'] = $nom;
    $_SESSION['populate_value']['prenom'] = $prenom;
    $_SESSION['populate_value']['pseudo'] = $pseudo;
 
    if (!validate_email($mail) || !validate_password($password) || !isEquals('password1', 'password1_conf')) {
        $validation = FALSE;
        if(validate_email($mail)) {
            //Pour repeupler le champ email, pour eviter à l'utilisateur de le remplir à nouveau
            $_SESSION['populate_value']['mail1'] = $mail;
            $_SESSION['errors']['password1'] = "Les mots de passe doit contenir au moins 6 caract&egrave;res et doivent &ecirc;tre identiques";
        }elseif (validate_password($password) &&  isEquals('password1', 'password1_conf')) {
            //Pour repeupler le champ email, pour eviter à l'utilisateur de le remplir à nouveau
            $_SESSION['errors']['mail1'] = "V&eacute;rifier que le format de l'email que vous avez rentr&eacute; est valide";
        }else {
            $_SESSION['errors']['password1'] = "Les mots de passe doitvent contenir au moins 6 caract&egrave;res et doivent &ecirc;tre identiques";
            $_SESSION['errors']['mail1'] = "V&eacute;rifier le format de l'email que vous avez rentr&eacute;";
        }
    }else {
        $sql = "SELECT * FROM users  "
                . "WHERE email = '". $mail ."'";
        $query = $connexion->query($sql);
        //Si cet email existe deja dans la base de données
        if ($query->num_rows > 0) {
            //Redirection avec message cet adresse email est deja utilisé
            $_SESSION['errors']['use_email'] = "Cette adresse email existe d&eacuteja;, svp veuillez saisir une autre adresse email";
            header('location:../forum.php');
        }else {
            $hashage = md5($pseudo. '_'. $mail.'_'.  date('d-m-Y h:i:s'));
            $sql = "INSERT INTO users (email, password , pseudonyme, hashage) "
                . "VALUES ('$mail', '". md5($password) ."', '$pseudo', '$hashage')";
            $query = $connexion->query($sql);
            
            if ($query) {
                $id = $connexion->insert_id;
                $_SESSION['populate_value'] = array();
                $_SESSION['flash']['success'] = "Inscription r&eacuteussie. Verifiez votre boite email, un lien d'activation vous &agrave; &eacute;t&eacute; envoy&eacute;";
                $lien  = 'http://'.$_SERVER['SERVER_NAME'].'/actions/confirm_subscription.php?id='.$id.'&token='. time().'&hash='.$hashage;

                sendMail($mail, "Finalisation de votre demande d'inscription", "Vous venez de faire une"
                        . " demande d'inscription sur notre site"
                        . ". Pour poursuivre votre inscription cliquez sur le lien suivant: \r\nLien : "
                        .$lien);
                header('location:../forum.php');
            }else {
                //Redirection vers la page de d'erreur probl&egrave;me de connexion
                echo "Redirection vers la page de d'erreur probl&egrave;me de connexion";
            }
        }
    }
}else {
    $validation = FALSE;
    $_SESSION['errors']['required'] = "Certains champs obligatoires (*) n'ont pas &eacute;t&eacute; renseign&eacute;s";
    if (!empty($_POST['nom'])) {
        $_SESSION['populate_value']['nom'] = $_POST['nom'];
    }
    if (!empty($_POST['prenom'])) {
        $_SESSION['populate_value']['prenom'] = $_POST['prenom'];
    }
    if (!empty($_POST['pseudo'])) {
        $_SESSION['populate_value']['pseudo'] = $_POST['pseudo'];
    }
    if(validate_email($_POST['mail1'])) {
        $_SESSION['populate_value']['mail1'] = $_POST['mail1'];
    }
    
}

if (!$validation) {
    header('location:../forum.php');
}



