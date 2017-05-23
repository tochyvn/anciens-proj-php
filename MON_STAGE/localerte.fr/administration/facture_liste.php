<?php
	require_once('configuration.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'tarif_forfait.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'facture_pdf.php');
	require_once(PWD_INCLUSION.'mail.php');
	
	if(!isset($_SESSION['facture_page']))
		$_SESSION['facture_page']=1;
	if(!isset($_SESSION['facture_tri']))
		$_SESSION['facture_tri']='emission';
	if(!isset($_SESSION['facture_ordre']))
		$_SESSION['facture_ordre']='desc';
	if(!isset($_SESSION['facture_recherche']))
		$_SESSION['facture_recherche']='';
	if(!isset($_SESSION['facture_adherent']))
		$_SESSION['facture_adherent']='';
	
	if(isset($_REQUEST['facture_page']))
		$_SESSION['facture_page']=$_REQUEST['facture_page'];
	if(isset($_REQUEST['facture_tri']))
	{
		$_SESSION['facture_tri']=$_REQUEST['facture_tri'];
		if(!isset($_REQUEST['facture_ordre']) || $_REQUEST['facture_ordre']!='desc')
			$_REQUEST['facture_ordre']='asc';
	}
	if(isset($_REQUEST['facture_ordre']))
		$_SESSION['facture_ordre']=$_REQUEST['facture_ordre'];
	if(isset($_REQUEST['facture_adherent']))
		$_SESSION['facture_adherent']=$_REQUEST['facture_adherent'];
	
	$adherent=new ld_adherent();
	$adherent->identifiant=$_SESSION['facture_adherent'];
	$adherent->lire();	
	
	$facture_liste_erreur=0;
	$facture_liste_succes=0;
	
	if(isset($_REQUEST['facture_liste_submit']))
	{
		switch($_REQUEST['facture_liste_submit'])
		{
			case 'voir':
				if(isset($_REQUEST['facture_identifiant']))
				{
					if(sizeof($_REQUEST['facture_identifiant'])==1)
					{
						$facture_pdf=new ld_facture_pdf();
						$facture_pdf->creer($_REQUEST['facture_identifiant'][0],'I');
						die();
					}
					else
						$facture_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$facture_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'annuler':
				if(isset($_REQUEST['facture_identifiant']))
				{
					if(sizeof($_REQUEST['facture_identifiant'])==1)
					{
						$facture_liste_succes=LISTE_SUCCES_ANNULER;
						$facture=new ld_facture();
						$facture->identifiant=$_REQUEST['facture_identifiant'][0];
						if($facture->annuler())
						{
							$facture_liste_succes=0;
							$facture_liste_erreur=LISTE_ERREUR_ANNULER;
						}
					}
					else
						$facture_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$facture_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'payer NULL':
			case 'payer CHEQUE':
			case 'payer WHA':
			case 'payer PAYPAL':
			case 'payer CB':
				if(isset($_REQUEST['facture_identifiant']))
				{
					if(sizeof($_REQUEST['facture_identifiant'])==1)
					{
						$facture_liste_succes=LISTE_SUCCES_PAYER+LISTE_SUCCES_ENVOYER;
						$facture=new ld_facture();
						$facture->identifiant=$_REQUEST['facture_identifiant'][0];
						
						if($_REQUEST['facture_liste_submit']=='payer NULL') $mode=NULL;
						elseif($_REQUEST['facture_liste_submit']=='payer CHEQUE') $mode='CHEQUE';
						elseif($_REQUEST['facture_liste_submit']=='payer WHA') $mode='WHA';
						elseif($_REQUEST['facture_liste_submit']=='payer PAYPAL') $mode='PAYPAL';
						elseif($_REQUEST['facture_liste_submit']=='payer CB') $mode='CB';
						
						if($facture->payer($mode))
						{
							$facture_liste_succes=0;
							$facture_liste_erreur=LISTE_ERREUR_PAYER+LISTE_ERREUR_ENVOYER;
						}
						elseif($facture->envoyer()!==true)
						{
							$facture_liste_succes-=LISTE_SUCCES_ENVOYER;
							$facture_liste_erreur=LISTE_ERREUR_PAYER;							
						}
					}
					else
						$facture_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$facture_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'envoyer':
				if(isset($_REQUEST['facture_identifiant']))
				{
					if(sizeof($_REQUEST['facture_identifiant'])==1)
					{
						$facture_liste_succes+=LISTE_SUCCES_ENVOYER;
						$facture=new ld_facture();
						$facture->identifiant=$_REQUEST['facture_identifiant'][0];
						if($facture->envoyer()!==true)
						{
							$facture_liste_succes=0;
							$facture_liste_erreur+=LISTE_ERREUR_ENVOYER;
						}
					}
					else
						$facture_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$facture_liste_erreur=LISTE_ERREUR_AUCUN;
				break;
			case 'forfait':
				if(isset($_REQUEST['facture_identifiant']))
				{
					if(sizeof($_REQUEST['facture_identifiant'])==1)
					{
						$facture_liste_succes+=LISTE_SUCCES_ENVOYER;
						$facture=new ld_facture();
						$facture->identifiant=$_REQUEST['facture_identifiant'][0];
						if($facture->envoyer('forfait')!==true)
						{
							$facture_liste_succes=0;
							$facture_liste_erreur+=LISTE_ERREUR_ENVOYER;
						}
					}
					else
						$facture_liste_erreur=LISTE_ERREUR_TROP;
				}
				else
					$facture_liste_erreur=LISTE_ERREUR_AUCUN;
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
			facture.identifiant as identifiant,
			facture.statut as statut,
			unix_timestamp(facture.emission) as emission,
			unix_timestamp(facture.paiement) as paiement,
			sum(facture_ligne.prix_ht*facture_ligne.quantite) as montant_ht,
			sum(facture_ligne.prix_ht*facture_ligne.quantite*facture_ligne.tva/100) as montant_tva,
			sum(facture_ligne.prix_ht*facture_ligne.quantite*(1+facture_ligne.tva/100)) as montant_ttc,
			tarif_forfait.identifiant as forfait
		from facture
			inner join facture_ligne on facture.identifiant=facture_ligne.facture
			left join tarif_forfait on facture_ligne.reference=tarif_forfait.identifiant
		where 1
		'.$_SESSION['facture_recherche'].'
			and facture.adherent=\''.addslashes($_SESSION['facture_adherent']).'\'
		group by facture.identifiant
		order by `'.$_SESSION['facture_tri'].'` '.$_SESSION['facture_ordre'].'
		limit '.(($_SESSION['facture_page']-1)*LISTE_INTERVAL).','.LISTE_INTERVAL.'
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
          <th><?php print('Liste des factures pour l\'adh&eacute;rent '.ma_htmlentities($adherent->email.' ('.$adherent->identifiant.')'));?></th>
        </tr>
        <tr>
          <td class="important"><?php
	if(isset($_REQUEST['facture_liste_submit']) && $_REQUEST['facture_liste_submit']!='Annuler la recherche')
	{
		if($facture_liste_erreur & LISTE_ERREUR_AUCUN) print('Aucun &eacute;l&eacute;ment s&eacute;lectionn&eacute;<br />');
		if($facture_liste_erreur & LISTE_ERREUR_TROP) print('Trop d\'&eacute;l&eacute;ments s&eacute;lectionn&eacute;s<br />');
		if($facture_liste_erreur & LISTE_ERREUR_PAYER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous pay&eacute;s<br />');
		if($facture_liste_succes & LISTE_SUCCES_PAYER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; pay&eacute;s<br />');
		if($facture_liste_erreur & LISTE_ERREUR_ANNULER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous annul&eacute;s<br />');
		if($facture_liste_succes & LISTE_SUCCES_ANNULER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; annul&eacute;s<br />');
		if($facture_liste_erreur & LISTE_ERREUR_ENVOYER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s n\'ont pu &ecirc;tre tous envoy&eacute;s<br />');
		if($facture_liste_succes & LISTE_SUCCES_ENVOYER) print('Les &eacute;l&eacute;ments s&eacute;lectionn&eacute;s ont tous &eacute;t&eacute; envoy&eacute;s<br />');
	}
	else
		print('&nbsp;');
?>
          </td>
        </tr>
        <tr>
          <td><form action="facture_liste.php" method="post" id="formulaire">
              <table cellspacing="0" cellpadding="4">
                <tr>
                  <td nowrap="nowrap"><?php print_pagination($liste,'facture_liste.php','facture_page');?></td>
                  <td align="right"><input name="facture_liste_submit" type="submit" id="facture_liste_submit" value="Retour aux adh&eacute;rents" onclick="this.form.target='';" /></td>
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
                          <a href="facture_liste.php?facture_tri=identifiant">&Lambda;</a> <a href="facture_liste.php?facture_tri=identifiant&facture_ordre=desc">V</a></td>
                        <td class="entete">Date d'&eacute;mission<br />
                          <a href="facture_liste.php?facture_tri=emission">&Lambda;</a> <a href="facture_liste.php?facture_tri=emission&facture_ordre=desc">V</a></td>
                        <td class="entete">Date de paiement<br />
                          <a href="facture_liste.php?facture_tri=paiement">&Lambda;</a> <a href="facture_liste.php?facture_tri=paiement&facture_ordre=desc">V</a></td>
                        <td class="entete">Montant HT<br />
                          <a href="facture_liste.php?facture_tri=montant_ht">&Lambda;</a> <a href="facture_liste.php?facture_tri=montant_ht&facture_ordre=desc">V</a></td>
                        <td class="entete">Montant TVA<br />
                          <a href="facture_liste.php?facture_tri=montant_tva">&Lambda;</a> <a href="facture_liste.php?facture_tri=montant_tva&facture_ordre=desc">V</a></td>
                        <td class="entete">Total TTC<br />
                          <a href="facture_liste.php?facture_tri=montant_ttc">&Lambda;</a> <a href="facture_liste.php?facture_tri=montant_ttc&facture_ordre=desc">V</a></td>
                        <td class="entete">Statut<br />
                          <a href="facture_liste.php?facture_tri=statut">&Lambda;</a> <a href="facture_liste.php?facture_tri=statut&facture_ordre=desc">V</a></td>
                        <td class="entete">&nbsp;</td>
                        <td class="entete">&nbsp;</td>
                        <td class="entete">&nbsp;</td>
                        <td class="entete">&nbsp;</td>
                        <td class="entete">&nbsp;</td>
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
				    onclick="liste_onClick('facture_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>');"
				    ondblclick="liste_onDblClick('facture_identifiant_<?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?>','<?php print($couleur_courant);?>','<?php print($couleur_click);?>');"
				  >
                        <td><?php print(ma_htmlentities($liste->occurrence[$i]['identifiant']));?></td>
                        <td><?php print(ma_htmlentities(date(STRING_DATETIME,$liste->occurrence[$i]['emission'])));?></td>
                        <td><?php if($liste->occurrence[$i]['paiement']!==NULL) print(ma_htmlentities(date(STRING_DATETIME,$liste->occurrence[$i]['paiement'])));?></td>
                        <td><?php print(ma_htmlentities(number_format($liste->occurrence[$i]['montant_ht'],2,'.','')).' &euro;');?></td>
                        <td><?php print(ma_htmlentities(number_format($liste->occurrence[$i]['montant_tva'],2,'.','')).' &euro;');?></td>
                        <td><?php print(ma_htmlentities(number_format($liste->occurrence[$i]['montant_ttc'],2,'.','')).' &euro;');?></td>
                        <td><?php
	switch($liste->occurrence[$i]['statut'])
	{
		case 'PAYE':
			print('<span style="color: #009900;">Pay&eacute;e</span>');
			break;
		case 'ATTENTE':
			print('<span style="color: #ff9900;">En attente</span>');
			break;
		case 'ANNULE':
			print('<span style="color: #000000;">Annul&eacute;e</span>');
			break;
	}
?></td>
                        <td><a href="<?php print('facture_liste.php?facture_liste_submit=voir&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']))?>" target="_blank">Voir</a></td>
                        <td><?php if($liste->occurrence[$i]['statut']=='ATTENTE') print
						('
							<a href="facture_liste.php?facture_liste_submit=payer+NULL&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']).'" onclick="return confirm(\'Etes vous certain de vouloir noter la facture comme pay&eacute;e ?\');">Payer NULL</a>
							<a href="facture_liste.php?facture_liste_submit=payer+CHEQUE&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']).'" onclick="return confirm(\'Etes vous certain de vouloir noter la facture comme pay&eacute;e ?\');">Payer CHEQUE</a>
							<a href="facture_liste.php?facture_liste_submit=payer+WHA&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']).'" onclick="return confirm(\'Etes vous certain de vouloir noter la facture comme pay&eacute;e ?\');">Payer WHA</a>
							<a href="facture_liste.php?facture_liste_submit=payer+PAYPAL&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']).'" onclick="return confirm(\'Etes vous certain de vouloir noter la facture comme pay&eacute;e ?\');">Payer PAYPAL</a>
							<a href="facture_liste.php?facture_liste_submit=payer+CB&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']).'" onclick="return confirm(\'Etes vous certain de vouloir noter la facture comme pay&eacute;e ?\');">Payer CB</a>
						');?></td>
                        <td><?php if($liste->occurrence[$i]['statut']!='ANNULE') print('<a href="facture_liste.php?facture_liste_submit=annuler&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']).'" onclick="return confirm(\'Etes vous certain de vouloir noter la facture comme annul&eacute;e ?\');">Annuler</a>');?></td>
                        <td><?php print('<a href="facture_liste.php?facture_liste_submit=envoyer&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']).'">Envoyer</a>');?></td>
                        <td><?php if($liste->occurrence[$i]['statut']=='PAYE' && $liste->occurrence[$i]['forfait']!='') print('<a href="facture_liste.php?facture_liste_submit=forfait&facture_identifiant%5B%5D='.urlencode($liste->occurrence[$i]['identifiant']).'">Forfait</a>');?></td>
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
                  <td nowrap="nowrap"><?php print_pagination($liste,'facture_liste.php','facture_page');?></td>
                  <td align="right"><input name="facture_liste_submit" type="submit" id="facture_liste_submit" value="Retour aux adh&eacute;rents" onclick="this.form.target='';" /></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
