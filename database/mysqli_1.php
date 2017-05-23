CONNEXION ET DECONNEXION AU SERVEUR <br/>
<?php
//connexion (utilisation des valeurs par defaut)
$connexion = mysqli_connect();
if ($connexion)
    echo "connexion reussie :"." version du serveur = ",$connexion->server_info,"<br/>";
else
    echo "erreur lors de la connexion";
    
    //deconnexion
$ok = mysqli_close($connexion);
echo "deconnexion : $ok ",(!$ok)?"tochap":"imy","<br/>\n";

?>

<br/><br/>LIRE LES DONNEES D'UNE BD <br/>
<?php

//connexion (utilisation des valeurs par defaut) ('mysql:host=localhost;dbname=SCOLARITE;charset=UTF-8','root','')
$connexion = mysqli_connect('localhost','root','root');
if ($connexion)
    echo "connexion reussie :"." version du serveur = ",$connexion->server_info,"<br/>";
else
    echo "erreur lors de la connexion <br/>";

//selection de la base de données
$ok = mysqli_select_db($connexion,'SCOLARITE');
if ($ok)
    echo "base de donne&eacutes selectionn&eacutee <br/>";
else
    exit('Echec de la selection de la BD');

/*deconnexion
$ok = mysqli_close($connexion);
echo ($ok)?"Deconnexion reussie.":"Echec de deconnexion.";*/
?>

<br/><br/>EXECUTION D'UNE REQUETE SELECT<br/>

<?php
//Execution d'une bonne requête SELECT
$requete = mysqli_query($connexion,'SELECT * FROM ELEVE WHERE YEAR(DATE_NAIS)=\'1994\'');
if ($requete === FALSE)
    echo 'Echec d\'execution de la requete','<br/>';
else {
    echo 'Execution reussie.','<br/>';
    //RECUPERATION DU NOMBRE DE LIGNES DU RESULTAT
    $resultat = mysqli_num_rows($requete);
    echo 'Le nombre de ligne du resutat est de :'.$resultat.'<br/>';
}

//Execution d'une mauvaise requête SELECT
$requete = mysqli_query($connexion,'SELECT * FROM ELEV');
if ($requete === FALSE)
    echo 'Echec d\'execution de la requete','<br/>';
else 
    echo 'Execution reussie.','<br/>';
    
//Deconnexion
$ok = mysqli_close($connexion);
?>

