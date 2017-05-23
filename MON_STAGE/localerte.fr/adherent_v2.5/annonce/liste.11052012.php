<?php
	define('REPETITION',20);
	
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'ville.php');
	require_once(PWD_INCLUSION.'type.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	if(!isset($_SESSION['annonce_tri']))
		$_SESSION['annonce_tri']='parution';
	if(!isset($_SESSION['annonce_ordre']))
		$_SESSION['annonce_ordre']='desc';
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
	if(isset($_REQUEST['annonce_submit_nb'])) $_REQUEST['annonce_submit']='GO';
	
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
			select
				liste.identifiant as identifiant,
				\''.addslashes($i).'\' as alerte,
				loyer,
				ville_nom as ville,
				liste.code_postal as code_postal,
				type_designation as type,
				unix_timestamp(parution) as parution,
				(adherent_annonce.adherent is not null) as adherent_annonce,
				if(loyer is null,1,0) as loyer_not_null
			from
				liste
				inner join ville on liste.ville_identifiant=ville.identifiant
				left join adherent_annonce on adherent_annonce.adherent='.addslashes($_SESSION['adherent_identifiant']).' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
			where
				(6366*acos(cos(radians('.$alerte[$i]['ville']->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$alerte[$i]['ville']->longitude.'))+sin(radians('.$alerte[$i]['ville']->latitude.'))*sin(radians(ville.latitude))))<\''.addslashes($alerte[$i]['objet']->rayon).'\'
				and type_identifiant in ('.implode(', ',$type_identifiant).')
				'.(($_SESSION['annonce_statut']!='')?('and statut=\''.addslashes($_SESSION['annonce_statut']).'\''):('')).'
			order by '.(($_SESSION['annonce_tri']=='loyer')?('loyer_not_null, '):('')).'`'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].(($_SESSION['annonce_tri']=='ville')?(', code_postal '.$_SESSION['annonce_ordre']):('')).'
		');
		
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
<script src="<?php print(URL_INCLUSION);?>liste.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
	function verifier() {
		liste_objet=document.getElementsByName('annonce_identifiant[]');
		var l=liste_objet.length;
		for(i=0; l>i; i++)
			if(liste_objet[i].checked)
				return true;
		
		alert('Sélectionnez vos annonces avant de cliquer sur " Voir les annonces cochées "');
		return false;
	}
	function survol(id) {
		document.getElementById(id+'col3').style.backgroundColor = '#FF7602';
		document.getElementById(id+'col4').style.backgroundColor = '#FF7602';
		document.getElementById(id+'col5').style.backgroundColor = '#FF7602';
		document.getElementById(id+'col6').style.backgroundColor = '#FF7602';
		document.getElementById(id+'col3').style.color = '#FFF';
		document.getElementById(id+'col4').style.color = '#FFF';
		document.getElementById(id+'col5').style.color = '#FFF';
		document.getElementById(id+'col6').style.color = '#FFF';
	}
	function unsurvol(id, lu) {
		if(lu) {
			document.getElementById(id+'col3').style.backgroundColor = '#D8E3F0';
			document.getElementById(id+'col4').style.backgroundColor = '#D8E3F0';
			document.getElementById(id+'col5').style.backgroundColor = '#D8E3F0';
			document.getElementById(id+'col6').style.backgroundColor = '#D8E3F0';
		} else {
			document.getElementById(id+'col3').style.backgroundColor = '#FFF';
			document.getElementById(id+'col4').style.backgroundColor = '#FFF';
			document.getElementById(id+'col5').style.backgroundColor = '#FFF';
			document.getElementById(id+'col6').style.backgroundColor = '#FFF';
		}
		document.getElementById(id+'col3').style.color = '#2C5D97';
		document.getElementById(id+'col4').style.color = '#2C5D97';
		document.getElementById(id+'col5').style.color = '#2C5D97';
		document.getElementById(id+'col6').style.color = '#2C5D97';
	}

	function enquete(sec) {
		setTimeout("window.location='<?php print(URL_ADHERENT.'compte/enquete.php');?>'",sec*1000);
	}
-->
</script>
</head>
<body<?php /*if(!isset($_COOKIE['la_enquete_'.$_SESSION['adherent_identifiant'].'_1'])) print(' onload="enquete(12);"');*/?>>
<!--?php include(PWD_ADHERENT.'chronometre.php');?-->
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
      <form action="<?php print(URL_ADHERENT.'annonce/liste.php');?>" method="post" onsubmit="return verifier();">
        <input type="hidden" name="nb_annonces_cochees" id="nb_annonces_cochees" value="0" />
        <!--p class="orange2 moyen gras centre"> Cochez les annonces de votre choix, puis cliquez sur :<br />
          <input type="submit" name="annonce_submit" id="annonce_submit" class="liste_valide" value="Voir ma s&eacute;lection" />
          <br /><br /></p-->
        <?php
	$k=0;
	for($i=0;$i<sizeof($alerte);$i++) {
if($i==0 && !isset($_COOKIE['bulle']['annonce-liste']))
			print
			('
				  <script type="text/javascript">
				  <!--
					document.write(\'<span class="bulle fleche-bas-gauche" style="top:118px; left:488px; width:333px;" id="bulle">\');
					document.write(\'<span class="cadre">\');
					document.write(\'<span class="haut-gauche"></span>\');
					document.write(\'<span class="haut-centre"></span>\');
					document.write(\'<span class="haut-droite"></span>\');
					document.write(\'<span class="milieu" style="">Cochez les annonces de votre choix, puis cliquez sur<br />&laquo; VOIR MA S&Eacute;LECTION &raquo; pour acc&eacute;der &agrave; vos annonces.<br /><span style="float: left;"><a href="?bulle_submit=" style="font-size:11px; margin-top:5px; color:#9C4F01;">Ne plus afficher cette aide</a></span><span style="display:inline; text-align:right;"><a href="#" onclick="document.getElementById(\\\'bulle\\\').style.display=\\\'none\\\';" style="font-size:11px; float:right; margin-top:5px; text-decoration:none; background-image:url('.URL_ADHERENT.'image/bulle/fermer.jpg); background-repeat:no-repeat; background-position:right center; line-height:16px; padding-right:20px; font-weight:normal; color:#9C4F01;">Fermer</a></span></span>\');
					document.write(\'<span class="bas-gauche"></span>\');
					document.write(\'<span class="bas-centre"></span>\');
					document.write(\'<span class="bas-droite"></span>\');
					document.write(\'</span>\');
					document.write(\'<span class="fleche"></span>\');
					document.write(\'</span>\');

				  //-->
				  </script>
			');
?>
        <table class="annonce_liste" cellpadding="0" cellspacing="0">
          <caption class="cache">
          <?php print('Alerte n&deg;'.($i+1));?>
          </caption>
          <tr class="onglet_alerte">
            <td colspan="7" style="margin:0; padding:0;"><table cellpadding="0" cellspacing="0" class="onglet_alerte">
                <tr>
                  <?php
		  	    for($i2=0;$i2<sizeof($alerte);$i2++)
				  if($i2!=$i) print('<td class="onglet1"><a href="#alerte'.($i2+1).'">Votre alerte '.($i2+1).'</a></td>');
				  else print('<td class="onglet2"><a name="alerte'.($i+1).'"></a><a href="#alerte'.($i2+1).'">Votre alerte '.($i2+1).'</a></td>');
	  	        while($i2<3) { print('<td width="215"></td>'); $i2++; }
			  ?>
                  <td width="25"></td>
                </tr>
              </table></td>
          </tr>
          <tr class="t13">
            <td class="coche_bleu"></td>
            <td class="filler_gauche_bleu" width="12"></td>
            <td colspan="4" class="bleu gras gauche"><?php print('<br />Rappel de votre alerte : recherche de logements type');
			print('<ul class="liste_type">');
                for($j=0;$j<sizeof($alerte[$i]['type']);$j++) print('<li>'.ma_htmlentities($alerte[$i]['type'][$j]->designation).' </li>');
             print('</ul><br />');			
			print('<span style="padding-left:153px;">&agrave; '.ma_htmlentities($alerte[$i]['objet']->rayon).' km autour de '.ma_htmlentities($alerte[$i]['ville']->nom));
			print('</span><br /><br />Aujourd\'hui, LOCALERTE a trouv&eacute; <span class="orange2 gras">'.($alerte[$i]['statut']['PARTICULIER']+$alerte[$i]['statut']['PROFESSIONNEL']).'</span> annonce'.(($alerte[$i]['liste']->total>1)?('s'):('')).' correspondant &agrave; votre recherche.');
 ?> <br />
              <br />
              <a class="orange2" href="<?php print(URL_ADHERENT.'alerte/liste.php');?>">Modifier mes alertes</a> <br />
              <br />
              <?php if($alerte[$i]['liste']->total) {?>
              <ul class="filtre_partpro">
                <li>[ <a href="<?php print(URL_ADHERENT.'annonce/liste.php?annonce_statut=PARTICULIER#alerte'.($i+1));?>" <?php if($_SESSION['annonce_statut']=='PARTICULIER') print(' class="selected"');?>>Annonces de particuliers</a> : <?php print($alerte[$i]['statut']['PARTICULIER']);?> ]</li>
                <li>[ <a href="<?php print(URL_ADHERENT.'annonce/liste.php?annonce_statut=PROFESSIONNEL#alerte'.($i+1));?>" <?php if($_SESSION['annonce_statut']=='PROFESSIONNEL') print(' class="selected"');?>>Annonces de professionnels</a> : <?php print($alerte[$i]['statut']['PROFESSIONNEL']);?> ]</li>
                <li>[ <a href="<?php print(URL_ADHERENT.'annonce/liste.php?annonce_statut=#alerte'.($i+1));?>" <?php if($_SESSION['annonce_statut']=='') print(' class="selected"');?>>Toutes</a> ]</li>
              </ul>
              <?php }?>
              <br /></td>
            <td class="filler_droite"></td>
          </tr>
          <?php
	  	if($alerte[$i]['liste']->total) {		
?>
          <tr>
            <td class="coche" id="<?php print('ligne'.$k.'x20col1a');?>"></td>
            <td class="filler_gauche_orange" id="<?php print('ligne'.$k.'x20col2a');?>"></td>
            <td class="liste_valide" id="<?php print('ligne'.$k.'x20col3a');?>"><span style="display:block; position:relative;"><input id="<?php print('bouton'.$k.'x20col3a');?>" type="submit" name="annonce_submit_nb" class="liste_valide2" value="0 annonce coch&eacute;e" /><input type="submit" name="annonce_submit" value="GO" style="position:absolute; right:10px; top:-1px; border:2px solid #333333; border-style:outset; padding:0px; width:50px; cursor:pointer;" /></span></td>
            <td colspan="4" class="liste_valide"><input type="submit" name="annonce_submit" class="liste_valide3" value="VOIR MA S&Eacute;LECTION" /></td>
            <!--td class="filler_droite_orange"></td-->
          </tr>
          <!--tr>
            <td class="coche"></td>
            <td class="filler_gauche"></td>
            <td colspan="4" class="bleu"></td>
            <td class="filler_droite"></td>
          </tr-->
          <?php
		  for($j=0;$j<$alerte[$i]['liste']->total;$j++,$k++) {
			if($j%REPETITION==0) {
				if($j!=0) {
?>
          <tr>
            <td class="coche" id="<?php print('ligne'.$k.'x20col1a');?>"></td>
            <td class="filler_gauche_orange" id="<?php print('ligne'.$k.'x20col2a');?>"></td>
            <td class="liste_valide" id="<?php print('ligne'.$k.'x20col3a');?>"><span style="display:block; position:relative;"><input id="<?php print('bouton'.$k.'x20col3a');?>" type="submit" name="annonce_submit_nb" class="liste_valide2" value="0 annonce coch&eacute;e" /><input type="submit" name="annonce_submit" value="GO" style="position:absolute; right:10px; top:-1px; border:2px solid #333333; border-style:outset; padding:0px; width:50px; cursor:pointer;" /></span></td>
            <td colspan="4" class="liste_valide"><input type="submit" name="annonce_submit" class="liste_valide3" value="VOIR MA S&Eacute;LECTION" /></td>
            <!--td class="filler_droite_orange"></td-->
          </tr>
          <?php
				}
?>
          <tr>
            <td class="coche" id="<?php print('ligne'.$k.'x20col1b');?>"></td>
            <td class="filler_gauche"></td>
            <th><a href="liste.php?annonce_tri=ville&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=ville&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a>&nbsp;&nbsp; Localit&eacute;</th>
            <th><a href="liste.php?annonce_tri=type&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=type&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a>&nbsp;&nbsp; Type</th>
            <th><a href="liste.php?annonce_tri=loyer&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=loyer&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a>&nbsp;&nbsp; Loyer</th>
            <th><a href="liste.php?annonce_tri=parution&amp;annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_haut.jpg')?>" alt="&Lambda;" title="&Lambda;" /></a> <a href="liste.php?annonce_tri=parution&amp;annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT.'image/liste/fleche_bas.jpg')?>" alt="V" title="V" /></a>&nbsp;&nbsp; Parution</th>
            <td class="filler_droite"></td>
          </tr>
          <?php
			}
?>
          <tr id="<?php print('ligne'.$k);?>" onmouseover="survol('<?php print('ligne'.$k);?>')" onmouseout="unsurvol('<?php print('ligne'.$k);?>', <?php print( $alerte[$i]['liste']->occurrence[$j]['adherent_annonce']);?>)">
            <td class="coche" id="<?php print('ligne'.$k.'col1');?>"><input type="checkbox" name="annonce_identifiant[]" id="alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']))?>" value="<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']))?>" onclick="liste_onClick_effect('alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>', 'annonce_submit_nb', 'annonce_submit', 'nb_annonces_cochees', 0, <?php print($j);?>, <?php print($k);?>);" /></td>
            <td class="filler_gauche" onclick="liste_onClick_effect('alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>', 'annonce_submit_nb', 'annonce_submit', 'nb_annonces_cochees', 1, <?php print($j);?>, <?php print($k);?>);" id="<?php print('ligne'.$k.'col2');?>"></td>
            <td onclick="liste_onClick_effect('alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>', 'annonce_submit_nb', 'annonce_submit', 'nb_annonces_cochees', 1, <?php print($j);?>, <?php print($k);?>);" class="<?php if($alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print('lu_'); else print('paslu_');?>gauche" id="<?php print('ligne'.$k.'col3');?>"><img src="<?php print(URL_ADHERENT.'image/liste/enveloppe'.(($alerte[$i]['liste']->occurrence[$j]['adherent_annonce'])?('_lu.png'):('.jpg')));?>" alt="" style="vertical-align:middle;" /> &nbsp;<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['code_postal'].' '.$alerte[$i]['liste']->occurrence[$j]['ville']))?></td>
            <td onclick="liste_onClick_effect('alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>', 'annonce_submit_nb', 'annonce_submit', 'nb_annonces_cochees', 1, <?php print($j);?>, <?php print($k);?>);" class="<?php if($alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print('lu'); else print('paslu');?>" id="<?php print('ligne'.$k.'col4');?>"><?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['type']))?></td>
            <td onclick="liste_onClick_effect('alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>', 'annonce_submit_nb', 'annonce_submit', 'nb_annonces_cochees', 1, <?php print($j);?>, <?php print($k);?>);" class="<?php if($alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print('lu'); else print('paslu');?>" id="<?php print('ligne'.$k.'col5');?>"><?php if($alerte[$i]['liste']->occurrence[$j]['loyer']!==NULL) print(ma_htmlentities(number_format($alerte[$i]['liste']->occurrence[$j]['loyer'],0, ',', ' ')).' &euro;')?></td>
            <td onclick="liste_onClick_effect('alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>', 'annonce_submit_nb', 'annonce_submit', 'nb_annonces_cochees', 1, <?php print($j);?>, <?php print($k);?>);" class="<?php if($alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print('lu_'); else print('paslu_');?>droite" id="<?php print('ligne'.$k.'col6');?>"><?php print(ma_htmlentities(strftime('%d %B %Y',$alerte[$i]['liste']->occurrence[$j]['parution'])))?></td>
            <td onclick="liste_onClick_effect('alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>', 'annonce_submit_nb', 'annonce_submit', 'nb_annonces_cochees', 1, <?php print($j);?>, <?php print($k);?>);" class="filler_droite" id="<?php print('ligne'.$k.'col7');?>"></td>
          </tr>
          <?php 
			}
		}
?>
        </table>
        <p><br />
          <br />
        </p>
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
