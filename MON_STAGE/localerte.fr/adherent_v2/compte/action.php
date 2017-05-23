<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	
	header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=action'));
	die();
?>