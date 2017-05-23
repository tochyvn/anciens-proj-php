<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'unscribebounce.php');
	
	if(!isset($_REQUEST['unscribebounce_fiche_mode']) || $_REQUEST['unscribebounce_fiche_mode']!='modifier')
		$_REQUEST['unscribebounce_fiche_mode']='ajouter';
	if(!isset($_REQUEST['unscribebounce_identifiant']))
		$_REQUEST['unscribebounce_identifiant']='';
	
	$unscribebounce=new ld_unscribebounce();
	
	$unscribebounce_fiche_erreur=0;
	$unscribebounce_fiche_succes=0;
	
	if(isset($_REQUEST['unscribebounce_fiche_submit']))
	{
		if($_REQUEST['unscribebounce_fiche_mode']=='modifier')
		{
			$unscribebounce->identifiant=$_REQUEST['unscribebounce_identifiant'];
			$unscribebounce->nouveau_identifiant=$_REQUEST['unscribebounce_identifiant'];
		}
		else
		{
			$unscribebounce->identifiant='';
			$unscribebounce->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_unscribebounce','identifiant',UNSCRIBEBOUNCE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		}
		$unscribebounce->expression=$_REQUEST['unscribebounce_expression'];
		$unscribebounce->casse=$_REQUEST['unscribebounce_casse'];
		$unscribebounce->negatif=$_REQUEST['unscribebounce_negatif'];
		if(isset($_REQUEST['unscribebounce_endroit']))
			$unscribebounce->endroit=implode(',',$_REQUEST['unscribebounce_endroit']);
		else
			$unscribebounce->endroit=NULL;
		$unscribebounce->description=$_REQUEST['unscribebounce_description'];
		
		switch($_REQUEST['unscribebounce_fiche_submit'])
		{
			case 'Enregistrer':
				if($_REQUEST['unscribebounce_fiche_mode']=='modifier')
				{
					$unscribebounce_fiche_erreur=$unscribebounce->modifier();
					if(!$unscribebounce_fiche_erreur)
						$unscribebounce_fiche_succes=FICHE_SUCCES_MODIFIER;
				}
				else
				{
					$unscribebounce_fiche_erreur=$unscribebounce->ajouter();
					if(!$unscribebounce_fiche_erreur)
					{
						$_REQUEST['unscribebounce_fiche_mode']='modifier';
						$unscribebounce_fiche_succes=FICHE_SUCCES_AJOUTER;
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('unscribebounce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		$unscribebounce->identifiant=$_REQUEST['unscribebounce_identifiant'];
		if(!$unscribebounce->lire())
			$_REQUEST['unscribebounce_fiche_mode']='ajouter';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('unscribebounce_expression');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th><?php print(($_REQUEST['unscribebounce_fiche_mode']=='modifier')?('Modifier'):('Ajouter'));?> un unscribebounce</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['unscribebounce_fiche_submit']))
	{
		if($unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_EXPRESSION_ERREUR_LONGUEUR || $unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_EXPRESSION_ERREUR_PATTERN) print('L\'expression n\'est pas valide<br />');
		if($unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_CASSE_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre sensible &agrave; la casse<br />');
		if($unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_NEGATIF_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre recherch&eacute;e n&eacute;gativement<br />');
		if($unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_ENDROIT_ERREUR) print('Choisissez l\'endoit de recherche<br />');
		if($unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_DESCRIPTION_ERREUR) print('La d&eacute;scription doit &ecirc;tre comprise entre '.ma_htmlentities(UNSCRIBEBOUNCE_DESCRIPTION_MIN).' et '.ma_htmlentities(UNSCRIBEBOUNCE_DESCRIPTION_MAX).' caract&egrave;res<br />');
		if($unscribebounce_fiche_succes & FICHE_SUCCES_AJOUTER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;<br />');
		if($unscribebounce_fiche_succes & FICHE_SUCCES_MODIFIER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="unscribebounce_fiche.php" method="post" enctype="multipart/form-data" id="formulaire">
              <input type="hidden" name="unscribebounce_identifiant" id="unscribebounce_identifiant" value="<?php print(ma_htmlentities($unscribebounce->identifiant));?>" />
              <input type="hidden" name="unscribebounce_fiche_mode" id="unscribebounce_fiche_mode" value="<?php print(ma_htmlentities($_REQUEST['unscribebounce_fiche_mode']));?>" />
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><?php print(ma_htmlentities($unscribebounce->identifiant));?></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['unscribebounce_fiche_submit']) && ($unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_EXPRESSION_ERREUR_LONGUEUR || $unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_EXPRESSION_ERREUR_PATTERN)) print(' class="important"');?>>Expression : </td>
                  <td><input name="unscribebounce_expression" type="text" id="unscribebounce_expression" value="<?php print(ma_htmlentities($unscribebounce->expression));?>" maxlength="<?php print(ma_htmlentities(UNSCRIBEBOUNCE_EXPRESSION_MAX))?>" />
                    <script>document.write(' <a href="" onclick="document.getElementById(\'unscribebounce_expression\').value=EncapsulerPattern(document.getElementById(\'unscribebounce_expression\').value); return false;">Encapsuler</a>');</script>
                    <script>document.write(' <a href="" onclick="document.getElementById(\'unscribebounce_expression\').value=FormaterPattern(document.getElementById(\'unscribebounce_expression\').value); return false;">Formater</a>');</script>
                    <script>document.write(' <a href="" onclick="VerifierPattern(document.getElementById(\'unscribebounce_expression\').value,true); return false;">V&eacute;rifier</a>');</script></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['unscribebounce_fiche_submit']) && $unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_CASSE_ERREUR) print(' class="important"');?>>Casse : </td>
                  <td><input name="unscribebounce_casse" type="radio" id="unscribebounce_casse_sensible" value="SENSIBLE"<?php if($unscribebounce->casse=='SENSIBLE') print(' checked="checked"');?> />
                    <label for="unscribebounce_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="unscribebounce_casse" type="radio" id="unscribebounce_casse_insensible" value="INSENSIBLE"<?php if($unscribebounce->casse=='INSENSIBLE') print(' checked="checked"');?> />
                    <label for="unscribebounce_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['unscribebounce_fiche_submit']) && $unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_NEGATIF_ERREUR) print(' class="important"');?>>N&eacute;gatif : </td>
                  <td><input name="unscribebounce_negatif" type="radio" id="unscribebounce_negatif_oui" value="OUI"<?php if($unscribebounce->negatif=='OUI') print(' checked="checked"');?> />
                    <label for="unscribebounce_negatif_oui">OUI</label>
                    <br />
                    <input name="unscribebounce_negatif" type="radio" id="unscribebounce_negatif_non" value="NON"<?php if($unscribebounce->negatif=='NON') print(' checked="checked"');?> />
                    <label for="unscribebounce_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['unscribebounce_fiche_submit']) && $unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_ENDROIT_ERREUR) print(' class="important"');?>>Endroit : </td>
                  <td><input name="unscribebounce_endroit[]" type="checkbox" id="unscribebounce_endroit_entete" value="ENTETE"<?php if(array_search('ENTETE',explode(',',$unscribebounce->endroit))!==false) print(' checked="checked"');?> />
                    <label for="unscribebounce_endroit_entete">ENTETE</label>
                    <br />
                    <input name="unscribebounce_endroit[]" type="checkbox" id="unscribebounce_endroit_corps" value="CORPS"<?php if(array_search('CORPS',explode(',',$unscribebounce->endroit))!==false) print(' checked="checked"');?> />
                    <label for="unscribebounce_endroit_corps">CORPS</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['unscribebounce_fiche_submit']) && $unscribebounce_fiche_erreur & UNSCRIBEBOUNCE_DESCRIPTION_ERREUR) print(' class="important"');?>>D&eacute;scription : </td>
                  <td><input name="unscribebounce_description" type="text" id="unscribebounce_description" value="<?php print(ma_htmlentities($unscribebounce->description));?>" maxlength="<?php print(ma_htmlentities(UNSCRIBEBOUNCE_DESCRIPTION_MAX))?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="unscribebounce_fiche_submit" id="unscribebounce_fiche_submit" value="Enregistrer" />
                    <input type="submit" name="unscribebounce_fiche_submit" id="unscribebounce_fiche_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
