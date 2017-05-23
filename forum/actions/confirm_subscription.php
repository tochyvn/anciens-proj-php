<?php
session_start();
require '../includes/connexion_mysqli.php';
if (isset($_GET['token'], $_GET['id'], $_GET['hash'])) {
    $hashage = $_GET['hash'];
    $id = $_GET['id'];
    $now = time();
    $delai = $now - $_GET['token'];
    $sql = "SELECT * FROM users  "
            . "WHERE id_user = ". $id ." AND hashage = '". $hashage. "'";
    $query = $connexion->query($sql);
    $num_rows = $query->num_rows;
    if ($delai <= 3600*24 && $num_rows > 0) {
        $row = $query->fetch_assoc();
        //Mise a jour du status passant ‡ 1 (compte activÈ) et du hashage pour rendre le lien expirÈ
        $hashage_update = md5($row['pseudonyme']. '_'. $row['email'].'_'.  date('d-m-Y h:i:s'));
        $sql = "UPDATE users SET statut = 1, hashage = '".$hashage_update ."'"
                . "WHERE id_user = '". $id ."' AND hashage = '". $hashage ."'";
        $query = $connexion->query($sql);
        if ($query) {
            //Redirection vers la page de connexion
            $_SESSION['flash'] = "F&eacute;licitations. Votre compte vient d'&ecirc;tre activ&eacute;, vous pouvez vous connecter &agrave; pr&eacute;sent.";
            header('location:../index.php');
        }else {
           //Redirection vers la page de connexion d'erreur de connexion
           echo 'erreur de connexion'. $connexion->error;
        }
    }else {
        //Redirection vers la page d'erreur avec message lien expiré envoyé en GET
        echo 'Ce lien a expiré ou l\'utilisateur n\'existe pas';
    }
    unset($_SESSION['confirm_email_subscription']);
}
