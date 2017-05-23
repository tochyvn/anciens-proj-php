<?php
	require_once(PWD_ADHERENT.'configuration.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
</head>
<body>
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <div id="comment">
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a><br />
        <br />
      </p>
      <h2>Comment faire votre recherche ?</h2>
      <p>
      <br />
      LOCALERTE est un <span class="orange2">moteur de recherche sp&eacute;cialis&eacute; dans la location immobili&egrave;re &agrave; l'ann&eacute;e</span>.<br />
      Chaque jour, notre service parcourt <span class="orange2">les sites Web sp&eacute;cialis&eacute;s ainsi que la Presse r&eacute;gionale et nationale</span> pour vous signaler toutes les annonces susceptibles de r&eacute;pondre &agrave; vos crit&egrave;res de recherche.<br />
      <br />
      Notre moteur de recherche vous met ensuite en relation directement avec les annonceurs que vous aurez s&eacute;lectionn&eacute;s.<br />
      <br />
      </p>
      <h3>Votre recherche sur LOCALERTE</h3>
      <br />
      <h3>Etape 1. D&eacute;finition &amp; r&eacute;ception de vos alertes emails.</h3>
      <p>
      <br />
      Une fois enregistr&eacute; sur LOCALERTE, vous devez d&eacute;finir vos alertes. Cette &eacute;tape vous permettra d'&ecirc;tre inform&eacute; <span class="orange2">2 fois par jour</span>, par email &agrave; l'adresse que vous nous aurez indiqu&eacute;e, des nouvelles annonces que nous aurons relev&eacute;es pour vous. Un simple clic depuis l'email reçu vous conduira directement vers votre tableau de r&eacute;sultats de recherche(s).<br />
      <br />
      Vous pouvez d&eacute;finir <span class="orange2">un maximum de 3 alertes</span> par compte cr&eacute;&eacute; et les modifier &agrave; tout moment depuis le lien pr&eacute;sent dans le haut de votre tableau de r&eacute;sultats.<br />
      <br />
      <b><span class="noir">Afin de vous assurer que les emails que nous vous envoyons vous sont bien d&eacute;livr&eacute;s, merci de v&eacute;rifier le dossier '&Eacute;l&eacute;ments ind&eacute;sirables' ou 'Spam' de votre boite email. En cas de d&eacute;livrabilit&eacute; malencontreuse dans ce dossier, vous devrez d&eacute;clarer nos alertes emails comme 'd&eacute;sirables' depuis votre messagerie.</span></b><br />
      </p>
      <br />
      <img src="<?php print(URL_ADHERENT.'image/comment1.jpg');?>" alt="" /><br />
      <h3>Etape 2. S&eacute;lection des annonces vues.</h3>
      <p>
      <br />
      Vous &ecirc;tes inscrits et recevez correctement nos alertes emails. D&egrave;s lors, vous devez s&eacute;lectionner toutes les annonces qui vous int&eacute;ressent en cochant / d&eacute;cochant les cases correspondantes dans la marge orange plac&eacute;e &agrave; gauche de votre tableau de r&eacute;sultats.<br />
      <br />
      Chacune de vos alertes est mat&eacute;rialis&eacute;e par un onglet plac&eacute; en haut de chaque tableau de r&eacute;sultats.<br />
      <br />
      Vous pouvez <span class="orange2">trier chaque r&eacute;sultat par crit&egrave;re : 'Localit&eacute;', 'Type', 'Loyer', 'Parution' ; ou encore par origine de l'annonce</span> : 'Annonces de particuliers' ou 'Annonces de professionnels'.<br />
      <br />
      Chaque annonce coch&eacute;e se marque d'un fond bleu p&acirc;le et est compt&eacute;e par le bouton de validation de votre s&eacute;lection, plac&eacute; horizontalement en orange toutes les 20 annonces.<br />
      <br />
      Une fois votre s&eacute;lection termin&eacute;e, vous devez cliquer sur le bouton <span class="orange2">'Voir les XX annonces coch&eacute;es'</span> pour valider votre s&eacute;lection.<br />
      <br />
      &Agrave; chaque visite sur votre tableau de r&eacute;sultats, les annonces que vous aurez d&eacute;j&agrave; vues pr&eacute;c&eacute;demment vous seront signal&eacute;es d'un texte 'non gras' sur fond bleut&eacute; avec une petite enveloppe d&eacute;cachet&eacute;e.<br />
      </p>
      <br />
      <img src="<?php print(URL_ADHERENT.'image/comment2.jpg');?>" alt="" /><br />
      <h3>Etape 3. Visualisation des annonces chez les annonceurs.</h3>
      <p>
      <br />
      Votre s&eacute;lection est faite. Vous pouvez &agrave; tout moment la modifier en cliquant sur le lien <span class="orange2">'Retour &agrave; la liste d'annonces'</span>.<br />
      <br />
      Pour visualiser vos annonces vous devez &agrave; pr&eacute;sent choisir un moyen de paiement.<br />
      <br />
      Le micro-paiement vous permet de <span class="orange2">d&eacute;couvrir l'int&eacute;gralit&eacute; de notre service et des annonces sans attente</span>, d&egrave;s lors que vous aurez compos&eacute; le num&eacute;ro de t&eacute;l&eacute;phone indiqu&eacute; ou envoy&eacute; 'LOC' par SMS.<br />
      <br />
      Votre code d'acc&egrave;s vous sera communiqu&eacute; soit par t&eacute;l&eacute;phone durant votre communication si vous choisissez d'appeler le num&eacute;ro indiqu&eacute;, soit par SMS apr&egrave;s avoir envoy&eacute; 'LOC' par SMS, si vous choisissez ce mode de micro-paiement.<br />
      <br />
      <span class="orange2">Le micro-paiement reste valable le temps de votre session</span>, c'est &agrave; dire tant que votre navigateur est ouvert sur notre service et que vous &ecirc;tes actif. En cas d'inactivit&eacute; ou de fermeture de votre navigateur, votre consultation libre sera interrompue et vous devrez la renouveler.<br />
      <br />
      Le paiement par abonnement vous permet de <span class="orange2">consulter l'int&eacute;gralit&eacute; de notre service et des annonces sans attente, durant la p&eacute;riode de votre choix &agrave; des tarifs avantageux</span>. Une fois cette p&eacute;riode &eacute;chue, votre consultation libre sera interrompue et vous devrez la renouveler.<br />
      <br />
      &Agrave; noter que pour utiliser pleinement notre service, votre ordinateur devra accepter les cookies et vous devrez ne pas les effacer durant le temps de votre abonnement.<br />
      </p>
      <br />
      <img src="<?php print(URL_ADHERENT.'image/comment3.jpg');?>" alt="" /><br />
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a><br />
        <br />
      </p>
      <p class="gauche">
        <?php include(PWD_ADHERENT.'adsense.php');?>
      </p>
    </div>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>