<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	if(isset($_REQUEST['unscribebounce_recherche_submit']))
	{
		switch($_REQUEST['unscribebounce_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('unscribebounce_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['unscribebounce_identifiant']) && $_REQUEST['unscribebounce_identifiant']!='')
					$recherche[]='unscribebounce.identifiant like \''.addslashes($_REQUEST['unscribebounce_identifiant']).'\'';
				if(isset($_REQUEST['unscribebounce_expression']) && $_REQUEST['unscribebounce_expression']!='')
					$recherche[]='unscribebounce.expression like \''.addslashes($_REQUEST['unscribebounce_expression']).'\'';
				if(isset($_REQUEST['unscribebounce_casse']))
					$recherche[]='unscribebounce.casse in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['unscribebounce_casse'])).'\')';
				if(isset($_REQUEST['unscribebounce_negatif']))
					$recherche[]='unscribebounce.negatif in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['unscribebounce_negatif'])).'\')';
				if(isset($_REQUEST['unscribebounce_endroit']))
					$recherche[]='unscribebounce.endroit in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['unscribebounce_endroit'])).'\')';
				if(isset($_REQUEST['unscribebounce_description']) && $_REQUEST['unscribebounce_description']!='')
					$recherche[]='unscribebounce.description like \''.addslashes($_REQUEST['unscribebounce_description']).'\'';
				if(sizeof($recherche))
					$_SESSION['unscribebounce_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['unscribebounce_recherche']='';
				header('location: '.url_use_trans_sid('unscribebounce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['unscribebounce_recherche']))
			$_SESSION['unscribebounce_recherche']='';
		
		$_REQUEST['unscribebounce_identifiant']='';
		$_REQUEST['unscribebounce_expression']='';
		$_REQUEST['unscribebounce_casse']=array();
		$_REQUEST['unscribebounce_negatif']=array();
		$_REQUEST['unscribebounce_endroit']=array();
		$_REQUEST['unscribebounce_description']='';
		
		if(preg_match('/unscribebounce\.identifiant like \'(.*)\'/',$_SESSION['unscribebounce_recherche'],$recherche))
			$_REQUEST['unscribebounce_identifiant']=stripslashes($recherche[1]);
		if(preg_match('/unscribebounce\.expression like \'(.*)\'/',$_SESSION['unscribebounce_recherche'],$recherche))
			$_REQUEST['unscribebounce_expression']=stripslashes($recherche[1]);
		if(preg_match('/unscribebounce\.casse in \(\'(.+)\'\)/',$_SESSION['unscribebounce_recherche'],$recherche))
			$_REQUEST['unscribebounce_casse']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/unscribebounce\.negatif in \(\'(.+)\'\)/',$_SESSION['unscribebounce_recherche'],$recherche))
			$_REQUEST['unscribebounce_negatif']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/unscribebounce\.endroit in \(\'(.+)\'\)/',$_SESSION['unscribebounce_recherche'],$recherche))
			$_REQUEST['unscribebounce_endroit']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/unscribebounce\.description like \'(.*)\'/',$_SESSION['unscribebounce_recherche'],$recherche))
			$_REQUEST['unscribebounce_description']=stripslashes($recherche[1]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('unscribebounce_identifiant');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des unscribebounces </th>
        </tr>
        <tr>
          <td><form action="unscribebounce_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><input name="unscribebounce_identifiant" type="text" id="unscribebounce_identifiant"  value="<?php print(ma_htmlentities($_REQUEST['unscribebounce_identifiant']));?>" /></td>
                </tr>
                <tr>
                  <td>Expression : </td>
                  <td><input name="unscribebounce_expression" type="text" id="unscribebounce_expression" value="<?php print(ma_htmlentities($_REQUEST['unscribebounce_expression']));?>" /></td>
                </tr>
                <tr>
                  <td>Casse : </td>
                  <td><input name="unscribebounce_casse[]" type="checkbox" id="unscribebounce_casse_sensible" value="SENSIBLE"<?php if(!sizeof($_REQUEST['unscribebounce_casse']) || array_search('SENSIBLE',$_REQUEST['unscribebounce_casse'])!==false) print(' checked="checked"');?> />
                    <label for="unscribebounce_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="unscribebounce_casse[]" type="checkbox" id="unscribebounce_casse_insensible" value="INSENSIBLE"<?php if(!sizeof($_REQUEST['unscribebounce_casse']) || array_search('INSENSIBLE',$_REQUEST['unscribebounce_casse'])!==false) print(' checked="checked"');?> />
                  <label for="unscribebounce_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td>Negatif : </td>
                  <td><input name="unscribebounce_negatif[]" type="checkbox" id="unscribebounce_negatif_oui" value="OUI"<?php if(!sizeof($_REQUEST['unscribebounce_negatif']) || array_search('OUI',$_REQUEST['unscribebounce_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="unscribebounce_negatif_oui">OUI</label>
                    <br />
                    <input name="unscribebounce_negatif[]" type="checkbox" id="unscribebounce_negatif_non" value="NON"<?php if(!sizeof($_REQUEST['unscribebounce_negatif']) || array_search('NON',$_REQUEST['unscribebounce_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="unscribebounce_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td>Endroit : </td>
                  <td><input name="unscribebounce_endroit[]" type="checkbox" id="unscribebounce_endroit_entete" value="ENTETE"<?php if(!sizeof($_REQUEST['unscribebounce_endroit']) || array_search('ENTETE',$_REQUEST['unscribebounce_endroit'])!==false) print(' checked="checked"');?> />
                    <label for="unscribebounce_endroit_entete">ENTETE</label>
                    <br />
                    <input name="unscribebounce_endroit[]" type="checkbox" id="unscribebounce_endroit_corps" value="CORPS"<?php if(!sizeof($_REQUEST['unscribebounce_endroit']) || array_search('CORPS',$_REQUEST['unscribebounce_endroit'])!==false) print(' checked="checked"');?> />
                    <label for="unscribebounce_endroit_corps">CORPS</label></td>
                </tr>
                <tr>
                  <td>D&eacute;scription : </td>
                  <td><input name="unscribebounce_description" type="text" id="unscribebounce_description" value="<?php print(ma_htmlentities($_REQUEST['unscribebounce_description']));?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="unscribebounce_recherche_submit" id="unscribebounce_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
