<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	if(isset($_REQUEST['hardbounce_recherche_submit']))
	{
		switch($_REQUEST['hardbounce_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('hardbounce_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['hardbounce_identifiant']) && $_REQUEST['hardbounce_identifiant']!='')
					$recherche[]='hardbounce.identifiant like \''.addslashes($_REQUEST['hardbounce_identifiant']).'\'';
				if(isset($_REQUEST['hardbounce_expression']) && $_REQUEST['hardbounce_expression']!='')
					$recherche[]='hardbounce.expression like \''.addslashes($_REQUEST['hardbounce_expression']).'\'';
				if(isset($_REQUEST['hardbounce_casse']))
					$recherche[]='hardbounce.casse in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['hardbounce_casse'])).'\')';
				if(isset($_REQUEST['hardbounce_negatif']))
					$recherche[]='hardbounce.negatif in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['hardbounce_negatif'])).'\')';
				if(isset($_REQUEST['hardbounce_description']) && $_REQUEST['hardbounce_description']!='')
					$recherche[]='hardbounce.description like \''.addslashes($_REQUEST['hardbounce_description']).'\'';
				if(sizeof($recherche))
					$_SESSION['hardbounce_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['hardbounce_recherche']='';
				header('location: '.url_use_trans_sid('hardbounce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['hardbounce_recherche']))
			$_SESSION['hardbounce_recherche']='';
		
		$_REQUEST['hardbounce_identifiant']='';
		$_REQUEST['hardbounce_expression']='';
		$_REQUEST['hardbounce_casse']=array();
		$_REQUEST['hardbounce_negatif']=array();
		$_REQUEST['hardbounce_description']='';
		
		if(preg_match('/hardbounce\.identifiant like \'(.*)\'/',$_SESSION['hardbounce_recherche'],$recherche))
			$_REQUEST['hardbounce_identifiant']=stripslashes($recherche[1]);
		if(preg_match('/hardbounce\.expression like \'(.*)\'/',$_SESSION['hardbounce_recherche'],$recherche))
			$_REQUEST['hardbounce_expression']=stripslashes($recherche[1]);
		if(preg_match('/hardbounce\.casse in \(\'(.+)\'\)/',$_SESSION['hardbounce_recherche'],$recherche))
			$_REQUEST['hardbounce_casse']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/hardbounce\.negatif in \(\'(.+)\'\)/',$_SESSION['hardbounce_recherche'],$recherche))
			$_REQUEST['hardbounce_negatif']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/hardbounce\.description like \'(.*)\'/',$_SESSION['hardbounce_recherche'],$recherche))
			$_REQUEST['hardbounce_description']=stripslashes($recherche[1]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('hardbounce_identifiant');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des hardbounces </th>
        </tr>
        <tr>
          <td><form action="hardbounce_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><input name="hardbounce_identifiant" type="text" id="hardbounce_identifiant"  value="<?php print(ma_htmlentities($_REQUEST['hardbounce_identifiant']));?>" /></td>
                </tr>
                <tr>
                  <td>Expression : </td>
                  <td><input name="hardbounce_expression" type="text" id="hardbounce_expression" value="<?php print(ma_htmlentities($_REQUEST['hardbounce_expression']));?>" /></td>
                </tr>
                <tr>
                  <td>Casse : </td>
                  <td><input name="hardbounce_casse[]" type="checkbox" id="hardbounce_casse_sensible" value="SENSIBLE"<?php if(!sizeof($_REQUEST['hardbounce_casse']) || array_search('SENSIBLE',$_REQUEST['hardbounce_casse'])!==false) print(' checked="checked"');?> />
                    <label for="hardbounce_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="hardbounce_casse[]" type="checkbox" id="hardbounce_casse_insensible" value="INSENSIBLE"<?php if(!sizeof($_REQUEST['hardbounce_casse']) || array_search('INSENSIBLE',$_REQUEST['hardbounce_casse'])!==false) print(' checked="checked"');?> />
                  <label for="hardbounce_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td>Negatif : </td>
                  <td><input name="hardbounce_negatif[]" type="checkbox" id="hardbounce_negatif_oui" value="OUI"<?php if(!sizeof($_REQUEST['hardbounce_negatif']) || array_search('OUI',$_REQUEST['hardbounce_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="hardbounce_negatif_oui">OUI</label>
                    <br />
                    <input name="hardbounce_negatif[]" type="checkbox" id="hardbounce_negatif_non" value="NON"<?php if(!sizeof($_REQUEST['hardbounce_negatif']) || array_search('NON',$_REQUEST['hardbounce_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="hardbounce_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td>D&eacute;scription : </td>
                  <td><input name="hardbounce_description" type="text" id="hardbounce_description" value="<?php print(ma_htmlentities($_REQUEST['hardbounce_description']));?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="hardbounce_recherche_submit" id="hardbounce_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
