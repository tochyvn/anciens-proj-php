<?php
//Inclusion du fichier
include('fonctions.inc');
phpinfo();

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
    
echo "1- UTILISER mysqli_fetch_all <br/>";

$sql = 'SELECT * FROM ARTICLES';
$requete = mysqli_query($connexion,$sql);
echo "tochXW";
$resultat = mysqli_fetch_all($requete);
echo "lion";
//affiche($resultat);


?>