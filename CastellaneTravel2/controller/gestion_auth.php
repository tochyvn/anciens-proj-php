<?php
    
    if (!isset($_REQUEST['action']) or $_REQUEST['action']== NULL) {

        include 'page/accueil.php';

    }
    else {
    $action = $_REQUEST['action'];
    
    switch ($action) 
        {
    
        case "ajaxconnexion":
            require 'class/connect.class.php';
            $user= new connect($DB);
            $email = $_POST['email'];
            $passwd = $_POST['passwd'];
            $resultat= $user->login($email, $passwd);
            echo json_encode($resultat);
            break;
    
        case "connexion":
            include $header_front;
            include 'page/connexion.php';
            include $footer_front;
            break;
    
        case "deconnexion":
            require 'class/connect.class.php';
            $user= new connect($DB);
            $user->deconnect();
            include $header_front;
            include 'page/accueil.php';
            include $footer_front;
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
}
    
    
    
    