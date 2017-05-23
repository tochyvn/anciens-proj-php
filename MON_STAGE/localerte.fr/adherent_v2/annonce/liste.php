<?php
	define('REPETITION',20);
	
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'alerte.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'ville.php');
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
	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'GO':
			case 'Détail':
				if(isset($_REQUEST['annonce_identifiant']))
				{
					$_SESSION['annonce_identifiant']=$_REQUEST['annonce_identifiant'];
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/identification.php'));
					die();
				}
				break;
			case 'Filtrer':
				break;
		}
	}
	
	ini_set('memory_limit','64M');
	
	$preference=new ld_preference();
	
	$liste=new ld_liste
	('
		select identifiant
		from alerte
		where adherent=\''.addslashes($_SESSION['adherent_identifiant']).'\'
	');
	
	if($liste->total<=ALERTE_ALERTE_TYPE_MAX)
		define('ALERTE_CARDINALITE',$liste->total);
	else
		define('ALERTE_CARDINALITE',ALERTE_ALERTE_TYPE_MAX);
	
	$requete=array();
	$alerte=array();
	for($i=0;$i<ALERTE_CARDINALITE;$i++)
	{
		if($i>=$liste->total) file_put_contents(PWD_INCLUSION.'prive/log/php_error.log',$_SESSION['adherent_identifiant'].CRLF,FILE_APPEND);
		$alerte[$i]['instance']=new ld_alerte();
		$alerte[$i]['instance']->identifiant=$liste->occurrence[$i]['identifiant'];
		$alerte[$i]['instance']->lire();
		
		$alerte[$i]['ville']=new ld_ville();
		$alerte[$i]['ville']->identifiant=$alerte[$i]['instance']->ville;
		$alerte[$i]['ville']->lire();
		
		$type=array();
		for($j=0;$j<$alerte[$i]['instance']->alerte_type_compter();$j++)
		{
			$instance=$alerte[$i]['instance']->alerte_type_lire($j);
			
			$temp=new ld_liste('select identifiant from type where identifiant=\''.$instance['objet']->type.'\' or parent=\''.$instance['objet']->type.'\'');
			for($k=0;$k<$temp->total;$k++)
				$type[]=$temp->occurrence[$k]['identifiant'];
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
				(adherent_annonce.adherent is not null) as adherent_annonce
			from liste
				inner join ville on liste.ville_identifiant=ville.identifiant
				left join adherent_annonce on adherent_annonce.adherent=\''.addslashes($_SESSION['adherent_identifiant']).'\' and liste.identifiant=adherent_annonce.annonce and adherent_annonce.lu>now() - interval (select annonce_affiche_lu from preference limit 1) day
			where (6366*acos(cos(radians('.$alerte[$i]['ville']->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$alerte[$i]['ville']->longitude.'))+sin(radians('.$alerte[$i]['ville']->latitude.'))*sin(radians(ville.latitude))))<\''.addslashes($alerte[$i]['instance']->rayon).'\'
				and type_identifiant in (\''.implode('\', \'',array_map('addslashes',$type)).'\')
				'.(($_SESSION['annonce_statut']!='')?('and statut=\''.addslashes($_SESSION['annonce_statut']).'\''):('')).'
			order by `'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].(($_SESSION['annonce_tri']=='ville')?(', code_postal '.$_SESSION['annonce_ordre']):('')).'
		');
		/*('
			select annonce.identifiant as identifiant,
				\''.addslashes($i).'\' as alerte,
				annonce.loyer as loyer,
				ville.nom as ville,
				code_postal as code_postal,
				type.designation as type,
				unix_timestamp(annonce.parution) as parution,
				(adherent_annonce.adherent is not null) as adherent_annonce
			from annonce
				inner join ville on annonce.ville=ville.identifiant
				inner join type on annonce.type=type.identifiant
				left join adherent_annonce on adherent_annonce.adherent=\''.addslashes($_SESSION['adherent_identifiant']).'\' and annonce.identifiant=adherent_annonce.annonce
			where annonce.parution>\''.addslashes(date(SQL_DATETIME,mktime(23,59,59,date('m'),date('d')-$preference->annonce_affiche_dernier_jour,date('Y')))).'\'
				and annonce.etat=\'VALIDE\'
				and ville.latitude<>0
				and ville.longitude<>0
				and type in (\''.implode('\', \'',array_map('addslashes',$type)).'\')
				and (6366*acos(cos(radians('.$alerte[$i]['ville']->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$alerte[$i]['ville']->longitude.'))+sin(radians('.$alerte[$i]['ville']->latitude.'))*sin(radians(ville.latitude))))<\''.addslashes($alerte[$i]['instance']->rayon).'\'
			order by `'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].'
		');*/
		/*('
			select annonce.identifiant as identifiant,
				\''.addslashes($i).'\' as alerte,
				annonce.loyer as loyer,
				ville.nom as ville,
				ville.code_postal as code_postal,
				type.designation as type,
				unix_timestamp(annonce.parution) as parution,
				ville.rayon,
				(adherent_annonce.adherent is not null) as adherent_annonce
			from annonce
				inner join
				(
					select
						identifiant,
						nom,
						code_postal,
						ifnull((6366*acos(cos(radians('.$alerte[$i]['ville']->latitude.'))*cos(radians(ville.latitude))*cos(radians(ville.longitude)-radians('.$alerte[$i]['ville']->longitude.'))+sin(radians('.$alerte[$i]['ville']->latitude.'))*sin(radians(ville.latitude)))),0) as rayon
					from ville
					where latitude<>0
						and longitude<>0
					having rayon<=\''.addslashes($alerte[$i]['instance']->rayon).'\'
				) ville on annonce.ville=ville.identifiant
				inner join type on annonce.type=type.identifiant
				left join adherent_annonce on adherent_annonce.adherent=\''.addslashes($_SESSION['adherent_identifiant']).'\' and annonce.identifiant=adherent_annonce.annonce
			where type in (\''.implode('\', \'',array_map('addslashes',$type)).'\')
				and annonce.parution>\''.addslashes(date(SQL_DATETIME,mktime(23,59,59,date('m'),date('d')-$preference->annonce_affiche_dernier_jour,date('Y')))).'\'
				and annonce.etat=\'VALIDE\'
			order by `'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].', identifiant
		');*/
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
<script language="javascript">
	function mouseover(parent)
	{
		objet=parent.getElementsByTagName('td');
		for(i=0;i<objet.length;i++)
		{
			if(objet[i].getAttribute('class')=='out'+i+' non_lu' || objet[i].getAttribute('className')=='out'+i+' non_lu')
			{
				objet[i].setAttribute('class','over'+i+' non_lu');
				objet[i].setAttribute('className','over'+i+' non_lu');
			}
			else
			{
				objet[i].setAttribute('class','over'+i+'');
				objet[i].setAttribute('className','over'+i+'');
			}
		}
	}
	
	function mouseout(parent)
	{
		objet=parent.getElementsByTagName('td');
		for(i=0;i<objet.length;i++)
		{
			if(objet[i].getAttribute('class')=='over'+i+' non_lu' || objet[i].getAttribute('className')=='over'+i+' non_lu')
			{
				objet[i].setAttribute('class','out'+i+' non_lu');
				objet[i].setAttribute('className','out'+i+' non_lu');
			}
			else
			{
				objet[i].setAttribute('class','out'+i+'');
				objet[i].setAttribute('className','out'+i+'');
			}
		}
	}
	
	function verifier()
	{
		objet=document.getElementsByName('annonce_identifiant[]');
		for(i=0;i<objet.length;i++)
			if(objet[i].checked)
				return true;
		
		alert('Vous devez sélectionner les annonces dont vous voulez le détail.');
		return false;
	}
</script>
</head>
<body>
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="annonce_liste">Nos annonces du jour - Liste</h1>
  <form id="annonce_liste" action="<?php print(URL_ADHERENT_V2.'annonce/liste.php');?>" method="post" onsubmit="return verifier();">
  <p id="annonce_liste" style="color:#ff9115; font-weight:bold;"><img src="<?php print(URL_ADHERENT_V2.'image/aide.png');?>" alt="Aide" title="Aide" />Pour voir le d&eacute;tail des annonces, cochez les cases correspondantes et cliquez sur 
    <input type="submit" name="annonce_submit" value="GO" />
  .</p>
    <?php
	$k=0;
	for($i=0;$i<sizeof($alerte);$i++)
	{
?>
	<a name="<?php print('alerte'.($i+1));?>"></a>
	<ul id="filtre"> 
    <dfn>Afficher les annonces de:</dfn>
    <li><a href="<?php print(URL_ADHERENT_V2.'annonce/liste.php?annonce_statut=PARTICULIER#alerte'.($i+1));?>" class="position1<?php if($_SESSION['annonce_statut']=='PARTICULIER') print(' selected');?>">Particuliers</a></li>
    <li><a href="<?php print(URL_ADHERENT_V2.'annonce/liste.php?annonce_statut=PROFESSIONNEL#alerte'.($i+1));?>" class="position2<?php if($_SESSION['annonce_statut']=='PROFESSIONNEL') print(' selected');?>">Professionnels</a></li>
    <li><a href="<?php print(URL_ADHERENT_V2.'annonce/liste.php?annonce_statut=#alerte'.($i+1));?>" class="position3<?php if($_SESSION['annonce_statut']=='') print(' selected');?>">Toutes</a></li>
    </ul>
    <table id="annonce_liste_<?php print($i);?>">
      <caption>
      <?php print('Alerte n&deg;'.($i+1));?>
      </caption>
      <tr id="nombre">
        <th colspan="5"><?php print($alerte[$i]['liste']->total.' annonce'.(($alerte[$i]['liste']->total>1)?('s'):('')).' dans un rayon de '.ma_htmlentities($alerte[$i]['instance']->rayon).' km de '.ma_htmlentities($alerte[$i]['ville']->nom));?> - <a href="<?php print(URL_ADHERENT_V2.'compte/fiche.php');?>">Modifier</a></th>
      </tr>
      <?php
	  	if($alerte[$i]['liste']->total)
		{
			for($j=0;$j<$alerte[$i]['liste']->total;$j++,$k++)
			{
				if($j%REPETITION==0)
				{
?>
      <tr id="<?php if($j) print('sousentete'); else print('entete');?>">
        <th id="position0">Localit&eacute;<a id="ascendant" href="liste.php?annonce_tri=ville&annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT_V2.'image/tri_ascendant.png')?>" alt="tri ascendant" title="tri ascendant" /></a><a id="descendant" href="liste.php?annonce_tri=ville&annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT_V2.'image/tri_descendant.png')?>" alt="tri descendant" title="tri descendant" /></a></th>
        <th id="position1">Type<a id="ascendant" href="liste.php?annonce_tri=type&annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT_V2.'image/tri_ascendant.png')?>" alt="tri ascendant" title="tri ascendant" /></a><a id="descendant" href="liste.php?annonce_tri=type&annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT_V2.'image/tri_descendant.png')?>" alt="tri descendant" title="tri descendant" /></a> </th>
        <th id="position2">Loyer<a id="ascendant" href="liste.php?annonce_tri=loyer&annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT_V2.'image/tri_ascendant.png')?>" alt="tri ascendant" title="tri ascendant" /></a><a id="descendant" href="liste.php?annonce_tri=loyer&annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT_V2.'image/tri_descendant.png')?>" alt="tri descendant" title="tri descendant" /></a> </th>
        <th id="position3">Parution<a id="ascendant" href="liste.php?annonce_tri=parution&annonce_ordre=asc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT_V2.'image/tri_ascendant.png')?>" alt="tri ascendant" title="tri ascendant" /></a><a id="descendant" href="liste.php?annonce_tri=parution&annonce_ordre=desc<?php print('#alerte'.($i+1));?>"><img src="<?php print(URL_ADHERENT_V2.'image/tri_descendant.png')?>" alt="tri descendant" title="tri descendant" /></a> </th>
        <th id="position4">Cochez et <input type="submit" name="annonce_submit" value="GO" /></th>
      </tr>
      <?php
				}
?>
      <tr id="<?php print('ligne'.$k);?>" onclick="liste_onClick('alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>');">
        <td id="position0" class="out0<?php if(!$alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print(' non_lu');?>" onmouseout="mouseout(this.parentNode);" onmouseover="mouseover(this.parentNode);"><!--a style="text-decoration:none;" href="liste.php?annonce_submit=GO&annonce_identifiant%5B%5D=<?php print(urlencode($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>"--><?php if(!$alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print('<img style="border:none;" src="'.URL_ADHERENT_V2.'image/non_lu.jpg" alt="Annonce non consult&eacute;e" title="Annonce non consult&eacute;e" />'); else print('<img style="border:none;" src="'.URL_ADHERENT_V2.'image/lu.gif" alt="Annonce d&eacute;j&agrave; consult&eacute;e" title="Annonce d&eacute;j&agrave; consult&eacute;e" />'); print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['code_postal'].' '.$alerte[$i]['liste']->occurrence[$j]['ville']))?><!--/a--></td>
        <td id="position1" class="out1<?php if(!$alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print(' non_lu');?>" onmouseout="mouseout(this.parentNode);" onmouseover="mouseover(this.parentNode);"><!--a style="text-decoration:none;" href="liste.php?annonce_submit=GO&annonce_identifiant%5B%5D=<?php print(urlencode($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>"--><?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['type']))?><!--/a--></td>
        <td id="position2" class="out2<?php if(!$alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print(' non_lu');?>" onmouseout="mouseout(this.parentNode);" onmouseover="mouseover(this.parentNode);"><!--a style="text-decoration:none;" href="liste.php?annonce_submit=GO&annonce_identifiant%5B%5D=<?php print(urlencode($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>"--><?php if($alerte[$i]['liste']->occurrence[$j]['loyer']!==NULL) print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['loyer']).'&euro;')?><!--/a--></td>
        <td id="position3" class="out3<?php if(!$alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print(' non_lu');?>" onmouseout="mouseout(this.parentNode);" onmouseover="mouseover(this.parentNode);"><!--a style="text-decoration:none;" href="liste.php?annonce_submit=GO&annonce_identifiant%5B%5D=<?php print(urlencode($alerte[$i]['liste']->occurrence[$j]['identifiant']));?>"--><?php print(ma_htmlentities(strftime('%d %B %Y',$alerte[$i]['liste']->occurrence[$j]['parution'])))?><!--/a--></td>
        <td id="position4" class="out4<?php if(!$alerte[$i]['liste']->occurrence[$j]['adherent_annonce']) print(' non_lu');?>" onmouseout="mouseout(this.parentNode);" onmouseover="mouseover(this.parentNode);"><input type="checkbox" name="annonce_identifiant[]" id="alerte<?php print($i);?>_annonce_identifiant_<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']))?>" value="<?php print(ma_htmlentities($alerte[$i]['liste']->occurrence[$j]['identifiant']))?>" onclick="liste_onUnClick(this,2);" /></td>
      </tr>
      <?php
			}
		}
		else
		{
?>
        <tr id="critere">
		  <th colspan="5">Cette alerte ne contient aucune annonce. Afin d'augmenter vos chances de trouver une location, nous vous conseillons d'&eacute;largir votre recherche en <a href="<?php print(URL_ADHERENT_V2.'compte/fiche.php');?>">cliquant ici</a>.</th>
        </tr>
<?php
		}
?>
    </table>
    <?php
	}
?>
  </form>
  <iframe src="<?php print(URL_ADHERENT_V2);?>adsense.php?adsense_identifiant=728x90" id="adsense728x90" scrolling="no" frameborder="0"></iframe>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
