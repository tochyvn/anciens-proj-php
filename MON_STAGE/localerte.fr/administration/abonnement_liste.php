<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'abonnement.php');
	require_once(PWD_INCLUSION.'date.php');
	
	if(!isset($_SESSION['abonnement_page']))
		$_SESSION['abonnement_page']=1;
	if(!isset($_SESSION['abonnement_tri']))
		$_SESSION['abonnement_tri']='premiere_utilisation';
	if(!isset($_SESSION['abonnement_ordre']))
		$_SESSION['abonnement_ordre']='asc';
	if(!isset($_SESSION['abonnement_recherche']))
		$_SESSION['abonnement_recherche']='';
	
	if(isset($_REQUEST['abonnement_page']))
		$_SESSION['abonnement_page']=$_REQUEST['abonnement_page'];
	if(isset($_REQUEST['abonnement_tri']))
	{
		$_SESSION['abonnement_tri']=$_REQUEST['abonnement_tri'];
		if(!isset($_REQUEST['abonnement_ordre']) || $_REQUEST['abonnement_ordre']!='desc')
			$_REQUEST['abonnement_ordre']='asc';
	}
	if(isset($_REQUEST['abonnement_ordre']))
		$_SESSION['abonnement_ordre']=$_REQUEST['abonnement_ordre'];
	if(isset($_REQUEST['abonnement_adherent']))
		$_SESSION['abonnement_adherent']=$_REQUEST['abonnement_adherent'];
	
	require('abonnement_verification.php');
	
	$abonnement_liste_erreur=0;
	$abonnement_liste_succes=0;
	
	if(isset($_REQUEST['abonnement_liste_submit']))
	{
		switch($_REQUEST['abonnement_liste_submit'])
		{
			case 'Ajouter':
				header('location: '.url_use_trans_sid('abonnement_fiche.php'));
				die();
				break;
			case 'Modifier':
				if(isset($_REQUEST['abonnement_identifiant']))
				{
					if(sizeof($_REQUEST['abonnement_identifiant'])==1)
					{
						header('location: '.url_use_trans_sid('abonnement_fiche.php?abonnement_fiche_mode=modifier&abonnement_identifiant='.urlencode($_REQUEST['abonnement_identifiant'][0])));
						die();
					}
					else
						$abonnement_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$abonnement_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Supprimer':
				if(isset($_REQUEST['abonnement_identifiant']))
				{
					$abonnement_liste_succes=LISTE_SUCCES_SUPPRIMER;
					for($i=0;$i<sizeof($_REQUEST['abonnement_identifiant']);$i++)
					{
						$abonnement=new ld_abonnement();
						$abonnement->identifiant=$_REQUEST['abonnement_identifiant'][$i];
						if($abonnement->supprimer())
						{
							$abonnement_liste_succes=0;
							$abonnement_liste_erreur=LISTE_ERREUR_SUPPRIMER;
						}
					}
				}
				else
					$abonnement_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Retour aux adhérents':
				header('location: '.url_use_trans_sid('adherent_liste.php'));
				die();
				break;
		}
	}
	
	$liste=new ld_liste
	('
		select
			identifiant,
			delai,
			unix_timestamp(enregistrement) as enregistrement,
			unix_timestamp(premiere_utilisation) as premiere_utilisation,
			unix_timestamp(derniere_utilisation) as derniere_utilisation,
			unix_timestamp(premiere_utilisation)+delai as fin_utilisation
		from abonnement
		where 1
			and adherent=\''.addslashes($_SESSION['abonnement_adherent']).'\'
		'.$_SESSION['abonnement_recherche'].'
		order by `'.$_SESSION['abonnement_tri'].'` '.$_SESSION['abonnement_ordre'].'
		limit '.(($_SESSION['abonnement_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
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
          <th><?php print('Liste des abonnements pour l\'adh&eacute;rent '.ma_htmlentities($adherent->email.' ('.$adherent->identifiant.')'));?></th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['abonnement_liste_submit']) && $_REQUEST['abonnement_liste_submit']!='Annuler la recherche')
	{
		if($abonnement_liste_erreur & LISTE_ERREUR_AUCUN) print('Aucun &eacute;l&eacute;ment s&eacute;lectionn&eacute;<br />');
		if($abonnement_liste_erreur & LISTE_ERREUR_TROP) print('Trop d\'&eacute;l&eacute;ments s&eacute;lectionn&eacute;s<br />');
		if($abonnement_liste_erreur & LISTE_ERREUR_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous supprim&eacute;s<br />');
		if($abonnement_liste_succes & LISTE_SUCCES_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; supprim&eacute;s<br />');
		if($abonnement_liste_erreur & LISTE_ERREUR_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous modifi&eacute;s<br />');
		if($abonnement_liste_succes & LISTE_SUCCES_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; modifi&eacute;s<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="abonnement_liste.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'abonnement_liste.php','abonnement_page');?></td>
                  <td align="right"><input name="abonnement_liste_submit" type="submit" id="abonnement_liste_submit" value="Retour aux adh&eacute;rents" onclick="this.form.target='';" />
                    <input name="abonnement_liste_submit" type="submit" id="abonnement_liste_submit" value="Ajouter" onclick="this.form.target='';" />
                    <input name="abonnement_liste_submit" type="submit" id="abonnement_liste_submit" value="Modifier" onclick="this.form.target='';" />
                    <input name="abonnement_liste_submit" type="submit" id="abonnement_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
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
                          <a href="abonnement_liste.php?abonnement_tri=identifiant">&Lambda;</a> <a href="abonnement_liste.php?abonnement_tri=identifiant&abonnement_ordre=desc">V</a></td>
                        <td class="entete">Enregistrement<br />
                          <a href="abonnement_liste.php?abonnement_tri=enregistrement">&Lambda;</a> <a href="abonnement_liste.php?abonnement_tri=enregistrement&abonnement_ordre=desc">V</a></td>
                        <td class="entete">D&eacute;lai<br />
                          <a href="abonnement_liste.php?abonnement_tri=delai">&Lambda;</a> <a href="abonnement_liste.php?abonnement_tri=delai&abonnement_ordre=desc">V</a></td>
                        <td class="entete">Premi&egrave;re utilisation<br />
                          <a href="abonnement_liste.php?abonnement_tri=premiere_utilisation">&Lambda;</a> <a href="abonnement_liste.php?abonnement_tri=premiere_utilisation&abonnement_ordre=desc">V</a></td>
                        <td class="entete">Derni&egrave;re utilisation<br />
                          <a href="abonnement_liste.php?abonnement_tri=derniere_utilisation">&Lambda;</a> <a href="abonnement_liste.php?abonnement_tri=derniere_utilisation&abonnement_ordre=desc">V</a></td>
                        <td class="entete">Fin d'utilisation<br />
                          <a href="abonnement_liste.php?abonnement_tri=fin_utilisation">&Lambda;</a> <a href="abonnement_liste.php?abonnement_tri=fin_utilisation&abonnement_ordre=desc">V</a></td>
                        <td width="10" align="center"><script language="javascript" type="text/javascript">document.write('<input type="checkbox" id="cocher_abonnement_identifiant" onclick="liste_cocher(this,\'abonnement_identifiant[]\');" \/>');</script></td>
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
				    onclick="liste_onClick('abonnement_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('abonnement_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                        <td><?php print(ma_htmlentities(date(STRING_DATETIME,$liste->occurrence[$i]['enregistrement'])));?></td>
                        <td><?php print(ma_htmlentities(duree($liste->occurrence[$i]['delai'],'%jj %hh %mm %ss')));?></td>
                        <td><?php if($liste->occurrence[$i]['premiere_utilisation']) print(ma_htmlentities(date(STRING_DATETIME,$liste->occurrence[$i]['enregistrement'])));?></td>
                        <td><?php if($liste->occurrence[$i]['derniere_utilisation']) print(ma_htmlentities(date(STRING_DATETIME,$liste->occurrence[$i]['derniere_utilisation'])));?></td>
                        <td><?php if($liste->occurrence[$i]['fin_utilisation']) print(ma_htmlentities(date(STRING_DATETIME,$liste->occurrence[$i]['fin_utilisation'])));?></td>
                        <td width="10" align="center"><input type="checkbox" name="abonnement_identifiant[]" id="abonnement_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
                      </tr>
                      <?php
		}
?>
                    </table>
                    <?php
	}
	else
		print('<span class="important">Aucun &eacute;l&eacute;ment</span>');
?>
                  </td>
                </tr>
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'abonnement_liste.php','abonnement_page');?></td>
                  <td align="right"><input name="abonnement_liste_submit" type="submit" id="abonnement_liste_submit" value="Retour aux adh&eacute;rents" onclick="this.form.target='';" />
                    <input name="abonnement_liste_submit" type="submit" id="abonnement_liste_submit" value="Ajouter" onclick="this.form.target='';" />
                    <input name="abonnement_liste_submit" type="submit" id="abonnement_liste_submit" value="Modifier" onclick="this.form.target='';" />
                    <input name="abonnement_liste_submit" type="submit" id="abonnement_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
