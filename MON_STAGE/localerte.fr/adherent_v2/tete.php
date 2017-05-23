<a href="<?php print(URL_ADHERENT_V2);?>" id="logo"><img src="<?php print(URL_ADHERENT_V2.'/image/logo.jpg');?>" /></a>
<div style="position:absolute; left:465px; top:10px;"><a style="color:#FF9115;" href="?adherent_version=V2.5"><b>Nouveau: d&eacute;couvrez la nouvelle version de Localerte</b></a></div>
<h1 id="sommaire">Sommaire</h1>
<ul id="sommaire">
  <li id="position01"><a href="<?php print(URL_ADHERENT_V2.'index.php');?>">Accueil</a></li>
  <li id="position02"><a href="<?php if(isset($_SESSION['adherent_identifiant'])) print(URL_ADHERENT_V2.'annonce/liste.php'); else print(URL_ADHERENT_V2.'compte/fiche.php');?>">Consulter les annonces du jour</a></li>
  <li id="position03"><a href="<?php print(URL_ADHERENT_V2.'compte/fiche.php');?>"><?php if(!isset($_SESSION['adherent_identifiant'])) print('S\'inscrire'); else print('Modifier mes crit&egrave;res');?></a></li>
  <li id="position04"><a href="<?php print(URL_ADHERENT_V2.'compte/desabonnement.php');?>">D&eacute;sabonnez-vous</a></li>
  <li id="position05"><a href="<?php print(URL_ADHERENT_V2.'contact.php');?>">Contactez-nous</a></li>
</ul>
<?php
	if(!isset($_SESSION['adherent_identifiant']))
	{
?>
<h1 id="identification">Espace client</h1>
<?php
		if($identification_erreur)
			print('<p id="identification_ko">Adresse email ou mot de passe incorrect</p>');
?>
<form id="identification" action="<?php print($_SERVER['PHP_SELF']);?>" method="post">
  <div id="adherent_email">
    <label>Email:</label>
    <input type="text" name="adherent_email" value="" />
  </div>
  <div id="adherent_passe">
    <label>Mot de passe:</label>
    <input type="password" name="adherent_passe" value="" />
  </div>
  <div id="identification_submit">
    <input type="submit" name="identification_submit" value="Connexion" />
  </div>
  <a href="<?php print(URL_ADHERENT_V2.'compte/passe.php');?>">Mot de passe oubli&eacute; ?</a>
</form>
<?php
	}
	else
	{
?>
<div id="deconnexion"><a href="<?php print($_SERVER['PHP_SELF'].'?identification_submit=deconnexion');?>">D&eacute;connexion</a></div>
<div id="abonnement">
<?php
		switch($abonnement['resultat'])
		{
			case 'ABONNEMENT_DELAI_PERIME':
				print('Votre abonnement est expir&eacute;. Pour le prolonger, <a href="'.URL_ADHERENT_V2.'annonce/prolongation.php">cliquez ici</a>');
				break;
			case 'ABONNEMENT_ADHERENT_INCONNU':
				print('');
				break;
			case 'ABONNEMENT_AUCUN':
				print('');
				break;
			case 'ABONNEMENT_UTILISABLE':
				print('Votre abonnement prendra fin le '.strftime(STRING_DATETIMECOMLPLET,$abonnement['objet']->premiere_utilisation+$abonnement['objet']->delai).'.');
				break;
		}
?>
</div>
<?php
	}
?>
