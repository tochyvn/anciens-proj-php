<?php
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	$compte=new ld_adherent();
	$compte->identifiant=$_SESSION['adherent_identifiant'];
	$compte->lire();
	$compte_erreur=0;
	
	if(isset($_REQUEST['compte_submit']))
	{
		$compte->email=$_REQUEST['compte_email'];
		$compte->passe=$_REQUEST['compte_passe'];
		$compte->confirmation=$_REQUEST['compte_confirmation'];
			
		$compte_erreur=$compte->modifier(isset($_REQUEST['compte_lalettredujour']));
	}
	
	$liste=new ld_liste('select count(identifiant) as nombre from alerte where adherent='.$_SESSION['adherent_identifiant']);
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Mon compte - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-mon-compte">
  <div class="header">
    <h1>Mon compte</h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <form action="mon-compte.php" method="post">
      <p> <strong>Date d'inscription :</strong> <?php print(ma_htmlentities(date('d/m/Y',$compte->date_abonnement)));?> <br>
      <strong>Nombre d'alertes cr&eacute;es :</strong> <?php print(ma_htmlentities($liste->occurrence[0]['nombre']));?> </p>
      <hr>
      <?php
	if(isset($_REQUEST['compte_submit']))
	{
		if($compte_erreur)
		{
			print('<ul class="erreur">');
			if($compte_erreur && $compte_erreur&ADHERENT_EMAIL_ERREUR_LONGUEUR) print('<li>Adresse email non valide</li>');
			if($compte_erreur && $compte_erreur&ADHERENT_EMAIL_ERREUR_FILTRE && !($compte_erreur&ADHERENT_EMAIL_ERREUR_LONGUEUR)) print('<li>Adresse email non valide</li>');
			if($compte_erreur && $compte_erreur&ADHERENT_EMAIL_ERREUR_UNIQUE) print('<li>Adresse email d&eacute;j&agrave; utilis&eacute;e</li>');
			if($compte_erreur && $compte_erreur&ADHERENT_PASSE_ERREUR) print('<li>Mot de passe non valide</li>');
			if($compte_erreur && $compte_erreur&ADHERENT_CONFIRMATION_ERREUR) print('<li>Confirmation de mot de passe non valide</li>');
			print('</ul>');
		}
		else print('<p class="succes">Compte modifi&eacute;</p>');
	}
	if(!isset($_REQUEST['compte_submit']) || $compte_erreur)
	{
?>
      <p class="champ">
        <input type="text" name="compte_email" value="<?php print(ma_htmlentities($compte->email));?>" placeholder="Adresse e-mail" class="inputreset" autocomplete="off" autofocus>
      </p>
      <hr>
      <p>Modification de votre mot de passe</p>
      <p class="champ">
        <input type="password" name="compte_passe" value="" placeholder="Nouveau mot de passe" class="inputreset">
      </p>
      <p class="champ">
        <input type="password" name="compte_confirmation" value="" placeholder="Confirmation mot de passe" class="inputreset">
      </p>
      <p class="action">
        <button class="bouton" type="submit" name="compte_submit" value="Valider">Valider</button>
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
</html>
