<?php
phpinfo();
//Inclusion du fichier
include('fonctions.inc');

//Creation de la connexion
$connexion = mysqli_connect('localhost','root','root');
if ($connexion)
    echo "Connexion reussie : Version du serveur ".$connexion->server_info."<br/>";
else
    exit('Echec de connexion');
  
//Selection de la base de données
$database= mysqli_select_db($connexion,'TEST_PHP');
if ($database)
    echo "Base de donn&eacutees selectionn&eacutee avec succ&egraves <br/>";
else
    exit('Echec de selection de la BD');
    
//Requete de selection
$sql = 'SELECT * FROM ARTICLES';
$requete = mysqli_query($connexion,$sql);

echo "Lecture du resulat de la requete <br/><br/>";

echo "1- mysqli_fetch_row <br/>";
$resultat = mysqli_fetch_row($requete);
affiche($resultat);

echo "2- mysqli_fetch_assoc <br/>";
$resultat = mysqli_fetch_assoc($requete);
affiche($resultat);

echo "3- mysqli_fetch_array <br/>";
$resultat = mysqli_fetch_array($requete,MYSQLI_ASSOC);
affiche($resultat);

echo "4- mysqli_fetch_object <br/>";
$objet = mysqli_fetch_object($requete);
echo '$objet->identifiant : '.$objet->identifiant.'<br/>';
echo '$objet->libelle : '.$objet->libelle.'<br/>';
echo '$objet->prix : '.$objet->prix.'<br/><br/>';

echo "5- mysqli_fetch_all <br/>";
$resultat = mysqli_fetch_all($requete,MYSQLI_NUM);
affiche($resultat);

//Fermeture de la connexion
$ok = mysqli_close($connexion);
echo ($ok)?"Deconnexion reussie":"Echec de deconnexion"." <br/>"

?>
