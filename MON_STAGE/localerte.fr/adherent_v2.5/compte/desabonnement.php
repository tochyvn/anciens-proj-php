<h1 class="cache">Mot de passe oubli&eacute;</h1>
<div class="onglet"><?php if($_SERVER['PHP_SELF']==URL_ADHERENT.'index.php') { ?><a href="?mode=inscription">Pas inscrit ?</a><?php }?></div><div class="onglet"><a href="?mode=connexion">D&eacute;sabonnement</a></div>
<form class="encart" action="" method="post">
  <p class="droite">
  	<br /><br />
    <label>Votre adresse email:</label>
    <input type="text" name="adherent_email" value="<?php print(ma_htmlentities($desabonnement->email));?>" />
  </p>
<?php
	if(isset($_REQUEST['desabonnement_submit']))
	{
	  	if($desabonnement_erreur) print('<p class="orange_fonce gras"><img src="'.URL_ADHERENT.'image/erreur.png" alt="" />Nous ne retrouvons pas cette adresse.<br />V&eacute;rifiez que vous &ecirc;tes bien inscrit &agrave; notre service et que vous avez correctement entr&eacute; votre adresse.</p>');
	  	if(!$desabonnement_erreur) print('<p class="orange_fonce gras"><br /><br /><img src="'.URL_ADHERENT.'image/valid.png" alt="" />Votre d&eacute;sabonnement a &eacute;t&eacute; effectu&eacute;.</p>');
	}
?>
  <p class="bleu"><br /><br /><a href="<?php print($_SERVER['PHP_SELF']);?>?mode=connexion">[ Retour ]</a></p>
  <p class="submit">
    <input id="submit" class="submit validation" type="submit" name="desabonnement_submit" value="Valider" />
  </p>
</form>
