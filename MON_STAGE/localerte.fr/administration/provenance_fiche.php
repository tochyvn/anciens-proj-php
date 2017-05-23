<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'provenance.php');
	
	if(!isset($_REQUEST['provenance_fiche_mode']) || $_REQUEST['provenance_fiche_mode']!='modifier')
		$_REQUEST['provenance_fiche_mode']='ajouter';
	if(!isset($_REQUEST['provenance_identifiant']))
		$_REQUEST['provenance_identifiant']='';
	
	$provenance=new ld_provenance();
	
	$provenance_fiche_erreur=0;
	$provenance_fiche_succes=0;
	
	if(isset($_REQUEST['provenance_fiche_submit']))
	{
		if($_REQUEST['provenance_fiche_mode']=='modifier')
		{
			$provenance->identifiant=$_REQUEST['provenance_identifiant'];
			$provenance->nouveau_identifiant=$_REQUEST['provenance_identifiant'];
		}
		else
		{
			$provenance->identifiant='';
			$provenance->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_provenance','identifiant',PROVENANCE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		}
		$provenance->code=$_REQUEST['provenance_code'];
		$provenance->designation=$_REQUEST['provenance_designation'];
		$provenance->url=$_REQUEST['provenance_url'];
		$provenance->couleur=$_REQUEST['provenance_couleur'];
		
		switch($_REQUEST['provenance_fiche_submit'])
		{
			case 'Enregistrer':
				if($_REQUEST['provenance_fiche_mode']=='modifier')
				{
					$provenance_fiche_erreur=$provenance->modifier();
					if(!$provenance_fiche_erreur)
						$provenance_fiche_succes=FICHE_SUCCES_MODIFIER;
				}
				else
				{
					$provenance_fiche_erreur=$provenance->ajouter();
					if(!$provenance_fiche_erreur)
					{
						$_REQUEST['provenance_fiche_mode']='modifier';
						$provenance_fiche_succes=FICHE_SUCCES_AJOUTER;
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('provenance_liste.php'));
				die();
				break;
		}
	}
	else
	{
		$provenance->identifiant=$_REQUEST['provenance_identifiant'];
		if(!$provenance->lire())
			$_REQUEST['provenance_fiche_mode']='ajouter';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script src="general.js" language="javascript" type="text/javascript"></script>
</head>
<body onload="DonnerFocus('provenance_designation');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th><?php print(($_REQUEST['provenance_fiche_mode']=='modifier')?('Modifier'):('Ajouter'));?> une provenance</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['provenance_fiche_submit']))
	{
		if($provenance_fiche_erreur & PROVENANCE_CODE_ERREUR_LONGUEUR) print('Le code doit &ecirc;tre comprise entre '.ma_htmlentities(PROVENANCE_CODE_MIN).' et '.ma_htmlentities(PROVENANCE_CODE_MAX).' caract&egrave;res<br />');
		if($provenance_fiche_erreur & PROVENANCE_CODE_ERREUR_UNIQUE) print('Le code est d&eacute;j&agrave; utilis&eacute;<br />');
		if($provenance_fiche_erreur & PROVENANCE_DESIGNATION_ERREUR) print('La d&eacute;signation doit &ecirc;tre comprise entre '.ma_htmlentities(PROVENANCE_DESIGNATION_MIN).' et '.ma_htmlentities(PROVENANCE_DESIGNATION_MAX).' caract&egrave;res<br />');
		if($provenance_fiche_erreur & PROVENANCE_URL_ERREUR_LONGUEUR || $provenance_fiche_erreur & PROVENANCE_URL_ERREUR_FILTRE) print('L\'URL n\'est pas valide<br />');
		if($provenance_fiche_erreur & PROVENANCE_COULEUR_ERREUR_FILTRE) print('La couleur n\'est pas valide<br />');
		if($provenance_fiche_erreur & PROVENANCE_COULEUR_ERREUR_UNIQUE) print('La couleur est d&eacute;j&agrave; utilis&eacute;e<br />');
		if($provenance_fiche_succes & FICHE_SUCCES_AJOUTER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;<br />');
		if($provenance_fiche_succes & FICHE_SUCCES_MODIFIER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="provenance_fiche.php" method="post" enctype="multipart/form-data" id="formulaire">
              <input type="hidden" name="provenance_identifiant" id="provenance_identifiant" value="<?php print(ma_htmlentities($provenance->identifiant));?>" />
              <input type="hidden" name="provenance_fiche_mode" id="provenance_fiche_mode" value="<?php print(ma_htmlentities($_REQUEST['provenance_fiche_mode']));?>" />
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><?php print(ma_htmlentities($provenance->identifiant));?></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['provenance_fiche_submit']) && ($provenance_fiche_erreur & PROVENANCE_CODE_ERREUR_LONGUEUR || $provenance_fiche_erreur & PROVENANCE_CODE_ERREUR_UNIQUE)) print(' class="important"');?>>Code : </td>
                  <td><input name="provenance_code" type="text" id="provenance_code" value="<?php print(ma_htmlentities($provenance->code));?>" maxlength="<?php print(ma_htmlentities(PROVENANCE_CODE_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['provenance_fiche_submit']) && $provenance_fiche_erreur & PROVENANCE_DESIGNATION_ERREUR) print(' class="important"');?>>D&eacute;signation : </td>
                  <td><input name="provenance_designation" type="text" id="provenance_designation" value="<?php print(ma_htmlentities($provenance->designation));?>" maxlength="<?php print(ma_htmlentities(PROVENANCE_DESIGNATION_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['provenance_fiche_submit']) && ($provenance_fiche_erreur & PROVENANCE_URL_ERREUR_LONGUEUR || $provenance_fiche_erreur & PROVENANCE_URL_ERREUR_FILTRE)) print(' class="important"');?>>URL : </td>
                  <td><input name="provenance_url" type="text" id="provenance_url" value="<?php print(ma_htmlentities($provenance->url));?>" maxlength="<?php print(ma_htmlentities(PROVENANCE_URL_MAX))?>" />
                  <script>document.write(' <a href="" onclick="window.open(document.getElementById(\'provenance_url\').value,true); return false;">V&eacute;rifier</a>');</script></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['provenance_fiche_submit']) && $provenance_fiche_erreur & PROVENANCE_COULEUR_ERREUR_FILTRE) print(' class="important"');?>>Couleur : </td>
                  <td><noscript><input name="provenance_couleur" type="text" id="provenance_couleur" value="<?php print(ma_htmlentities($provenance->couleur));?>" /></noscript>
                   <script language="javascript">CreerCouleur('provenance_couleur','<?php print($provenance->couleur);?>');</script></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="provenance_fiche_submit" id="provenance_fiche_submit" value="Enregistrer" />
                    <input type="submit" name="provenance_fiche_submit" id="provenance_fiche_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
