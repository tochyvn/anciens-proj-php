<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	if(isset($_REQUEST['adherent_recherche_submit']))
	{
		switch($_REQUEST['adherent_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('adherent_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['adherent_identifiant_valeur']) && $_REQUEST['adherent_identifiant_valeur']!='')
					$recherche[]='adherent.identifiant '.$_REQUEST['adherent_identifiant_operateur'].' \''.addslashes($_REQUEST['adherent_identifiant_valeur']).'\'';
				if(isset($_REQUEST['adherent_email_valeur']) && $_REQUEST['adherent_email_valeur']!='')
					$recherche[]='adherent.email '.$_REQUEST['adherent_email_operateur'].' \''.addslashes($_REQUEST['adherent_email_valeur']).'\'';
				if(isset($_REQUEST['adherent_code_valeur']) && $_REQUEST['adherent_code_valeur']!='')
					$recherche[]='adherent.code '.$_REQUEST['adherent_code_operateur'].' \''.addslashes($_REQUEST['adherent_code_valeur']).'\'';
				if(isset($_REQUEST['adherent_abonne_valeur']))
					$recherche[]='adherent.abonne in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['adherent_abonne_valeur'])).'\')';
				if(isset($_REQUEST['adherent_brule_valeur']))
					$recherche[]='adherent.brule in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['adherent_brule_valeur'])).'\')';
				if(isset($_REQUEST['adherent_spamtrap_valeur']))
					$recherche[]='adherent.spamtrap in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['adherent_spamtrap_valeur'])).'\')';
				if(sizeof($recherche))
					$_SESSION['adherent_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['adherent_recherche']='';
				header('location: '.url_use_trans_sid('adherent_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['adherent_recherche']))
			$_SESSION['adherent_recherche']='';
		
		$_REQUEST['adherent_identifiant_valeur']='';
		$_REQUEST['adherent_identifiant_operateur']='=';
		$_REQUEST['adherent_email_valeur']='';
		$_REQUEST['adherent_email_operateur']='=';
		$_REQUEST['adherent_code_valeur']='';
		$_REQUEST['adherent_code_operateur']='=';
		$_REQUEST['adherent_abonne_valeur']=array();
		$_REQUEST['adherent_brule_valeur']=array();
		$_REQUEST['adherent_spamtrap_valeur']=array();
		
		if(preg_match('/adherent\.identifiant (like|=) \'(.*)\'/',$_SESSION['adherent_recherche'],$recherche))
		{
			$_REQUEST['adherent_identifiant_valeur']=stripslashes($recherche[2]);
			$_REQUEST['adherent_identifiant_operateur']=$recherche[1];
		}
		if(preg_match('/adherent\.email (like|=) \'(.*)\'/',$_SESSION['adherent_recherche'],$recherche))
		{
			$_REQUEST['adherent_email_valeur']=stripslashes($recherche[2]);
			$_REQUEST['adherent_email_operateur']=$recherche[1];
		}
		if(preg_match('/adherent\.code (like|=) \'(.*)\'/',$_SESSION['adherent_recherche'],$recherche))
		{
			$_REQUEST['adherent_code_valeur']=stripslashes($recherche[2]);
			$_REQUEST['adherent_code_operateur']=$recherche[1];
		}
		if(preg_match('/adherent\.abonne in \(\'(.+)\'\)/',$_SESSION['adherent_recherche'],$recherche))
			$_REQUEST['adherent_abonne_valeur']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/adherent\.brule in \(\'(.+)\'\)/',$_SESSION['adherent_recherche'],$recherche))
			$_REQUEST['adherent_brule_valeur']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/adherent\.spamtrap in \(\'(.+)\'\)/',$_SESSION['adherent_recherche'],$recherche))
			$_REQUEST['adherent_spamtrap_valeur']=array_map('stripslashes',explode('\',\'',$recherche[1]));
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('adherent_identifiant_valeur');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des adh&eacute;rents </th>
        </tr>
        <tr>
          <td><form action="adherent_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><select name="adherent_identifiant_operateur" id="adherent_identifiant_operateur">
                    <option value="="<?php if($_REQUEST['adherent_identifiant_operateur']=='=') print(' selected="selected"');?>>=</option>
                    <option value="like"<?php if($_REQUEST['adherent_identifiant_operateur']=='like') print(' selected="selected"');?>>like</option>
                  </select></td>
                  <td><input name="adherent_identifiant_valeur" type="text" id="adherent_identifiant_valeur"  value="<?php print(ma_htmlentities($_REQUEST['adherent_identifiant_valeur']));?>" /></td>
                </tr>
                <tr>
                  <td>Email : </td>
                  <td><select name="adherent_email_operateur" id="adherent_email_operateur">
                    <option value="="<?php if($_REQUEST['adherent_email_operateur']=='=') print(' selected="selected"');?>>=</option>
                    <option value="like"<?php if($_REQUEST['adherent_email_operateur']=='like') print(' selected="selected"');?>>like</option>
                  </select></td>
                  <td><input name="adherent_email_valeur" type="text" id="adherent_email_valeur" value="<?php print(ma_htmlentities($_REQUEST['adherent_email_valeur']));?>" /></td>
                </tr>
                <tr>
                  <td>Code : </td>
                  <td><select name="adherent_code_operateur" id="adherent_code_operateur">
                    <option value="="<?php if($_REQUEST['adherent_code_operateur']=='=') print(' selected="selected"');?>>=</option>
                    <option value="like"<?php if($_REQUEST['adherent_code_operateur']=='like') print(' selected="selected"');?>>like</option>
                  </select></td>
                  <td><input name="adherent_code_valeur" type="text" id="adherent_code_valeur" value="<?php print(ma_htmlentities($_REQUEST['adherent_code_valeur']));?>" /></td>
                </tr>
                <tr>
                  <td>Abonn&eacute; : </td>
                  <td>&nbsp;</td>
                  <td><input name="adherent_abonne_valeur[]" type="checkbox" id="adherent_abonne_oui" value="OUI"<?php if(array_search('OUI',$_REQUEST['adherent_abonne_valeur'])!==false) print(' checked="checked"');?> />
                    <label for="adherent_abonne_oui">Oui</label>
                    <br />
                    <input name="adherent_abonne_valeur[]" type="checkbox" id="adherent_abonne_non" value="NON"<?php if(array_search('NON',$_REQUEST['adherent_abonne_valeur'])!==false) print(' checked="checked"');?> />
                    <label for="adherent_abonne_non">Non</label></td>
                </tr>
                <tr>
                  <td>Brul&eacute; : </td>
                  <td>&nbsp;</td>
                  <td><input name="adherent_brule_valeur[]" type="checkbox" id="adherent_brule_oui" value="OUI"<?php if(array_search('OUI',$_REQUEST['adherent_brule_valeur'])!==false) print(' checked="checked"');?> />
                    <label for="adherent_brule_oui">Oui</label>
                    <br />
                    <input name="adherent_brule_valeur[]" type="checkbox" id="adherent_brule_non" value="NON"<?php if(array_search('NON',$_REQUEST['adherent_brule_valeur'])!==false) print(' checked="checked"');?> />
                    <label for="adherent_brule_non">Non</label></td>
                </tr>
                <tr>
                  <td>Spamtrap : </td>
                  <td>&nbsp;</td>
                  <td><input name="adherent_spamtrap_valeur[]" type="checkbox" id="adherent_spamtrap_oui" value="OUI"<?php if(array_search('OUI',$_REQUEST['adherent_spamtrap_valeur'])!==false) print(' checked="checked"');?> />
                      <label for="adherent_spamtrap_oui">Oui</label>
                      <br />
                      <input name="adherent_spamtrap_valeur[]" type="checkbox" id="adherent_spamtrap_non" value="NON"<?php if(array_search('NON',$_REQUEST['adherent_spamtrap_valeur'])!==false) print(' checked="checked"');?> />
                      <label for="adherent_spamtrap_non">Non</label></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="adherent_recherche_submit" id="adherent_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
