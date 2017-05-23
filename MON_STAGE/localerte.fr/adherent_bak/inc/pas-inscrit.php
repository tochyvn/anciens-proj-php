<?php
	require_once(PWD_INCLUSION.'adherent.php');
	
	$inscription=new ld_adherent();
	$inscription_erreur=0;
	
	if(isset($_REQUEST['inscription_submit']))
	{
		$nouveau=false;
		
		$inscription->email=$_REQUEST['inscription_email'];
		$inscription->passe=$_REQUEST['inscription_passe'];
		$inscription->confirmation=$_REQUEST['inscription_confirmation'];
		if(!$inscription->lire('email'))
		{
			$nouveau=true;
			
			$inscription->email=$_REQUEST['inscription_email'];
			$inscription->passe=$_REQUEST['inscription_passe'];
			$inscription->confirmation=$_REQUEST['inscription_confirmation'];
			
			$inscription->identifiant='';
			$inscription->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_adherent','identifiant',ADHERENT_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
			$inscription->abonne='OUI';
			$inscription->brule='NON';
			$inscription->validation='OUI';
			$inscription->spamtrap='NON';
			
			$inscription_erreur=$inscription->ajouter(isset($_REQUEST['inscription_lalettredujour']));
		}
		elseif($inscription->abonne=='NON')
		{
			$nouveau=true;
			
			$inscription->email=$_REQUEST['inscription_email'];
			$inscription->passe=$_REQUEST['inscription_passe'];
			$inscription->confirmation=$_REQUEST['inscription_confirmation'];
			
			$inscription->abonne='OUI';
			
			$inscription_erreur=$inscription->modifier(isset($_REQUEST['inscription_lalettredujour']));
		}
		elseif($inscription->passe!=$_REQUEST['inscription_passe'])
		{
			$inscription->email=$_REQUEST['inscription_email'];
			$inscription->passe=$_REQUEST['inscription_passe'];
			$inscription->confirmation=$_REQUEST['inscription_confirmation'];
			
			$inscription_erreur=$inscription->ajouter(isset($_REQUEST['inscription_lalettredujour']));
		}
		
		if(!$inscription_erreur)
		{
			if($nouveau) $inscription->envoyer('inscription');
			
			$_SESSION['adherent_identifiant']=$inscription->identifiant;
			header('location: '.url_use_trans_sid(URL_ADHERENT.'/ma-liste.php'));
			die();
		}
	}
?>
