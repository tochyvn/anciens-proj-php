<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'hardbounce.php');
	
	if(!isset($_SESSION['hardbounce_page']))
		$_SESSION['hardbounce_page']=1;
	if(!isset($_SESSION['hardbounce_tri']))
		$_SESSION['hardbounce_tri']='expression';
	if(!isset($_SESSION['hardbounce_ordre']))
		$_SESSION['hardbounce_ordre']='asc';
	if(!isset($_SESSION['hardbounce_recherche']))
		$_SESSION['hardbounce_recherche']='';
	
	if(isset($_REQUEST['hardbounce_page']))
		$_SESSION['hardbounce_page']=$_REQUEST['hardbounce_page'];
	if(isset($_REQUEST['hardbounce_tri']))
	{
		$_SESSION['hardbounce_tri']=$_REQUEST['hardbounce_tri'];
		if(!isset($_REQUEST['hardbounce_ordre']) || $_REQUEST['hardbounce_ordre']!='desc')
			$_REQUEST['hardbounce_ordre']='asc';
	}
	if(isset($_REQUEST['hardbounce_ordre']))
		$_SESSION['hardbounce_ordre']=$_REQUEST['hardbounce_ordre'];
	
	$hardbounce_liste_erreur=0;
	$hardbounce_liste_succes=0;
	
	if(isset($_REQUEST['hardbounce_liste_submit']))
	{
		switch($_REQUEST['hardbounce_liste_submit'])
		{
			case 'Rechercher':
			case 'Modifier la recherche':
				header('location: '.url_use_trans_sid('hardbounce_recherche.php'));
				die();
				break;
			case 'Annuler la recherche':
				$_SESSION['hardbounce_recherche']='';
				break;
			case 'Ajouter':
				header('location: '.url_use_trans_sid('hardbounce_fiche.php'));
				die();
				break;
			case 'Modifier':
				if(isset($_REQUEST['hardbounce_identifiant']))
				{
					if(sizeof($_REQUEST['hardbounce_identifiant'])==1)
					{
						header('location: '.url_use_trans_sid('hardbounce_fiche.php?hardbounce_fiche_mode=modifier&hardbounce_identifiant='.urlencode($_REQUEST['hardbounce_identifiant'][0])));
						die();
					}
					else
						$hardbounce_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$hardbounce_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Supprimer':
				if(isset($_REQUEST['hardbounce_identifiant']))
				{
					$hardbounce_liste_succes=LISTE_SUCCES_SUPPRIMER;
					for($i=0;$i<sizeof($_REQUEST['hardbounce_identifiant']);$i++)
					{
						$hardbounce=new ld_hardbounce();
						$hardbounce->identifiant=$_REQUEST['hardbounce_identifiant'][$i];
						if($hardbounce->supprimer())
						{
							$hardbounce_liste_succes=0;
							$hardbounce_liste_erreur=LISTE_ERREUR_SUPPRIMER;
						}
					}
				}
				else
					$hardbounce_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
		}
	}
	
	$liste=new ld_liste
	('
		select
			identifiant,
			expression,
			casse,
			negatif,
			description
		from hardbounce
		where 1
		'.$_SESSION['hardbounce_recherche'].'
		order by `'.$_SESSION['hardbounce_tri'].'` '.$_SESSION['hardbounce_ordre'].'
		limit '.(($_SESSION['hardbounce_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
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
          <th>Liste des hardbounces </th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['hardbounce_liste_submit']) && $_REQUEST['hardbounce_liste_submit']!='Annuler la recherche')
	{
		if($hardbounce_liste_erreur & LISTE_ERREUR_AUCUN) print('Aucun &eacute;l&eacute;ment s&eacute;lectionn&eacute;<br />');
		if($hardbounce_liste_erreur & LISTE_ERREUR_TROP) print('Trop d\'&eacute;l&eacute;ments s&eacute;lectionn&eacute;s<br />');
		if($hardbounce_liste_erreur & LISTE_ERREUR_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous supprim&eacute;s<br />');
		if($hardbounce_liste_succes & LISTE_SUCCES_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; supprim&eacute;s<br />');
		if($hardbounce_liste_erreur & LISTE_ERREUR_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous modifi&eacute;s<br />');
		if($hardbounce_liste_succes & LISTE_SUCCES_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; modifi&eacute;s<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="hardbounce_liste.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'hardbounce_liste.php','hardbounce_page');?></td>
                  <td align="right"><?php
	if($_SESSION['hardbounce_recherche']!='')
		print
		('
			<input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Modifier la recherche" onclick="this.form.target=\'\';" />
			<input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Annuler la recherche" onclick="this.form.target=\'\';" />
		');
	else
		print('<input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Rechercher" onclick="this.form.target=\'\';" />');
?>
                    <input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Ajouter" onclick="this.form.target='';" />
                    <input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Modifier" onclick="this.form.target='';" />
                    <input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
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
                          <a href="hardbounce_liste.php?hardbounce_tri=identifiant">&Lambda;</a> <a href="hardbounce_liste.php?hardbounce_tri=identifiant&hardbounce_ordre=desc">V</a></td>
                        <td class="entete">Expression<br />
                          <a href="hardbounce_liste.php?hardbounce_tri=expression">&Lambda;</a> <a href="hardbounce_liste.php?hardbounce_tri=expression&hardbounce_ordre=desc">V</a></td>
                        <td class="entete">Casse<br />
                          <a href="hardbounce_liste.php?hardbounce_tri=casse">&Lambda;</a> <a href="hardbounce_liste.php?hardbounce_tri=casse&hardbounce_ordre=desc">V</a></td>
                        <td class="entete">Negatif<br />
                          <a href="hardbounce_liste.php?hardbounce_tri=negatif">&Lambda;</a> <a href="hardbounce_liste.php?hardbounce_tri=negatif&hardbounce_ordre=desc">V</a></td>
                        <td class="entete">D&eacute;scription<br />
                          <a href="hardbounce_liste.php?hardbounce_tri=description">&Lambda;</a> <a href="hardbounce_liste.php?hardbounce_tri=description&hardbounce_ordre=desc">V</a></td>
                        <td width="10" align="center"><script language="javascript" type="text/javascript">document.write('<input type="checkbox" id="cocher_hardbounce_identifiant" onclick="liste_cocher(this,\'hardbounce_identifiant[]\');" \/>');</script></td>
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
				    onclick="liste_onClick('hardbounce_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('hardbounce_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['expression']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['casse']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['negatif']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['description']));?></td>
                        <td width="10" align="center"><input type="checkbox" name="hardbounce_identifiant[]" id="hardbounce_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
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
                  <td nowrap="nowrap"><?php print_pagination($liste,'hardbounce_liste.php','hardbounce_page');?></td>
                  <td align="right"><?php
	if($_SESSION['hardbounce_recherche']!='')
		print
		('
			<input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Modifier la recherche" onclick="this.form.target=\'\';" />
			<input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Annuler la recherche" onclick="this.form.target=\'\';" />
		');
	else
		print('<input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Rechercher" onclick="this.form.target=\'\';" />');
?>
                    <input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Ajouter" onclick="this.form.target='';" />
                    <input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Modifier" onclick="this.form.target='';" />
                    <input name="hardbounce_liste_submit" type="submit" id="hardbounce_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
