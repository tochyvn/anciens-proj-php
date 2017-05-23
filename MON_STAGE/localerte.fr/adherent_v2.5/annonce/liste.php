<?php
	define('REPETITION',20);
	
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'ville.php');
	require_once(PWD_INCLUSION.'type.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	if(!isset($_SESSION['annonce_tri']))
		$_SESSION['annonce_tri']='distance';
	if(!isset($_SESSION['annonce_ordre']))
		$_SESSION['annonce_ordre']='asc';
	if(!isset($_SESSION['annonce_statut']))
		$_SESSION['annonce_statut']='';
	
	if(isset($_REQUEST['annonce_tri']))
	{
		$_SESSION['annonce_tri']=$_REQUEST['annonce_tri'];
		if(!isset($_REQUEST['annonce_ordre']) || $_REQUEST['annonce_ordre']!='desc')
			$_REQUEST['annonce_ordre']='asc';
	}
	if(isset($_REQUEST['annonce_ordre']))
		$_SESSION['annonce_ordre']=$_REQUEST['annonce_ordre'];
	if(isset($_REQUEST['annonce_statut']) && (preg_match('/^(PARTICULIER|PROFESSIONNEL)$/',$_REQUEST['annonce_statut']) || $_REQUEST['annonce_statut']==''))
		$_SESSION['annonce_statut']=$_REQUEST['annonce_statut'];
	if(!isset($_REQUEST['annonce_page']) || !preg_match('/^[1-9][0-9]*$/',$_REQUEST['annonce_page']))
		$_REQUEST['annonce_page']=1;
	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'GO':
			case 'Détail':
			default:
				if(isset($_REQUEST['annonce_identifiant']))
				{
					$_SESSION['annonce_identifiant']=$_REQUEST['annonce_identifiant'];
					header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/tarif.php'));
					die();
				}
				break;
		}
	}
	
	$liste=new ld_liste('select identifiant from alerte where adherent='.$_SESSION['adherent_identifiant']);
	if(!$liste->total)
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT).'alerte/fiche.php');
		die();
	}
	
	$alerte=array();
	for($i=0;$i<$liste->total;$i++)
	{
		$alerte[$i]['objet']=new ld_alerte();
		$alerte[$i]['objet']->identifiant=$liste->occurrence[$i]['identifiant'];
		$alerte[$i]['objet']->lire();
		
		$alerte[$i]['ville']=new ld_ville();
		$alerte[$i]['ville']->identifiant=$alerte[$i]['objet']->ville;
		$alerte[$i]['ville']->lire();
		
		$type_identifiant=array();
		for($j=0;$j<$alerte[$i]['objet']->alerte_type_compter();$j++)
		{
			$instance=$alerte[$i]['objet']->alerte_type_lire($j);
			
			$type=new ld_type();
			$type->identifiant=$instance['objet']->type;
			$type->lire();
			
			$alerte[$i]['type'][$j]=$type;
			
			$temp=new ld_liste('select identifiant from type where identifiant='.$alerte[$i]['type'][$j]->identifiant.' or parent='.$alerte[$i]['type'][$j]->identifiant);
			for($k=0;$k<$temp->total;$k++)  // j'ai remplacé liste par temp
				$type_identifiant[]=$temp->occurrence[$k]['identifiant'];
		}
		
		$alerte[$i]['liste']=new ld_liste
		('
			select sql_calc_found_rows 
				liste.identifiant as identifiant,
				\''.addslashes($i).'\' as alerte,
				loyer,
				ville_nom as ville,
				liste.code_postal as code_postal,
				type_designation as type,
				statut,
				if(datediff(enregistrement,modification)=0,unix_timestamp(enregistrement),unix_timestamp(parution)) as parution,
				unix_timestamp(enregistrement) as enregistrement,
				(adherent_annonce.adherent is not null) as adherent_annonce,
				if(loyer is null,1,0) as loyer_not_null,
				image,
				(6366*acos(cos(radians('.$alerte[$i]['ville']->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$alerte[$i]['ville']->longitude.'))+sin(radians('.$alerte[$i]['ville']->latitude.'))*sin(radians(ville.latitude)))) as distance
			from
				liste
				inner join ville on liste.ville_identifiant=ville.identifiant
				left join adherent_annonce on adherent_annonce.adherent='.addslashes($_SESSION['adherent_identifiant']).' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
			where
				(6366*acos(cos(radians('.$alerte[$i]['ville']->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$alerte[$i]['ville']->longitude.'))+sin(radians('.$alerte[$i]['ville']->latitude.'))*sin(radians(ville.latitude))))<\''.addslashes($alerte[$i]['objet']->rayon).'\'
				and type_identifiant in ('.implode(', ',$type_identifiant).')
				'.(($_SESSION['annonce_statut']!='')?('and statut=\''.addslashes($_SESSION['annonce_statut']).'\''):('')).'
			order by '.(($_SESSION['annonce_tri']=='loyer')?('loyer_not_null, '):('')).'`'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].(($_SESSION['annonce_tri']=='ville')?(', code_postal '.$_SESSION['annonce_ordre']):('')).', parution DESC
			limit '.(($_REQUEST['annonce_page']-1)*100).',100
		',1);
		
		$temp=new ld_liste
		('
			select
				liste.statut as statut,
				count(liste.identifiant) as nombre
			from
				liste
				inner join ville on liste.ville_identifiant=ville.identifiant
			where
				(6366*acos(cos(radians('.$alerte[$i]['ville']->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$alerte[$i]['ville']->longitude.'))+sin(radians('.$alerte[$i]['ville']->latitude.'))*sin(radians(ville.latitude))))<\''.addslashes($alerte[$i]['objet']->rayon).'\'
				and type_identifiant in ('.implode(', ',$type_identifiant).')
			group by liste.statut
		');
		
		$alerte[$i]['statut']['PARTICULIER']=0;
		$alerte[$i]['statut']['PROFESSIONNEL']=0;
		$alerte[$i]['statut']['NULL']=0;
		for($j=0;$j<$temp->total;$j++)
			if($temp->occurrence[$j]['statut']=='PARTICULIER') $alerte[$i]['statut']['PARTICULIER']=$temp->occurrence[$j]['nombre'];
			elseif($temp->occurrence[$j]['statut']=='PROFESSIONNEL') $alerte[$i]['statut']['PROFESSIONNEL']=$temp->occurrence[$j]['nombre'];
			else $alerte[$i]['statut']['NULL']=$temp->occurrence[$j]['nombre'];
	}
	
	// BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE BULLE
	if(isset($_REQUEST['bulle_submit']) || isset($_COOKIE['bulle']['annonce-liste'])){setcookie('bulle[annonce-liste]','1',time()+20*24*60*60,'/','.localerte.fr'); $_COOKIE['bulle']['annonce-liste']='1';}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
<script src="<?php print(URL_ADHERENT.'liste.js');?>" type="text/javascript"></script>
</head>
<body>
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <div id="pub_gauche">
      <?php include(PWD_ADHERENT.'adsense_gauche.php');?>
    </div>
    <div id="annonce_liste">
      <h1 class="cache">Nos annonces du jour - Liste</h1>
      <form action="<?php print(URL_ADHERENT.'annonce/liste.php');?>" method="post" id="js-liste-formulaire">
        <?php
	$k=0;
	for($i=0;$i<sizeof($alerte);$i++) {
?>
        <div class="ld-liste" id="<?php print('ld-alerte-'.$i);?>">
          <ul class="ld-onglet">
            <li<?php if($i==0) print(' class="selected"');?>><a<?php if($i==0) print(' name="alerte1"');?> href="#alerte1">Votre alerte 1</a> </li>
            <li<?php if($i==1) print(' class="selected"');?>><a<?php if($i==1) print(' name="alerte2"');?> href="#alerte2">Votre alerte 2</a> </li>
            <li<?php if($i==2) print(' class="selected"');?>><a<?php if($i==2) print(' name="alerte3"');?> href="#alerte3">Votre alerte 3</a> </li>
          </ul>
          <p class="ld-rappel">
            <?php
            	print('<strong>Rappel de votre alerte :</strong>recherche de logements type ');
                for($j=0;$j<sizeof($alerte[$i]['type']);$j++) print(($j?', ':'').ma_htmlentities($alerte[$i]['type'][$j]->designation));
				print('<br />&agrave; '.ma_htmlentities($alerte[$i]['objet']->rayon).' km autour de '.ma_htmlentities($alerte[$i]['ville']->nom));
			?>
          </p>
          <p class="ld-nombre"><?php print('Aujourd\'hui, LOCALERTE a trouv&eacute; <strong>'.($alerte[$i]['statut']['PARTICULIER']+$alerte[$i]['statut']['PROFESSIONNEL']).'</strong> annonce'.(($alerte[$i]['liste']->total>1)?('s'):('')).' correspondant &agrave; votre recherche.');?></p>
          <p class="ld-modification"><a href="<?php print(URL_ADHERENT.'alerte/liste.php');?>">Modifier mes alertes</a></p>
          <ul class="ld-statut">
            <li>[ <a href="<?php print(URL_ADHERENT.'annonce/liste.php?annonce_statut=PARTICULIER#alerte'.($i+1));?>" <?php if($_SESSION['annonce_statut']=='PARTICULIER') print(' class="selected"');?>>Annonces de particuliers</a> : <?php print($alerte[$i]['statut']['PARTICULIER']);?> ]</li>
            <li>[ <a href="<?php print(URL_ADHERENT.'annonce/liste.php?annonce_statut=PROFESSIONNEL#alerte'.($i+1));?>" <?php if($_SESSION['annonce_statut']=='PROFESSIONNEL') print(' class="selected"');?>>Annonces de professionnels</a> : <?php print($alerte[$i]['statut']['PROFESSIONNEL']);?> ]</li>
            <li>[ <a href="<?php print(URL_ADHERENT.'annonce/liste.php?annonce_statut=#alerte'.($i+1));?>" <?php if($_SESSION['annonce_statut']=='') print(' class="selected"');?>>Toutes</a> ]</li>
          </ul>
          <table cellpadding="0" cellspacing="0">
            <?php
	  	if(sizeof($alerte[$i]['liste']->occurrence)) {		
?>
            <tr>
              <th colspan="7" class="selection">Cochez les annonces que vous souhaitez consulter, puis cliquez sur <input type="submit" name="annonce_submit" value="Consulter" /></th>
            </tr>
            <?php
		  for($j=0;$j<sizeof($alerte[$i]['liste']->occurrence);$j++,$k++) {
			if($j%REPETITION==0) {
?>
            <tr>
              <th colspan="2" class="js-liste-case"></th>
              <th><a href="liste.php?annonce_tri=ville&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=distance&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a><span>Localit&eacute;</span></th>
              <th><a href="liste.php?annonce_tri=distance&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=ville&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a><span>Km</span>
              <span class="js-liste-interrogation" title="Filtrez ici en fonction de votre rayon de recherche plus ou moins &eacute;loign&eacute; de la ville cibl&eacute;e.">?</span>
              </th>
              <th><a href="liste.php?annonce_tri=type&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=type&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a><span>Type</span>
  		  	  <span class="js-liste-interrogation" title="Filtrez ici par types d'habitation (studio, T1, T2, T3, ...) indiquant le nombre de pi&egrave;ces.">?</span>
              </th>
              <th><a href="liste.php?annonce_tri=loyer&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=loyer&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a><span>Loyer</span></th>
              <th><a href="liste.php?annonce_tri=parution&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=parution&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a><span>Parution</span></th>
            </tr>
            <?php
			}
			
			$annonce_moins_4h = time()-$alerte[$i]['liste']->occurrence[$j]['enregistrement']<(3600*4);
			$annonce_moins_16h = time()-$alerte[$i]['liste']->occurrence[$j]['enregistrement']<(3600*12) && time()-$alerte[$i]['liste']->occurrence[$j]['enregistrement']>=(3600*4) ;
			
			if($alerte[$i]['liste']->occurrence[$j]['distance']>=15) $distance=15;
			elseif($alerte[$i]['liste']->occurrence[$j]['distance']>=5) $distance=5;
			else $distance=0;
?>
            <tr class="js-liste-ligne <?php print(($j+1)%2?'impair':'pair');?><?php if($alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print(' deja_lu');?>" id="<?php print('liste_ligne_'.$i.'_'.$j);?>">
              <td><input type="checkbox" name="annonce_identifiant[]" value="<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']))?>" /></td>
              <td class="image"><?php print('<img src="'.($alerte[$i]['liste']->occurrence[$j]['image']?ma_htmlentities(URL_INCLUSION.'gd.php?forme=vignette&largeur=150&url='.urlencode($alerte[$i]['liste']->occurrence[$j]['image'])):URL_ADHERENT.'image/liste/indisponible.png').'" alt="" />')?></td>
              <td class="ville"><?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['ville']))?> <small>(<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['code_postal']))?>)</small> <?php if($alerte[$i]['liste']->occurrence[$j]['statut']=='PARTICULIER') print('<strong>'.ma_htmlentities(ucfirst(strtolower($alerte[$i]['liste']->occurrence[$j]['statut']))).'</strong>')?></td>
              <td class="distance"><img src="<?php print(URL_ADHERENT.'image/liste/distance_'.$distance.'.png');?>" alt="" /><?php if($distance) print('+ de '.$distance.' km'); else print('Localisation id&eacute;ale');?></td>
              <td><?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['type']))?></td>
              <td><?php if($alerte[$i]['liste']->occurrence[$j]['loyer']!==NULL) print(ma_htmlentities(number_format($alerte[$i]['liste']->occurrence[$j]['loyer'],0, ',', ' ')).' &euro;')?></td>
              <td class="parution"><?php print(ma_htmlentities(strftime('%d/%m/%Y',$alerte[$i]['liste']->occurrence[$j]['parution'])));?><?php print(($annonce_moins_16h)?('<img src="'.URL_ADHERENT.'image/liste/12h.png" title="Annonce de moins de 12h" alt="" />'):(($annonce_moins_4h)?('<img src="'.URL_ADHERENT.'image/liste/4h.png" title="Annonce de moins de 4h" alt="" />'):('')));?></td>
            </tr>
            <?php 
			}
			
			if($alerte[$i]['liste']->page_courante<$alerte[$i]['liste']->page_total)
			{
				print
				('
					<tr class="js-resultat">
					  <td colspan="7"><a style="display:block; width:350px; margin:auto; padding:10px 20px; border:1px solid #F49737; background:#F49737; color:#FFFFFF; font-size:14px; text-decoration:none; font-weight:blod; box-shadow:0px 0px 4px #999;  text-align:center;" class="js-resultat-ld-alerte-'.$i.'" href="'.URL_ADHERENT.'annonce/liste.php?annonce_page='.$alerte[$i]['liste']->page_suivante.'#alerte'.($i+1).'">Afficher les 100 annonces suivantes</a></td>
					</tr>
				');
			}
		}
?>
          </table>
        </div>
        <?php
	}
?>
      </form>
    </div>
    <div id="pub_droite">
      <?php include(PWD_ADHERENT.'adsense_droit.php');?>
    </div>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>
