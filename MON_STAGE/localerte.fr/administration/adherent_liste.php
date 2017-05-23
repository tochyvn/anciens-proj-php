<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	if(!isset($_SESSION['adherent_page']))
		$_SESSION['adherent_page']=1;
	if(!isset($_SESSION['adherent_tri']))
		$_SESSION['adherent_tri']='identifiant';
	if(!isset($_SESSION['adherent_ordre']))
		$_SESSION['adherent_ordre']='asc';
	if(!isset($_SESSION['adherent_recherche']) || $_SESSION['adherent_recherche']=='')
	{
		header('location: '.url_use_trans_sid('adherent_recherche.php'));
		die();
	}
	
	if(isset($_REQUEST['adherent_page']))
		$_SESSION['adherent_page']=$_REQUEST['adherent_page'];
	if(isset($_REQUEST['adherent_tri']))
	{
		$_SESSION['adherent_tri']=$_REQUEST['adherent_tri'];
		if(!isset($_REQUEST['adherent_ordre']) || $_REQUEST['adherent_ordre']!='desc')
			$_REQUEST['adherent_ordre']='asc';
	}
	if(isset($_REQUEST['adherent_ordre']))
		$_SESSION['adherent_ordre']=$_REQUEST['adherent_ordre'];
	
	$adherent_liste_erreur=0;
	$adherent_liste_succes=0;
	
	if(isset($_REQUEST['adherent_liste_submit']))
	{
		switch($_REQUEST['adherent_liste_submit'])
		{
			case 'Rechercher':
			case 'Modifier la recherche':
				header('location: '.url_use_trans_sid('adherent_recherche.php'));
				die();
				break;
			case 'Annuler la recherche':
				$_SESSION['adherent_recherche']='';
				break;
			case 'Abonnement en masse':
				header('location: '.url_use_trans_sid('adherent_abonne.php'));
				die();
				break;
			case 'Supprimer':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_SUPPRIMER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						if($adherent->supprimer())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_SUPPRIMER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Abonner':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_MODIFIER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						$adherent->lire();
						$adherent->abonne='OUI';
						if($adherent->modifier())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_MODIFIER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Désabonner':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_MODIFIER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						$adherent->lire();
						$adherent->abonne='NON';
						if($adherent->modifier())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_MODIFIER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Spamtrap':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_MODIFIER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						$adherent->lire();
						$adherent->spamtrap='OUI';
						if($adherent->modifier())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_MODIFIER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Pas spamtrap':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_MODIFIER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						$adherent->lire();
						$adherent->spamtrap='NON';
						if($adherent->modifier())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_MODIFIER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Bruler':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_MODIFIER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						$adherent->lire();
						$adherent->brule='OUI';
						if($adherent->modifier())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_MODIFIER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Débruler':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_MODIFIER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						$adherent->lire();
						$adherent->brule='NON';
						if($adherent->modifier())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_MODIFIER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Valider':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_MODIFIER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						$adherent->lire();
						$adherent->validation='OUI';
						if($adherent->modifier())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_MODIFIER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Dévalider':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					$adherent_liste_succes=LISTE_SUCCES_MODIFIER;
					for($i=0;$i<sizeof($_REQUEST['adherent_identifiant']);$i++)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][$i];
						$adherent->lire();
						$adherent->validation='NON';
						if($adherent->modifier())
						{
							$adherent_liste_succes=0;
							$adherent_liste_erreur=LISTE_ERREUR_MODIFIER;
						}
					}
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Compte':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					if(sizeof($_REQUEST['adherent_identifiant'])==1)
					{
						$adherent=new ld_adherent();
						$adherent->identifiant=$_REQUEST['adherent_identifiant'][0];
						$adherent->lire();
						header('location: '.url_use_trans_sid(URL_ADHERENT.'bienvenue.php?connexion_email='.urlencode($adherent->email).'&connexion_passe='.urlencode($adherent->passe).'&connexion_submit=Connexion'));
						die();
						//$adherent=new ld_adherent();
						//$adherent->identifiant=$_REQUEST['adherent_identifiant'][0];
						//$adherent->lire();
						//header('location: '.url_use_trans_sid(URL_ADHERENT.'index.php?connexion_email='.urlencode($adherent->email).'&connexion_passe='.urlencode($adherent->passe).'&connexion_submit='.urlencode('Connexion')));
						//die();
					}
					else
						$adherent_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Les abonnements':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					if(sizeof($_REQUEST['adherent_identifiant'])==1)
					{
						header('location: '.url_use_trans_sid('abonnement_liste.php?abonnement_adherent='.urlencode($_REQUEST['adherent_identifiant'][0])));
						die();
					}
					else
						$adherent_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'Les factures':
				if(isset($_REQUEST['adherent_identifiant']))
				{
					if(sizeof($_REQUEST['adherent_identifiant'])==1)
					{
						header('location: '.url_use_trans_sid('facture_liste.php?facture_adherent='.urlencode($_REQUEST['adherent_identifiant'][0])));
						die();
					}
					else
						$adherent_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$adherent_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
		}
	}
	
	$liste=new ld_liste
	('
		select
			identifiant,
			'.($_SESSION['administrateur_pseudonyme']=='aicom'?'email':'\'\' as email').',
			passe,
			unix_timestamp(date_enregistrement) as date_enregistrement,
			unix_timestamp(date_resiliation) as date_resiliation,
			unix_timestamp(date_abonnement) as date_abonnement,
			unix_timestamp(date_action) as date_action,
			abonne,
			brule,
			validation,
			spamtrap,
			code,
			hardbounce,
			softbounce,
			plainte
		from adherent
		where 1
		'.$_SESSION['adherent_recherche'].'
		order by `'.$_SESSION['adherent_tri'].'` '.$_SESSION['adherent_ordre'].'
		limit '.(($_SESSION['adherent_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
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
          <th>Liste des adh&eacute;rents</th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['adherent_liste_submit']) && $_REQUEST['adherent_liste_submit']!='Annuler la recherche')
	{
		if($adherent_liste_erreur & LISTE_ERREUR_AUCUN) print('Aucun &eacute;l&eacute;ment s&eacute;lectionn&eacute;<br />');
		if($adherent_liste_erreur & LISTE_ERREUR_TROP) print('Trop d\'&eacute;l&eacute;ments s&eacute;lectionn&eacute;s<br />');
		if($adherent_liste_erreur & LISTE_ERREUR_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous supprim&eacute;s<br />');
		if($adherent_liste_succes & LISTE_SUCCES_SUPPRIMER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; supprim&eacute;s<br />');
		if($adherent_liste_erreur & LISTE_ERREUR_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous modifi&eacute;s<br />');
		if($adherent_liste_succes & LISTE_SUCCES_MODIFIER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; modifi&eacute;s<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="adherent_liste.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'adherent_liste.php','adherent_page');?></td>
                  <td align="right"><?php
	if($_SESSION['adherent_recherche']!='')
		print
		('
			<input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Modifier la recherche" onclick="this.form.target=\'\';" />
			<input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Annuler la recherche" onclick="this.form.target=\'\';" />
		');
	else
		print('<input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Rechercher" onclick="this.form.target=\'\';" />');
?>
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Compte" onclick="this.form.target='_blank';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Abonner" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="D&eacute;sabonner" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Abonnement en masse" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Bruler" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="D&eacute;bruler" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Valider" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="D&eacute;valider" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Spamtrap" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Pas spamtrap" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Les abonnements" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Les factures" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
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
                          <a href="adherent_liste.php?adherent_tri=identifiant">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=identifiant&adherent_ordre=desc">V</a></td>
                        <td class="entete">Email<br />
                          <a href="adherent_liste.php?adherent_tri=email">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=email&adherent_ordre=desc">V</a></td>
                        <td class="entete">Passe<br />
                          <a href="adherent_liste.php?adherent_tri=passe">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=passe&adherent_ordre=desc">V</a></td>
                        <td class="entete">Abonn&eacute;<br />
                          <a href="adherent_liste.php?adherent_tri=abonne">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=abonne&adherent_ordre=desc">V</a></td>
                        <td class="entete">Brul&eacute;<br />
                          <a href="adherent_liste.php?adherent_tri=brule">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=brule&adherent_ordre=desc">V</a></td>
                        <td class="entete">Validation<br />
                          <a href="adherent_liste.php?adherent_tri=validation">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=validation&adherent_ordre=desc">V</a></td>
                        <td class="entete">Spamtrap<br />
                          <a href="adherent_liste.php?adherent_tri=spamtrap">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=spamtrap&adherent_ordre=desc">V</a></td>
                        <td class="entete">Hardbounce<br />
                          <a href="adherent_liste.php?adherent_tri=hardbounce">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=hardbounce&adherent_ordre=desc">V</a></td>
                        <td class="entete">SoftBounce<br />
                          <a href="adherent_liste.php?adherent_tri=softbounce">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=softbounce&amp;adherent_ordre=desc">V</a></td>
                        <td class="entete">Plaintes<br />
                          <a href="adherent_liste.php?adherent_tri=plainte">&Lambda;</a> <a href="adherent_liste.php?adherent_tri=plainte&adherent_ordre=desc">V</a></td>
                        <td class="entete" style="text-align:center;">Cryptage</td>
                        <td width="10" align="center"><script language="javascript" type="text/javascript">document.write('<input type="checkbox" id="cocher_adherent_identifiant" onclick="liste_cocher(this,\'adherent_identifiant[]\');" \/>');</script></td>
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
				    onclick="liste_onClick('adherent_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('adherent_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                        <td><a href="mail_envoi.php?mail_a=<?php print(urlencode($liste->occurrence[$i]['email']));?>"><?php print(ma_htmlentities($liste->occurrence[$i]['email']));?></a></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['passe']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['abonne'].' ('.date('d/m/y',($liste->occurrence[$i]['abonne']=='OUI')?($liste->occurrence[$i]['date_abonnement']):($liste->occurrence[$i]['date_resiliation'])).')'));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['brule']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['validation']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['spamtrap']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['hardbounce']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['softbounce']));?></td>
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['plainte']));?></td>
                        <td style="text-align:center;"><a href="adherent_cryptage.php?adherent_identifiant=<?php print(urlencode($liste->occurrence[$i]['identifiant']));?>" target="_blank" onclick="liste_onUnClick(this,2); return !OuvrirPopup(this.href,true,'adherent_cryptage','width=640,height=480');">Voir</a></td>
                        <td width="10" align="center"><input type="checkbox" name="adherent_identifiant[]" id="adherent_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" value="<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
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
                  <td nowrap="nowrap"><?php print_pagination($liste,'adherent_liste.php','adherent_page');?></td>
                  <td align="right"><?php
	if($_SESSION['adherent_recherche']!='')
		print
		('
			<input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Modifier la recherche" onclick="this.form.target=\'\';" />
			<input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Annuler la recherche" onclick="this.form.target=\'\';" />
		');
	else
		print('<input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Rechercher" onclick="this.form.target=\'\';" />');
?>
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Compte" onclick="this.form.target='_blank';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Abonner" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="D&eacute;sabonner" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Abonnement en masse" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Bruler" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="D&eacute;bruler" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Valider" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="D&eacute;valider" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Spamtrap" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Pas spamtrap" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Les abonnements" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Les factures" onclick="this.form.target='';" />
                    <input name="adherent_liste_submit" type="submit" id="adherent_liste_submit" value="Supprimer" onclick="this.form.target=''; return confirm('&Ecirc;tes-vous certain de vouloir supprimer les &eacute;l&eacute;ments s&eacute;lectionne&eacute;s ?');" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
