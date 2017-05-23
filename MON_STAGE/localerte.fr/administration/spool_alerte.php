<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'spool_alerte.php');
	
	session_write_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>

<body>
<?php
	$spool_alerte=new ld_spool_alerte();
	$spool_alerte->envoyer();
?>
</body>
</html>