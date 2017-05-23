<?php
    require '../class/db.class.php';
    include '../class/connect.class.php';
    $DB = new DB();
    $connect = new connect($DB);
    
    if (isset($_GET['action'])) {       
        $action = $_GET['action'];
    }
    else {
        $action = $_POST['action'];
    }
        
    switch ($action) {
    
        case "connexion":
            //Recuperation des informations soumis dans le formulaire
            $email = $_POST['email'];
            $passwd = $_POST['passwd'];
            $resultat = $connect->login($email, $passwd);
            //Pour la reponse à la requete AJAX
            echo json_encode($resultat);
        break;
    
        case "subscribe":
            
        break;

        default:
        
        break;
    }

    
    
    
    