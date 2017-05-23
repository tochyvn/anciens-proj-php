<h1 class="cache">Mot de passe oubli&eacute;</h1>
<div class="onglet"><?php if($_SERVER['PHP_SELF']==URL_ADHERENT.'index.php') { ?><a href="?mode=inscription">Pas inscrit ?</a><?php }?></div><div class="onglet"><a href="?mode=connexion">Mot de passe oubli&eacute;</a></div>
<form class="encart" action="" method="post">
  <p class="droite">
  	<br /><br />
    <label>Votre adresse email :</label>
    <input type="text" name="passe_email" value="<?php print(ma_htmlentities($passe->email));?>" />
  </p>
<?php
	if(isset($_REQUEST['passe_submit']))
	{
	  	if($passe_erreur) print('<p class="orange_fonce gras"><br /><br />Identifiants de connexion non valides</p>');
	  	if(!$passe_erreur) print('<p class="orange_fonce gras"><br /><br />Votre mot de passe a &eacute;t&eacute; envoy&eacute; &agrave; votre adresse.</p>');
	}
?>
  <p class="bleu"><br /><br /><a href="<?php print($_SERVER['PHP_SELF']);?>?mode=connexion">[ Retour ]</a></p>
  <p class="submit">
    <input class="submit validation" type="submit" name="passe_submit" value="Valider" />
  </p>
</form>
