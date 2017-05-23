<?php
	require_once(PWD_INCLUSION.'dossier.php');
	
	ini_set('error_reporting','2047');
	ini_set('display_errors','1');
	
	define('DB_LOCAL_DENTATION',str_repeat('&nbsp;',5));
	define('DB_LOCAL_CHEMIN_LOCAL','/var/www/vhost/aicom/base_de_donnees/localerte/');
	define('DB_LOCAL_BASE','localerte');
	define('DB_LOCAL_EXTENSION','.csv');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Localerte - Sauvegarde de la base de donn&eacute;es distante</title>
</head>

<body>
<?php
	set_time_limit(0);
	
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
	
	$sql=new ld_sql();
	$sql->ouvrir();
	
	print('Lev&eacute; de la v&eacute;rification des clefs &eacute;trang&egrave;res<br>'.CRLF);
	flush();
	$sql->executer('set foreign_key_checks=0');
	
	print('Cr&eacute;ation des tables<br>'.CRLF);
	flush();
	$requete=explode(';'.CRLF,file_get_contents(DB_LOCAL_CHEMIN_LOCAL.DB_LOCAL_BASE.'.sql'));
	print('<ul>');
	for($i=0;$i<sizeof($requete);$i++)
	{
		if($requete[$i]!='')
		{
			print('<li>'.str_replace(LF,'',$requete[$i]).'</li><br>'.CRLF);
			flush();
			$sql->executer($requete[$i]);
		}
	}
	print('</ul>');
	
	print('Lecture du r&eacute;pertoire distant<br>'.CRLF);
	flush();
	$fichier=scandir(DB_LOCAL_CHEMIN_LOCAL);
	
	for($i=0;$i<sizeof($fichier);$i++)
	{
		if(preg_match('/'.DB_LOCAL_EXTENSION.'$/',$fichier[$i]))
		{
			print('Fichier : <b>'.$fichier[$i].'</b><br>'.CRLF);
			flush();
			$table=preg_replace('/'.DB_LOCAL_EXTENSION.'$/','',$fichier[$i]);
			$sql->executer
			('

				load data infile \''.str_replace('\\','\\\\',DB_LOCAL_CHEMIN_LOCAL).$fichier[$i].'\'
					into table '.$table.'
					fields
						terminated by \';\'
						enclosed by \'"\'
						escaped by \'\\\\\'
					lines
						terminated by \'\r\n\'
			');
			print(DB_LOCAL_DENTATION.'Fin de la sauvegarde<br>'.CRLF);
			flush();
		}
	}
	
	print('Remise de la v&eacute;rification des clefs &eacute;trang&egrave;res<br>'.CRLF);
	flush();
	$sql->executer('set foreign_key_checks=1');
	
	$sql->fermer();
	
	print('Fin du traitement<br>'.CRLF);
	flush();
?>
</body>
</html>