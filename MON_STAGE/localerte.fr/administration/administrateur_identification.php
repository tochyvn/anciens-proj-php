<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'administrateur.php');
	
	if(isset($_REQUEST['deconnexion']) && isset($_SESSION['administrateur_pseudonyme']))
		unset($_SESSION['administrateur_pseudonyme']);
	
	if(isset($_REQUEST['administrateur_identification_submit']))
	{
		$administrateur=new ld_administrateur();
		$administrateur->pseudonyme=$_REQUEST['administrateur_pseudonyme'];
		$administrateur->passe=$_REQUEST['administrateur_passe'];
		if($administrateur->lire())
		{
			$_SESSION['administrateur_pseudonyme']=$administrateur->pseudonyme;
			if(isset($_REQUEST['administrateur_etape']))
			{
				switch($_REQUEST['administrateur_etape'])
				{
					case '0':
						header('location: '.url_use_trans_sid('annonce_import.php'));
						die();
						break;
					case '1':
						header('location: '.url_use_trans_sid('annonce_import.php?mode=lister'));
						die();
						break;
					case '2':
						header('location: '.url_use_trans_sid('plainte_nettoyage.php'));
						die();
						break;
					case '3':
						header('location: '.url_use_trans_sid('retour_nettoyage.php'));
						die();
						break;
					case '3':
						header('location: '.url_use_trans_sid('desabonnement_nettoyage.php'));
						die();
						break;
					default:
						header('location: '.url_use_trans_sid('index.php'));
						die();
						break;
				}
			}
		}
		else
			sleep(3);
		unset($administrateur);
	}
	
	if(!isset($_SESSION['administrateur_pseudonyme']))
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>

<body onload="DonnerFocus('administrateur_pseudonyme');">
<table class="petit" align="center" cellspacing="0" cellpadding="4">
  <tr>
    <th>Identifiez-vous </th>
  </tr>
  <tr>
    <td class="important">
<?php
	if(isset($_REQUEST['administrateur_identification_submit']))
		print('Pseudonyme ou mot de passe incorrect');
	else
		print('&nbsp;');
?>
	</td>
  </tr>
  <tr>
    <td><form action="index.php" method="post" id="formulaire">
      <table cellspacing="0" cellpadding="4">
        <tr>
          <td>Pseudonyme : </td>
          <td><input name="administrateur_pseudonyme" type="text" id="administrateur_pseudonyme" /></td>
        </tr>
        <tr>
          <td>Mot de passe : </td>
          <td><input name="administrateur_passe" type="password" id="administrateur_passe" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="administrateur_identification_submit" type="submit" id="administrateur_identification_submit" value="Connecter" /></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
		die();
	}
?>