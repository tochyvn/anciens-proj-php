<?php
	/*header('location: '.URL_INCLUSION.'maintenance.html');
	die();*/
	
	define('LISTE_ERREUR_AUCUN',1);
	define('LISTE_ERREUR_TROP',2);
	define('LISTE_ERREUR_SUPPRIMER',4);
	define('LISTE_ERREUR_MODIFIER',8);
	
	define('FICHE_SUCCES_AJOUTER',1);
	define('FICHE_SUCCES_MODIFIER',2);
	define('LISTE_SUCCES_SUPPRIMER',4);
	define('LISTE_SUCCES_MODIFIER',8);
	
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_ADHERENT_V2.'compte/identification.php');
	require_once(PWD_INCLUSION.'abonnement.php');
	
	if(!isset($_SESSION['wha_securite'])) $_SESSION['wha_securite']=rand(1000000000,9999999999);
	
	if(isset($_SESSION['adherent_identifiant']))
	{
		$abonnement['objet']=new ld_abonnement();
		$abonnement['resultat']=$abonnement['objet']->identifier($_SESSION['adherent_identifiant']);
	}
	
	$changement_version=false;
	if(isset($_SESSION['adherent_identifiant']))
	{
		$adherent=new ld_adherent();
		$adherent->identifiant=$_SESSION['adherent_identifiant'];
		$adherent->lire();
		
		if(isset($_REQUEST['adherent_version']))
		{
			$adherent->version=$_REQUEST['adherent_version'];
			$adherent->modifier();
		}
		
		if($adherent->version=='V2.5') $changement_version=true;
		
		unset($adherent);
	}
	elseif(isset($_REQUEST['adherent_version']) && $_REQUEST['adherent_version']=='V2.5') $changement_version=true;
	
	if($changement_version)
	{
		    if($_SERVER['PHP_SELF']=='/adherent_v2/annonce/abus.php') $url='/adherent/annonce/abus.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/annonce/detail.php') $url='/adherent/annonce/detail.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/annonce/forfait.php') $url='/adherent/annonce/tarif.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/annonce/liste.php') $url='/adherent/annonce/liste.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/annonce/identification.php') $url='/adherent/annonce/tarif.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/annonce/impression.php') $url='/adherent/annonce/detail.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/annonce/prolongation.php') $url='/adherent/annonce/tarif.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/compte/desabonnement.php') $url='/adherent/compte/desabonnement_direct.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/compte/fiche.php') $url='/adherent/alerte/liste.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/compte/passe.php') $url='/adherent/';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/aicom.php') $url='/adherent/';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/condition.php') $url='/adherent/condition.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/condition_english.php') $url='/adherent/condition_english.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/contact.php') $url='/adherent/contact.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/index.php') $url='/adherent/';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2/message.php') $url='/adherent/';
		else $url='/adherent/';
		
		$url.=(($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):(''));
		
		header('location: '.url_use_trans_sid($url));
		die();
	}
?>