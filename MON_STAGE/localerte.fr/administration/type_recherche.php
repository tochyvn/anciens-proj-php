<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	if(isset($_REQUEST['type_recherche_submit']))
	{
		switch($_REQUEST['type_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('type_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['type_identifiant']) && $_REQUEST['type_identifiant']!='')
					$recherche[]='type.identifiant like \''.addslashes($_REQUEST['type_identifiant']).'\'';
				if(isset($_REQUEST['type_parent']))
				{
					$parent_not_null=false;
					for($i=0;$i<sizeof($_REQUEST['type_parent']);$i++)
						if($_REQUEST['type_parent']!='')
						{
							$parent_not_null=true;
							$_REQUEST['type_parent'][$i]=addslashes($_REQUEST['type_parent'][$i]);
						}
					if($parent_not_null)
						$recherche[]='type.parent in (\''.implode('\',\'',$_REQUEST['type_parent']).'\')';
					if(array_search('',$_REQUEST['type_parent'])!==false)
					{
						if($parent_not_null)
							$recherche[sizeof($recherche)-1]='('.$recherche[sizeof($recherche)-1].' or type.parent is null)';
						else
							$recherche[]='type.parent is null';
					}
				}
				if(isset($_REQUEST['type_designation']) && $_REQUEST['type_designation']!='')
					$recherche[]='type.designation like \''.addslashes($_REQUEST['type_designation']).'\'';
				if(sizeof($recherche))
					$_SESSION['type_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['type_recherche']='';
				header('location: '.url_use_trans_sid('type_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['type_recherche']))
			$_SESSION['type_recherche']='';
		
		$_REQUEST['type_identifiant']='';
		$_REQUEST['type_parent']=array();
		$_REQUEST['type_designation']='';
		
		if(preg_match('/type\.identifiant like \'(.*)\'/',$_SESSION['type_recherche'],$recherche))
			$_REQUEST['type_identifiant']=stripslashes($recherche[1]);
		if(preg_match('/type.parent in \(\'(.+)\'\)/',$_SESSION['type_recherche'],$recherche))
		{
			$_REQUEST['type_parent']=explode('\',\'',$recherche[1]);
			foreach($_REQUEST['type_parent'] as $clef=>$valeur)
				$_REQUEST['type_parent'][$clef]=stripslashes($valeur);
		}
		if(preg_match('/type.parent is null/',$_SESSION['type_recherche']))
			$_REQUEST['type_parent'][]='';
		if(preg_match('/type\.designation like \'(.*)\'/',$_SESSION['type_recherche'],$recherche))
			$_REQUEST['type_designation']=stripslashes($recherche[1]);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
</head>
<body onload="DonnerFocus('type_identifiant');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des types </th>
        </tr>
        <tr>
          <td><form action="type_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><input name="type_identifiant" type="text" id="type_identifiant"  value="<?php print(ma_htmlentities($_REQUEST['type_identifiant']));?>" /></td>
                </tr>
                <tr>
                  <td valign="top">Parent : </td>
                  <td><?php
	print('<input type="checkbox" name="type_parent[]" value="" id="type_parent_"'.((array_search('',$_REQUEST['type_parent'])!==false)?(' checked="checked"'):('')).' /><label for="type_parent_">Sans parent</label><br />');
	$liste=new ld_liste
	('
		select
			identifiant,
			designation
		from type
		where parent is null
		order by designation
	');
	for($i=0;$i<$liste->total;$i++)
		print('<input type="checkbox" name="type_parent[]" value="'.ma_htmlentities($liste->occurrence[$i]['identifiant']).'" id="type_parent_'.ma_htmlentities($liste->occurrence[$i]['identifiant']).'"'.((array_search($liste->occurrence[$i]['identifiant'],$_REQUEST['type_parent'])!==false)?(' checked="checked"'):('')).' /><label for="type_parent_'.ma_htmlentities($liste->occurrence[$i]['identifiant']).'">'.ma_htmlentities($liste->occurrence[$i]['designation']).'</label><br />');
?></td>
                </tr>
                <tr>
                  <td>D&eacute;signation : </td>
                  <td><input name="type_designation" type="text" id="type_designation" value="<?php print(ma_htmlentities($_REQUEST['type_designation']));?>" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="type_recherche_submit" id="type_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
