<h1 class="cache">Connectez-vous</h1>
<div class="onglet"><?php if($_SERVER['PHP_SELF']==URL_ADHERENT.'index.php') { ?><a href="?mode=inscription">Pas inscrit ?</a><?php }?></div><div class="onglet"><a href="?mode=connexion">D&eacute;j&agrave; inscrit ?</a></div>
<form class="encart" action="" method="post">
  <?php
	if(isset($_REQUEST['connexion_submit'])) {
	  	if($connexion_erreur) print('<p class="orange_fonce gras"><br />Identifiants de connexion non valides</p>');
	}
  ?>
  <p class="cache">
    <label class="cache">Redirection :</label>
    <input class="cache" type="text" name="connexion_redirection" value="liste" />
  </p>
  <p class="droite">
    <label>Adresse email :</label>
    <input type="text" name="connexion_email" value="" />
  </p>
  <p class="droite">
    <label>Mot de passe :</label>
    <input type="password" name="connexion_passe" value="" />
  </p>
  <p class="bleu"><br />
    <br />
    <a href="?mode=passe<?php if(isset($_REQUEST['departement_identifiant'])) print('&amp;departement_identifiant='.urlencode($_REQUEST['departement_identifiant']));?>">[ Mot de passe oubli&eacute; ]</a> <a href="?mode=desabonnement<?php if(isset($_REQUEST['departement_identifiant'])) print('&amp;departement_identifiant='.urlencode($_REQUEST['departement_identifiant']));?>">[ D&eacute;sabonnement ]</a></p>
  <p class="submit">
    <input type="submit" class="submit connexion" name="connexion_submit" value="Valider" />
  </p>
</form>
