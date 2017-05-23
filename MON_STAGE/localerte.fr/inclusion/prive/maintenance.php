<?php
	require_once(PWD_INCLUSION.'sql.php');
	
	file_put_contents(PWD_INCLUSION.'prive/log/maintenance.log',date('d/m/Y H:i:s').' Début'.CRLF);
	
	$str_repeat=str_repeat(' ',8192);
	set_time_limit(0);
	//ini_set('max_execution_time',0);
	ini_set('mysql.connect_timeout',28800);
	ignore_user_abort(true);
	
	$sql=new ld_sql();
	$sql->ouvrir();
	
	$sql->executer('update preference set acces_bloque=\'OUI\'');
		
	$sql->executer('SHOW TABLE STATUS');
	
	$table=array();
	while($sql->donner_suivant($table[]));
	
	//$sql->executer('SET foreign_key_checks = 0;');
	
	file_put_contents(PWD_INCLUSION.'prive/log/maintenance.log',date('d/m/Y H:i:s').' Début boucle'.CRLF,FILE_APPEND);
	
	for($i=0;$i<sizeof($table)-1;$i++)
	{
		//if(preg_match('/^(abonnement|adherent|adherent_annonce|alerte|alerte_type|allopass|annonce)$/',$table[$i]['Name'])) continue;
		if($table[$i]['Engine']=='InnoDB')
		{
			print('D&eacute;fragmentation de '.$table[$i]['Name'].'<br />'.$str_repeat);
			flush();
			$sql->ouvrir();
			$sql->executer('ALTER TABLE '.$table[$i]['Name'].' ENGINE =  InnoDB;');
			//$sql->executer('ALTER TABLE '.$table[$i]['Name'].' ENGINE =  InnoDB;');
		}
			
		print('V&eacute;rification de '.$table[$i]['Name'].'<br />'.$str_repeat);
		flush();
		$sql->ouvrir();
		$sql->executer('CHECK TABLE '.$table[$i]['Name'].';');
		
		if($table[$i]['Engine']!='InnoDB')
		{
			print('Optimisation de '.$table[$i]['Name'].'<br />'.$str_repeat);
			flush();
			$sql->ouvrir();
			$sql->executer('OPTIMIZE TABLE '.$table[$i]['Name'].';');
		}
		
		print('Fin de traitement pour la table '.$table[$i]['Name'].'<br />&nbsp;<br />'.$str_repeat);
		flush();
	
		file_put_contents(PWD_INCLUSION.'prive/log/maintenance.log',date('d/m/Y H:i:s').' Fin traitement table '.$table[$i]['Name'].CRLF,FILE_APPEND);
	}
	
	file_put_contents(PWD_INCLUSION.'prive/log/maintenance.log',date('d/m/Y H:i:s').' Fin boucle'.CRLF,FILE_APPEND);
	
	$sql->ouvrir();
	$sql->executer('update preference set acces_bloque=\'NON\'');
	
	$sql->fermer();
	
	file_put_contents(PWD_INCLUSION.'prive/log/maintenance.log',date('d/m/Y H:i:s').' Fin'.CRLF,FILE_APPEND);
?>