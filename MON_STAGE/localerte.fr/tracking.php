<?php
	require_once(PWD_INCLUSION.'sql.php');

	$base=new ld_sql(); // connecteur mysql

	$base->ouvrir();	// on ouvre l'acces à la BDD

	$sql = 'update banniere_cn
			set clics = clics +1
			where id = 1';

	$req = mysql_query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysql_error());

	mysql_close (); // On ferme l'accès mysql

	// Redirection vers la page en question.
	header('Location: http://www.localerte.fr');

	exit();
?>