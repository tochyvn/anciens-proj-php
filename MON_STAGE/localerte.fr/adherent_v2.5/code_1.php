<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	$adherent=new ld_adherent();
	$adherent->identifiant=$_SESSION['adherent_identifiant'];
	$adherent->envoyer('code2',$_SESSION['code_1']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
</head>
<body>
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <div id="pub_gauche">
      <?php include(PWD_ADHERENT.'adsense_gauche.php');?>
    </div>
    <div id="contact">
      <h1><strong>Inscription confirm&eacute;e !</strong></h1>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a><br />
        <br />
      </p>
      <div class="contact" style="width:250px; padding:30px; margin:auto;">
      <p><strong>Votre Code promo vient de vous &ecirc;tre envoy&eacute; par email.</strong><br />
        <br />
        <br />
Bonne recherche avec notre partenaire LOCALERTE .fr</p>
      </div>
      <br />
      <br />
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a></p>
      <?php include(PWD_ADHERENT.'adsense.php');?>
    </div>
    <div id="pub_droite">
      <?php include(PWD_ADHERENT.'adsense_droit.php');?>
    </div>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>