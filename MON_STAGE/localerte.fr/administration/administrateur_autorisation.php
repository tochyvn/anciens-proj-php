<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'administrateur.php');
	
	if(isset($_SESSION['administrateur_pseudonyme']))
	{
		$administrateur=new ld_administrateur();
		$administrateur->pseudonyme=$_SESSION['administrateur_pseudonyme'];
		if(!$administrateur->autoriser($_SERVER['REQUEST_URI']))
		{
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>

<body>
<table class="petit" align="center" cellspacing="0" cellpadding="4">
  <tr>
    <th>Autorisation d'acc&egrave;s refus&eacute;e</th>
  </tr>
  <tr>
    <td class="important">Vous n'avez pas le droit d'acc&eacute;der &agrave; cette page. Pour retourner &agrave; l'accueil, <a href="index.php">cliquez ici</a>.</td>
  </tr>
</table>
</body>
</html>
<?php
			die();
		}
		
		unset($administrateur);
	}
?>