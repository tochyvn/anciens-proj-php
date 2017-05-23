<?php
	require_once(PWD_INCLUSION.'adherent.php');
	
	$connexion=new ld_adherent();
	$connexion_erreur=false;
	
	if(isset($_REQUEST['connexion_submit']))
	{
		$connexion->email=$_REQUEST['connexion_email'];
		$connexion->passe=$_REQUEST['connexion_passe'];
		if($connexion->identifier())
		{
			unset_adherent();
			$_SESSION['adherent_identifiant']=$connexion->identifiant;
			
			header('location: '.url_use_trans_sid(URL_ADHERENT_PUBLIC.'/ma-liste.php'));
			die();
			break;
		}
		else $connexion_erreur=true;
	}
?>
