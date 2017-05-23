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
		$uri[]=URL_ADHERENT_PUBLIC.'/api/image.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/bienvenue.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/conditions-generales-de-vente.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/desabonnement.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/mot-de-passe-oublie.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/nous-contacter.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/qui-sommes-nous.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/optimisation.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/redirection.php';
		$uri[]=URL_ADHERENT_PUBLIC.'/total.php';
		
		if(array_search($_SERVER['PHP_SELF'],$uri)===false)
		{
			$query=array();
			if(isset($_REQUEST['msgbox'])) $query['msgbox']=$_REQUEST['msgbox'];
			if(isset($_REQUEST['msgbox_query'])) $query['msgbox_query']=$_REQUEST['msgbox_query'];
			header('location: '.url_use_trans_sid(URL_ADHERENT.'/bienvenue.php'.(sizeof($query)?'?'.http_build_query($query,'','&'):'')));
			header('location: '.url_use_trans_sid(URL_ADHERENT_PUBLIC));
			die();
		}
	}
	
	if(isset($_SESSION['adherent_identifiant']))
	{
		setcookie(session_name(),session_id(),time()+$preference->cookie_duree_vie,'/','www.localerte.fr',false);
		$_SESSION['adherent_debut']=time()+$preference->cookie_duree_vie;
		
		$uri[]=URL_ADHERENT_PUBLIC.'/bienvenue.php';
		
		if(array_search($_SERVER['PHP_SELF'],$uri)!==false)
		{
			$query=array();
			if(isset($_REQUEST['msgbox'])) $query['msgbox']=$_REQUEST['msgbox'];
			if(isset($_REQUEST['msgbox_query'])) $query['msgbox_query']=$_REQUEST['msgbox_query'];
			header('location: '.url_use_trans_sid(URL_ADHERENT_PUBLIC.'/ma-liste.php'.(sizeof($query)?'?'.http_build_query($query,'','&'):'')));
			die();
		}
	}
	
	if(isset($_REQUEST['deconnexion_submit']))
	{
		unset_adherent();
		header('location: '.url_use_trans_sid(URL_ADHERENT_PUBLIC));
		die();
	}
?>