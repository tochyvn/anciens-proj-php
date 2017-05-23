<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'provenance.php');
	
	$provenance_liste=new ld_liste
	('
		select identifiant,
			designation,
			url,
			couleur
		from provenance
		order by designation
	');
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
    <div id="pub_gauche"><?php include(PWD_ADHERENT.'adsense_gauche.php');?></div>
    <div id="provenance">
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste des annonces</a></p>
<?php
		for($i=0;$i<$provenance_liste->total;$i++) {
			print('<img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=8&y=8&c='.urlencode($provenance_liste->occurrence[$i]['couleur']).'" /> <a id="provenance'.$i.'" href="'.$provenance_liste->occurrence[$i]['url'].'" class="js_blank bleu_fonce gras">'.ma_htmlentities($provenance_liste->occurrence[$i]['designation']).'</a><br />'.CRLF);      
		}
?>
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste des annonces</a></p>
    </div>
    <div id="pub_droite"><?php include(PWD_ADHERENT.'adsense_droit.php');?></div>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>
