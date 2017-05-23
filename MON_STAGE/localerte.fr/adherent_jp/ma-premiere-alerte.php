<?php
	require_once(PWD_INCLUSION.'liste.php');
	
	$liste=new ld_liste('select identifiant from alerte where adherent='.$_SESSION['adherent_identifiant'].'');
	if($liste->total)
	{
		$query=array();
		if(isset($_REQUEST['msgbox'])) $query['msgbox']=$_REQUEST['msgbox'];
		if(isset($_REQUEST['msgbox_query'])) $query['msgbox_query']=$_REQUEST['msgbox_query'];
		header('location: '.url_use_trans_sid(URL_ADHERENT.'/ma-liste.php'.(sizeof($query)?'?'.http_build_query($query,'','&'):'')));
		die();
	}

	$_REQUEST['alerte_rayon']=35;
	$_REQUEST['alerte_type'][1]='';
	$_REQUEST['alerte_type'][2]='';
	$_REQUEST['alerte_identifiant']='';
	
	require_once(__DIR__.'/inc/mon-alerte.php');
	
	if(isset($_REQUEST['alerte_submit']) && !$alerte_erreur)
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'/ma-liste.php'));
		die();
	}
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Ma première alerte - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body>
<div class="style1">
  <div class="header">
    <?php include_once(__DIR__.'/inc/style1.header.php');?>
  </div>
  <div class="section">
    <form action="ma-premiere-alerte.php" method="post" class="ma-premiere-alerte">
      <h2>Cr&eacute;ez &agrave; pr&eacute;sent votre premi&egrave;re  alerte de recherche :</h2>
      <div>
      <?php
	if(isset($_REQUEST['alerte_submit']))
	{
		if($alerte_erreur)
		{
			print('<ul class="erreur">');
			if($alerte_erreur&ALERTE_VILLE_ERREUR) print('<li>Indiquez une ville pour votre recherche</li>');
			if($alerte_erreur&ALERTE_RAYON_ERREUR_VALEUR || $alerte_erreur&ALERTE_RAYON_ERREUR_FILTRE) print('<li>Renseignez un rayon de recherche</li>');
			if($alerte_erreur&ALERTE_ALERTE_TYPE_ERREUR_TAILLE || $alerte_erreur&ALERTE_ALERTE_TYPE_ERREUR_CLASSE) print('<li>Renseignez au moins 1 type d\'habitation recherch&eacute;</li>');
			print('</ul>');
		}
		else print('<p class="succes">Modification effectu&eacute;e</p>');
	}
?>
        <?php
	$liste=new ld_liste('select identifiant, designation from type where parent is null');
	$i=0;
	if($i<sizeof($alerte->alerte_type)) $type=$alerte->alerte_type[0]['objet']->nouveau_type;
	else $type=NULL;
	
	print
	('
		<p class="champ"><select name="alerte_type[]" class="selectdefault"'.(!$i?' autofocus':'').'>
		  <option value="">Choisissez le type '.($i+1).'</option>
	');
	for($j=0;$j<$liste->total;$j++)
		print('<option value="'.ma_htmlentities($liste->occurrence[$j]['identifiant']).'"'.(($type && $liste->occurrence[$j]['identifiant']==$type)?(' selected="selected"'):('')).'>'.ma_htmlentities($liste->occurrence[$j]['designation']).'</option>');
	print('</select></p>');
?>
        <p class="champ">
          <input class="json-localisation inputreset" type="text" name="alerte_filtre" value="<?php print(((isset($_REQUEST['alerte_filtre']))?(ma_htmlentities($_REQUEST['alerte_filtre'])):('')));?>" placeholder="Saisissez la ville ou code postal" autocomplete="off">
          <input type="hidden" name="alerte_ville" value="<?php if($alerte->ville) print('VILLE_'.$alerte->ville);?>">
        </p>
        <p class="action">
          <button class="bouton" type="submit" name="alerte_submit" value="Valider">Valider</button>
        </p>
        <div class="clear"></div>
      </div>
    </form>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style1.footer.php');?>
  </div>
</div>
</body>
</html>
