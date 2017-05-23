<?php
    
    include 'model/Midentification.php';
    
    
    if (isset($_GET['action'])) {       
        $action = $_GET['action'];
    }
    else {
        $action = $_POST['action'];
    }
        
    switch ($action) {
    
        case "connexion":
            //Recuperation des informations soumis dans le formulaire
            $email = test_input($_POST['email']);
            $passwd = test_input($_POST['passwd']);
            $resultat = loginPDO($email, $passwd);
            //Pour la reponse à la requete AJAX
            echo json_encode($resultat);
        break;
    
        case "subscription":
            
        break;

        default:
        
        break;
    }

    
    
    
    