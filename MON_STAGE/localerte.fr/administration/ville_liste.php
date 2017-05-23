<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'ville.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	if(!isset($_SESSION['ville_page']))
		$_SESSION['ville_page']=1;
	if(!isset($_SESSION['ville_tri']))
		$_SESSION['ville_tri']='nom';
	if(!isset($_SESSION['ville_ordre']))
		$_SESSION['ville_ordre']='asc';
	if(!isset($_SESSION['ville_recherche']))
		$_SESSION['ville_recherche']='';
	if(!isset($_SESSION['ville_identifiant']))
		$_SESSION['ville_identifiant']='124083042';
	
	if(isset($_REQUEST['ville_page']))
		$_SESSION['ville_page']=$_REQUEST['ville_page'];
	if(isset($_REQUEST['ville_tri']))
	{
		$_SESSION['ville_tri']=$_REQUEST['ville_tri'];
		if(!isset($_REQUEST['ville_ordre']) || $_REQUEST['ville_ordre']!='desc')
			$_REQUEST['ville_ordre']='asc';
	}
	if(isset($_REQUEST['ville_ordre']))
		$_SESSION['ville_ordre']=$_REQUEST['ville_ordre'];
	
	$ville_liste_erreur=0;
	
	if(isset($_REQUEST['ville_liste_submit']))
	{
		switch($_REQUEST['ville_liste_submit'])
		{
			case 'Rechercher':
			case 'Modifier la recherche':
				header('location: '.url_use_trans_sid('ville_recherche.php'));
				die();
				break;
			case 'Annuler la recherche':
				$_SESSION['ville_recherche']='';
				break;
			case 'Ville de référence':
				if(isset($_REQUEST['ville_identifiant']))
				{
					if(sizeof($_REQUEST['ville_identifiant'])==1)
						$_SESSION['ville_identifiant']=$_REQUEST['ville_identifiant'][0];
					else
						$ville_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$ville_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
		}
	}
	
	$ville=new ld_ville();
	$ville->identifiant=$_SESSION['ville_identifiant'];
	if(!$ville->lire())
	{
		$ville->identifiant='124083042';
		$ville->lire();
	}
	
	$liste=new ld_liste
	('
		select
			ville.identifiant as identifiant,
			departement.identifiant as departement_identifiant,
			departement.nom as departement_nom,
			ville.nom as nom,
			ville.code_postal as code_postal,
			ville.longitude as longitude,
			ville.latitude as latitude,
			round(ifnull((6366*acos(cos(radians('.$ville->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$ville->longitude.'))+sin(radians('.$ville->latitude.'))*sin(radians(ville.latitude)))),0),0) as distance
		from ville
			inner join departement on ville.departement=departement.identifiant
		where 1
		'.str_replace('%LONGITUDE%',$ville->longitude,str_replace('%LATITUDE%',$ville->latitude,$_SESSION['ville_recherche'])).'
		order by `'.$_SESSION['ville_tri'].'` '.$_SESSION['ville_ordre'].'
		limit '.(($_SESSION['ville_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
	',LISTE_PAGE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
</head>

<body>
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table cellspacing="0" cellpadding="4">
      <tr>
        <th>Liste des villes (ville de référence : <?php print(ma_htmlentities($ville->code_postal.' '.$ville->nom))?>)</th>
      </tr>
      <tr>
        <td class="important">
<?php
	if(isset($_REQUEST['ville_liste_submit']) && $ville_liste_erreur)
	{
		if($ville_liste_erreur & LISTE_ERREUR_AUCUN) print('Aucun &eacute;l&eacute;ment s&eacute;lectionn&eacute;<br />');
		if($ville_liste_erreur & LISTE_ERREUR_TROP) print('Trop d\'&eacute;l&eacute;ments s&eacute;lectionn&eacute;s<br />');
	}
	else
		print('&nbsp;');
?>
        </td>
      </tr>
      <tr>
        <td><form action="ville_liste.php" method="post" id="formulaire">
          <table cellspacing="0" cellpadding="4">
            <tr>
              <td nowrap="nowrap"><?php print_pagination($liste,'ville_liste.php','ville_page');?></td>
              <td align="right">
<?php
	if($_SESSION['ville_recherche']!='')
		print
		('
			<input name="ville_liste_submit" type="submit" id="ville_liste_submit" value="Modifier la recherche" />
			<input name="ville_liste_submit" type="submit" id="ville_liste_submit" value="Annuler la recherche" />
		');
	else
		print('<input name="ville_liste_submit" type="submit" id="ville_liste_submit" value="Rechercher" />');
?>
                <input name="ville_liste_submit" type="submit" id="ville_liste_submit" value="Ville de r&eacute;f&eacute;rence" /></td>
            </tr>
            <tr>
              <td colspan="2">
<?php
	if($liste->total)
	{
?>

			    <table cellspacing="0" cellpadding="4">
<?php
		for($i=0;$i<sizeof($liste->occurrence);$i++)
		{
			if($i%LISTE_RAPPEL_ENTETE==0)
			{
?>
                  <tr>
                    <td class="entete">Identifiant<br />
                      <a href="ville_liste.php?ville_tri=identifiant">&Lambda;</a> <a href="ville_liste.php?ville_tri=identifiant&ville_ordre=desc">V</a></td>
                    <td class="entete">D&eacute;partement<br />
                      <a href="ville_liste.php?ville_tri=departement">&Lambda;</a> <a href="ville_liste.php?ville_tri=departement_nom&ville_ordre=desc">V</a></td>
                    <td class="entete">Nom<br />
                      <a href="ville_liste.php?ville_tri=nom">&Lambda;</a> <a href="ville_liste.php?ville_tri=nom&ville_ordre=desc">V</a></td>
                    <td class="entete">Code postal <br />
                      <a href="ville_liste.php?ville_tri=code_postal">&Lambda;</a> <a href="ville_liste.php?ville_tri=code_postal&ville_ordre=desc">V</a></td>
                    <td class="entete">Longitude<br />
                      <a href="ville_liste.php?ville_tri=longitude">&Lambda;</a> <a href="ville_liste.php?ville_tri=longitude&ville_ordre=desc">V</a></td>
                    <td class="entete">Lattitude<br />
                      <a href="ville_liste.php?ville_tri=latitude">&Lambda;</a> <a href="ville_liste.php?ville_tri=latitude&ville_ordre=desc">V</a></td>
                    <td class="entete">Distance<br />
                      <a href="ville_liste.php?ville_tri=distance">&Lambda;</a> <a href="ville_liste.php?ville_tri=distance&ville_ordre=desc">V</a></td>
                    <td width="10" align="center"><script language="javascript" type="text/javascript">document.write('<input type="checkbox" id="cocher_ville_identifiant" onclick="liste_cocher(this,\'ville_identifiant[]\');" />');</script>
</td>
                  </tr>
<?php
			}
			$couleur_survol=LISTE_SURVOL;
			$couleur_click=LISTE_CLICK;
			if($i%2)
				$couleur_courant=LISTE_IMPAIR;
			else
				$couleur_courant=LISTE_PAIR;
?>
                  <tr
				    style="background-color: <?php print($couleur_courant);?>;"
					onmouseover="liste_onMouseOver(this,'<?php print($couleur_survol);?>');"
					onmouseout="liste_onMouseOut(this,'<?php print($couleur_courant);?>');"
				    onclick="liste_onClick('ville_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('ville_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                    <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                    <td><?php print(ma_htmlentities($liste->occurrence[$i]['departement_nom'].' ('.$liste->occurrence[$i]['departement_identifiant'].')'));?></td>
                    <td><?php print(ma_htmlentities($liste->occurrence[$i]['nom']));?></td>
                    <td><?php print(ma_htmlentities($liste->occurrence[$i]['code_postal']));?></td>
                    <td><?php print(nl2br(ma_htmlentities($liste->occurrence[$i]['longitude'])));?></td>
                    <td><?php print(nl2br(ma_htmlentities($liste->occurrence[$i]['latitude'])));?></td>
                    <td><?php print(nl2br(ma_htmlentities($liste->occurrence[$i]['distance'])));?> Km</td>
                    <td width="10" align="center"><input type="checkbox" name="ville_identifiant[]" id="ville_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
                  </tr>
<?php
		}
?>
                </table>
<?php
	}
	else
		print('&nbsp;');
?>			  </td>
            </tr>
            <tr>
              <td nowrap="nowrap"><?php print_pagination($liste,'ville_liste.php','ville_page');?></td>
              <td align="right"><?php
	if($_SESSION['ville_recherche']!='')
		print
		('
			<input name="ville_liste_submit" type="submit" id="ville_liste_submit" value="Modifier la recherche" />
			<input name="ville_liste_submit" type="submit" id="ville_liste_submit" value="Annuler la recherche" />
		');
	else
		print('<input name="ville_liste_submit" type="submit" id="ville_liste_submit" value="Rechercher" />');
?>
                <input name="ville_liste_submit" type="submit" id="ville_liste_submit" value="Ville de r&eacute;f&eacute;rence" /></td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
