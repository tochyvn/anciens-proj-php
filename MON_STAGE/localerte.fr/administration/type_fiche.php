<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'type.php');
	require_once(PWD_INCLUSION.'liste.php');
	
	if(!isset($_REQUEST['type_fiche_mode']) || $_REQUEST['type_fiche_mode']!='modifier')
		$_REQUEST['type_fiche_mode']='ajouter';
	if(!isset($_REQUEST['type_identifiant']))
		$_REQUEST['type_identifiant']='';
	
	$type=new ld_type();
	
	$type_fiche_erreur=0;
	$type_fiche_succes=0;
	
	if(isset($_REQUEST['type_fiche_submit']))
	{
		if($_REQUEST['type_fiche_mode']=='modifier')
		{
			$type->identifiant=$_REQUEST['type_identifiant'];
			$type->nouveau_identifiant=$_REQUEST['type_identifiant'];
		}
		else
		{
			$type->identifiant='';
			$type->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_type','identifiant',TYPE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		}
		$type->parent=($_REQUEST['type_parent'])?($_REQUEST['type_parent']):(NULL);
		$type->designation=$_REQUEST['type_designation'];
		$type->position=($_REQUEST['type_position'])?($_REQUEST['type_position']):(NULL);
		
		switch($_REQUEST['type_fiche_submit'])
		{
			case 'Enregistrer':
				if($_REQUEST['type_fiche_mode']=='modifier')
				{
					$type_fiche_erreur=$type->modifier();
					if(!$type_fiche_erreur)
						$type_fiche_succes=FICHE_SUCCES_MODIFIER;
				}
				else
				{
					$type_fiche_erreur=$type->ajouter();
					if(!$type_fiche_erreur)
					{
						$_REQUEST['type_fiche_mode']='modifier';
						$type_fiche_succes=FICHE_SUCCES_AJOUTER;
					}
				}
				break;
			case 'Retour':
				header('location: '.url_use_trans_sid('type_liste.php'));
				die();
				break;
		}
	}
	else
	{
		$type->identifiant=$_REQUEST['type_identifiant'];
		if(!$type->lire())
			$_REQUEST['type_fiche_mode']='ajouter';
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script src="general.js" language="javascript" type="text/javascript"></script>
</head>
<body onload="DonnerFocus('type_designation');">
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table align="center" cellspacing="0" cellpadding="4" class="moyen">
        <tr>
          <th><?php print(($_REQUEST['type_fiche_mode']=='modifier')?('Modifier'):('Ajouter'));?> un type</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['type_fiche_submit']))
	{
		if($type_fiche_erreur & TYPE_PARENT_ERREUR) print('Le parent n\'existe pas ou poss&egrave;de lui-m&ecirc;me un parent<br />');
		if($type_fiche_erreur & TYPE_DESIGNATION_ERREUR) print('La d&eacute;signation doit &ecirc;tre comprise entre '.ma_htmlentities(TYPE_DESIGNATION_MIN).' et '.ma_htmlentities(TYPE_DESIGNATION_MAX).' caract&egrave;res<br />');
		if($type_fiche_erreur & TYPE_POSITION_ERREUR_VALEUR || $type_fiche_erreur & TYPE_POSITION_ERREUR_FILTRE) print('La position n\'est pas valide<br />');
		if($type_fiche_succes & FICHE_SUCCES_AJOUTER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; ajout&eacute;<br />');
		if($type_fiche_succes & FICHE_SUCCES_MODIFIER) print('L\'&eacute;l&eacute;ment a bien &eacute;t&eacute; modifi&eacute;<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="type_fiche.php" method="post" enctype="multipart/form-data" id="formulaire">
              <input type="hidden" name="type_identifiant" id="type_identifiant" value="<?php print(ma_htmlentities($type->identifiant));?>" />
              <input type="hidden" name="type_fiche_mode" id="type_fiche_mode" value="<?php print(ma_htmlentities($_REQUEST['type_fiche_mode']));?>" />
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td>Identifiant : </td>
                  <td><?php print(ma_htmlentities($type->identifiant));?></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['type_fiche_submit']) && $type_fiche_erreur & TYPE_PARENT_ERREUR) print(' class="important"');?>>Parent : </td>
                  <td><select name="type_parent" id="type_parent">
				  	<option value="">Choisissez</option>
<?php
	$liste=new ld_liste
	('
		select
			identifiant,
			designation
		from type
		where parent is null
			and identifiant<>\''.addslashes($_REQUEST['type_identifiant']).'\'
		order by position
	');
	for($i=0;$i<sizeof($liste->occurrence);$i++)
		print('<option value="'.ma_htmlentities($liste->occurrence[$i]['identifiant']).'"'.(($liste->occurrence[$i]['identifiant']==$type->parent)?(' selected="selected"'):('')).'>'.ma_htmlentities($liste->occurrence[$i]['designation']).' ('.ma_htmlentities($liste->occurrence[$i]['identifiant']).')</option>');
?>
				    </select></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['type_fiche_submit']) && $type_fiche_erreur & TYPE_DESIGNATION_ERREUR) print(' class="important"');?>>D&eacute;signation : </td>
                  <td><input name="type_designation" type="text" id="type_designation" value="<?php print(ma_htmlentities($type->designation));?>" maxlength="<?php print(ma_htmlentities(TYPE_DESIGNATION_MAX))?>" /></td>
                </tr>
                <tr>
                  <td<?php if(isset($_REQUEST['saison_fiche_submit']) && ($type_fiche_erreur & TYPE_POSITION_ERREUR_VALEUR || $type_fiche_erreur & TYPE_POSITION_ERREUR_FILTRE)) print(' class="important"');?>>Position : </td>
                  <td><select name="type_position" id="type_position">
				    <option value="">Choisissez</option>
<?php
	$liste=new ld_liste
	('
		select
			identifiant,
			designation,
			position
		from type
		where
			position is not null
		order by position
	');
	for($i=0;$i<sizeof($liste->occurrence);$i++)
		print('<option value="'.ma_htmlentities($liste->occurrence[$i]['position']).'"'.(($liste->occurrence[$i]['position']==$type->position)?(' selected="selected"'):('')).'>'.ma_htmlentities($liste->occurrence[$i]['position'].TAB.': '.$liste->occurrence[$i]['designation'].' ('.$liste->occurrence[$i]['identifiant'].')').'</option>');
	print('<option value="'.ma_htmlentities($i+1).'"'.(($i+1==$_REQUEST['type_position'])?(' selected="selected"'):('')).'>'.ma_htmlentities(($i+1).TAB).': </option>');
?>
				  </select></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" name="type_fiche_submit" id="type_fiche_submit" value="Enregistrer" />
                    <input type="submit" name="type_fiche_submit" id="type_fiche_submit" value="Retour" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
