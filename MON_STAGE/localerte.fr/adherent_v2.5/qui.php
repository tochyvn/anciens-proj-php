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
    <div id="pub_gauche">
      <?php include(PWD_ADHERENT.'adsense_gauche.php');?>
    </div>
    <div id="qui">
      <h1>Qui sommes-nous ?</h1>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a><br />
        <br />
      </p>
      <p><br />
        LOCALERTE est un service de recherche propri&eacute;t&eacute; de la soci&eacute;t&eacute; AICOM Sarl.<br />
        <br />
      </p>
      <p>Situ&eacute;e en Provence le long de la côte varoise, AICOM est une entreprise &agrave; taille humaine anim&eacute;e par la passion d'une &eacute;quipe vou&eacute;e depuis son plus jeune &acirc;ge aux nouvelles technologies.<br />
        <br />
      </p>
      <p>Cette startup n&eacute;e en 1993 (!) puise son inspiration &agrave; La Farl&egrave;de (83210) au pied du mont COUDON, massif calcaire parsem&eacute; de pins et baign&eacute; d'oliviers centenaires en son pied. L'histoire d'AICOM est forte de l'exp&eacute;rience de 25 ans de son cr&eacute;ateur, Jean-Pierre Mourot, acquise d&egrave;s les ann&eacute;es 80 &agrave; l'heure de notre l&eacute;gendaire Minitel, et adapt&eacute;e d&eacute;sormais &agrave; la dynamique sans limite d'Internet.<br />
        <br />
      </p>
      <p>Un accent &laquo; humain &raquo; sonne chez nous, bien loin du silence de nos machines.<br />
        <br />
      </p>
      <p>
      <ul style="list-style:none;">
        <li>Direction&nbsp;: Jean-Pierre Mourot</li>
        <li>Marketing&nbsp;: R&eacute;gis C&eacute;r&eacute;sola</li>
        <li>Technique : Laurent Davenne</li>
        <li>Graphisme&nbsp;: Pixl Cr&eacute;ation Graphique</li>
      </ul>
      <br />
      </p>
      <p>AICOM - 117 rue de la R&eacute;publique - 83210 La Farl&egrave;de<br />
        T&eacute;l. 0892 65 14 00 (0,34 &euro;/min).<br />
        Fax. 04.94.27.81.72.<br />
        Web. www.aicom-multimedia.fr<br />
        <br />
      </p>
      <p class="centre"><img src="<?php print(URL_ADHERENT.'image/coudon.jpg');?>" alt="" />
      </p>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT);?>">Retour &agrave; l'accueil</a></p>
      <?php include(PWD_ADHERENT.'adsense.php');?>
    </div>
    <div id="pub_droite">
      <?php include(PWD_ADHERENT.'adsense_droit.php');?>
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