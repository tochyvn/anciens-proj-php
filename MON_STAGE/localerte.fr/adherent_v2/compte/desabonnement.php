<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	$adherent=new ld_adherent();
	$desabonnement_erreur=false;
	
	if(isset($_REQUEST['desabonnement_submit']))
	{
		switch($_REQUEST['desabonnement_submit'])
		{
			case 'automatique':
			case 'Valider':
				$adherent->email=$_REQUEST['adherent_email'];
				if($adherent->lire('email') && $adherent->abonne=='OUI')
				{
					$adherent->abonne='NON';
					$adherent->modifier();
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=desabonnement'));
					die();
				}
				else
					$desabonnement_erreur=true;
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
</head>
<body onload="DonnerFocus('desabonnement','adherent_email',0);">
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="desabonnement">D&eacute;sabonnez-vous</h1>
<?php
	if(isset($_REQUEST['desabonnement_submit']) && $desabonnement_erreur)
	  	print('<p id="desabonnement_ko"><img src="'.URL_ADHERENT_V2.'image/ko.png" />Vous &ecirc;tes d&eacute;sabonn&eacute; ou cet email n\'est pas pr&eacute;sent dans notre base. Dans ce dernier cas, v&eacute;rifiez l\'orthographe de l\'email.</p>');
?>
  <p id="desabonnement">Pour vous d&eacute;sabonner, veuillez entrer votre adresse e-mail.</p>
  <form id="desabonnement" action="<?php print(URL_ADHERENT_V2.'compte/desabonnement.php');?>" method="post" fo>
    <div id="adherent_email">
      <label>Votre adresse email:</label>
      <input type="text" name="adherent_email" value="<?php print(ma_htmlentities($adherent->email));?>" />
    </div>
    <div id="desabonnement_submit">
      <input id="submit" type="submit" name="desabonnement_submit" value="Valider" />
    </div>
  </form>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
