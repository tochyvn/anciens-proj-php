<?php
    
    
    
    
    if (isset($_GET['action'])) {       
        $action = $_GET['action'];
    }
    else {
        $action = $_POST['action'];
    }
        
    switch ($action) {
    
        case "connexion":
            include 'model/Midentification.php';
            //Recuperation des informations soumis dans le formulaire
            $email = test_input($_POST['email']);
            $passwd = test_input($_POST['passwd']);
            $resultat = login($email, $passwd);
            //Pour la reponse à la requete AJAX
            echo json_encode($resultat);
        break;
    
        case "deconnexion":
            unset($_SESSION['email']);
            include 'include/header_front.php';
            
            include 'include/footer_front.php';
        break;
    
        case "authenfier":
            /*
            include $header_front;
            include 'view/Videntification.php';
            include $footer_front; 
             * 
             */
            include 'include/header_front.php';
            include 'view/contenu/Vconnexion.php';
            include 'include/footer_front.php';
        break;
    
        case "ajax":
            include 'model/Mville.php';
            $term = test_input($_GET['term']);
            $villes = ajaxVilles($term);
            echo json_encode($villes);
        break;
    
        case "subscribe":
            include $header_front;
            include 'view/Vsubscription.php';
            include $footer_front;
        break;
    
        case "signin":
            include 'model/Midentification.php';
            $array = array(
                'nom' => test_input($_POST['nom']),
                'pseudo' => test_input($_POST['pseudo']),
                'email' => test_input($_POST['email']),
                'passwd' => test_input($_POST['passwd']),
                'adresse' => test_input($_POST['adresse']),
                'idVille' => test_input($_POST['id_ville'])
            );
            $resultat = signin($array);
            echo json_encode($resultat);
        break;

        default:
        
        break;
    }

    
    
    
    