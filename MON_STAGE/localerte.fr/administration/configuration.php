<?php
	define('LISTE_INTERVAL',20);
	define('LISTE_PAGE',10);
	define('LISTE_SURVOL','#DDDDDD');
	define('LISTE_CLICK','#CCCCCC');
	define('LISTE_PAIR','#EEEEEE');
	define('LISTE_IMPAIR','#EEEEEE');
	define('LISTE_RAPPEL_ENTETE',10);
	
	define('LISTE_ERREUR_AUCUN',1);
	define('LISTE_ERREUR_TROP',2);
	define('LISTE_ERREUR_SUPPRIMER',4);
	define('LISTE_ERREUR_MODIFIER',8);
	define('LISTE_ERREUR_PAYER',16);
	define('LISTE_ERREUR_ANNULER',32);
	define('LISTE_ERREUR_ENVOYER',64);
	
	define('FICHE_SUCCES_AJOUTER',1);
	define('FICHE_SUCCES_MODIFIER',2);
	define('LISTE_SUCCES_SUPPRIMER',4);
	define('LISTE_SUCCES_MODIFIER',8);
	define('LISTE_SUCCES_PAYER',16);
	define('LISTE_SUCCES_ANNULER',32);
	define('LISTE_SUCCES_ENVOYER',64);
	
	require_once(PWD_INCLUSION.'configuration.php');
	
	function print_pagination($liste,$url,$variable)
	{
		if($liste->page_fin>1)
		{
			if(strpos($url,'?')===false)
				$query='?';
			else
				$query='&';
			print('<a href="'.$url.$query.urlencode($variable).'=1">D&eacute;but</a> ');
			for($i=$liste->page_debut;$i<=$liste->page_fin;$i++)
			{
				if($i!=$liste->page_courante)
					print('<a href="'.$url.$query.urlencode($variable).'='.$i.'">'.$i.'</a> ');
				else
					print('<a href="'.$url.$query.urlencode($variable).'='.$i.'" class="page_courante">'.$i.'</a> ');
			}
			print('<a href="'.$url.$query.urlencode($variable).'='.$liste->page_total.'">Fin</a>');
		}
	}
	
	require_once('administrateur_identification.php');
	require_once('administrateur_autorisation.php');
?>