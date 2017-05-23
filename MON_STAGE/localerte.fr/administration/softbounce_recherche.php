<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	if(isset($_REQUEST['softbounce_recherche_submit']))
	{
		switch($_REQUEST['softbounce_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('softbounce_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['softbounce_identifiant']) && $_REQUEST['softbounce_identifiant']!='')
					$recherche[]='softbounce.identifiant like \''.addslashes($_REQUEST['softbounce_identifiant']).'\'';
				if(isset($_REQUEST['softbounce_expression']) && $_REQUEST['softbounce_expression']!='')
					$recherche[]='softbounce.expression like \''.addslashes($_REQUEST['softbounce_expression']).'\'';
				if(isset($_REQUEST['softbounce_casse']))
					$recherche[]='softbounce.casse in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['softbounce_casse'])).'\')';
				if(isset($_REQUEST['softbounce_negatif']))
					$recherche[]='softbounce.negatif in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['softbounce_negatif'])).'\')';
				if(isset($_REQUEST['softbounce_description']) && $_REQUEST['softbounce_description']!='')
					$recherche[]='softbounce.description like \''.addslashes($_REQUEST['softbounce_description']).'\'';
				if(sizeof($recherche))
					$_SESSION['softbounce_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['softbounce_recherche']='';
				header('location: '.url_use_trans_sid('softbounce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['softbounce_recherche']))
			$_SESSION['softbounce_recherche']='';
		
		$_REQUEST['softbounce_identifiant']='';
		$_REQUEST['softbounce_expression']='';
		$_REQUEST['softbounce_casse']=array();
		$_REQUEST['softbounce_negatif']=array();
		$_REQUEST['softbounce_description']='';
		
		if(preg_match('/softbounce\.identifiant like \'(.*)\'/',$_SESSION['softbounce_recherche'],$recherche))
			$_REQUEST['softbounce_identifiant']=stripslashes($recherche[1]);
		if(preg_match('/softbounce\.expression like \'(.*)\'/',$_SESSION['softbounce_recherche'],$recherche))
			$_REQUEST['softbounce_expression']=stripslashes($recherche[1]);
		if(preg_match('/softbounce\.casse in \(\'(.+)\'\)/',$_SESSION['softbounce_recherche'],$recherche))
			$_REQUEST['softbounce_casse']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/softbounce\.negatif in \(\'(.+)\'\)/',$_SESSION['softbounce_recherche'],$recherche))
			$_REQUEST['softbounce_negatif']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/softbounce\.description like \'(.*)\'/',$_SESSION['softbounce_recherche'],$recherche))
			$_REQUEST['softbounce_description']=stripslashes($recherche[1]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('softbounce_identifiant');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des softbounces </th>
        </tr>
        <tr>
          <td><form action="softbounce_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><input name="softbounce_identifiant" type="text" id="softbounce_identifiant"  value="<?php print(ma_htmlentities($_REQUEST['softbounce_identifiant']));?>" /></td>
                </tr>
                <tr>
                  <td>Expression : </td>
                  <td><input name="softbounce_expression" type="text" id="softbounce_expression" value="<?php print(ma_htmlentities($_REQUEST['softbounce_expression']));?>" /></td>
                </tr>
                <tr>
                  <td>Casse : </td>
                  <td><input name="softbounce_casse[]" type="checkbox" id="softbounce_casse_sensible" value="SENSIBLE"<?php if(!sizeof($_REQUEST['softbounce_casse']) || array_search('SENSIBLE',$_REQUEST['softbounce_casse'])!==false) print(' checked="checked"');?> />
                    <label for="softbounce_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="softbounce_casse[]" type="checkbox" id="softbounce_casse_insensible" value="INSENSIBLE"<?php if(!sizeof($_REQUEST['softbounce_casse']) || array_search('INSENSIBLE',$_REQUEST['softbounce_casse'])!==false) print(' checked="checked"');?> />
                  <label for="softbounce_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td>Negatif : </td>
                  <td><input name="softbounce_negatif[]" type="checkbox" id="softbounce_negatif_oui" value="OUI"<?php if(!sizeof($_REQUEST['softbounce_negatif']) || array_search('OUI',$_REQUEST['softbounce_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="softbounce_negatif_oui">OUI</label>
                    <br />
                    <input name="softbounce_negatif[]" type="checkbox" id="softbounce_negatif_non" value="NON"<?php if(!sizeof($_REQUEST['softbounce_negatif']) || array_search('NON',$_REQUEST['softbounce_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="softbounce_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td>D&eacute;scription : </td>
                  <td><input name="softbounce_description" type="text" id="softbounce_description" value="<?php print(ma_htmlentities($_REQUEST['softbounce_description']));?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="softbounce_recherche_submit" id="softbounce_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
