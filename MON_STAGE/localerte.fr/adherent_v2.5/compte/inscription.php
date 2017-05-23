<h1 class="cache">Inscription</h1>
<div class="onglet"><a href="?mode=inscription">Pas inscrit ?</a></div><div class="onglet"><?php if($_SERVER['PHP_SELF']==URL_ADHERENT.'index.php') { ?><a href="?mode=connexion">D&eacute;j&agrave; inscrit ?</a><?php }?></div>
<form class="encart" action="" method="post">
  <?php
	if(!isset($_REQUEST['inscription_submit']))
	{
	  	print('<p class="centre t15">Cr&eacute;ez GRATUITEMENT votre compte<br /></p>');
	} else {
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_EMAIL_ERREUR_LONGUEUR) print('<p class="orange_fonce gras">Adresse email non valide</p>');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_EMAIL_ERREUR_FILTRE && !($inscription_erreur&ADHERENT_EMAIL_ERREUR_LONGUEUR)) print('<p class="rouge">Adresse email non valide</p>');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_EMAIL_ERREUR_UNIQUE) print('<p class="orange_fonce gras">Adresse email d&eacute;j&agrave; utilis&eacute;e</p>');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_PASSE_ERREUR) print('<p class="orange_fonce gras">Mot de passe non valide</p>');
	  	if($inscription_erreur && $inscription_erreur&ADHERENT_CONFIRMATION_ERREUR) print('<p class="orange_fonce gras">Confirmation de mot de passe non valide</p>');
	}
?>
  <p class="droite">
    <label>Adresse email :</label>
    <input type="text" name="inscription_email" value="<?php print(ma_htmlentities($inscription->email));?>" maxlength="<?php print(ADHERENT_EMAIL_MAX);?>" />
  </p>
  <p class="droite">
    <label>Mot de passe :</label>
    <input type="password" name="inscription_passe" value="<?php print(ma_htmlentities($inscription->passe));?>" maxlength="<?php print(ADHERENT_PASSE_MAX);?>" />
  </p>
  <p class="droite">
    <label>Confirmez le mot de passe :</label>
    <input type="password" name="inscription_confirmation" value="<?php print(ma_htmlentities($inscription->confirmation));?>" maxlength="<?php print(ADHERENT_PASSE_MAX);?>" />
  </p>
  <p class="orange_fonce t11">
    <label class="w300" for="inscription_lalettredujour"><input class="checkbox" type="checkbox" id="inscription_lalettredujour" name="inscription_lalettredujour" value="1"<?php if(isset($_REQUEST['inscription_lalettredujour'])) print(' checked="checked"');?> /> Lib&eacute;rez votre pouvoir d'achat !<br />Recevez les bons plans<br />de Geo Mailing</label>
  </p>
  <p class="submit">
    <input class="submit inscription" type="submit" name="inscription_submit" value="Valider" />
  </p>
</form>
