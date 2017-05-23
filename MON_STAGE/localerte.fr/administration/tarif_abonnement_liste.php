<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'date.php');
	
	if(!isset($_SESSION['tarif_abonnement_tri']))
		$_SESSION['tarif_abonnement_tri']='identifiant';
	if(!isset($_SESSION['tarif_abonnement_ordre']))
		$_SESSION['tarif_abonnement_ordre']='asc';
	
	if(isset($_REQUEST['tarif_abonnement_tri']))
	{
		$_SESSION['tarif_abonnement_tri']=$_REQUEST['tarif_abonnement_tri'];
		if(!isset($_REQUEST['tarif_abonnement_ordre']) || $_REQUEST['tarif_abonnement_ordre']!='desc')
			$_REQUEST['tarif_abonnement_ordre']='asc';
	}
	if(isset($_REQUEST['tarif_abonnement_ordre']))
		$_SESSION['tarif_abonnement_ordre']=$_REQUEST['tarif_abonnement_ordre'];
	
	$liste=new ld_liste
	('
		select
			identifiant,
			prix_ht,
			tva,
			round(prix_ht*(1+tva/100),2) as prix_ttc,
			delai,
			paypal
		from tarif_abonnement
		where 1
		order by `'.$_SESSION['tarif_abonnement_tri'].'` '.$_SESSION['tarif_abonnement_ordre'].'
	');
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
          <th>Liste des tarifs des abonnements</th>
        </tr>
        <tr>
          <td><?php
	if($liste->total)
	{
?>
            <table cellspacing="0" cellpadding="4" class="petit" align="center">
              <?php
		for($i=0;$i<sizeof($liste->occurrence);$i++)
		{
			if($i%LISTE_RAPPEL_ENTETE==0)
			{
?>
              <tr>
                <td class="entete">Identifiant<br />
                  <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=identifiant">&Lambda;</a> <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=identifiant&tarif_abonnement_ordre=desc">V</a></td>
                <td class="entete">Prix HT<br />
                  <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=prix_ht">&Lambda;</a> <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=prix_ht&tarif_abonnement_ordre=desc">V</a></td>
                <td class="entete">TVA<br />
                  <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=tva">&Lambda;</a> <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=tva&tarif_abonnement_ordre=desc">V</a></td>
                <td class="entete">Prix TTC<br />
                  <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=prix_ttc">&Lambda;</a> <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=prix_ttc&tarif_abonnement_ordre=desc">V</a></td>
                <td class="entete">D&eacute;lai<br />
                  <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=delai">&Lambda;</a> <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=delai&tarif_abonnement_ordre=desc">V</a></td>
                <td class="entete">Paypal<br />
                  <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=paypal">&Lambda;</a> <a href="tarif_abonnement_liste.php?tarif_abonnement_tri=paypal&tarif_abonnement_ordre=desc">V</a></td>
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
				    onclick="liste_onClick('tarif_abonnement_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('tarif_abonnement_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                <td><?php print(ma_htmlentities($liste->occurrence[$i]['prix_ht']).'&euro;');?></td>
                <td><?php print(ma_htmlentities($liste->occurrence[$i]['tva'].'%'));?></td>
                <td><?php print(ma_htmlentities($liste->occurrence[$i]['prix_ttc']).'&euro;');?></td>
                <td><?php print(ma_htmlentities(duree($liste->occurrence[$i]['delai'],'%j jours')));?></td>
                <td><?php print(ma_htmlentities($liste->occurrence[$i]['paypal']));?></td>
              </tr>
              <?php
		}
?>
            </table>
            <?php
	}
	else
		print('<span class="important">Aucun &eacute;l&eacute;ment</span>');
?></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
