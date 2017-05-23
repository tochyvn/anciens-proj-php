<?php
	
	define('HTTPS',isset($_SERVER['HTTPS']));

	define('URL_ADHERENT','/adherent');
	define('PWD_ADHERENT',$_SERVER['DOCUMENT_ROOT'].URL_ADHERENT);
	define('HTTP_ADHERENT','http'.(HTTPS?'s':'').'://www.localerte.fr'.URL_ADHERENT);
	define('HTTP_STATIC','http'.(HTTPS?'s':'').'://static.localerte.fr'.URL_ADHERENT);
	
	define('DEBUGAGE',0);
	define('CHARSET','windows-1252');
	define('LOCAL','\'fr_FR\',\'fr\'');
	
	require_once($_SERVER['DOCUMENT_ROOT'].'/inclusion/prepend.php');
	
	$secret='idsfgmkfdsfdfughmgjkhdfmghmqjqferhfmqhjlmfkgjù²ohtjmfjdqsjkqhmklqjdflgjlmgjkhmqkfhjk';
	function localerte_mobi($secret)
	{
		$tableau=array();
		if(isset($_SESSION['adherent_identifiant'])) $tableau['adherent_identifiant']=$_SESSION['adherent_identifiant'];
		if(isset($_SESSION['wha_identifiant'])) $tableau['wha_identifiant']=$_SESSION['wha_identifiant'];
		if(isset($_SESSION['allopass_reference'])) $tableau['allopass_reference']=$_SESSION['allopass_reference'];
		if(isset($_SESSION['code_reference'])) $tableau['code_reference']=$_SESSION['code_reference'];
		if(isset($_SESSION['annonce_identifiant'])) $tableau['annonce_identifiant']=$_SESSION['annonce_identifiant'];
		if(isset($_SESSION['adherent_debut'])) $tableau['adherent_debut']=$_SESSION['adherent_debut'];
		$crypt=encrypt_text(serialize($tableau),$secret);
		
		return 'http://www.localerte.mobi/mes-alertes.php?crypt='.urlencode($crypt);
	}
	
	if(isset($_REQUEST['crypt']))
	{
		require_once(PWD_INCLUSION.'string.php');
		unset_adherent();
		$tableau=unserialize(decrypt_text($_REQUEST['crypt'],$secret));
		foreach($tableau as $clef=>$valeur) $_SESSION[$clef]=$valeur;
	}
	
	if(isset($_SERVER['HTTP_USER_AGENT']))
	{
		$mobile_version=preg_match('/android|iphone|blackberry|iipad|ppalm/i',$_SERVER['HTTP_USER_AGENT'])/* && 0*/;
		if($mobile_version && !isset($_SESSION['mobi_propose']) && (!isset($_SESSION['redirection']) || !isset($_REQUEST['msgbox'])))
		{
			$_SESSION['mobi_propose']=1;
			header('location: '.localerte_mobi($secret));
			die();
		}
	}
	
	//VIENS DE REDIRECTION.PHP
	if(isset($_SESSION['redirection'])) unset($_SESSION['redirection']);
	
	require_once(__DIR__.'/identification.php');
	
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
	
	//REDIRECTION PAIEMENTS
	if(isset($_SESSION['adherent_identifiant']))
	{
		require_once(PWD_INCLUSION.'liste.php');
		
		$cond1=new ld_liste('select * from abonnement where adherent='.$_SESSION['adherent_identifiant'].'');
		$cond2=new ld_liste
		('
			(select unix_timestamp(enregistrement) as enregistrement from allopass where adherent='.$_SESSION['adherent_identifiant'].')
			union all
			(select unix_timestamp(enregistrement) as enregistrement from wha where adherent='.$_SESSION['adherent_identifiant'].')
			order by enregistrement asc
			limit 1
		');
		$cond3=array('debut'=>mktime(19,0,0,7,25,2013),'fin'=>mktime(23,0,0,7,25,2013));
		if(!$cond1->total && $cond2->total && ($cond2->occurrence[0]['enregistrement']+(7*24*60*60))-time()>0){
			$minuteur=$cond2->occurrence[0]['enregistrement']+(7*24*60*60);
			$paiement='/mes-offres-reservees.php';
			file_put_contents(PWD_INCLUSION.'prive/log/mes-offres-reservees.php.log',$_SESSION['adherent_identifiant']."\r\n",FILE_APPEND);
		}
		elseif($cond3['debut']<time() && $cond3['fin']-time()>0){
			$minuteur=$cond3['fin'];
			$paiement='/mes-ventes-flash.php';
		}
		else $paiement='/mes-paiements.php';
		
		//if($_SERVER['REMOTE_ADDR']=='83.113.3.5'){
		//	$minuteur=time()+(16*60*60);
		//	$paiement='/mes-offres-reservees.php';
		//}
	}
	else $paiement='/mes-paiements.php';
?>