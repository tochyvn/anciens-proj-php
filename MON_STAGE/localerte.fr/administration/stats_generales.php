<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	$liste_stats_annonce=new ld_liste
	('
		SELECT
			jour,
			total,
			insertion,
			ajout
		FROM statistiques_annonce
		ORDER BY jour DESC
		LIMIT 0, 7
	');


	$liste_stats_alerte=new ld_liste
	('
		SELECT
			jour,
			total,
			clic
		FROM statistiques_alerte
		ORDER BY jour DESC
		LIMIT 0, 7
	');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body>
<table cellspacing="0" cellpadding="4">
   <tr>
    <td>Jour</td>
    <td>Annonces ins&eacute;r&eacute;es</td>
    <td>dont nouvelles</td>
    <td>Nb d'alertes envoy&eacute;es</td>
    <td>Nb clics sur alerte</td>
  </tr>
<?php for($i=0;$i<7;$i++){ ?>
  <tr>
    <td><?php print(ma_htmlentities($liste_stats_annonce->occurrence[$i]['jour']));?></td>
    <td><?php print(ma_htmlentities($liste_stats_annonce->occurrence[$i]['insertion']));?></td>
    <td><?php print(ma_htmlentities($liste_stats_annonce->occurrence[$i]['ajout']));?></td>
    <td><?php print(ma_htmlentities($liste_stats_alerte->occurrence[$i]['total']));?></td>
    <td><?php print(ma_htmlentities($liste_stats_alerte->occurrence[$i]['clic']));?></td>
  </tr>
<?php } ?>
</table>
</body>
</html>
