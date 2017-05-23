<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	if(isset($_REQUEST['replybounce_recherche_submit']))
	{
		switch($_REQUEST['replybounce_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('replybounce_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['replybounce_identifiant']) && $_REQUEST['replybounce_identifiant']!='')
					$recherche[]='replybounce.identifiant like \''.addslashes($_REQUEST['replybounce_identifiant']).'\'';
				if(isset($_REQUEST['replybounce_expression']) && $_REQUEST['replybounce_expression']!='')
					$recherche[]='replybounce.expression like \''.addslashes($_REQUEST['replybounce_expression']).'\'';
				if(isset($_REQUEST['replybounce_casse']))
					$recherche[]='replybounce.casse in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['replybounce_casse'])).'\')';
				if(isset($_REQUEST['replybounce_negatif']))
					$recherche[]='replybounce.negatif in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['replybounce_negatif'])).'\')';
				if(isset($_REQUEST['replybounce_endroit']))
					$recherche[]='replybounce.endroit in (\''.implode('\',\'',array_map('addslashes',$_REQUEST['replybounce_endroit'])).'\')';
				if(isset($_REQUEST['replybounce_description']) && $_REQUEST['replybounce_description']!='')
					$recherche[]='replybounce.description like \''.addslashes($_REQUEST['replybounce_description']).'\'';
				if(sizeof($recherche))
					$_SESSION['replybounce_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['replybounce_recherche']='';
				header('location: '.url_use_trans_sid('replybounce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['replybounce_recherche']))
			$_SESSION['replybounce_recherche']='';
		
		$_REQUEST['replybounce_identifiant']='';
		$_REQUEST['replybounce_expression']='';
		$_REQUEST['replybounce_casse']=array();
		$_REQUEST['replybounce_negatif']=array();
		$_REQUEST['replybounce_endroit']=array();
		$_REQUEST['replybounce_description']='';
		
		if(preg_match('/replybounce\.identifiant like \'(.*)\'/',$_SESSION['replybounce_recherche'],$recherche))
			$_REQUEST['replybounce_identifiant']=stripslashes($recherche[1]);
		if(preg_match('/replybounce\.expression like \'(.*)\'/',$_SESSION['replybounce_recherche'],$recherche))
			$_REQUEST['replybounce_expression']=stripslashes($recherche[1]);
		if(preg_match('/replybounce\.casse in \(\'(.+)\'\)/',$_SESSION['replybounce_recherche'],$recherche))
			$_REQUEST['replybounce_casse']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/replybounce\.negatif in \(\'(.+)\'\)/',$_SESSION['replybounce_recherche'],$recherche))
			$_REQUEST['replybounce_negatif']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/replybounce\.endroit in \(\'(.+)\'\)/',$_SESSION['replybounce_recherche'],$recherche))
			$_REQUEST['replybounce_endroit']=array_map('stripslashes',explode('\',\'',$recherche[1]));
		if(preg_match('/replybounce\.description like \'(.*)\'/',$_SESSION['replybounce_recherche'],$recherche))
			$_REQUEST['replybounce_description']=stripslashes($recherche[1]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('replybounce_identifiant');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des replybounces </th>
        </tr>
        <tr>
          <td><form action="replybounce_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><input name="replybounce_identifiant" type="text" id="replybounce_identifiant"  value="<?php print(ma_htmlentities($_REQUEST['replybounce_identifiant']));?>" /></td>
                </tr>
                <tr>
                  <td>Expression : </td>
                  <td><input name="replybounce_expression" type="text" id="replybounce_expression" value="<?php print(ma_htmlentities($_REQUEST['replybounce_expression']));?>" /></td>
                </tr>
                <tr>
                  <td>Casse : </td>
                  <td><input name="replybounce_casse[]" type="checkbox" id="replybounce_casse_sensible" value="SENSIBLE"<?php if(!sizeof($_REQUEST['replybounce_casse']) || array_search('SENSIBLE',$_REQUEST['replybounce_casse'])!==false) print(' checked="checked"');?> />
                    <label for="replybounce_casse_sensible">SENSIBLE</label>
                    <br />
                    <input name="replybounce_casse[]" type="checkbox" id="replybounce_casse_insensible" value="INSENSIBLE"<?php if(!sizeof($_REQUEST['replybounce_casse']) || array_search('INSENSIBLE',$_REQUEST['replybounce_casse'])!==false) print(' checked="checked"');?> />
                  <label for="replybounce_casse_insensible">INSENSIBLE</label></td>
                </tr>
                <tr>
                  <td>Negatif : </td>
                  <td><input name="replybounce_negatif[]" type="checkbox" id="replybounce_negatif_oui" value="OUI"<?php if(!sizeof($_REQUEST['replybounce_negatif']) || array_search('OUI',$_REQUEST['replybounce_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="replybounce_negatif_oui">OUI</label>
                    <br />
                    <input name="replybounce_negatif[]" type="checkbox" id="replybounce_negatif_non" value="NON"<?php if(!sizeof($_REQUEST['replybounce_negatif']) || array_search('NON',$_REQUEST['replybounce_negatif'])!==false) print(' checked="checked"');?> />
                    <label for="replybounce_negatif_non">NON</label></td>
                </tr>
                <tr>
                  <td>Endroit : </td>
                  <td><input name="replybounce_endroit[]" type="checkbox" id="replybounce_endroit_entete" value="ENTETE"<?php if(!sizeof($_REQUEST['replybounce_endroit']) || array_search('ENTETE',$_REQUEST['replybounce_endroit'])!==false) print(' checked="checked"');?> />
                    <label for="replybounce_endroit_entete">ENTETE</label>
                    <br />
                    <input name="replybounce_endroit[]" type="checkbox" id="replybounce_endroit_corps" value="CORPS"<?php if(!sizeof($_REQUEST['replybounce_endroit']) || array_search('CORPS',$_REQUEST['replybounce_endroit'])!==false) print(' checked="checked"');?> />
                    <label for="replybounce_endroit_corps">CORPS</label></td>
                </tr>
                <tr>
                  <td>D&eacute;scription : </td>
                  <td><input name="replybounce_description" type="text" id="replybounce_description" value="<?php print(ma_htmlentities($_REQUEST['replybounce_description']));?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="replybounce_recherche_submit" id="replybounce_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
