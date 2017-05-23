<?php
	require_once(PWD_INCLUSION.'configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	if(isset($_REQUEST['idc']))
	{
		$adherent=new ld_adherent();
		if(strlen($_REQUEST['idc'])==32)
		{
			$adherent->identifiant=$_REQUEST['idc'];
			$adherent->identifier('cryptage');
		}
		else
		{
			$adherent->identifiant=$_REQUEST['idc'];
			$adherent->lire();			
		}
		
		header('location: '.url_use_trans_sid('/d_'.urlencode(($adherent->code!==NULL)?($adherent->code):($_REQUEST['idc'])).'.html'));
		die();
	}
	
	header('location: '.url_use_trans_sid(URL_ADHERENT));
	die();
?>