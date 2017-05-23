<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	$adherent=new ld_adherent();
	$passe_erreur=false;
	
	if(isset($_REQUEST['passe_submit']))
	{
		switch($_REQUEST['passe_submit'])
		{
			case 'Valider':
				$adherent->email=$_REQUEST['adherent_email'];
				if($adherent->lire('email') && $adherent->abonne=='OUI')
				{
					$adherent->envoyer('passe');
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=passe'));
					die();
				}
				else
					$passe_erreur=true;
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
</head>
<body onload="DonnerFocus('passe','adherent_email',0);">
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="passe">Mot de passe oubli&eacute;</h1>
<?php
	if(isset($_REQUEST['passe_submit']) && $passe_erreur)
	  	print('<p id="passe_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />L\'email n\'est pas pr&eacute;sent dans notre base de donn&eacute;es</p>');
?>
  <p id="passe">Pour obtenir votre mot de passe, veuillez entrer votre adresse e-mail.</p>
  <form id="passe" action="<?php print(URL_ADHERENT_V2.'compte/passe.php');?>" method="post">
    <div id="adherent_email">
      <label>Votre adresse email:</label>
      <input type="text" name="adherent_email" value="<?php print(ma_htmlentities($adherent->email));?>" />
    </div>
    <div id="passe_submit">
      <input id="submit" type="submit" name="passe_submit" value="Valider" />
    </div>
  </form>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
