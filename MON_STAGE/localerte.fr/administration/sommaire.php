<div class="sommaire">
<?php
	$sommaire['Adhérents']=array('href'=>'adherent_liste.php','target'=>'_self');
	$sommaire['Annonces']=array('href'=>'annonce_liste.php','target'=>'_self');
	$sommaire['Codes']=array('href'=>'code_liste.php','target'=>'_self');
	$sommaire['Départements']=array('href'=>'departement_liste.php','target'=>'_self');
	$sommaire['Envoyer un mail']=array('href'=>'mail_envoi.php','target'=>'_self');
	$sommaire['Hardbounces']=array('href'=>'hardbounce_liste.php','target'=>'_self');
	$sommaire['Maintenance']=array('href'=>'maintenance.php','target'=>'_self');
	$sommaire['Préférences']=array('href'=>'preference.php','target'=>'_self');
	$sommaire['Provenances']=array('href'=>'provenance_liste.php','target'=>'_self');
	$sommaire['Régions']=array('href'=>'region_liste.php','target'=>'_self');
	$sommaire['Replybounces']=array('href'=>'replybounce_liste.php','target'=>'_self');
	$sommaire['Softbounces']=array('href'=>'softbounce_liste.php','target'=>'_self');
	$sommaire['Statistiques']=array('href'=>'statistiques_gestion.php','target'=>'_self');
	$sommaire['Tarifs des abonnements']=array('href'=>'tarif_abonnement_liste.php','target'=>'_self');
	$sommaire['Tarifs des forfaits']=array('href'=>'tarif_forfait_liste.php','target'=>'_self');
	$sommaire['Types']=array('href'=>'type_liste.php','target'=>'_self');
	$sommaire['Villes']=array('href'=>'ville_liste.php','target'=>'_self');
	$sommaire['Nettoyage de retour']=array('href'=>'retour_nettoyage.php','target'=>'_blank');
	$sommaire['Spool']=array('href'=>'spool_gestion.php','target'=>'_self');
	$sommaire['Exclusions']=array('href'=>'exclusion_liste.php','target'=>'_self');
	$sommaire['Tester les emails']=array('href'=>'test_email.php','target'=>'_self');
	$sommaire['Nettoyage des plaintes']=array('href'=>'plainte_nettoyage.php','target'=>'_blank');
	$sommaire['Nettoyage des désabonnement']=array('href'=>'desabonnement_nettoyage.php','target'=>'_blank');
	$sommaire['Unscribebounces']=array('href'=>'unscribebounce_liste.php','target'=>'_self');
	
	ksort($sommaire);
?>
<table width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td><a href="<?php print(URL_ADHERENT);?>" target="_blank">Accueil adh&eacute;rent</a></td>
  </tr>
  <tr>
    <td><a href="<?php print(URL_PUBLIC);?>" target="_blank">Accueil public</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="index.php">Accueil</a></td>
  </tr>
<?php
	$verification=new ld_administrateur();
	$verification->pseudonyme=$_SESSION['administrateur_pseudonyme'];
	foreach($sommaire as $clef=>$valeur)
		if($verification->autoriser(URL_ADMINISTRATION.$valeur['href']))
			print
			('
	  <tr>
    	<td><a href="'.$valeur['href'].'" target="'.ma_htmlentities($valeur['target']).'">'.ma_htmlentities($clef).'</a></td>
	  </tr>
			');
?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="administrateur_identification.php?deconnexion">D&eacute;connexion</a></td>
  </tr>
</table>
</div>