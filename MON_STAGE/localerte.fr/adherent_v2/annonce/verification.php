<?php
	if((!isset($_SESSION['code_reference']) && !isset($_SESSION['allopass_reference']) && !isset($_SESSION['wha_identifiant']) && $abonnement['resultat']!='ABONNEMENT_UTILISABLE' && $abonnement['resultat']!='ABONNEMENT_DELAI_PERIME') || !isset($_SESSION['annonce_identifiant']))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/liste.php'));
		die();
	}
	
	if(isset($_SESSION['code_reference']))
	{
		$code=new ld_code();
		if($code->controler($_SESSION['code_reference'],$_SESSION['adherent_identifiant'])!='CODE_UTILISABLE')
		{
			unset($_SESSION['code_reference']);
			header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/identification.php'));
			die();
		}
	}
	
	if($abonnement['resultat']!='ABONNEMENT_UTILISABLE' && !isset($_SESSION['allopass_reference']) && !isset($_SESSION['wha_identifiant']) && !isset($_SESSION['code_reference']))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/identification.php'));
		die();
	}
?>