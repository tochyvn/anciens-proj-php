<?php
	$tableau=array(/*'spool_vieux,'spool_veille','spool_aide','spool_rappel',*/'spool_alerte');
	
	$cookie=uniqid('',true);
	$socket=curl_init();
	
	curl_setopt($socket,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($socket,CURLOPT_HEADER,false);
	curl_setopt($socket,CURLOPT_COOKIEFILE,PWD_INCLUSION.'prive/temp/'.$cookie);
	curl_setopt($socket,CURLOPT_COOKIEJAR,PWD_INCLUSION.'prive/temp/'.$cookie);
	curl_setopt($socket,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($socket,CURLOPT_AUTOREFERER,true);
	
	curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/index.php?administrateur_identification_submit=&administrateur_pseudonyme=cron&administrateur_passe=fiVus19--2');
	curl_exec($socket);
	
	curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/retour_nettoyage.php');
	echo curl_exec($socket);
	
	curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/plainte_nettoyage.php');
	echo curl_exec($socket);
	
	curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/desabonnement_nettoyage.php');
	echo curl_exec($socket);
	
	for($i=0;$i<sizeof($tableau);$i++)
	{
		curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/index.php?administrateur_identification_submit=&administrateur_pseudonyme=cron&administrateur_passe=fiVus19--2');
		curl_exec($socket);
		
		curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/spool_gestion.php?submit=vider&spool='.$tableau[$i]);
		echo curl_exec($socket);
		
		curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/index.php?administrateur_identification_submit=&administrateur_pseudonyme=cron&administrateur_passe=fiVus19--2');
		curl_exec($socket);
		
		curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/spool_gestion.php?submit=charger&spool='.$tableau[$i]);
		echo curl_exec($socket);
		
		curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/index.php?administrateur_identification_submit=&administrateur_pseudonyme=cron&administrateur_passe=fiVus19--2');
		curl_exec($socket);
		
		curl_setopt($socket,CURLOPT_URL,'http://'.$_SERVER['HTTP_HOST'].'/administration/'.$tableau[$i].'.php');
		echo curl_exec($socket);
	}
	
	if(is_file(PWD_INCLUSION.'prive/temp/'.$cookie)) unlink(PWD_INCLUSION.'prive/temp/'.$cookie);
?>
