<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'annonce.php');
	require_once(PWD_INCLUSION.'dossier.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	//$ignore_user_abort=ignore_user_abort(true);//1749383
	
	session_write_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>

<body>
<?php
	$preference=new ld_preference();
	$annonce=new ld_annonce();
	
	if(!preg_match('/\/$/',$preference->annonce_chemin_dossier))
		$preference->annonce_chemin_dossier.='/';
	
	$fichier=scandir($preference->annonce_chemin_dossier);
	
	$action=true;
	for($i=0;$i<sizeof($fichier) && $action;$i++)
	{
		$chemin_source=$preference->annonce_chemin_dossier.$fichier[$i];
		if(is_file($chemin_source) && $fichier[$i]!='.' && $fichier[$i]!='..' && $fichier[$i]!='.htaccess' && mktime(0,0,0,date('m'),date('d'),date('Y'))>filemtime($chemin_source))
		{
			$action=false;
			print('<span class="important">Fichier(s) trop vieux</span><br />');
		}
	}
	
	if($action)
	{
		for($i=0;$i<sizeof($fichier);$i++)
		{
			$chemin_source=$preference->annonce_chemin_dossier.$fichier[$i];
			if(is_file($chemin_source) && $fichier[$i]!='.' && $fichier[$i]!='..' && $fichier[$i]!='.htaccess')
			{
				print('<span class="important">Source: '.ma_htmlentities($chemin_source).'</span><br />');
				print('<span class="important">Date: '.strftime(STRING_DATETIMECOMLPLET,filemtime($chemin_source)).'</span><br />');
				flush();
				
				$chemin_destination=PWD_INCLUSION.'prive/temp/';
				$chemin_destination=tempnam($chemin_destination,'');
				
				$fichier_source=fopen($chemin_source,'r');
				$fichier_destination=fopen($chemin_destination,'w');
				
				while(!feof($fichier_source))
				{
					$ligne=fgets($fichier_source);
					if(preg_match('/^"[^"]+";"[^"]+";"([0-9][0-9])\/([0-9][0-9])\/([0-9][0-9][0-9][0-9])"/',$ligne,$resultat) && mktime(0,0,0,$resultat[2],$resultat[1],$resultat[3])>mktime(23,59,59,date('m'),date('d')-$preference->annonce_affiche_dernier_jour,date('Y')))
						fputs($fichier_destination,$ligne);
				}
				
				fclose($fichier_source);
				fclose($fichier_destination);
				
				$annonce->importer($chemin_destination,STRRND_MODE,$i);
				unlink($chemin_destination);
			}
		}
		
		//file_put_contents(PWD_INCLUSION.'prive/temp/titi.txt','a');
		
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='lister')
		{
			print('<span class="important">D&eacute;but de listage des annonces valides</span><br />'.str_repeat(' ',4096));
			flush();
			$annonce->lister(mktime(date('H')-$preference->annonce_affiche_dernier_jour,date('i'),date('s'),date('m'),date('d'),date('Y')));
			print('<span class="important">Traitement termin&eacute;</span><br />'.str_repeat(' ',4096));
			flush();
		}
	}
?>
</body>
</html>