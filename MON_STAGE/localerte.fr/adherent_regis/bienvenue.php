<?php
	require_once(__DIR__.'/inc/pas-inscrit.php');
	require_once(__DIR__.'/inc/deja-inscrit.php');
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Localerte.fr - Bienvenue'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body>
<div class="style1">
  <div class="header">
    <?php include_once(__DIR__.'/inc/style1.header.php');?>
  </div>
  <div class="section">
    <div class="gauche">
      <form action="bienvenue.php" method="post">
        <h2 class="bleu">Inscrivez-vous pour cr&eacute;er votre  premi&egrave;re alerte de recherche </h2>
        <?php
	if(isset($_REQUEST['inscription_submit']) && $inscription_erreur)
	{
		print('<ul class="erreur">');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_EMAIL_ERREUR_LONGUEUR) print('<li>Adresse email non valide</li>');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_EMAIL_ERREUR_FILTRE && !($inscription_erreur&ADHERENT_EMAIL_ERREUR_LONGUEUR)) print('<li>Adresse email non valide</li>');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_EMAIL_ERREUR_UNIQUE) print('<li>Adresse email d&eacute;j&agrave; utilis&eacute;e</li>');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_PASSE_ERREUR) print('<li>Mot de passe non valide</li>');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_CONFIRMATION_ERREUR) print('<li>Confirmation de mot de passe non valide</li>');
		print('</ul>');
	}
?>
        <p class="champ">
          <input type="text" name="inscription_email" value="<?php if(array_key_exists('inscription_email',$_REQUEST)) print(ma_htmlentities($_REQUEST['inscription_email']));?>" placeholder="Adresse e-mail" autofocus autocomplete="off" class="inputreset">
        </p>
        <p class="champ">
          <input type="password" name="inscription_passe" value="" placeholder="Mot de passe" class="inputreset">
        </p>
        <p class="champ">
          <input type="password" name="inscription_confirmation" value="" placeholder="Confirmation mot de passe" class="inputreset">
        </p>
        <p class="action">
          <button type="submit" name="inscription_submit" value="Valider" class="bouton">Valider</button>
        </p>
      </form>
    </div>
    <div class="droite">
      <form action="bienvenue.php" method="post">
        <h2>Vous &ecirc;tes d&eacute;j&agrave; inscrit ?</h2>
        <?php
	if(isset($_REQUEST['connexion_submit']) && $connexion_erreur) print('<ul class="erreur"><li>Identifiants de connexion non valides</li></ul>');
  ?>
        <p class="champ">
          <input type="text" name="connexion_email" value="<?php if(array_key_exists('connexion_email',$_REQUEST)) print(ma_htmlentities($_REQUEST['connexion_email']));?>" placeholder="Adresse e-mail"  class="inputreset">
        </p>
        <p class="champ">
          <input type="password" name="connexion_passe" value="" placeholder="Mot de passe" class="inputreset">
        </p>
        <p class="lien"><a target="_blank" class="mot-de-passe" href="mot-de-passe-oublie.php">Mot de passe oubli&eacute; ?</a></p>
        <p class="action">
          <button type="submit" name="connexion_submit" value="Connexion" class="bouton">Me connecter</button>
        </p>
      </form>
    </div>
    <div class="clear"></div>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style1.footer.php');?>
  </div>
</div>
</body>
</html>
