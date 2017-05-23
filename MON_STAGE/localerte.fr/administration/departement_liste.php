<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	if(!isset($_SESSION['departement_page']))
		$_SESSION['departement_page']=1;
	if(!isset($_SESSION['departement_tri']))
		$_SESSION['departement_tri']='nom';
	if(!isset($_SESSION['departement_ordre']))
		$_SESSION['departement_ordre']='asc';
	
	if(isset($_REQUEST['departement_page']))
		$_SESSION['departement_page']=$_REQUEST['departement_page'];
	if(isset($_REQUEST['departement_tri']))
	{
		$_SESSION['departement_tri']=$_REQUEST['departement_tri'];
		if(!isset($_REQUEST['departement_ordre']) || $_REQUEST['departement_ordre']!='desc')
			$_REQUEST['departement_ordre']='asc';
	}
	if(isset($_REQUEST['departement_ordre']))
		$_SESSION['departement_ordre']=$_REQUEST['departement_ordre'];
	
	$liste=new ld_liste
	('
		select
			departement.identifiant as identifiant,
			departement.region as region_identifiant,
			region.nom as region_nom,
			departement.nom as nom
		from departement
			inner join region on departement.region=region.identifiant
		order by `'.$_SESSION['departement_tri'].'` '.$_SESSION['departement_ordre'].'
		limit '.(($_SESSION['departement_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
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
        <th>Liste des departements</th>
      </tr>
      <tr>
        <td class="important">&nbsp;</td>
      </tr>
      <tr>
        <td><form action="departement_liste.php" method="post" id="formulaire">
          <table cellspacing="0" cellpadding="4">
            <tr>
              <td nowrap="nowrap"><?php print_pagination($liste,'departement_liste.php','departement_page');?></td>
              <td align="right">&nbsp;</td>
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
                      <a href="departement_liste.php?departement_tri=identifiant">&Lambda;</a> <a href="departement_liste.php?departement_tri=identifiant&departement_ordre=desc">V</a></td>
                    <td class="entete">R&eacute;gion<br />
                      <a href="departement_liste.php?departement_tri=region_nom">&Lambda;</a> <a href="departement_liste.php?departement_tri=region_nom&departement_ordre=desc">V</a></td>
                    <td class="entete">Nom<br />
                      <a href="departement_liste.php?departement_tri=nom">&Lambda;</a> <a href="departement_liste.php?departement_tri=nom&departement_ordre=desc">V</a></td>
                    <td width="10" align="center"><script language="javascript" type="text/javascript">document.write('<input type="checkbox" id="cocher_departement_identifiant" onclick="liste_cocher(this,\'departement_identifiant[]\');" \/>');</script>
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
				    onclick="liste_onClick('departement_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('departement_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                    <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                    <td><?php print(ma_htmlentities($liste->occurrence[$i]['region_nom'].' ('.$liste->occurrence[$i]['region_identifiant'].')'));?></td>
                    <td><?php print(ma_htmlentities($liste->occurrence[$i]['nom']));?></td>
                    <td width="10" align="center"><input type="checkbox" name="departement_identifiant[]" id="departement_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
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
              <td nowrap="nowrap"><?php print_pagination($liste,'departement_liste.php','departement_page');?></td>
              <td align="right">&nbsp;</td>
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
