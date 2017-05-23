<?php
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	$preference=new ld_preference();
	
	if(isset($_SESSION['adherent_debut']) && $_SESSION['adherent_debut']<time()) unset_adherent();
	
	if(isset($_SESSION['adherent_identifiant']))
	{
		$adherent=new ld_adherent();
		$adherent->identifiant=$_SESSION['adherent_identifiant'];
		if(!$adherent->lire() || $adherent->abonne!='OUI') unset_adherent();
	}
	
	if(!isset($_SESSION['adherent_identifiant']))
	{
		$uri[]=URL_ADHERENT.'compte/fiche.php';
		$uri[]=URL_ADHERENT.'aicom.php';
		$uri[]=URL_ADHERENT.'qui.php';
		$uri[]=URL_ADHERENT.'condition.php';
		$uri[]=URL_ADHERENT.'condition_english.php';
		$uri[]=URL_ADHERENT.'contact.php';
		$uri[]=URL_ADHERENT.'comment.php';
		$uri[]=URL_ADHERENT.'departement.php';
		$uri[]=URL_ADHERENT.'compte/desabonnement_direct.php';
		$uri[]=URL_ADHERENT.'index.php';
		$uri[]=URL_ADHERENT.'localerte.mobi.php';
		$uri[]=URL_ADHERENT.'general.css';
		if(array_search($_SERVER['PHP_SELF'],$uri)===false)
		{
			header('location: '.url_use_trans_sid(URL_ADHERENT));
			die();
		}
	}
	
	if(isset($_SESSION['adherent_identifiant']))
	{
		setcookie(session_name(),session_id(),time()+$preference->cookie_duree_vie,'/','www.localerte.fr',false);
		$_SESSION['adherent_debut']=time()+$preference->cookie_duree_vie;
	}
?>