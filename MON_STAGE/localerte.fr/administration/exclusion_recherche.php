<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	if(isset($_REQUEST['exclusion_recherche_submit']))
	{
		switch($_REQUEST['exclusion_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('exclusion_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['exclusion_identifiant']) && $_REQUEST['exclusion_identifiant']!='')
					$recherche[]='exclusion.identifiant like \''.addslashes($_REQUEST['exclusion_identifiant']).'\'';
				if(isset($_REQUEST['exclusion_expression']) && $_REQUEST['exclusion_expression']!='')
					$recherche[]='exclusion.expression like \''.addslashes($_REQUEST['exclusion_expression']).'\'';
				if(isset($_REQUEST['exclusion_casse']))
					$recherche[]='exclusion.casse in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['exclusion_casse'])).'\')';
				if(isset($_REQUEST['exclusion_negatif']))
					$recherche[]='exclusion.negatif in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['exclusion_negatif'])).'\')';
				if(isset($_REQUEST['exclusion_description']) && $_REQUEST['exclusion_description']!='')
					$recherche[]='exclusion.description like \''.addslashes($_REQUEST['exclusion_description']).'\'';
				if(sizeof($recherche))
					$_SESSION['exclusion_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['exclusion_recherche']='';
				header('location: '.url_use_trans_sid('exclusion_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['exclusion_recherche']))
			$_SESSION['exclusion_recherche']='';
		
		$_REQUEST['exclusion_identifiant']='';
		$_REQUEST['exclusion_expression']='';
		$_REQUEST['exclusion_casse']=array();
		$_REQUEST['exclusion_negatif']=array();
		$_REQUEST['exclusion_description']='';
		
		if(preg_match('/exclusion\.identifiant like \'(.*)\'/',$_SESSION['exclusion_recherche'],$recherche))
			$_REQUEST['exclusion_identifiant']=stripslashes($recherche[1]);
		if(preg_match('/exclusion\.expression like \'(.*)\'/',$_SESSION['exclusion_recherche'],$recherche))
			$_REQUEST['exclusion_expression']=stripslashes($recherche[1]);
		if(preg_match('/exclusion\.casse in \(\'(.+)\'\)/',$_SESSION['exclusion_recherche'],$recherche))
			$_REQUEST['exclusion_casse']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/exclusion\.negatif in \(\'(.+)\'\)/',$_SESSION['exclusion_recherche'],$recherche))
			$_REQUEST['exclusion_negatif']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/exclusion\.description like \'(.*)\'/',$_SESSION['exclusion_recherche'],$recherche))
			$_REQUEST['exclusion_description']=stripslashes($recherche[1]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('exclusion_identifiant');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des exclusions </th>
        </tr>
        <tr>
          <td><form action="exclusion_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><input name="exclusion_identifiant" type="text" id="exclusion_identifiant"  value="<?php print(ma_htmlentities($_REQUEST['exclusion_identifiant']));?>" /></td>
                </tr>
                <tr>
                  <td>Expression : </td>
                  <td><input name="exclusion_expression" type="text" id="exclusion_expression" value="<?php print(ma_htmlentities($_REQUEST['exclusion_expression']));?>" /></td>
                </tr>
                <tr>
                  <td>Casse : </td>
                  <td><input name="exclusion_casse[]" type="checkbox" id="exclusion_casse_sensible" value="SENSIBLE"<?php if(!sizeof($_REQUEST['exclusion_casse']) || array_search('SENSIBLE',$_REQUEST['exclusion_casse'])!==false) print(' checked="checked"');?> />
                    <label for="exclusion_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="exclusion_casse[]" type="checkbox" id="exclusion_casse_insensible" value="INSENSIBLE"<?php if(!sizeof($_REQUEST['exclusion_casse']) || array_search('INSENSIBLE',$_REQUEST['exclusion_casse'])!==false) print(' checked="checked"');?> />
                  <label for="exclusion_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td>Negatif : </td>
                  <td><input name="exclusion_negatif[]" type="checkbox" id="exclusion_negatif_oui" value="OUI"<?php if(!sizeof($_REQUEST['exclusion_negatif']) || array_search('OUI',$_REQUEST['exclusion_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="exclusion_negatif_oui">OUI</label>
                    <br />
                    <input name="exclusion_negatif[]" type="checkbox" id="exclusion_negatif_non" value="NON"<?php if(!sizeof($_REQUEST['exclusion_negatif']) || array_search('NON',$_REQUEST['exclusion_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="exclusion_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td>D&eacute;scription : </td>
                  <td><input name="exclusion_description" type="text" id="exclusion_description" value="<?php print(ma_htmlentities($_REQUEST['exclusion_description']));?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="exclusion_recherche_submit" id="exclusion_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
