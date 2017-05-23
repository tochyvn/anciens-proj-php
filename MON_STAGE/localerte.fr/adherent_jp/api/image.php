<?php
	require_once(PWD_INCLUSION.'liste.php');
	
	$liste=new ld_liste('select image from liste where identifiant='.$_REQUEST['identifiant']);
	
	$_REQUEST['forme']='vignette';
	$_REQUEST['largeur']=200;
	$_REQUEST['url']=$liste->occurrence[0]['image'];
	
	require_once('gd.php');
?>