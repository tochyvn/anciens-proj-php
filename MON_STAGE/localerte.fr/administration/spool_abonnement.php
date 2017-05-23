<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'spool_abonnement.php');
	
	session_write_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>

<body>
<?php
	$spool_abonnement=new ld_spool_abonnement();
	$spool_abonnement->envoyer();
?>
</body>
</html>