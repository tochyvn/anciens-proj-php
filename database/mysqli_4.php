<?php

//inclusion du fichier qui contient la fonction affiche
include('fonctions.inc');
//intialisation des variables
$identifiant="";
$libelle="";
$prix='';
$message='';
//definition de constantes
define('HOSTNAME','localhost');
define('USERNAME','root');
define('PASSWORD','root');
define(DATABASE,'TEST_PHP');
//tester comment le script est appelé
if (!empty($_POST)) {
    //traitement du formulaire
    //Recuperer les valeurs saisies
    $identifiant=$_POST['identifiant'];
    echo var_dump($identifiant). "<br/>";
    //controle des valeurs saisies
    if ($identifiant == "") {
        $message.="L'identifiant est obligatoire.\n";
        echo $message."<br/>";
    }
    if (! preg_match('#^[0-9]+$#',$identifiant)) {
        $message.="L'identifiant doit etre un nombre <br/>";
        echo $message."<br/>";
    }
    //Tester s'il y a des erreurs à ce stade
    if ($message == "") {
        //pas d'erreur
        //connexion et selection de la base de données
        $connexion=mysqli_connect(HOSTNAME,USERNAME,PASSWORD);
        if($connexion) echo "Connexion OK a la base de donnees ".DATABASE."<br/>";
        else echo "Echec de connexion";
        $database=mysqli_select_db($connexion,DATABASE);
        if($database) echo "Selection ok"."<br/>";
        //executer la requete de selection
        $requete="SELECT * FROM ARTICLES WHERE identifiant=$identifiant";
        $resultat=mysqli_query($connexion,$requete);
        //fetch si la requete a bien été exécutée
        if($resultat) {
            $article=mysqli_fetch_assoc($resultat);
            echo "Requete executee avec succes"."<br/>";
            
        }
        if(!$resultat) {
            $message.="Erreur.\n";
            echo "Erreur d'execution de la requete";
        }
        elseif (!$article) {
            $message.="Pas d'article pour cet identifiant.\n";
            echo $message."<br/>";
        }
            else {
                //ok
                //recuperation des informations à afficher
                echo "tochdebug <br/>";
                affiche($article);
                $libelle = $article['libelle'];
                $prix = $article['prix'];
                //Mise en forme.
                //$libelle = vers_page($libelle);
                $prix = number_format($prix,2,',',' ');
                //$prix = vers_page($prix);
            }
    }
    //Tester s'il y a des erreurs à ce stade
    if ($message != '') {
        //Erreur
        //preparer le message pour l'affichage
        //$message = vers_page($message);
        //bien s'assurer que les infos à afficher sont vides
        $libelle = '';
        $prix ='';
        
    }
}

//Affichage de la page..
error_reporting(-1);
?>
<!DOCTYPE html>

<html>
<head>
    <title>Formulaire</title>
</head>

<body>
<!-- Formulaire de recherche très simple!!!!! -->
<form action="mysqli_4.php" method="post">
    <div>Identifiant article :
    <input type="text" name="identifiant"
           value="<?php echo $identifiant; ?>" />
    <input type="submit" name="ok" value="OK" size="12"/>
    </div>
</form>
<table border="0" padding="4">
    <tr><td><u>Libelle :</u></td>
        <td><?php echo $libelle ?></td><tr/>
    <tr><td><u>Prix :</u></td>
    <td><?php echo $prix ?></td></tr>
</table>


</body>
</html> 