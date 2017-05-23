<?php
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'fichier.php');
	
	$preference=new ld_preference();

	if((!$preference->ip_paiement || $preference->ip_paiement==$_SERVER['REMOTE_ADDR']) && isset($_REQUEST['invoice']))
	{
		
		$facture=new ld_facture();
		$facture->identifiant=preg_replace('/^(LA-PAYPAL)/','',$_REQUEST['invoice']);
		if($facture->lire())
		{
			if(isset($_REQUEST['payment_status']) && $_REQUEST['payment_status']=='Completed')
			{
				$facture->payer('PAYPAL');
				$facture->envoyer();
			}
			//else
			//	$facture->supprimer();
		}
	}
?>