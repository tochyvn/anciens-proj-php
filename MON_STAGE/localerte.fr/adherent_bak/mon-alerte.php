<?php
	require_once(__DIR__.'/inc/mon-alerte.php');
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Mon alerte - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body class="no-bg-image">
<div class="style3 style3-mon-alerte">
  <div class="header">
    <h1><?php print($mode!='modifier'?'Cr&eacute;er  une nouvelle alerte de recherche':'Modifier mon alerte de recherche')?></h1>
    <?php include_once(__DIR__.'/inc/style3.header.php');?>
  </div>
  <div class="section">
    <form action="mon-alerte.php" method="post">
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
	if(!isset($_REQUEST['alerte_submit']) || $alerte_erreur)
 	{
?>
      <p class="champ">
        <input class="json-localisation inputreset" type="text" name="alerte_filtre" value="<?php print(((isset($_REQUEST['alerte_filtre']))?(ma_htmlentities($_REQUEST['alerte_filtre'])):('')));?>" placeholder="Saisissez la ville ou code postal" autocomplete="off" autofocus>
        <input type="hidden" name="alerte_ville" value="<?php if($alerte->ville) print('VILLE_'.$alerte->ville);?>">
      </p>
      <hr>
      <p class="champ">
        <select name="alerte_rayon" class="selectdefault">
          <option value="">Choisissez le rayon</option>
          <option value="5"<?php if($alerte->rayon==5) print(' selected="selected"');?>>Jusqu'&agrave; 5 km</option>
          <option value="10"<?php if($alerte->rayon==10) print(' selected="selected"');?>>Jusqu'&agrave; 10 km</option>
          <option value="20"<?php if($alerte->rayon==20) print(' selected="selected"');?>>Jusqu'&agrave; 20 km</option>
          <option value="35"<?php if($alerte->rayon==35) print(' selected="selected"');?>>Jusqu'&agrave; 35 km</option>
          <option value="50"<?php if($alerte->rayon==50) print(' selected="selected"');?>>Jusqu'&agrave; 50 km</option>
        </select>
      </p>
      <hr>
      <?php
		$liste=new ld_liste('select identifiant, designation from type where parent is null');
		for($i=0;$i<3;$i++)
		{
			if($i<sizeof($alerte->alerte_type)) $type=$alerte->alerte_type[$i]['objet']->nouveau_type;
			else $type=NULL;
			
			print
			('
				<p class="champ"><select name="alerte_type[]" class="selectdefault">
				  <option value="">Choisissez le type '.($i+1).'</option>
			');
			for($j=0;$j<$liste->total;$j++)
				print('<option value="'.ma_htmlentities($liste->occurrence[$j]['identifiant']).'"'.(($type && $liste->occurrence[$j]['identifiant']==$type)?(' selected="selected"'):('')).'>'.ma_htmlentities($liste->occurrence[$j]['designation']).'</option>');
			print('</select></p>');
		}
?>
      <p class="cache">
        <input type="hidden" name="alerte_identifiant" value="<?php print(ma_htmlentities($_REQUEST['alerte_identifiant']));?>">
      </p>
      <p class="action">
        <button class="bouton" type="submit" name="alerte_submit" value="Valider">Valider</button>
      </p>
<?php
	}
?>
    </form>
  </div>
  <div class="footer">
    <?php include_once(__DIR__.'/inc/style3.footer.php');?>
  </div>
</div>
</body>
</html>
