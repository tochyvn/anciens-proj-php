<?php
session_start();
if (isset($_SESSION['auth'])) {
	$pseudo = $_SESSION['auth']['pseudonyme'];
}else {
	//Redirection avec affichage du message, verifiez votre boite email pour pour plus d'infos sur la 
    $_SESSION['flash']['error'] = "Vous devez vous connecter afin de pouvoir visualiser cette page." ;
    header('location:../forum.php');
}



