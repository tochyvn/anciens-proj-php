<div id="logo"><a href="<?php print(URL_ADHERENT);?>"><img src="<?php print(URL_ADHERENT.'/image/logo2.jpg');?>" alt="Localerte" /><!--br /> On cherche pour vous, partout--></a></div>
<div id="deconnexion">
<?php if(isset($_SESSION['adherent_identifiant'])) { ?><a href="?deconnexion_submit=">D&eacute;connexion</a><?php }?><br />
<!--a href="?adherent_version=V2">Revenir &agrave; l'ancienne version de Localerte</a-->
</div>
<div id="total"><?php include(PWD_ADHERENT.'total.php');?></div>
<div id="menu">
<h1>Sommaire</h1>
<ul>
  <li id="menu1"><a href="<?php print(URL_ADHERENT.'contact.php');?>">Nous contacter</a></li>
  <li id="menu2"><a href="<?php print(URL_ADHERENT.'comment.php');?>">Comment faire votre recherche</a></li>
  <li id="menu3"><a href="http://cheznous.fr/adherent/compte/fiche.php" class="js-blank">D&eacute;poser gratuitement une annonce</a></li>
</ul>
</div>
