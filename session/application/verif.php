<?php

//Initialisation de session
session_start();

function de() {
    return isset($_POST['envoyer']);
}

function verification($nom, $password) {
    
}

//Si on a reu les donnŽes d'un formulaire
if (isset($_POST['pseudo']) && isset($_POST['password'])) {
    
    //On les recupre
    $nom = $_POST['pseudo'];
    $passwd = $_POST['password'];
    
    //On teste si le password est valide
    
    if (verification($nom, $passwd)) {
        
        //Le password est valide
        //On change d'identifiant de session
        session_regenerate_id();
        
        //On sauvegarde son nom dans la session
        $_SESSION['nom'] = $nom;
        
        
        
    }
    
}

?>