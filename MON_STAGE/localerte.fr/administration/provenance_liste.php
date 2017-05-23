<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'provenance.php');
	
	if(!isset($_SESSION['provenance_page']))
		$_SESSION['provenance_page']=1;
	if(!isset($_SESSION['provenance_tri']))
		$_SESSION['provenance_tri']='designation';
	if(!isset($_SESSION['provenance_ordre']))
		$_SESSION['provenance_ordre']='asc';
	if(!isset($_SESSION['provenance_recherche']))
		$_SESSION['provenance_recherche']='';
	
	if(isset($_REQUEST['provenance_page']))
		$_SESSION['provenance_page']=$_REQUEST['provenance_page'];
	if(isset($_REQUEST['provenance_tri']))
	{
		$_SESSION['provenance_tri']=$_REQUEST['provenance_tri'];
		if(!isset($_REQUEST['provenance_ordre']) || $_REQUEST['provenance_ordre']!='desc')
			$_REQUEST['provenance_ordre']='asc';
	}
	if(isset($_REQUEST['provenance_ordre']))
		$_SESSION['provenance_ordre']=$_REQUEST['provenance_ordre'];
	
	$provenance_liste_erreur=0;
	$provenance_liste_succes=0;
	
	if(isset($_REQUEST['provenance_liste_submit']))
	{
		switch($_REQUEST['provenance_liste_submit'])
		{
			case 'Rechercher':
			case 'Modifier la recherche':
				header('location: '.url_use_trans_sid('provenance_recherche.php'));
				die();
				break;
			case 'Annuler la recherche':
				$_SESSION['provenance_recherche']='';
				break;
			case 'Ajouter':
				header('location: '.url_use_trans_sid('provenance_fiche.php'));
				die();
				break;
			case 'Modifier':
				if(isset($_REQUEST['provenance_identifiant']))
				{
					if(sizeof($_REQUEST['provenance_identifiant'])==1)
					{
						header('location: '.url_use_trans_sid('provenance_fiche.php?provenance_fiche_mode=modifier&provenance_identifiant='.urlencode($_REQUEST['provenance_identifiant'][0])));
						die();
					}
					else
						$provenance_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$provenance_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Supprimer':
				if(isset($_REQUEST['provenance_identifiant']))
				{
					$provenance_liste_succes=LISTE_SUCCES_SUPPRIMER;
					for($i=0;$i<sizeof($_REQUEST['provenance_identifiant']);$i++)
					{
						$provenance=new ld_provenance();
						$provenance->identifiant=$_REQUEST['provenance_identifiant'][$i];
						if($provenance->supprimer())
						{
							$provenance_liste_succes=0;
							$provenance_liste_erreur=LISTE_ERREUR_SUPPRIMER;
						}
					}
				}
				else
					$provenance_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
		}
	}
	
	$liste=new ld_liste
	('
		select
			identifiant,
			code,
			designation,
			url,
			couleur
		from provenance
		where 1
		'.$_SESSION['provenance_recherche'].'
		order by `'.$_SESSION['provenance_tri'].'` '.$_SESSION['provenance_ordre'].'
		limit '.(($_SESSION['provenance_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
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
          <th>Liste des provenances </th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['provenance_liste_submit']) && $_REQUEST['provenance_liste_submit']!='Annuler la recherche')
	{
		if($provenance_liste_erreur & LISTE_ERREUR_AUCUN) print('Aucun &eacute;l&eacute;ment s&eacute;lectionn&eacute;<br />');
		if($provenance_liste_erreur & LISTE_ERREUR_TROP) print('Trop d\'&eacute;l&eacute;ments s&eacute;lectionn&eacute;s<br />');
		if($provenance_liste_erreur & LISTE_ERREUR_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous supprim&eacute;s<br />');
		if($provenance_liste_succes & LISTE_SUCCES_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; supprim&eacute;s<br />');
		if($provenance_liste_erreur & LISTE_ERREUR_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous modifi&eacute;s<br />');
		if($provenance_liste_succes & LISTE_SUCCES_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; modifi&eacute;s<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="provenance_liste.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'provenance_liste.php','provenance_page');?></td>
                  <td align="right"><?php
	if($_SESSION['provenance_recherche']!='')
		print
		('
			<input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Modifier la recherche" onclick="this.form.target=\'\';" />
			<input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Annuler la recherche" onclick="this.form.target=\'\';" />
		');
	else
		print('<input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Rechercher" onclick="this.form.target=\'\';" />');
?>
                    <input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Ajouter" onclick="this.form.target='';" />
                    <input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Modifier" onclick="this.form.target='';" />
                    <input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
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
                          <a href="provenance_liste.php?provenance_tri=identifiant">&Lambda;</a> <a href="provenance_liste.php?provenance_tri=identifiant&provenance_ordre=desc">V</a></td>
                        <td class="entete">Code<br />
                          <a href="provenance_liste.php?provenance_tri=code">&Lambda;</a> <a href="provenance_liste.php?provenance_tri=code&provenance_ordre=desc">V</a></td>
                        <td class="entete">D&eacute;signation<br />
                          <a href="provenance_liste.php?provenance_tri=designation">&Lambda;</a> <a href="provenance_liste.php?provenance_tri=designation&provenance_ordre=desc">V</a></td>
                        <td class="entete">URL<br />
                          <a href="provenance_liste.php?provenance_tri=url">&Lambda;</a> <a href="provenance_liste.php?provenance_tri=url&provenance_ordre=desc">V</a></td>
                        <td class="entete">Couleur<br />
                        &nbsp;</td>
                        <td width="10" align="center"><script language="javascript" type="text/javascript">document.write('<input type="checkbox" id="cocher_provenance_identifiant" onclick="liste_cocher(this,\'provenance_identifiant[]\');" \/>');</script></td>
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
				    onclick="liste_onClick('provenance_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('provenance_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['code']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['designation']));?></td>
                        <td><?php print('<a href="'.$liste->occurrence[$i]['url'].'" target="_blank">'.ma_htmlentities($liste->occurrence[$i]['url']).'</a>');?></td>
                        <td><?php print('<img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=35&y=15&c='.urlencode($liste->occurrence[$i]['couleur']).'" alt="'.ma_htmlentities($liste->occurrence[$i]['couleur']).'" title="'.ma_htmlentities($liste->occurrence[$i]['couleur']).'" />');?></td>
                        <td width="10" align="center"><input type="checkbox" name="provenance_identifiant[]" id="provenance_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
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
                  <td nowrap="nowrap"><?php print_pagination($liste,'provenance_liste.php','provenance_page');?></td>
                  <td align="right"><?php
	if($_SESSION['provenance_recherche']!='')
		print
		('
			<input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Modifier la recherche" onclick="this.form.target=\'\';" />
			<input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Annuler la recherche" onclick="this.form.target=\'\';" />
		');
	else
		print('<input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Rechercher" onclick="this.form.target=\'\';" />');
?>
                    <input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Ajouter" onclick="this.form.target='';" />
                    <input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Modifier" onclick="this.form.target='';" />
                    <input name="provenance_liste_submit" type="submit" id="provenance_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
