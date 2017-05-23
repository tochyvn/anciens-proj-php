<?php
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'fichier.php');
	
	//file_put_contents(PWD_INCLUSION.'prive/temp/test.txt',print_r($_SERVER,true),FILE_APPEND);
	
	$preference=new ld_preference();

	if((!$preference->ip_paiement || $preference->ip_paiement==$_SERVER['REMOTE_ADDR']) && isset($_REQUEST['ref']))
	{
		$facture=new ld_facture();
		$facture->identifiant=preg_replace('/^(LA(mobi)?)/','',$_REQUEST['ref']);
		if($facture->lire())
		{
			if(isset($_REQUEST['auto']) && preg_match('/^([0-9]+|XXXXXX)$/',$_REQUEST['auto']))
			{
				$facture->payer('CB');
				$facture->envoyer();
				$facture->envoyer('forfait');
			}
			//else
			//	$facture->supprimer();
		}
	}
?>