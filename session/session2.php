<?php

//permet de specifier dans quels type d'emplacement sera sauvé nos fichiers de sessions
//session_set_save_handler();

//Definition de l'id de la session
session_id('tochapImane2');

//Definition de client comme nom de session par defaut PHPSESSID
//session_name('client');

//Definition du repertoire de stockage des sessions '/Applications/MAMP/htdocs/session
session_save_path('/Applications/MAMP/htdocs/session');


//initialisation de la session
session_start();

//ecrire 'PHP' dans la variable session 'langage'
$_SESSION['langage'] = 'PHP';
$_SESSION['name'] = 'TOCHAP';
$_SESSION['prenom'] = 'Lionel';
$_SESSION['datenaiss'] = '13/05/1991';
 
$tableau = array('un', 'deux', 'trois', 'quatre');

$_SESSION['tab'] = $tableau;

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

//afficher l'id de la session
echo '<br/>Voici l\'id de la session : '.session_id();

//affiche le nom de la session
echo '<br/>Voici le nom de la session : '.session_name();

//Detruire la session càd le fichier contenant ses infos du visiteur
//session_destroy();

//Afficher le nom du repertoire ou st sauvée les fichier de sessions
echo '<br/>'.session_save_path();

//
echo '<br/>'.session_module_name();

//echo '<br/>'.session_save_handler();
echo '<br/><br/><br/><br/>Affichage des sur la session en cours<br/>';
echo session_name().'<br/>';
echo $_SESSION['name']." ".$_SESSION['prenom']." ".$_SESSION['datenaiss'];


phpinfo();

?>