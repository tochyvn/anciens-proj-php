<?php
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	$preference=new ld_preference();
	
	if(isset($_SESSION['adherent_debut']) && $_SESSION['adherent_debut']<time())
	{
		if(isset($_SESSION['adherent_identifiant']))
			unset($_SESSION['adherent_identifiant']);
		if(isset($_SESSION['wha_identifiant']))
			unset($_SESSION['wha_identifiant']);
		if(isset($_SESSION['code_reference']))
			unset($_SESSION['code_reference']);
		if(isset($_SESSION['annonce_identifiant']))
			unset($_SESSION['annonce_identifiant']);
		if(isset($_SESSION['adherent_debut']))
			unset($_SESSION['adherent_debut']);
	}
	
	$identification_erreur=false;
	
	if(isset($_REQUEST['identification_submit']))
	{
		switch($_REQUEST['identification_submit'])
		{
			case 'Connexion':
			case 'Ok':
				$adherent=new ld_adherent();
				$adherent->email=$_REQUEST['adherent_email'];
				$adherent->passe=$_REQUEST['adherent_passe'];
				if($adherent->identifier())
				{
					if(isset($_SESSION['wha_identifiant']))
						unset($_SESSION['wha_identifiant']);
					if(isset($_SESSION['code_reference']))
						unset($_SESSION['code_reference']);
					if(isset($_SESSION['annonce_identifiant']))
						unset($_SESSION['annonce_identifiant']);
					if(isset($_SESSION['adherent_debut']))
						unset($_SESSION['adherent_debut']);
					
					$_SESSION['adherent_identifiant']=$adherent->identifiant;
					
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/liste.php'));
					die();
				}
				else
					$identification_erreur=true;
				break;
			case 'deconnexion':
				if(isset($_SESSION['adherent_identifiant']))
					unset($_SESSION['adherent_identifiant']);
				break;
		}
	}
	
	if(isset($_SESSION['adherent_identifiant']))
	{
		$adherent=new ld_adherent();
		$adherent->identifiant=$_SESSION['adherent_identifiant'];
		if(!$adherent->lire() || $adherent->abonne!='OUI')
			unset($_SESSION['adherent_identifiant']);
	}
	
	if(!isset($_SESSION['adherent_identifiant']))
	{
		$uri[]=URL_ADHERENT_V2.'compte/desabonnement.php';
		$uri[]=URL_ADHERENT_V2.'compte/fiche.php';
		$uri[]=URL_ADHERENT_V2.'compte/passe.php';
		$uri[]=URL_ADHERENT_V2.'aicom.php';
		$uri[]=URL_ADHERENT_V2.'condition.php';
		$uri[]=URL_ADHERENT_V2.'condition_english.php';
		$uri[]=URL_ADHERENT_V2.'contact.php';
		$uri[]=URL_ADHERENT_V2.'index.php';
		$uri[]=URL_ADHERENT_V2.'message.php';
		$uri[]=URL_ADHERENT_V2.'partenaire.php';
		$uri[]=URL_ADHERENT_V2.'general.css';
		if(array_search($_SERVER['PHP_SELF'],$uri)===false)
		{
			header('location: '.url_use_trans_sid(URL_ADHERENT_V2));
			die();
		}
	}
	
	/*$hack=array(492813611,15511401,675791824);*/
	if(isset($_SESSION['adherent_identifiant'])/* && array_search($_SESSION['adherent_identifiant'],$hack)===false*/)
	{
		setcookie(session_name(),session_id(),time()+$preference->cookie_duree_vie,'/','localerte.fr',false);
		$_SESSION['adherent_debut']=time()+$preference->cookie_duree_vie;
	}
?>