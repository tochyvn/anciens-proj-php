<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'date.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'prolongation':
				$tarif_abonnement=new ld_tarif_abonnement();
				$tarif_abonnement->identifiant=$_REQUEST['tarif_prolongation_identifiant'];
				if(!$tarif_abonnement->lire())
				{
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=tarif_prolongation'));
					die();
				}
				
				$facture=new ld_facture();
				$facture->identifiant='';
				$facture->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_facture','identifiant',FACTURE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
				$facture->adherent=$_SESSION['adherent_identifiant'];
				$facture->adresse=NULL;
				$facture->complement_adresse=NULL;
				$facture->code_postal=NULL;
				$facture->ville=NULL;
				$facture->raison_sociale=NULL;
				$facture->nom=NULL;
				$facture->prenom=NULL;
				
				$facture_ligne=new ld_facture_ligne();
				$facture_ligne->identifiant='';
				$facture_ligne->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_facture_ligne','identifiant',FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
				$facture_ligne->facture=$facture->nouveau_identifiant;
				$facture_ligne->reference=$tarif_abonnement->identifiant;
				$facture_ligne->designation=duree($tarif_abonnement->delai,'Abonnement de %j jours');
				$facture_ligne->prix_ht=$tarif_abonnement->prix_ht;
				$facture_ligne->quantite=1;
				$facture_ligne->tva=$tarif_abonnement->tva;
				$facture->facture_ligne_ajouter($facture_ligne,'ajouter');
				
				$facture->ajouter();
				$facture->payer();
				
				header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/detail.php'));
				die();
				break;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
</head>
<body onload="DonnerFocus('annonce_identification','code_reference',0);">
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="annonce_prolongation">Nos annonces du jours - Prolongation</h1>
  <h2 id="prolongation">Abonnement</h2>
  <p id="prolongation"><img src="<?php print(URL_ADHERENT_V2.'image/aide.png');?>" alt="Aide" title="Aide" />Abonnez-vous &agrave; des tarifs pr&eacute;f&eacute;rentiels et acc&eacute;dez 24/24h &agrave; toutes les annonces d&eacute;taill&eacute;es</p>
  <form id="annonce_prolongation" action="<?php print(URL_ADHERENT_V2.'annonce/special.php');?>" method="post" onsubmit="return GererWHA();">
    <input type="hidden" name="annonce_submit" value="prolongation" />
    <div id="tarif_prolongation">
      <label id="champ">Choix de l'abonnement:</label>
      <input type="radio" name="tarif_prolongation_identifiant" value="ab0003" id="tarif_prolongation_identifiant1" />
      <label for="tarif_prolongation_identifiant1" id="position1">7 jours<span id="prix">5&euro;</span></label>
      <input type="radio" name="tarif_prolongation_identifiant" value="ab0004" id="tarif_prolongation_identifiant2" checked="checked" />
      <label for="tarif_prolongation_identifiant2" id="position2">14 jours<span id="prix">9&euro;</span></label>
    </div>
    <div id="annonce_submit">
      <input type="image" src="<?php print(URL_ADHERENT_V2.'image/bouton_valider.jpg');?>" />
    </div>
  </form>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
