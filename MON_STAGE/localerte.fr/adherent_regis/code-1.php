<?php
	require_once(PWD_INCLUSION.'adherent.php');
	
	$adherent=new ld_adherent();
	$adherent->identifiant=$_SESSION['adherent_identifiant'];
	$adherent->envoyer('code2',$_SESSION['code_1']);
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Inscription confirmée ! - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-code-1">
  <div class="header">
    <h1>Inscription confirm&eacute;e !</h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <p><strong>Votre Code promo vient de vous &ecirc;tre envoy&eacute; par email.</strong></p>
    <p>Bonne recherche avec notre partenaire LOCALERTE .fr</p>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style3.footer.php');?>
  </div>
</div>
</body>
</html>