<?php
	require_once(PWD_INCLUSION.'adherent.php');
	
	$desabonnement=new ld_adherent();
	$desabonnement_erreur=false;
	
	if(isset($_POST['desabonnement_submit']))
	{
		$desabonnement->email=$_POST['adherent_email'];
		if($desabonnement->lire('email'))
		{
			$desabonnement->abonne='NON';
			$desabonnement->modifier();
		}
		else $desabonnement_erreur=true;
	}
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Désabonnement alertes mail - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-desabonnement">
  <div class="header">
    <h1>D&eacute;sabonnement alertes mail</h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <form action="desabonnement.php" method="post">
      <p><strong class="orange">Attention : </strong>si  vous disposez d&rsquo;un abonnement payant, celui-ci sera automatiquement caduque</p>
      <hr>
      <?php
	if(isset($_POST['desabonnement_submit']))
	{
	  	if($desabonnement_erreur)print('<ul class="erreur"><li>E-mail d&eacute;j&agrave; d&eacute;sabonn&eacute; ou mal orthographi&eacute;.</li></ul>');
	  	if(!$desabonnement_erreur) print('<p class="succes">Votre d&eacute;sabonnement a &eacute;t&eacute; effectu&eacute;.</p>');
	}
	if(!isset($_POST['desabonnement_submit']) || $desabonnement_erreur)
	{
?>
      <p class="champ">
        <input type="text" name="adherent_email" value="<?php if(array_key_exists('adherent_email',$_POST)) print(ma_htmlentities($_POST['adherent_email']));?>" placeholder="Adresse e-mail" class="inputreset" autocomplete="off" autofocus>
      </p>
      <p class="action">
        <input class="bouton" type="submit" name="desabonnement_submit" value="Me d&eacute;sabonner">Me d&eacute;sabonner</input>
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
