<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'sql.php');
	
	if(isset($_REQUEST['annonce_recherche_submit']))
	{
		switch($_REQUEST['annonce_recherche_submit'])
		{
			case 'Retour à la liste':
				header('location: '.url_use_trans_sid('annonce_liste.php'));
				die();
				break;
			case 'Rechercher':	
				$recherche=array();
				if(isset($_REQUEST['annonce_identifiant_valeur']) && $_REQUEST['annonce_identifiant_valeur']!='')
					$recherche[]='annonce.identifiant '.$_REQUEST['annonce_identifiant_operateur'].' \''.addslashes($_REQUEST['annonce_identifiant_valeur']).'\'';
				if(isset($_REQUEST['annonce_ville_valeur']) && $_REQUEST['annonce_ville_valeur']!='')
					$recherche[]='ville.nom '.$_REQUEST['annonce_ville_operateur'].' \''.addslashes($_REQUEST['annonce_ville_valeur']).'\'';
				if(isset($_REQUEST['annonce_telephone_valeur']) && $_REQUEST['annonce_telephone_valeur']!='')
					$recherche[]='annonce_telephone.telephone '.$_REQUEST['annonce_telephone_operateur'].' \''.addslashes($_REQUEST['annonce_telephone_valeur']).'\'';
				if(isset($_REQUEST['annonce_email_valeur']) && $_REQUEST['annonce_email_valeur']!='')
					$recherche[]='annonce_email.email '.$_REQUEST['annonce_email_operateur'].' \''.addslashes($_REQUEST['annonce_email_valeur']).'\'';
				if(isset($_REQUEST['annonce_descriptif_valeur']) && $_REQUEST['annonce_descriptif_valeur']!='')
					$recherche[]='annonce.descriptif '.$_REQUEST['annonce_descriptif_operateur'].' \''.addslashes($_REQUEST['annonce_descriptif_valeur']).'\'';
				if(isset($_REQUEST['annonce_parution_debut_valeur']))
				{
					if(!is_array($_REQUEST['annonce_parution_debut_valeur']))
					{
						if(preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/',$_REQUEST['annonce_parution_debut_valeur'],$resultat))
							$recherche[]='annonce.parution>=\''.date(SQL_DATETIME,mktime(0,0,0,$resultat[2],$resultat[1],$resultat[3])).'\'';
					}
					else
					{
						if(checkdate($_REQUEST['annonce_parution_debut_valeur'][1],$_REQUEST['annonce_parution_debut_valeur'][0],$_REQUEST['annonce_parution_debut_valeur'][2]))
							$recherche[]='annonce.parution>=\''.date(SQL_DATETIME,mktime(0,0,0,$_REQUEST['annonce_parution_debut_valeur'][1],$_REQUEST['annonce_parution_debut_valeur'][0],$_REQUEST['annonce_parution_debut_valeur'][2])).'\'';
					}
				}
				if(isset($_REQUEST['annonce_parution_fin_valeur']))
				{
					if(!is_array($_REQUEST['annonce_parution_fin_valeur']))
					{
						if(preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/',$_REQUEST['annonce_parution_fin_valeur'],$resultat))
							$recherche[]='annonce.parution<=\''.date(SQL_DATETIME,mktime(0,0,0,$resultat[2],$resultat[1],$resultat[3])).'\'';
					}
					else
					{
						if(checkdate($_REQUEST['annonce_parution_fin_valeur'][1],$_REQUEST['annonce_parution_fin_valeur'][0],$_REQUEST['annonce_parution_fin_valeur'][2]))
							$recherche[]='annonce.parution<=\''.date(SQL_DATETIME,mktime(0,0,0,$_REQUEST['annonce_parution_fin_valeur'][1],$_REQUEST['annonce_parution_fin_valeur'][0],$_REQUEST['annonce_parution_fin_valeur'][2])).'\'';
					}
				}
				if(sizeof($recherche))
					$_SESSION['annonce_recherche']='and '.implode('
						and ',$recherche);
				else
					$_SESSION['annonce_recherche']='';
				header('location: '.url_use_trans_sid('annonce_liste.php'));
				die();
				break;
		}
	}
	else
	{
		if(!isset($_SESSION['annonce_recherche']))
			$_SESSION['annonce_recherche']='';
		
		$_REQUEST['annonce_identifiant_valeur']='';
		$_REQUEST['annonce_identifiant_operateur']='=';
		$_REQUEST['annonce_ville_valeur']='';
		$_REQUEST['annonce_ville_operateur']='=';
		$_REQUEST['annonce_telephone_valeur']='';
		$_REQUEST['annonce_telephone_operateur']='=';
		$_REQUEST['annonce_email_valeur']='';
		$_REQUEST['annonce_email_operateur']='=';
		$_REQUEST['annonce_descriptif_valeur']='';
		$_REQUEST['annonce_descriptif_operateur']='=';
		$_REQUEST['annonce_parution_debut_valeur']=array();
		$_REQUEST['annonce_parution_fin_valeur']=array();
		
		if(preg_match('/annonce\.identifiant (like|=) \'(.*)\'/',$_SESSION['annonce_recherche'],$recherche))
		{
			$_REQUEST['annonce_identifiant_valeur']=stripslashes($recherche[2]);
			$_REQUEST['annonce_identifiant_operateur']=$recherche[1];
		}
		if(preg_match('/ville\.nom (like|=) \'(.*)\'/',$_SESSION['annonce_recherche'],$recherche))
		{
			$_REQUEST['annonce_ville_valeur']=stripslashes($recherche[2]);
			$_REQUEST['annonce_ville_operateur']=$recherche[1];
		}
		if(preg_match('/annonce_telephone\.telephone (like|=) \'(.*)\'/',$_SESSION['annonce_recherche'],$recherche))
		{
			$_REQUEST['annonce_telephone_valeur']=stripslashes($recherche[2]);
			$_REQUEST['annonce_telephone_operateur']=$recherche[1];
		}
		if(preg_match('/annonce_email\.email (like|=) \'(.*)\'/',$_SESSION['annonce_recherche'],$recherche))
		{
			$_REQUEST['annonce_email_valeur']=stripslashes($recherche[2]);
			$_REQUEST['annonce_email_operateur']=$recherche[1];
		}
		if(preg_match('/annonce\.descriptif (like|=) \'(.*)\'/',$_SESSION['annonce_recherche'],$recherche))
		{
			$_REQUEST['annonce_descriptif_valeur']=stripslashes($recherche[2]);
			$_REQUEST['annonce_descriptif_operateur']=$recherche[1];
		}
		if(preg_match('/annonce\.parution>=\'([0-9]{4})-([0-9]{2})-([0-9]{2})/',$_SESSION['annonce_recherche'],$recherche))
		{
			$_REQUEST['annonce_parution_debut_valeur'][]=stripslashes($recherche[3]);
			$_REQUEST['annonce_parution_debut_valeur'][]=stripslashes($recherche[2]);
			$_REQUEST['annonce_parution_debut_valeur'][]=stripslashes($recherche[1]);
		}
		if(preg_match('/annonce\.parution<=\'([0-9]{4})-([0-9]{2})-([0-9]{2})/',$_SESSION['annonce_recherche'],$recherche))
		{
			$_REQUEST['annonce_parution_fin_valeur'][]=stripslashes($recherche[3]);
			$_REQUEST['annonce_parution_fin_valeur'][]=stripslashes($recherche[2]);
			$_REQUEST['annonce_parution_fin_valeur'][]=stripslashes($recherche[1]);
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script src="general.js" language="javascript" type="text/javascript"></script>
</head>
<body onload="DonnerFocus('annonce_identifiant_valeur');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th>Rechercher des annonces </th>
        </tr>
        <tr>
          <td><form action="annonce_recherche.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><select name="annonce_identifiant_operateur" id="annonce_identifiant_operateur">
                    <option value="="<?php if($_REQUEST['annonce_identifiant_operateur']=='=') print(' selected="selected"');?>>=</option>
                    <option value="like"<?php if($_REQUEST['annonce_identifiant_operateur']=='like') print(' selected="selected"');?>>like</option>
                  </select></td>
                  <td><input name="annonce_identifiant_valeur" type="text" id="annonce_identifiant_valeur"  value="<?php print(ma_htmlentities($_REQUEST['annonce_identifiant_valeur']));?>" /></td>
                </tr>
                <tr>
                  <td>Ville : </td>
                  <td><select name="annonce_ville_operateur" id="annonce_ville_operateur">
                    <option value="="<?php if($_REQUEST['annonce_ville_operateur']=='=') print(' selected="selected"');?>>=</option>
                    <option value="like"<?php if($_REQUEST['annonce_ville_operateur']=='like') print(' selected="selected"');?>>like</option>
                  </select></td>
                  <td><input name="annonce_ville_valeur" type="text" id="annonce_ville_valeur" value="<?php print(ma_htmlentities($_REQUEST['annonce_ville_valeur']));?>" /></td>
                </tr>
                <tr>
                  <td>T&eacute;l&eacute;phone : </td>
                  <td><select name="annonce_telephone_operateur" id="annonce_telephone_operateur">
                    <option value="="<?php if($_REQUEST['annonce_telephone_operateur']=='=') print(' selected="selected"');?>>=</option>
                    <option value="like"<?php if($_REQUEST['annonce_telephone_operateur']=='like') print(' selected="selected"');?>>like</option>
                  </select></td>
                  <td><input name="annonce_telephone_valeur" type="text" id="annonce_telephone_valeur" value="<?php print(ma_htmlentities($_REQUEST['annonce_telephone_valeur']));?>" /></td>
                </tr>
                <tr>
                  <td>Email : </td>
                  <td><select name="annonce_email_operateur" id="annonce_email_operateur">
                    <option value="="<?php if($_REQUEST['annonce_email_operateur']=='=') print(' selected="selected"');?>>=</option>
                    <option value="like"<?php if($_REQUEST['annonce_email_operateur']=='like') print(' selected="selected"');?>>like</option>
                  </select></td>
                  <td><input name="annonce_email_valeur" type="text" id="annonce_email_valeur" value="<?php print(ma_htmlentities($_REQUEST['annonce_email_valeur']));?>" /></td>
                </tr>
                <tr>
                  <td>Descriptif : </td>
                  <td><select name="annonce_descriptif_operateur" id="annonce_descriptif_operateur">
                    <option value="="<?php if($_REQUEST['annonce_descriptif_operateur']=='=') print(' selected="selected"');?>>=</option>
                    <option value="like"<?php if($_REQUEST['annonce_descriptif_operateur']=='like') print(' selected="selected"');?>>like</option>
                  </select></td>
                  <td><input name="annonce_descriptif_valeur" type="text" id="annonce_descriptif_valeur" value="<?php print(ma_htmlentities($_REQUEST['annonce_descriptif_valeur']));?>" /></td>
                </tr>
                <tr>
                  <td>Parution  : </td>
                  <td>&nbsp;</td>
                  <td><noscript>
                    <select name="annonce_parution_debut_valeur[]" id="annonce_parution_debut_jour">
                      <option value="">--</option>
                      <?php
	for($i=1;$i<=31;$i++)
		print('<option value="'.ma_htmlentities($i).'"'.((sizeof($_REQUEST['annonce_parution_debut_valeur']) && $i==$_REQUEST['annonce_parution_debut_valeur'][0])?(' selected="selected"'):('')).'>'.ma_htmlentities((($i<10)?('0'):('')).$i).'</option>');
?>
                    </select>
                    /
                    <select name="annonce_parution_debut_valeur[]" id="annonce_parution_debut_mois">
                      <option value="">--</option>
                      <?php
	for($i=1;$i<=12;$i++)
		print('<option value="'.ma_htmlentities($i).'"'.((sizeof($_REQUEST['annonce_parution_debut_valeur']) && $i==$_REQUEST['annonce_parution_debut_valeur'][1])?(' selected="selected"'):('')).'>'.ma_htmlentities(ucwords(strftime('%B',mktime(0,0,0,$i,1,2000)))).'</option>');
?>
                    </select>
                    <select name="annonce_parution_debut_valeur[]" id="annonce_parution_debut_annee">
                      <option value="">--</option>
                      <?php
	for($i=date('Y')+1;$i>=2008;$i--)
		print('<option value="'.ma_htmlentities($i).'"'.((sizeof($_REQUEST['annonce_parution_debut_valeur']) && $i==$_REQUEST['annonce_parution_debut_valeur'][2])?(' selected="selected"'):('')).'>'.ma_htmlentities($i).'</option>');
?>
                    </select>
                    </noscript>
                      <script type="text/javascript">CreerCalendrier('annonce_parution_debut_valeur',2,'<?php if(sizeof($_REQUEST['annonce_parution_debut_valeur'])) print($_REQUEST['annonce_parution_debut_valeur'][0].'/'.$_REQUEST['annonce_parution_debut_valeur'][1].'/'.$_REQUEST['annonce_parution_debut_valeur'][2]);?>');</script>
                      <br />
                      <noscript>
                      <select name="annonce_parution_fin_valeur[]" id="annonce_parution_fin_jour">
                        <option value="">--</option>
                        <?php
	for($i=1;$i<=31;$i++)
		print('<option value="'.ma_htmlentities($i).'"'.((sizeof($_REQUEST['annonce_parution_fin_valeur']) && $i==$_REQUEST['annonce_parution_fin_valeur'][0])?(' selected="selected"'):('')).'>'.ma_htmlentities((($i<10)?('0'):('')).$i).'</option>');
?>
                      </select>
                        /
                        <select name="annonce_parution_fin_valeur[]" id="annonce_parution_fin_mois">
                          <option value="">--</option>
                          <?php
	for($i=1;$i<=12;$i++)
		print('<option value="'.ma_htmlentities($i).'"'.((sizeof($_REQUEST['annonce_parution_fin_valeur']) && $i==$_REQUEST['annonce_parution_fin_valeur'][1])?(' selected="selected"'):('')).'>'.ma_htmlentities(ucwords(strftime('%B',mktime(0,0,0,$i,1,2000)))).'</option>');
?>
                        </select>
                        <select name="annonce_parution_fin_valeur[]" id="annonce_parution_fin_annee">
                          <option value="">--</option>
                          <?php
	for($i=date('Y')+1;$i>=2008;$i--)
		print('<option value="'.ma_htmlentities($i).'"'.((sizeof($_REQUEST['annonce_parution_fin_valeur']) && $i==$_REQUEST['annonce_parution_fin_valeur'][2])?(' selected="selected"'):('')).'>'.ma_htmlentities($i).'</option>');
?>
                        </select>
                      </noscript>
                      <script type="text/javascript">CreerCalendrier('annonce_parution_fin_valeur',2,'<?php if(sizeof($_REQUEST['annonce_parution_fin_valeur'])) print($_REQUEST['annonce_parution_fin_valeur'][0].'/'.$_REQUEST['annonce_parution_fin_valeur'][1].'/'.$_REQUEST['annonce_parution_fin_valeur'][2]);?>');</script></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="annonce_recherche_submit" id="annonce_recherche_submit" value="Rechercher" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
