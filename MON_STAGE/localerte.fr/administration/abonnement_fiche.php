<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'abonnement.php');
	
	require('abonnement_verification.php');
	
	if(!isset($_REQUEST['abonnement_fiche_mode']) || $_REQUEST['abonnement_fiche_mode']!='modifier')
		$_REQUEST['abonnement_fiche_mode']='ajouter';
	if(!isset($_REQUEST['abonnement_identifiant']))
		$_REQUEST['abonnement_identifiant']='';
	
	$abonnement=new ld_abonnement();
	
	$abonnement_fiche_erreur=0;
	$abonnement_fiche_succes=0;
	
	if(isset($_REQUEST['abonnement_fiche_submit']))
	{
		if($_REQUEST['abonnement_fiche_mode']=='modifier')
		{
			$abonnement->identifiant=$_REQUEST['abonnement_identifiant'];
			$abonnement->nouveau_identifiant=$_REQUEST['abonnement_identifiant'];
		}
		else
		{
			$abonnement->identifiant='';
			$abonnement->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_abonnement','identifiant',ABONNEMENT_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		}
		$abonnement->adherent=$_SESSION['abonnement_adherent'];
		$abonnement->delai=$_REQUEST['abonnement_delai'];
		$abonnement->domaine='localerte.fr';
		
		switch($_REQUEST['abonnement_fiche_submit'])
		{
			case 'Enregistrer':
				if($_REQUEST['abonnement_fiche_mode']=='modifier')
				{
					$abonnement_fiche_erreur=$abonnement->modifier();
					if(!$abonnement_fiche_erreur)
						$abonnement_fiche_succes=FICHE_SUCCES_MODIFIER;
				}
				else
				{
					$abonnement_fiche_erreur=$abonnement->ajouter();
					if(!$abonnement_fiche_erreur)
					{
						$_REQUEST['abonnement_fiche_mode']='modifier';
						$abonnement_fiche_succes=FICHE_SUCCES_AJOUTER;
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('abonnement_liste.php'));
				die();
				break;
		}
	}
	else
	{
		$abonnement->identifiant=$_REQUEST['abonnement_identifiant'];
		if(!$abonnement->lire())
			$_REQUEST['abonnement_fiche_mode']='ajouter';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('abonnement_expression');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th><?php print(($_REQUEST['abonnement_fiche_mode']=='modifier')?('Modifier'):('Ajouter')).' un abonnement pour l\'adh&eacute;rent '.ma_htmlentities($adherent->email.' ('.$adherent->identifiant.')');?></th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['abonnement_fiche_submit']))
	{
		if($abonnement_fiche_erreur & ABONNEMENT_DELAI_ERREUR_VALEUR || $abonnement_fiche_erreur & ABONNEMENT_DELAI_ERREUR_FILTRE) print('Le d&eacute;lai doit &ecirc;tre un nombre entier compris entre '.ma_htmlentities(ABONNEMENT_DELAI_MIN).' et '.ma_htmlentities(ABONNEMENT_DELAI_MAX).'<br />');
		if($abonnement_fiche_succes & FICHE_SUCCES_AJOUTER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;<br />');
		if($abonnement_fiche_succes & FICHE_SUCCES_MODIFIER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;<br />');
		var_dump($abonnement_fiche_erreur);
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="abonnement_fiche.php" method="post" enctype="multipart/form-data" id="formulaire">
              <input type="hidden" name="abonnement_identifiant" id="abonnement_identifiant" value="<?php print(ma_htmlentities($abonnement->identifiant));?>" />
              <input type="hidden" name="abonnement_fiche_mode" id="abonnement_fiche_mode" value="<?php print(ma_htmlentities($_REQUEST['abonnement_fiche_mode']));?>" />
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><?php print(ma_htmlentities($abonnement->identifiant));?></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['abonnement_fiche_submit']) && ($abonnement_fiche_erreur & ABONNEMENT_DELAI_ERREUR_VALEUR || $abonnement_fiche_erreur & ABONNEMENT_DELAI_ERREUR_FILTRE)) print(' class="important"');?>>D&eacute;lai (en secondes): </td>
                  <td><input name="abonnement_delai" type="text" id="abonnement_delai" value="<?php print(ma_htmlentities($abonnement->delai));?>" maxlength="<?php print(ma_htmlentities(ABONNEMENT_DELAI_MAX))?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="abonnement_fiche_submit" id="abonnement_fiche_submit" value="Enregistrer" />
                    <input type="submit" name="abonnement_fiche_submit" id="abonnement_fiche_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
