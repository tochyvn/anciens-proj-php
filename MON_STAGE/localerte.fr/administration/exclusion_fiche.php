<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'exclusion.php');
	
	if(!isset($_REQUEST['exclusion_fiche_mode']) || $_REQUEST['exclusion_fiche_mode']!='modifier')
		$_REQUEST['exclusion_fiche_mode']='ajouter';
	if(!isset($_REQUEST['exclusion_identifiant']))
		$_REQUEST['exclusion_identifiant']='';
	
	$exclusion=new ld_exclusion();
	
	$exclusion_fiche_erreur=0;
	$exclusion_fiche_succes=0;
	$exclusion_fiche_compter=NULL;
	
	if(isset($_REQUEST['exclusion_fiche_submit']))
	{
		if($_REQUEST['exclusion_fiche_mode']=='modifier')
		{
			$exclusion->identifiant=$_REQUEST['exclusion_identifiant'];
			$exclusion->nouveau_identifiant=$_REQUEST['exclusion_identifiant'];
		}
		else
		{
			$exclusion->identifiant='';
			$exclusion->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_exclusion','identifiant',EXCLUSION_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		}
		$exclusion->expression=$_REQUEST['exclusion_expression'];
		$exclusion->casse=$_REQUEST['exclusion_casse'];
		$exclusion->negatif=$_REQUEST['exclusion_negatif'];
		$exclusion->description=$_REQUEST['exclusion_description'];
		
		switch($_REQUEST['exclusion_fiche_submit'])
		{
			case 'Compter':
				$exclusion_fiche_compter=$exclusion->compter();
				break;
			case 'Enregistrer':
				if($_REQUEST['exclusion_fiche_mode']=='modifier')
				{
					$exclusion_fiche_erreur=$exclusion->modifier();
					if(!$exclusion_fiche_erreur)
						$exclusion_fiche_succes=FICHE_SUCCES_MODIFIER;
				}
				else
				{
					$exclusion_fiche_erreur=$exclusion->ajouter();
					if(!$exclusion_fiche_erreur)
					{
						$_REQUEST['exclusion_fiche_mode']='modifier';
						$exclusion_fiche_succes=FICHE_SUCCES_AJOUTER;
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('exclusion_liste.php'));
				die();
				break;
		}
	}
	else
	{
		$exclusion->identifiant=$_REQUEST['exclusion_identifiant'];
		if(!$exclusion->lire())
			$_REQUEST['exclusion_fiche_mode']='ajouter';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('exclusion_expression');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th><?php print(($_REQUEST['exclusion_fiche_mode']=='modifier')?('Modifier'):('Ajouter'));?> un exclusion</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['exclusion_fiche_submit']))
	{
		if($exclusion_fiche_erreur & EXCLUSION_EXPRESSION_ERREUR_LONGUEUR || $exclusion_fiche_erreur & EXCLUSION_EXPRESSION_ERREUR_PATTERN) print('L\'expression n\'est pas valide<br />');
		if($exclusion_fiche_erreur & EXCLUSION_CASSE_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre sensible &agrave; la casse<br />');
		if($exclusion_fiche_erreur & EXCLUSION_NEGATIF_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre recherch&eacute;e n&eacute;gativement<br />');
		if($exclusion_fiche_erreur & EXCLUSION_DESCRIPTION_ERREUR) print('La d&eacute;scription doit &ecirc;tre comprise entre '.ma_htmlentities(EXCLUSION_DESCRIPTION_MIN).' et '.ma_htmlentities(EXCLUSION_DESCRIPTION_MAX).' caract&egrave;res<br />');
		if($exclusion_fiche_succes & FICHE_SUCCES_AJOUTER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;<br />');
		if($exclusion_fiche_succes & FICHE_SUCCES_MODIFIER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;<br />');
		if($exclusion_fiche_compter!==NULL) print($exclusion_fiche_compter.' annonce(s) concern&eacute;e(s)<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="exclusion_fiche.php" method="post" enctype="multipart/form-data" id="formulaire">
              <input type="hidden" name="exclusion_identifiant" id="exclusion_identifiant" value="<?php print(ma_htmlentities($exclusion->identifiant));?>" />
              <input type="hidden" name="exclusion_fiche_mode" id="exclusion_fiche_mode" value="<?php print(ma_htmlentities($_REQUEST['exclusion_fiche_mode']));?>" />
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><?php print(ma_htmlentities($exclusion->identifiant));?></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['exclusion_fiche_submit']) && ($exclusion_fiche_erreur & EXCLUSION_EXPRESSION_ERREUR_LONGUEUR || $exclusion_fiche_erreur & EXCLUSION_EXPRESSION_ERREUR_PATTERN)) print(' class="important"');?>>Expression : </td>
                  <td><input name="exclusion_expression" type="text" id="exclusion_expression" value="<?php print(ma_htmlentities($exclusion->expression));?>" maxlength="<?php print(ma_htmlentities(EXCLUSION_EXPRESSION_MAX))?>" />
                    <script>document.write(' <a href="" onclick="document.getElementById(\'exclusion_expression\').value=EncapsulerPattern(document.getElementById(\'exclusion_expression\').value); return false;">Encapsuler</a>');</script>
                    <script>document.write(' <a href="" onclick="document.getElementById(\'exclusion_expression\').value=FormaterPattern(document.getElementById(\'exclusion_expression\').value); return false;">Formater</a>');</script>
                    <script>document.write(' <a href="" onclick="VerifierPattern(document.getElementById(\'exclusion_expression\').value,true); return false;">V&eacute;rifier</a>');</script></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['exclusion_fiche_submit']) && $exclusion_fiche_erreur & EXCLUSION_CASSE_ERREUR) print(' class="important"');?>>Casse : </td>
                  <td><input name="exclusion_casse" type="radio" id="exclusion_casse_sensible" value="SENSIBLE"<?php if($exclusion->casse=='SENSIBLE') print(' checked="checked"');?> />
                    <label for="exclusion_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="exclusion_casse" type="radio" id="exclusion_casse_insensible" value="INSENSIBLE"<?php if($exclusion->casse=='INSENSIBLE') print(' checked="checked"');?> />
                    <label for="exclusion_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['exclusion_fiche_submit']) && $exclusion_fiche_erreur & EXCLUSION_CASSE_ERREUR) print(' class="important"');?>>N&eacute;gatif : </td>
                  <td><input name="exclusion_negatif" type="radio" id="exclusion_negatif_oui" value="OUI"<?php if($exclusion->negatif=='OUI') print(' checked="checked"');?> />
                    <label for="exclusion_negatif_oui">OUI</label>
                    <br />
                    <input name="exclusion_negatif" type="radio" id="exclusion_negatif_non" value="NON"<?php if($exclusion->negatif=='NON') print(' checked="checked"');?> />
                    <label for="exclusion_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['exclusion_fiche_submit']) && $exclusion_fiche_erreur & EXCLUSION_DESCRIPTION_ERREUR) print(' class="important"');?>>D&eacute;scription : </td>
                  <td><input name="exclusion_description" type="text" id="exclusion_description" value="<?php print(ma_htmlentities($exclusion->description));?>" maxlength="<?php print(ma_htmlentities(EXCLUSION_DESCRIPTION_MAX))?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="exclusion_fiche_submit" id="exclusion_fiche_submit" value="Enregistrer" />
                    <input type="submit" name="exclusion_fiche_submit" id="exclusion_fiche_submit" value="Compter" />
                    <input type="submit" name="exclusion_fiche_submit" id="exclusion_fiche_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
