<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'type.php');
	
	if(!isset($_SESSION['type_page']))
		$_SESSION['type_page']=1;
	if(!isset($_SESSION['type_tri']))
		$_SESSION['type_tri']='designation';
	if(!isset($_SESSION['type_ordre']))
		$_SESSION['type_ordre']='asc';
	if(!isset($_SESSION['type_recherche']))
		$_SESSION['type_recherche']='';
	
	if(isset($_REQUEST['type_page']))
		$_SESSION['type_page']=$_REQUEST['type_page'];
	if(isset($_REQUEST['type_tri']))
	{
		$_SESSION['type_tri']=$_REQUEST['type_tri'];
		if(!isset($_REQUEST['type_ordre']) || $_REQUEST['type_ordre']!='desc')
			$_REQUEST['type_ordre']='asc';
	}
	if(isset($_REQUEST['type_ordre']))
		$_SESSION['type_ordre']=$_REQUEST['type_ordre'];
	
	$type_liste_erreur=0;
	$type_liste_succes=0;
	
	if(isset($_REQUEST['type_liste_submit']))
	{
		switch($_REQUEST['type_liste_submit'])
		{
			case 'Rechercher':
			case 'Modifier la recherche':
				header('location: '.url_use_trans_sid('type_recherche.php'));
				die();
				break;
			case 'Annuler la recherche':
				$_SESSION['type_recherche']='';
				break;
			case 'Ajouter':
				header('location: '.url_use_trans_sid('type_fiche.php'));
				die();
				break;
			case 'Modifier':
				if(isset($_REQUEST['type_identifiant']))
				{
					if(sizeof($_REQUEST['type_identifiant'])==1)
					{
						header('location: '.url_use_trans_sid('type_fiche.php?type_fiche_mode=modifier&type_identifiant='.urlencode($_REQUEST['type_identifiant'][0])));
						die();
					}
					else
						$type_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$type_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Supprimer':
				if(isset($_REQUEST['type_identifiant']))
				{
					$type_liste_succes=LISTE_SUCCES_SUPPRIMER;
					for($i=0;$i<sizeof($_REQUEST['type_identifiant']);$i++)
					{
						$type=new ld_type();
						$type->identifiant=$_REQUEST['type_identifiant'][$i];
						if($type->supprimer())
						{
							$type_liste_succes=0;
							$type_liste_erreur=LISTE_ERREUR_SUPPRIMER;
						}
					}
				}
				else
					$type_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
		}
	}
	
	$liste=new ld_liste
	('
		select
			type.identifiant as identifiant,
			parent.identifiant as parent_identifiant,
			parent.designation as parent_designation,
			type.designation as designation,
			type.position as position
		from type
			left join type parent on type.parent=parent.identifiant
		where 1
		'.$_SESSION['type_recherche'].'
		order by `'.$_SESSION['type_tri'].'` '.$_SESSION['type_ordre'].'
		limit '.(($_SESSION['type_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
	',LISTE_PAGE);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once('tete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<table cellspacing="0" cellpadding="4">
  <tr>
    <td valign="top" class="sommaire"><?php include('sommaire.php')?></td>
    <td valign="top"><table cellspacing="0" cellpadding="4">
        <tr>
          <th>Liste des types </th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['type_liste_submit']) && $_REQUEST['type_liste_submit']!='Annuler la recherche')
	{
		if($type_liste_erreur & LISTE_ERREUR_AUCUN) print('Aucun &eacute;l&eacute;ment s&eacute;lectionn&eacute;<br />');
		if($type_liste_erreur & LISTE_ERREUR_TROP) print('Trop d\'&eacute;l&eacute;ments s&eacute;lectionn&eacute;s<br />');
		if($type_liste_erreur & LISTE_ERREUR_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous supprim&eacute;s<br />');
		if($type_liste_succes & LISTE_SUCCES_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; supprim&eacute;s<br />');
		if($type_liste_erreur & LISTE_ERREUR_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous modifi&eacute;s<br />');
		if($type_liste_succes & LISTE_SUCCES_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; modifi&eacute;s<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="type_liste.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'type_liste.php','type_page');?></td>
                  <td align="right"><?php
	if($_SESSION['type_recherche']!='')
		print
		('
			<input name="type_liste_submit" type="submit" id="type_liste_submit" value="Modifier la recherche" onclick="this.form.target=\'\';" />
			<input name="type_liste_submit" type="submit" id="type_liste_submit" value="Annuler la recherche" onclick="this.form.target=\'\';" />
		');
	else
		print('<input name="type_liste_submit" type="submit" id="type_liste_submit" value="Rechercher" onclick="this.form.target=\'\';" />');
?>
                    <input name="type_liste_submit" type="submit" id="type_liste_submit" value="Ajouter" onclick="this.form.target='';" />
                    <input name="type_liste_submit" type="submit" id="type_liste_submit" value="Modifier" onclick="this.form.target='';" />
                    <input name="type_liste_submit" type="submit" id="type_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
                </tr>
                <tr>
                  <td colspan="2"><?php
	if($liste->total)
	{
?>
                    <table cellspacing="0" cellpadding="4">
                      <?php
		for($i=0;$i<sizeof($liste->occurrence);$i++)
		{
			if($i%LISTE_RAPPEL_ENTETE==0)
			{
?>
                      <tr>
                        <td class="entete">Identifiant<br />
                          <a href="type_liste.php?type_tri=identifiant">&Lambda;</a> <a href="type_liste.php?type_tri=identifiant&type_ordre=desc">V</a></td>
                        <td class="entete">Parent<br />
                          <a href="type_liste.php?type_tri=parent_designation">&Lambda;</a> <a href="type_liste.php?type_tri=parent_designation&type_ordre=desc">V</a></td>
                        <td class="entete">D&eacute;signation<br />
                          <a href="type_liste.php?type_tri=designation">&Lambda;</a> <a href="type_liste.php?type_tri=designation&type_ordre=desc">V</a></td>
                        <td class="entete">Position<br />
                          <a href="type_liste.php?type_tri=position">&Lambda;</a> <a href="type_liste.php?type_tri=position&type_ordre=desc">V</a></td>
                        <td width="10" align="center"><script language="javascript" type="text/javascript">document.write('<input type="checkbox" id="cocher_type_identifiant" onclick="liste_cocher(this,\'type_identifiant[]\');" \/>');</script></td>
                      </tr>
                      <?php
			}
			$couleur_survol=LISTE_SURVOL;
			$couleur_click=LISTE_CLICK;
			if($i%2)
				$couleur_courant=LISTE_IMPAIR;
			else
				$couleur_courant=LISTE_PAIR;
?>
                      <tr
				    style="background-color: <?php print($couleur_courant);?>;"
					onmouseover="liste_onMouseOver(this,'<?php print($couleur_survol);?>');"
					onmouseout="liste_onMouseOut(this,'<?php print($couleur_courant);?>');"
				    onclick="liste_onClick('type_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('type_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                        <td><?php if($liste->occurrence[$i]['parent_identifiant']!==NULL) print(ma_htmlentities($liste->occurrence[$i]['parent_designation'].' ('.$liste->occurrence[$i]['parent_identifiant'].')'));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['designation']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['position']));?></td>
                        <td width="10" align="center"><input type="checkbox" name="type_identifiant[]" id="type_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
                      </tr>
                      <?php
		}
?>
                    </table>
                  <?php
	}
	else
		print('<span class="important">Aucun &eacute;l&eacute;ment</span>');
?>                  </td>
                </tr>
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'type_liste.php','type_page');?></td>
                  <td align="right"><?php
	if($_SESSION['type_recherche']!='')
		print
		('
			<input name="type_liste_submit" type="submit" id="type_liste_submit" value="Modifier la recherche" onclick="this.form.target=\'\';" />
			<input name="type_liste_submit" type="submit" id="type_liste_submit" value="Annuler la recherche" onclick="this.form.target=\'\';" />
		');
	else
		print('<input name="type_liste_submit" type="submit" id="type_liste_submit" value="Rechercher" onclick="this.form.target=\'\';" />');
?>
                    <input name="type_liste_submit" type="submit" id="type_liste_submit" value="Ajouter" onclick="this.form.target='';" />
                    <input name="type_liste_submit" type="submit" id="type_liste_submit" value="Modifier" onclick="this.form.target='';" />
                    <input name="type_liste_submit" type="submit" id="type_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
