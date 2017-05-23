<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'hardbounce.php');
	
	if(!isset($_REQUEST['hardbounce_fiche_mode']) || $_REQUEST['hardbounce_fiche_mode']!='modifier')
		$_REQUEST['hardbounce_fiche_mode']='ajouter';
	if(!isset($_REQUEST['hardbounce_identifiant']))
		$_REQUEST['hardbounce_identifiant']='';
	
	$hardbounce=new ld_hardbounce();
	
	$hardbounce_fiche_erreur=0;
	$hardbounce_fiche_succes=0;
	
	if(isset($_REQUEST['hardbounce_fiche_submit']))
	{
		if($_REQUEST['hardbounce_fiche_mode']=='modifier')
		{
			$hardbounce->identifiant=$_REQUEST['hardbounce_identifiant'];
			$hardbounce->nouveau_identifiant=$_REQUEST['hardbounce_identifiant'];
		}
		else
		{
			$hardbounce->identifiant='';
			$hardbounce->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_hardbounce','identifiant',HARDBOUNCE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		}
		$hardbounce->expression=$_REQUEST['hardbounce_expression'];
		$hardbounce->casse=$_REQUEST['hardbounce_casse'];
		$hardbounce->negatif=$_REQUEST['hardbounce_negatif'];
		$hardbounce->description=$_REQUEST['hardbounce_description'];
		
		switch($_REQUEST['hardbounce_fiche_submit'])
		{
			case 'Enregistrer':
				if($_REQUEST['hardbounce_fiche_mode']=='modifier')
				{
					$hardbounce_fiche_erreur=$hardbounce->modifier();
					if(!$hardbounce_fiche_erreur)
						$hardbounce_fiche_succes=FICHE_SUCCES_MODIFIER;
				}
				else
				{
					$hardbounce_fiche_erreur=$hardbounce->ajouter();
					if(!$hardbounce_fiche_erreur)
					{
						$_REQUEST['hardbounce_fiche_mode']='modifier';
						$hardbounce_fiche_succes=FICHE_SUCCES_AJOUTER;
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('hardbounce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		$hardbounce->identifiant=$_REQUEST['hardbounce_identifiant'];
		if(!$hardbounce->lire())
			$_REQUEST['hardbounce_fiche_mode']='ajouter';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('hardbounce_expression');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th><?php print(($_REQUEST['hardbounce_fiche_mode']=='modifier')?('Modifier'):('Ajouter'));?> un hardbounce</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['hardbounce_fiche_submit']))
	{
		if($hardbounce_fiche_erreur & HARDBOUNCE_EXPRESSION_ERREUR_LONGUEUR || $hardbounce_fiche_erreur & HARDBOUNCE_EXPRESSION_ERREUR_PATTERN) print('L\'expression n\'est pas valide<br />');
		if($hardbounce_fiche_erreur & HARDBOUNCE_CASSE_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre sensible &agrave; la casse<br />');
		if($hardbounce_fiche_erreur & HARDBOUNCE_NEGATIF_ERREUR) print('Choisissez si l\'expression doit &ecirc;tre recherch&eacute;e n&eacute;gativement<br />');
		if($hardbounce_fiche_erreur & HARDBOUNCE_DESCRIPTION_ERREUR) print('La d&eacute;scription doit &ecirc;tre comprise entre '.ma_htmlentities(HARDBOUNCE_DESCRIPTION_MIN).' et '.ma_htmlentities(HARDBOUNCE_DESCRIPTION_MAX).' caract&egrave;res<br />');
		if($hardbounce_fiche_succes & FICHE_SUCCES_AJOUTER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;<br />');
		if($hardbounce_fiche_succes & FICHE_SUCCES_MODIFIER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="hardbounce_fiche.php" method="post" enctype="multipart/form-data" id="formulaire">
              <input type="hidden" name="hardbounce_identifiant" id="hardbounce_identifiant" value="<?php print(ma_htmlentities($hardbounce->identifiant));?>" />
              <input type="hidden" name="hardbounce_fiche_mode" id="hardbounce_fiche_mode" value="<?php print(ma_htmlentities($_REQUEST['hardbounce_fiche_mode']));?>" />
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><?php print(ma_htmlentities($hardbounce->identifiant));?></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['hardbounce_fiche_submit']) && ($hardbounce_fiche_erreur & HARDBOUNCE_EXPRESSION_ERREUR_LONGUEUR || $hardbounce_fiche_erreur & HARDBOUNCE_EXPRESSION_ERREUR_PATTERN)) print(' class="important"');?>>Expression : </td>
                  <td><input name="hardbounce_expression" type="text" id="hardbounce_expression" value="<?php print(ma_htmlentities($hardbounce->expression));?>" maxlength="<?php print(ma_htmlentities(HARDBOUNCE_EXPRESSION_MAX))?>" />
                    <script>document.write(' <a href="" onclick="document.getElementById(\'hardbounce_expression\').value=EncapsulerPattern(document.getElementById(\'hardbounce_expression\').value); return false;">Encapsuler</a>');</script>
                    <script>document.write(' <a href="" onclick="document.getElementById(\'hardbounce_expression\').value=FormaterPattern(document.getElementById(\'hardbounce_expression\').value); return false;">Formater</a>');</script>
                    <script>document.write(' <a href="" onclick="VerifierPattern(document.getElementById(\'hardbounce_expression\').value,true); return false;">V&eacute;rifier</a>');</script></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['hardbounce_fiche_submit']) && $hardbounce_fiche_erreur & HARDBOUNCE_CASSE_ERREUR) print(' class="important"');?>>Casse : </td>
                  <td><input name="hardbounce_casse" type="radio" id="hardbounce_casse_sensible" value="SENSIBLE"<?php if($hardbounce->casse=='SENSIBLE') print(' checked="checked"');?> />
                    <label for="hardbounce_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="hardbounce_casse" type="radio" id="hardbounce_casse_insensible" value="INSENSIBLE"<?php if($hardbounce->casse=='INSENSIBLE') print(' checked="checked"');?> />
                    <label for="hardbounce_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['hardbounce_fiche_submit']) && $hardbounce_fiche_erreur & HARDBOUNCE_NEGATIF_ERREUR) print(' class="important"');?>>N&eacute;gatif : </td>
                  <td><input name="hardbounce_negatif" type="radio" id="hardbounce_negatif_oui" value="OUI"<?php if($hardbounce->negatif=='OUI') print(' checked="checked"');?> />
                    <label for="hardbounce_negatif_oui">OUI</label>
                    <br />
                    <input name="hardbounce_negatif" type="radio" id="hardbounce_negatif_non" value="NON"<?php if($hardbounce->negatif=='NON') print(' checked="checked"');?> />
                    <label for="hardbounce_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['hardbounce_fiche_submit']) && $hardbounce_fiche_erreur & HARDBOUNCE_DESCRIPTION_ERREUR) print(' class="important"');?>>D&eacute;scription : </td>
                  <td><input name="hardbounce_description" type="text" id="hardbounce_description" value="<?php print(ma_htmlentities($hardbounce->description));?>" maxlength="<?php print(ma_htmlentities(HARDBOUNCE_DESCRIPTION_MAX))?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="hardbounce_fiche_submit" id="hardbounce_fiche_submit" value="Enregistrer" />
                    <input type="submit" name="hardbounce_fiche_submit" id="hardbounce_fiche_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
