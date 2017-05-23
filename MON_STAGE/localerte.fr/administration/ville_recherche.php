<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'ville.php');
	
	$ville=new ld_ville();
	$ville->identifiant=$_SESSION['ville_identifiant'];
	$ville->lire();
	
	if(isset($_REQUEST['ville_recherche_submit']))
	{
		switch($_REQUEST['ville_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('ville_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['ville_identifiant']) && $_REQUEST['ville_identifiant']!='')
					$recherche[]='ville.identifiant like \''.addslashes($_REQUEST['ville_identifiant']).'\'';
				if(isset($_REQUEST['ville_nom']) && $_REQUEST['ville_nom']!='')
					$recherche[]='ville.nom like \''.addslashes($_REQUEST['ville_nom']).'\'';
				if(isset($_REQUEST['ville_code_postal']) && $_REQUEST['ville_code_postal']!='')
					$recherche[]='ville.code_postal like \''.addslashes($_REQUEST['ville_code_postal']).'\'';
				if(isset($_REQUEST['ville_distance']) && preg_match('/'.STRING_FILTRE_ENTIER_POSITIF.'/',$_REQUEST['ville_distance']))
					$recherche[]='ifnull((6366*acos(cos(radians(%LATITUDE%))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians(%LONGITUDE%))+sin(radians(%LATITUDE%))*sin(radians(ville.latitude)))),0)<='.addslashes($_REQUEST['ville_distance']);
				if(sizeof($recherche))
					$_SESSION['ville_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['ville_recherche']='';
				header('location: '.url_use_trans_sid('ville_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['ville_recherche']))
			$_SESSION['ville_recherche']='';
		
		$_REQUEST['ville_identifiant']='';
		$_REQUEST['ville_nom']='';
		$_REQUEST['ville_code_postal']='';
		$_REQUEST['ville_distance']='';
		
		if(preg_match('/ville\.identifiant like \'(.*)\'/',$_SESSION['ville_recherche'],$recherche))
			$_REQUEST['ville_identifiant']=stripslashes($recherche[1]);
		if(preg_match('/ville\.nom like \'(.*)\'/',$_SESSION['ville_recherche'],$recherche))
			$_REQUEST['ville_nom']=stripslashes($recherche[1]);
		if(preg_match('/ville\.code_postal like \'(.*)\'/',$_SESSION['ville_recherche'],$recherche))
			$_REQUEST['ville_code_postal']=stripslashes($recherche[1]);
		if(preg_match('/'.regencode('ifnull((6366*acos(cos(radians(%LATITUDE%))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians(%LONGITUDE%))+sin(radians(%LATITUDE%))*sin(radians(ville.latitude)))),0)').'<=(.*)/',$_SESSION['ville_recherche'],$recherche))
			$_REQUEST['ville_distance']=stripslashes($recherche[1]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('ville_identifiant');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des villes </th>
        </tr>
        <tr>
          <td><form action="ville_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><input name="ville_identifiant" type="text" id="ville_identifiant"  value="<?php print(ma_htmlentities($_REQUEST['ville_identifiant']));?>" /></td>
                </tr>
                <tr>
                  <td>Nom : </td>
                  <td><input name="ville_nom" type="text" id="ville_nom" value="<?php print(ma_htmlentities($_REQUEST['ville_nom']));?>" /></td>
                </tr>
                <tr>
                  <td>Code postal  : </td>
                  <td nowrap="nowrap"><input name="ville_code_postal" type="text" id="ville_code_postal" value="<?php print(ma_htmlentities($_REQUEST['ville_code_postal']));?>" /></td>
                </tr>
                <tr>
                  <td>Distance maximum : </td>
                  <td nowrap="nowrap"><input name="ville_distance" type="text" id="ville_distance" value="<?php print(ma_htmlentities($_REQUEST['ville_distance']));?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="ville_recherche_submit" id="ville_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
