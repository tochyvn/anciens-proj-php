<?php
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	$liste=new ld_liste('select round(count(identifiant)*1.1) as nombre from liste');
	$preference=new ld_preference();
	
	if(isset($_REQUEST['habillage']) && $_REQUEST['habillage']==0) print($liste->occurrence[0]['nombre']);
	else print('Aujourd\'hui, <span class="orange gras">'.number_format($liste->occurrence[0]['nombre'], 0, '.', ' ').'</span> annonces de location<br />de moins de '.$preference->annonce_affiche_dernier_jour.' jours vous attendent');
?>
