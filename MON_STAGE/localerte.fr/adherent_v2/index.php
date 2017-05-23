<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
</head>
<body>
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="caracteristique">Pourquoi vous abonner ?</h1>
  <ul id="caracteristique">
    <li id="position01"><span id="important">Vous cherchez un appartement &agrave; louer?</span>
      Vous allez disposer d'un maximum d'annonces
      de location pour faire votre choix en toute s&eacute;r&eacute;nit&eacute;.</li>
    <li id="position02">Localerte a d&eacute;velopp&eacute; <span id="important">un moteur de recherche
      sp&eacute;cifique</span> &agrave; la location immobili&egrave;re qui recense
      chaque jour le maximum d'annonces de location
      (presse r&eacute;gionale, nationale et internet).</li>
    <li id="position03"> <a href="<?php print(URL_ADHERENT_V2.'compte/fiche.php');?>">Inscrivez-vous</a> en sp&eacute;cifiant votre email
      et vos crit&egrave;res de recherche.</li>
    <li id="position04">Vous recevrez <span id="important">d&egrave;s le lendemain</span> toutes les
      annonces correspondant &agrave; vos crit&egrave;res de recherche.
      Les offres vous sont pr&eacute;sent&eacute;es sous forme
      d'un <span id="important">tableau clair et concis</span>.</li>
    <li id="position05">Si une ou plusieurs propositions vous satisfont,
      vous activez <span id="important">l'affichage d&eacute;taill&eacute;e des annonces</span> par paiement audiotel ou Internet Plus.
      Vous appelez, vous louez ... <a href="<?php print(URL_ADHERENT_V2.'compte/fiche.php');?>">Inscrivez-vous !</a></li>
  </ul>
  <!--h1 id="cout">Co&ucirc;t du service</h1>
  <ul id="cout">
    <li id="position01">* Co&ucirc;t appel audiotel: 1,34&euro;/appel + 0,34&euro;/min</li>
    <li id="position02">* Co&ucirc;t Internet Plus: 1,50&euro;</li>
  </ul-->
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
