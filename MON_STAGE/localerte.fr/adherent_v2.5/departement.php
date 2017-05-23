<?php
	require_once(PWD_ADHERENT.'configuration.php');
	
	if(isset($_SESSION['adherent_identifiant']))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/liste.php'));
		die();
	}
	
	require_once(PWD_INCLUSION.'liste.php');
	
	if(!isset($_REQUEST['departement_identifiant'])) $_REQUEST['departement_identifiant']='';
	
	$liste_dpt=new ld_liste
	('
		select
			departement.identifiant as identifiant,
			departement.nom as nom,
			round(count(liste.identifiant)*1.1) as nombre
		from
			departement
			inner join ville on departement.identifiant=ville.departement
			left join liste on ville.identifiant=liste.ville_identifiant
		where
			departement.identifiant=\''.addslashes($_REQUEST['departement_identifiant']).'\'
		group by departement.identifiant
	');
	
	if(!$liste_dpt->total)
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT));
		die();
	}
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
    <div id="departement_gauche"><?php if(isset($_REQUEST['departement_identifiant'])) {?>D&eacute;partement : <br /><?php print($liste_dpt->occurrence[0]['nom']);?><br /><br /><img src="<?php print(URL_ADHERENT.'image/carte/mini/'.$liste_dpt->occurrence[0]['identifiant'].'.gif');?>" alt="" /><br /><br /><span class="orange moyen gras"><?php print(number_format($liste_dpt->occurrence[0]['nombre'], 0, ',', ' '));?> annonces</span><br />de moins de <?php print($preference->annonce_affiche_dernier_jour);?> jours<br />vous attendent<?php }?></div>
    <div id="departement_droite">
      <div id="connexion" class="bleu"><?php
	  	if(!isset($_REQUEST['mode'])) $_REQUEST['mode'] = '';
	  	switch($_REQUEST['mode'])
		{
			default:
			case 'connexion':
				include(PWD_ADHERENT.'compte/connexion.php');
				break;
			case 'passe':
				include(PWD_ADHERENT.'compte/passe.php');
				break;
			case 'desabonnement':
				include(PWD_ADHERENT.'compte/desabonnement.php');
				break;
		}
      ?></div>
      <div id="inscription" class="orange"><?php include(PWD_ADHERENT.'compte/inscription.php');?></div>
      <div id="alerte_exemple"><img src="<?php print(URL_ADHERENT);?>image/alerte_exemple.jpg" alt="" /></div>
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