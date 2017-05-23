<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	
	if(isset($_REQUEST['provenance_recherche_submit']))
	{
		switch($_REQUEST['provenance_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('provenance_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['provenance_identifiant']) && $_REQUEST['provenance_identifiant']!='')
					$recherche[]='provenance.identifiant like \''.addslashes($_REQUEST['provenance_identifiant']).'\'';
				if(isset($_REQUEST['provenance_code']) && $_REQUEST['provenance_code']!='')
					$recherche[]='provenance.code like \''.addslashes($_REQUEST['provenance_code']).'\'';
				if(isset($_REQUEST['provenance_designation']) && $_REQUEST['provenance_designation']!='')
					$recherche[]='provenance.designation like \''.addslashes($_REQUEST['provenance_designation']).'\'';
				if(isset($_REQUEST['provenance_url']) && $_REQUEST['provenance_url']!='')
					$recherche[]='provenance.url like \''.addslashes($_REQUEST['provenance_url']).'\'';
				if(sizeof($recherche))
					$_SESSION['provenance_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['provenance_recherche']='';
				header('location: '.url_use_trans_sid('provenance_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['provenance_recherche']))
			$_SESSION['provenance_recherche']='';
		
		$_REQUEST['provenance_identifiant']='';
		$_REQUEST['provenance_code']='';
		$_REQUEST['provenance_designation']='';
		$_REQUEST['provenance_url']='';
		
		if(preg_match('/provenance\.identifiant like \'(.*)\'/',$_SESSION['provenance_recherche'],$recherche))
			$_REQUEST['provenance_identifiant']=stripslashes($recherche[1]);
		if(preg_match('/provenance\.code like \'(.*)\'/',$_SESSION['provenance_recherche'],$recherche))
			$_REQUEST['provenance_code']=stripslashes($recherche[1]);
		if(preg_match('/provenance\.designation like \'(.*)\'/',$_SESSION['provenance_recherche'],$recherche))
			$_REQUEST['provenance_designation']=stripslashes($recherche[1]);
		if(preg_match('/provenance\.url like \'(.*)\'/',$_SESSION['provenance_recherche'],$recherche))
			$_REQUEST['provenance_url']=stripslashes($recherche[1]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('provenance_identifiant');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des provenances </th>
        </tr>
        <tr>
          <td><form action="provenance_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><input name="provenance_identifiant" type="text" id="provenance_identifiant"  value="<?php print(ma_htmlentities($_REQUEST['provenance_identifiant']));?>" /></td>
                </tr>
                <tr>
                  <td>Code : </td>
                  <td><input name="provenance_code" type="text" id="provenance_code" value="<?php print(ma_htmlentities($_REQUEST['provenance_code']));?>" /></td>
                </tr>
                <tr>
                  <td>D&eacute;signation : </td>
                  <td><input name="provenance_designation" type="text" id="provenance_designation" value="<?php print(ma_htmlentities($_REQUEST['provenance_designation']));?>" /></td>
                </tr>
                <tr>
                  <td>URL : </td>
                  <td><input name="provenance_url" type="text" id="provenance_url" value="<?php print(ma_htmlentities($_REQUEST['provenance_url']));?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="provenance_recherche_submit" id="provenance_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
