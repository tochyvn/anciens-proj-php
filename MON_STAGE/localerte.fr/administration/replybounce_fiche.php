<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'replybounce.php');
	
	if(!isset($_REQUEST['replybounce_fiche_mode']) || $_REQUEST['replybounce_fiche_mode']!='modifier')
		$_REQUEST['replybounce_fiche_mode']='ajouter';
	if(!isset($_REQUEST['replybounce_identifiant']))
		$_REQUEST['replybounce_identifiant']='';
	
	$replybounce=new ld_replybounce();
	
	$replybounce_fiche_erreur=0;
	$replybounce_fiche_succes=0;
	
	if(isset($_REQUEST['replybounce_fiche_submit']))
	{
		if($_REQUEST['replybounce_fiche_mode']=='modifier')
		{
			$replybounce->identifiant=$_REQUEST['replybounce_identifiant'];
			$replybounce->nouveau_identifiant=$_REQUEST['replybounce_identifiant'];
		}
		else
		{
			$replybounce->identifiant='';
			$replybounce->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_replybounce','identifiant',REPLYBOUNCE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		}
		$replybounce->expression=$_REQUEST['replybounce_expression'];
		$replybounce->casse=$_REQUEST['replybounce_casse'];
		$replybounce->negatif=$_REQUEST['replybounce_negatif'];
		if(isset($_REQUEST['replybounce_endroit']))
			$replybounce->endroit=implode(',',$_REQUEST['replybounce_endroit']);
		else
			$replybounce->endroit=NULL;
		$replybounce->description=$_REQUEST['replybounce_description'];
		
		switch($_REQUEST['replybounce_fiche_submit'])
		{
			case 'Enregistrer':
				if($_REQUEST['replybounce_fiche_mode']=='modifier')
				{
					$replybounce_fiche_erreur=$replybounce->modifier();
					if(!$replybounce_fiche_erreur)
						$replybounce_fiche_succes=FICHE_SUCCES_MODIFIER;
				}
				else
				{
					$replybounce_fiche_erreur=$replybounce->ajouter();
					if(!$replybounce_fiche_erreur)
					{
						$_REQUEST['replybounce_fiche_mode']='modifier';
						$replybounce_fiche_succes=FICHE_SUCCES_AJOUTER;
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('replybounce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		$replybounce->identifiant=$_REQUEST['replybounce_identifiant'];
		if(!$replybounce->lire())
			$_REQUEST['replybounce_fiche_mode']='ajouter';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('replybounce_expression');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th><?php print(($_REQUEST['replybounce_fiche_mode']=='modifier')?('Modifier'):('Ajouter'));?> un replybounce</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['replybounce_fiche_submit']))
	{
		if($replybounce_fiche_erreur & REPLYBOUNCE_EXPRESSION_ERREUR_LONGUEUR || $replybounce_fiche_erreur & REPLYBOUNCE_EXPRESSION_ERREUR_PATTERN) print('L\'expression n\'est pas valide<br />');
		if($replybounce_fiche_erreur & REPLYBOUNCE_CASSE_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre sensible &agrave; la casse<br />');
		if($replybounce_fiche_erreur & REPLYBOUNCE_NEGATIF_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre recherch&eacute;e n&eacute;gativement<br />');
		if($replybounce_fiche_erreur & REPLYBOUNCE_ENDROIT_ERREUR) print('Choisissez l\'endoit de recherche<br />');
		if($replybounce_fiche_erreur & REPLYBOUNCE_DESCRIPTION_ERREUR) print('La d&eacute;scription doit &ecirc;tre comprise entre '.ma_htmlentities(REPLYBOUNCE_DESCRIPTION_MIN).' et '.ma_htmlentities(REPLYBOUNCE_DESCRIPTION_MAX).' caract&egrave;res<br />');
		if($replybounce_fiche_succes & FICHE_SUCCES_AJOUTER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;<br />');
		if($replybounce_fiche_succes & FICHE_SUCCES_MODIFIER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="replybounce_fiche.php" method="post" enctype="multipart/form-data" id="formulaire">
              <input type="hidden" name="replybounce_identifiant" id="replybounce_identifiant" value="<?php print(ma_htmlentities($replybounce->identifiant));?>" />
              <input type="hidden" name="replybounce_fiche_mode" id="replybounce_fiche_mode" value="<?php print(ma_htmlentities($_REQUEST['replybounce_fiche_mode']));?>" />
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><?php print(ma_htmlentities($replybounce->identifiant));?></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['replybounce_fiche_submit']) && ($replybounce_fiche_erreur & REPLYBOUNCE_EXPRESSION_ERREUR_LONGUEUR || $replybounce_fiche_erreur & REPLYBOUNCE_EXPRESSION_ERREUR_PATTERN)) print(' class="important"');?>>Expression : </td>
                  <td><input name="replybounce_expression" type="text" id="replybounce_expression" value="<?php print(ma_htmlentities($replybounce->expression));?>" maxlength="<?php print(ma_htmlentities(REPLYBOUNCE_EXPRESSION_MAX))?>" />
                    <script>document.write(' <a href="" onclick="document.getElementById(\'replybounce_expression\').value=EncapsulerPattern(document.getElementById(\'replybounce_expression\').value); return false;">Encapsuler</a>');</script>
                    <script>document.write(' <a href="" onclick="document.getElementById(\'replybounce_expression\').value=FormaterPattern(document.getElementById(\'replybounce_expression\').value); return false;">Formater</a>');</script>
                    <script>document.write(' <a href="" onclick="VerifierPattern(document.getElementById(\'replybounce_expression\').value,true); return false;">V&eacute;rifier</a>');</script></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['replybounce_fiche_submit']) && $replybounce_fiche_erreur & REPLYBOUNCE_CASSE_ERREUR) print(' class="important"');?>>Casse : </td>
                  <td><input name="replybounce_casse" type="radio" id="replybounce_casse_sensible" value="SENSIBLE"<?php if($replybounce->casse=='SENSIBLE') print(' checked="checked"');?> />
                    <label for="replybounce_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="replybounce_casse" type="radio" id="replybounce_casse_insensible" value="INSENSIBLE"<?php if($replybounce->casse=='INSENSIBLE') print(' checked="checked"');?> />
                    <label for="replybounce_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['replybounce_fiche_submit']) && $replybounce_fiche_erreur & REPLYBOUNCE_NEGATIF_ERREUR) print(' class="important"');?>>N&eacute;gatif : </td>
                  <td><input name="replybounce_negatif" type="radio" id="replybounce_negatif_oui" value="OUI"<?php if($replybounce->negatif=='OUI') print(' checked="checked"');?> />
                    <label for="replybounce_negatif_oui">OUI</label>
                    <br />
                    <input name="replybounce_negatif" type="radio" id="replybounce_negatif_non" value="NON"<?php if($replybounce->negatif=='NON') print(' checked="checked"');?> />
                    <label for="replybounce_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['replybounce_fiche_submit']) && $replybounce_fiche_erreur & REPLYBOUNCE_ENDROIT_ERREUR) print(' class="important"');?>>Endroit : </td>
                  <td><input name="replybounce_endroit[]" type="checkbox" id="replybounce_endroit_entete" value="ENTETE"<?php if(array_search('ENTETE',explode(',',$replybounce->endroit))!==false) print(' checked="checked"');?> />
                    <label for="replybounce_endroit_entete">ENTETE</label>
                    <br />
                    <input name="replybounce_endroit[]" type="checkbox" id="replybounce_endroit_corps" value="CORPS"<?php if(array_search('CORPS',explode(',',$replybounce->endroit))!==false) print(' checked="checked"');?> />
                    <label for="replybounce_endroit_corps">CORPS</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['replybounce_fiche_submit']) && $replybounce_fiche_erreur & REPLYBOUNCE_DESCRIPTION_ERREUR) print(' class="important"');?>>D&eacute;scription : </td>
                  <td><input name="replybounce_description" type="text" id="replybounce_description" value="<?php print(ma_htmlentities($replybounce->description));?>" maxlength="<?php print(ma_htmlentities(REPLYBOUNCE_DESCRIPTION_MAX))?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="replybounce_fiche_submit" id="replybounce_fiche_submit" value="Enregistrer" />
                    <input type="submit" name="replybounce_fiche_submit" id="replybounce_fiche_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
