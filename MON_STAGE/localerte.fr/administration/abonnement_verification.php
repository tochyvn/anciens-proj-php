<?php
	require_once(PWD_INCLUSION.'adherent.php');
	
	if(!isset($_SESSION['abonnement_adherent']))
		$_SESSION['abonnement_adherent']='';
	
	$adherent=new ld_adherent();
	$adherent->identifiant=$_SESSION['abonnement_adherent'];
	$adherent->lire();	
?>