<?php
	require_once(PWD_ADHERENT.'configuration.php');
	
	if(isset($_SESSION['adherent_identifiant']) && !(isset($_REQUEST['mode']) && $_REQUEST['mode']=='desabonnement'))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/liste.php'));
		die();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
</head>
<body>
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header"><?php include(PWD_ADHERENT.'tete.php');?></div>
  <div id="centre_haut"></div>
  <div id="centre">
    <div id="centre_gauche">
      <div id="teaser"><?php include(PWD_ADHERENT.'teaser.php');?></div>
      <?php
	  	if(!isset($_REQUEST['mode'])) $_REQUEST['mode'] = '';
	  	switch($_REQUEST['mode'])
		{
			default:
			case 'connexion':
				print('<div id="connexion" class="bleu_orange">');
				include(PWD_ADHERENT.'compte/connexion.php');
				print('</div>');
				break;
			case 'passe':
				print('<div id="passe" class="bleu_orange">');
				include(PWD_ADHERENT.'compte/passe.php');
				print('</div>');
				break;
			case 'desabonnement':
				print('<div id="desabonnement" class="bleu_orange">');
				include(PWD_ADHERENT.'compte/desabonnement.php');
				print('</div>');
				break;
			case 'inscription':
				print('<div id="inscription" class="orange_bleu">');
				include(PWD_ADHERENT.'compte/inscription.php');
				print('</div>');
				break;
		}
      ?>
    </div>
    <div id="centre_droit">
      <div id="carte"><?php include(PWD_ADHERENT.'carte.php');?></div>
    </div>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer"><?php include(PWD_ADHERENT.'pied.php');?></div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>