<?php
	/*header('location: '.URL_INCLUSION.'maintenance.html');
	die();*/
	
	define('ALERTE_CARDINALITE',3);
	
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	function unset_adherent()
	{
		if(isset($_SESSION['adherent_identifiant'])) unset($_SESSION['adherent_identifiant']);
		if(isset($_SESSION['wha_identifiant'])) unset($_SESSION['wha_identifiant']);
		if(isset($_SESSION['allopass_reference'])) unset($_SESSION['allopass_reference']);
		if(isset($_SESSION['code_reference'])) unset($_SESSION['code_reference']);
		if(isset($_SESSION['annonce_identifiant'])) unset($_SESSION['annonce_identifiant']);
		if(isset($_SESSION['adherent_debut'])) unset($_SESSION['adherent_debut']);
	}
	
	//DESABONNEMENT
	$desabonnement=new ld_adherent();
	$desabonnement_erreur=false;
	
	if(isset($_REQUEST['desabonnement_submit']))
	{
		$desabonnement->email=$_REQUEST['adherent_email'];
		if($desabonnement->lire('email'))
		{
			$desabonnement->abonne='NON';
			$desabonnement->modifier();
		}
		else $desabonnement_erreur=true;
	}
	
	//INSCRIPTION
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
			header('location: '.url_use_trans_sid(URL_ADHERENT.'alerte/fiche.php'));
			die();
		}
	}
	
	//PASSE
	$passe=new ld_adherent();
	$passe_erreur=false;
	
	if(isset($_REQUEST['passe_submit']))
	{
		$passe->email=$_REQUEST['passe_email'];
		if($passe->lire('email') && $passe->abonne=='OUI') $passe->envoyer('passe');
		else $passe_erreur=true;
	}
	
	$secret='idsfgmkfdsfdfughmgjkhdfmghmqjqferhfmqhjlmfkgjù²ohtjmfjdqsjkqhmklqjdflgjlmgjkhmqkfhjk';
	function localerte_mobi($secret)
	{
		$url='http://www.localerte.mobi';
		
			if($_SERVER['PHP_SELF']=='/adherent/alerte/fiche.php') $url.='/mon-alerte.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/alerte/liste.php') $url.='/mes-alertes.php';
		//elseif($_SERVER['PHP_SELF']=='/adherent/annonce/abonnement.php') $url.='/mon-abonnement.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/annonce/abus.php') $url='/signaler-une-erreur.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/annonce/detail.php') $url.='/ma-selection.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/annonce/liste.php') $url.='/ma-liste.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/annonce/provenance.php') $url.='/mes-alertes.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/annonce/tarif.php') $url.='/mes-paiements.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/compte/desabonnement_direct.php') $url.='/desabonnement.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/comment.php') $url.='/mes-alertes.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/condition.php') $url.='/conditions-generales-de-vente.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/condition_english.php') $url.='/conditions-generales-de-vente.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/contact.php') $url.='/nous-contacter.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/qui.php') $url.='/qui-sommes-nous.php';
		elseif($_SERVER['PHP_SELF']=='/adherent/departement.php') $url.='/mes-alertes.php';
		else $url.='/mes-alertes.php';
		
		$tableau=array();
		if(isset($_SESSION['adherent_identifiant'])) $tableau['adherent_identifiant']=$_SESSION['adherent_identifiant'];
		if(isset($_SESSION['wha_identifiant'])) $tableau['wha_identifiant']=$_SESSION['wha_identifiant'];
		if(isset($_SESSION['allopass_reference'])) $tableau['allopass_reference']=$_SESSION['allopass_reference'];
		if(isset($_SESSION['code_reference'])) $tableau['code_reference']=$_SESSION['code_reference'];
		if(isset($_SESSION['annonce_identifiant'])) $tableau['annonce_identifiant']=$_SESSION['annonce_identifiant'];
		if(isset($_SESSION['adherent_debut'])) $tableau['adherent_debut']=$_SESSION['adherent_debut'];
		$crypt=encrypt_text(serialize($tableau),$secret);
		
		$url.=($_SERVER['QUERY_STRING']?'?'.$_SERVER['QUERY_STRING']:'');
		$url.=($_SERVER['QUERY_STRING']?'&':'?').'crypt='.urlencode(encrypt_text(serialize($tableau),$secret));
		
		return $url;
	}
	
	if(isset($_REQUEST['crypt']))
	{
		require_once(PWD_INCLUSION.'string.php');
		unset_adherent();
		$tableau=unserialize(decrypt_text($_REQUEST['crypt'],$secret));
		foreach($tableau as $clef=>$valeur) $_SESSION[$clef]=$valeur;
	}
	
	$mobile_version=isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/android|iphone|blackberry|iipad|ppalm/i',$_SERVER['HTTP_USER_AGENT'])/* && 0*/;
	if($mobile_version && !isset($_SESSION['mobi_propose']))
	{
		$_SESSION['mobi_propose']=1;
		header('location: '.localerte_mobi($secret));
		die();
	}
	
	//DECONNEXION
	if(isset($_REQUEST['deconnexion_submit']))
	{
		unset_adherent();
		header('location: '.url_use_trans_sid(URL_ADHERENT));
		die();
	}
	
	//CONNEXION
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
			
			if(isset($_REQUEST['connexion_redirection']))
			{
				switch($_REQUEST['connexion_redirection'])
				{
					case 'fiche':
						header('location: '.url_use_trans_sid(URL_ADHERENT.'alerte/fiche.php'));
						break;
					case 'liste':
					default:
						header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/liste.php'));
						break;
				}
				die();
			}
		}
		else $connexion_erreur=true;
	}

	//IDENTIFICATION
	require_once(PWD_ADHERENT.'compte/identification.php');
	
	//WHA
	if(!isset($_SESSION['wha_securite'])) $_SESSION['wha_securite']=rand(1000000000,9999999999);
	
	//CODE
	//if(isset($_SESSION['code_reference']))
	//{
	//	$code=new ld_code();
	//	if($code->controler($_SESSION['code_reference'],$_SESSION['adherent_identifiant'])!='CODE_UTILISABLE')
	//	{
	//		unset($_SESSION['code_reference']);
	//		header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/tarif.php'));
	//		die();
	//	}
	//}
	
	//ABONNEMENT
	if(isset($_SESSION['adherent_identifiant']))
	{
		require_once(PWD_INCLUSION.'abonnement.php');
		$abonnement['objet']=new ld_abonnement();
		$abonnement['resultat']=$abonnement['objet']->identifier($_SESSION['adherent_identifiant']);
	}
	
	/*$changement_version=false;
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
		
		if($adherent->version=='V2') $changement_version=true;
		
		unset($adherent);
	}
	elseif(isset($_REQUEST['adherent_version']) && $_REQUEST['adherent_version']=='V2') $changement_version=true;
	
	if($changement_version)
	{
		    if($_SERVER['PHP_SELF']=='/adherent_v2.5/alerte/fiche.php') $url='/adherent/compte/fiche.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/alerte/liste.php') $url='/adherent/compte/fiche.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/annonce/abonnement.php') $url='/adherent/annonce/identification.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/annonce/detail.php') $url='/adherent/annonce/detail.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/annonce/liste.php') $url='/adherent/annonce/liste.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/annonce/tarif.php') $url='/adherent/annonce/identification.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/compte/desabonnement_direct.php') $url='/adherent/compte/desabonnement.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/comment.php') $url='/adherent/';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/condition.php') $url='/adherent/condition.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/condition_english.php') $url='/adherent/condition_english.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/contact.php') $url='/adherent/contact.php';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/qui.php') $url='/adherent/';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/departement.php') $url='/adherent/';
		elseif($_SERVER['PHP_SELF']=='/adherent_v2.5/index.php') $url='/adherent/';
		else $url='/adherent/';
		
		$url.=(($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):(''));
		
		header('location: '.url_use_trans_sid($url));
		die();
	}*/
?>