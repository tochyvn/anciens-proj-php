<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_ADHERENT_V2.'annonce/verification.php');
	
	if(!isset($_SESSION['annonce_tri']))
		$_SESSION['annonce_tri']='parution';
	if(!isset($_SESSION['annonce_ordre']))
		$_SESSION['annonce_ordre']='desc';
	
	ini_set('memory_limit','32M');
	
	$preference=new ld_preference();
	
	$liste=new ld_liste
	('
		select identifiant,
			meuble,
			loyer,
			descriptif,
			statut,
			image,
			url,
			ville_nom as ville,
			code_postal,
			type_designation as type,
			unix_timestamp(parution) as parution,
			telephone,
			email,
			provenance_designation,
			provenance_couleur
		from liste
		where identifiant in (\''.implode('\', \'',array_map('addslashes',$_SESSION['annonce_identifiant'])).'\')
		order by `'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].'
	');	
	/*('
		select annonce.identifiant as identifiant,
			annonce.meuble as meuble,
			annonce.loyer as loyer,
			annonce.descriptif as descriptif,
			annonce.statut as statut,
			annonce.image as image,
			annonce.url as url,
			ville.nom as ville,
			code_postal as code_postal,
			type.designation as type,
			unix_timestamp(annonce.parution) as parution,
			group_concat(distinct annonce_telephone.telephone separator \', \') as telephone,
			group_concat(distinct annonce_email.email separator \', \') as email,
			provenance.designation as provenance_designation,
			provenance.couleur as provenance_couleur
		from annonce
			inner join ville on annonce.ville=ville.identifiant
			inner join type on annonce.type=type.identifiant
			inner join provenance on annonce.provenance=provenance.identifiant
			left join annonce_telephone on annonce.identifiant=annonce_telephone.annonce
			left join annonce_email on annonce.identifiant=annonce_email.annonce
		where annonce.parution>\''.addslashes(date(SQL_DATETIME,mktime(23,59,59,date('m'),date('d')-$preference->annonce_affiche_dernier_jour,date('Y')))).'\'
			and annonce.identifiant in (\''.implode('\', \'',array_map('addslashes',$_SESSION['annonce_identifiant'])).'\')
			and annonce.etat=\'VALIDE\'
			and ville.latitude<>0
			and ville.longitude<>0
		group by annonce.identifiant
		order by `'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].'
	');*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
</head>
<body onload="window.print();">
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <table id="annonce_impression" cellpadding="5">
  <?php
  	for($i=0;$i<$liste->total;$i++)
	{
?>
    <tr>
      <td id="photo"><?php if($liste->occurrence[$i]['image']!==NULL) print('<img src="'.$liste->occurrence[$i]['image'].'" />');?></td>
      <td id="volet2"><table>
          <tr>
            <td id="type"><?php print(ma_htmlentities($liste->occurrence[$i]['type']));?></td>
          </tr>
          <tr>
            <td id="loyer"><?php if($liste->occurrence[$i]['loyer']!==NULL) print(ma_htmlentities($liste->occurrence[$i]['loyer']).'&euro;'); else print('- &euro;');?></td>
          </tr>
          <tr>
            <td id="statut"><?php if($liste->occurrence[$i]['statut']=='PARTICULIER') print('Particulier'); elseif($liste->occurrence[$i]['statut']=='PROFESSIONNEL') print('Professionnel'); else print('Statut N.C.');?></td>
          </tr>
          <tr>
            <td id="meuble"><?php if($liste->occurrence[$i]['meuble']=='OUI') print('Meubl&eacute;'); elseif($liste->occurrence[$i]['meuble']=='NON') print('Non meubl&eacute;'); else print('');?></td>
          </tr>
        </table></td>
      <td id="volet3"><table>
          <tr>
            <td id="localite"><?php print(ma_htmlentities($liste->occurrence[$i]['code_postal'].' '.$liste->occurrence[$i]['ville']));?></td>
          </tr>
          <tr>
            <td id="descriptif"><?php print(nl2br(ma_htmlentities($liste->occurrence[$i]['descriptif'])));?></td>
          </tr>
          <tr>
            <td id="contact"><?php
			$contact=array();
			if($liste->occurrence[$i]['telephone']!='')
			{
				$telephone=explode(', ',$liste->occurrence[$i]['telephone']);
				for($j=0;$j<sizeof($telephone);$j++)
					$telephone[$j]=formater($telephone[$j],'telephone_espace');
				$contact=$telephone;
			}
			if($liste->occurrence[$i]['email']!='')
			{
				$email=explode(', ',$liste->occurrence[$i]['email']);
				for($j=0;$j<sizeof($email);$j++)
					$email[$j]='<a href="mailto:'.urlencode($email[$j]).'">'.$email[$j].'</a>';
				$contact=array_merge($contact,$email);
			}
			print(implode(', ',$contact));
		?></td>
          </tr>
        </table></td>
    </tr>
<?php
	}
?>
  </table>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
