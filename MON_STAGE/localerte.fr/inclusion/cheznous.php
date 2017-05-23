<?php
	require_once(PWD_INCLUSION.'liste.php');
	
	switch($_REQUEST['mode'])
	{
		case 'connexion-par-mail':
			$liste=new ld_liste('select code from adherent where email=\''.addslashes($_REQUEST['email']).'\' and abonne=\'OUI\'');
			if($liste->total) die('http://'.$_SERVER['HTTP_HOST'].'/cn_'.urlencode($liste->occurrence[0]['code']).'.html');
			else die('http://'.$_SERVER['HTTP_HOST']);
			break;
			
	}
?>: