<?php
	$adherent=new ld_adherent();
	$adherent->identifiant=$_SESSION['adherent_identifiant'];
	$adherent->lire();
	$adherent->validation='OUI';
	$adherent->modifier();
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Votre Code promo - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-code-2">
  <div class="header">
    <h1>Votre Code promo</h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <p><strong>Votre Code d'acc&egrave;s gratuit est :</strong> <span><?php print($_SESSION['code_2']);?></span></p>
    <p>Pour consulter les annonces correspondant à votre recherche, copiez le code et <a href="mes-paiements.php" target="_top">cliquez ici</a></p>
    <p>Bonne recherche avec Localerte .fr</p>
    <p><small>Code &agrave; usage unique, utilisable exclusivement sur LOCALERTE .fr</small></p>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style3.footer.php');?>
  </div>
</div>
</body>
</html>