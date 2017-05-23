<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'softbounce.php');
	
	if(!isset($_REQUEST['softbounce_fiche_mode']) || $_REQUEST['softbounce_fiche_mode']!='modifier')
		$_REQUEST['softbounce_fiche_mode']='ajouter';
	if(!isset($_REQUEST['softbounce_identifiant']))
		$_REQUEST['softbounce_identifiant']='';
	
	$softbounce=new ld_softbounce();
	
	$softbounce_fiche_erreur=0;
	$softbounce_fiche_succes=0;
	
	if(isset($_REQUEST['softbounce_fiche_submit']))
	{
		if($_REQUEST['softbounce_fiche_mode']=='modifier')
		{
			$softbounce->identifiant=$_REQUEST['softbounce_identifiant'];
			$softbounce->nouveau_identifiant=$_REQUEST['softbounce_identifiant'];
		}
		else
		{
			$softbounce->identifiant='';
			$softbounce->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_softbounce','identifiant',SOFTBOUNCE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		}
		$softbounce->expression=$_REQUEST['softbounce_expression'];
		$softbounce->casse=$_REQUEST['softbounce_casse'];
		$softbounce->negatif=$_REQUEST['softbounce_negatif'];
		$softbounce->description=$_REQUEST['softbounce_description'];
		
		switch($_REQUEST['softbounce_fiche_submit'])
		{
			case 'Enregistrer':
				if($_REQUEST['softbounce_fiche_mode']=='modifier')
				{
					$softbounce_fiche_erreur=$softbounce->modifier();
					if(!$softbounce_fiche_erreur)
						$softbounce_fiche_succes=FICHE_SUCCES_MODIFIER;
				}
				else
				{
					$softbounce_fiche_erreur=$softbounce->ajouter();
					if(!$softbounce_fiche_erreur)
					{
						$_REQUEST['softbounce_fiche_mode']='modifier';
						$softbounce_fiche_succes=FICHE_SUCCES_AJOUTER;
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('softbounce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		$softbounce->identifiant=$_REQUEST['softbounce_identifiant'];
		if(!$softbounce->lire())
			$_REQUEST['softbounce_fiche_mode']='ajouter';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('softbounce_expression');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th><?php print(($_REQUEST['softbounce_fiche_mode']=='modifier')?('Modifier'):('Ajouter'));?> un softbounce</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['softbounce_fiche_submit']))
	{
		if($softbounce_fiche_erreur & SOFTBOUNCE_EXPRESSION_ERREUR_LONGUEUR || $softbounce_fiche_erreur & SOFTBOUNCE_EXPRESSION_ERREUR_PATTERN) print('L\'expression n\'est pas valide<br />');
		if($softbounce_fiche_erreur & SOFTBOUNCE_CASSE_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre sensible &agrave; la casse<br />');
		if($softbounce_fiche_erreur & SOFTBOUNCE_NEGATIF_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre recherch&eacute;e n&eacute;gativement<br />');
		if($softbounce_fiche_erreur & SOFTBOUNCE_DESCRIPTION_ERREUR) print('La d&eacute;scription doit &ecirc;tre comprise entre '.ma_htmlentities(SOFTBOUNCE_DESCRIPTION_MIN).' et '.ma_htmlentities(SOFTBOUNCE_DESCRIPTION_MAX).' caract&egrave;res<br />');
		if($softbounce_fiche_succes & FICHE_SUCCES_AJOUTER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;<br />');
		if($softbounce_fiche_succes & FICHE_SUCCES_MODIFIER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="softbounce_fiche.php" method="post" enctype="multipart/form-data" id="formulaire">
              <input type="hidden" name="softbounce_identifiant" id="softbounce_identifiant" value="<?php print(ma_htmlentities($softbounce->identifiant));?>" />
              <input type="hidden" name="softbounce_fiche_mode" id="softbounce_fiche_mode" value="<?php print(ma_htmlentities($_REQUEST['softbounce_fiche_mode']));?>" />
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><?php print(ma_htmlentities($softbounce->identifiant));?></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['softbounce_fiche_submit']) && ($softbounce_fiche_erreur & SOFTBOUNCE_EXPRESSION_ERREUR_LONGUEUR || $softbounce_fiche_erreur & SOFTBOUNCE_EXPRESSION_ERREUR_PATTERN)) print(' class="important"');?>>Expression : </td>
                  <td><input name="softbounce_expression" type="text" id="softbounce_expression" value="<?php print(ma_htmlentities($softbounce->expression));?>" maxlength="<?php print(ma_htmlentities(SOFTBOUNCE_EXPRESSION_MAX))?>" />
                    <script>document.write(' <a href="" onclick="document.getElementById(\'softbounce_expression\').value=EncapsulerPattern(document.getElementById(\'softbounce_expression\').value); return false;">Encapsuler</a>');</script>
                    <script>document.write(' <a href="" onclick="document.getElementById(\'softbounce_expression\').value=FormaterPattern(document.getElementById(\'softbounce_expression\').value); return false;">Formater</a>');</script>
                    <script>document.write(' <a href="" onclick="VerifierPattern(document.getElementById(\'softbounce_expression\').value,true); return false;">V&eacute;rifier</a>');</script></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['softbounce_fiche_submit']) && $softbounce_fiche_erreur & SOFTBOUNCE_CASSE_ERREUR) print(' class="important"');?>>Casse : </td>
                  <td><input name="softbounce_casse" type="radio" id="softbounce_casse_sensible" value="SENSIBLE"<?php if($softbounce->casse=='SENSIBLE') print(' checked="checked"');?> />
                    <label for="softbounce_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="softbounce_casse" type="radio" id="softbounce_casse_insensible" value="INSENSIBLE"<?php if($softbounce->casse=='INSENSIBLE') print(' checked="checked"');?> />
                    <label for="softbounce_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['softbounce_fiche_submit']) && $softbounce_fiche_erreur & SOFTBOUNCE_NEGATIF_ERREUR) print(' class="important"');?>>N&eacute;gatif : </td>
                  <td><input name="softbounce_negatif" type="radio" id="softbounce_negatif_oui" value="OUI"<?php if($softbounce->negatif=='OUI') print(' checked="checked"');?> />
                    <label for="softbounce_negatif_oui">OUI</label>
                    <br />
                    <input name="softbounce_negatif" type="radio" id="softbounce_negatif_non" value="NON"<?php if($softbounce->negatif=='NON') print(' checked="checked"');?> />
                    <label for="softbounce_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['softbounce_fiche_submit']) && $softbounce_fiche_erreur & SOFTBOUNCE_DESCRIPTION_ERREUR) print(' class="important"');?>>D&eacute;scription : </td>
                  <td><input name="softbounce_description" type="text" id="softbounce_description" value="<?php print(ma_htmlentities($softbounce->description));?>" maxlength="<?php print(ma_htmlentities(SOFTBOUNCE_DESCRIPTION_MAX))?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="softbounce_fiche_submit" id="softbounce_fiche_submit" value="Enregistrer" />
                    <input type="submit" name="softbounce_fiche_submit" id="softbounce_fiche_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
