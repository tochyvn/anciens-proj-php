<?php
	define('DB_DISTANT_DENTATION',str_repeat('&nbsp;',5));
	define('DB_DISTANT_CHEMIN','/var/www/vhost/aicom/base_de_donnees/localerte/');
	define('DB_DISTANT_EXTENSION','.csv');
	define('DB_DISTANT_BASE','localerte');
	
	require_once(PWD_INCLUSION.'sql.php');
	require_once(PWD_INCLUSION.'string.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Localerte - Sauvegarde de la base de donn&eacute;es distante</title>
</head>

<body>
<?php
	set_time_limit(0);
	
	$sql=new ld_sql();
	$sql->ouvrir();
	
	print('Etat de la base<br />'.CRLF);
	flush();
	
	$sql->executer('show table status');
	
	while($sql->donner_suivant($table[]));
	unset($table[sizeof($table)-1]);
	
	if(sizeof($table) && is_dir(DB_DISTANT_CHEMIN))
	{
	
		print('Lock de la base<br />'.CRLF);
		flush();
		for($i=0;$i<sizeof($table);$i++)
			$lock[]=$table[$i]['Name'].' read';
		$sql->executer('lock tables '.implode(', ',$lock));
		
		print('Cr&eacute;ation du fichier de la structure de la base<br />'.CRLF);
		flush();
		$fichier=fopen(DB_DISTANT_CHEMIN.DB_DISTANT_BASE.'.sql','w');
		for($i=0;$i<sizeof($table);$i++)
		{
			$sql->executer('show create table '.$table[$i]['Name']);
			$sql->donner_suivant($occurrence);
			fputs($fichier,'drop table if exists '.$table[$i]['Name'].';'.CRLF);
			fputs($fichier,$occurrence['Create Table'].';'.CRLF);
		}
		fclose($fichier);
		
		for($i=0;$i<sizeof($table);$i++)
		{
			print('Sauvegarde de la base : <b>'.$table[$i]['Name'].'</b><br />'.CRLF);
			flush();
			
			print(DB_DISTANT_DENTATION.'Suppression du fichier pr&eacute;c&eacute;dent<br />'.CRLF);
			flush();
			if(file_exists(DB_DISTANT_CHEMIN.$table[$i]['Name'].DB_DISTANT_EXTENSION))
				unlink(DB_DISTANT_CHEMIN.$table[$i]['Name'].DB_DISTANT_EXTENSION);
			
			print(DB_DISTANT_DENTATION.'Lecture des colonnes<br />'.CRLF);
			flush();
			$sql->executer('show columns from '.$table[$i]['Name']);
			$colonne=array();
			while($sql->donner_suivant($colonne[]));
			unset($colonne[sizeof($colonne)-1]);
			$champ=array();
			for($j=0;$j<sizeof($colonne);$j++)
					$champ[]='`'.$colonne[$j]['Field'].'`';
			
			print(DB_DISTANT_DENTATION.'Cr&eacute;ation du fichier<br />'.CRLF);
			flush();
			$sql->executer
			('
				select '.implode(', ',$champ).'
				into outfile \''.DB_DISTANT_CHEMIN.$table[$i]['Name'].DB_DISTANT_EXTENSION.'\'
					fields
						terminated by \';\'
						enclosed by \'"\'
						escaped by \'\\\\\'
					lines
						terminated by \'\r\n\'
				from '.$table[$i]['Name'].'
			');
			
			print(DB_DISTANT_DENTATION.'Fin de la sauvegarde<br />'.CRLF);
			flush();
		}
		
		print('Unlock de la base<br />'.CRLF);
		flush();
	}
	
	print('Fin du traitement<br />'.CRLF);
	flush();
	
	$sql->fermer();
?>
</body>
</html>