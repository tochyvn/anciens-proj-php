<?php
	require_once(PWD_INCLUSION.'adherent.php');
	
	$passe=new ld_adherent();
	$passe_erreur=false;
	
	if(isset($_REQUEST['passe_submit']))
	{
		$passe->email=$_REQUEST['passe_email'];
		if($passe->lire('email') && $passe->abonne=='OUI') $passe->envoyer('passe');
		else $passe_erreur=true;
	}
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Mot de passe oublié - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-mot-de-passe">
  <div class="header">
    <h1>Mot de passe oubli&eacute; ?</h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <form action="mot-de-passe-oublie.php" method="get">
      <?php
	if(isset($_REQUEST['passe_submit']))
	{
	  	if($passe_erreur) print('<ul class="erreur"><li>Cet identifiant est inconnu</li></ul>');
	  	if(!$passe_erreur) print('<p class="succes">Votre mot de passe a &eacute;t&eacute; envoy&eacute; &agrave; votre adresse.</p>');
	}
	if(!isset($_REQUEST['passe_submit']) || $passe_erreur)
	{
?>
      <p class="champ">
        <input type="text" name="passe_email" value="<?php if(array_key_exists('passe_email',$_REQUEST)) print(ma_htmlentities($_REQUEST['passe_email']));?>" placeholder="Adresse e-mail" class="inputreset" autofocus>
      </p>
      <p class="action">
        <button class="bouton" type="submit" name="passe_submit" value="Envoyer">Envoyer</button>
      </p>
<?php
	}
?>
    </form>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style3.footer.php');?>
  </div>
</div>
</body>
</html>
