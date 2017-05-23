<?php
	define('ADSENSE_REPETITION',5);
	define('ADSENSE_LIMITE',3);
	
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'adherent_annonce.php');
	require_once(PWD_ADHERENT_V2.'annonce/verification.php');

	if(!isset($_SESSION['annonce_tri']))
		$_SESSION['annonce_tri']='parution';
	if(!isset($_SESSION['annonce_ordre']))
		$_SESSION['annonce_ordre']='desc';
	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'poubelle':
				for($i=0;$i<sizeof($_REQUEST['annonce_identifiant']);$i++)
				{
					$resultat=array_search($_REQUEST['annonce_identifiant'][$i],$_SESSION['annonce_identifiant']);
					if($resultat!==false)
						unset($_SESSION['annonce_identifiant'][$resultat]);
				}
				$_SESSION['annonce_identifiant']=array_values($_SESSION['annonce_identifiant']);
				if(isset($_REQUEST['ajax']))
					die('0');
		}
	}
	
	ini_set('memory_limit','32M');
	
	$preference=new ld_preference();
	
	$annonce_liste=new ld_liste
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
	
	$provenance_liste=new ld_liste
	('
		select identifiant,
			designation,
			url,
			couleur
		from provenance
		order by designation
	');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT_V2.'entete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
<script language="javascript">
	function EnleverAnnonce(url,index)
	{
		try
		{
			var xhr_object = null;
			
			if(window.XMLHttpRequest)
				xhr_object = new XMLHttpRequest();
			else if(window.ActiveXObject)
				xhr_object = new ActiveXObject('Microsoft.XMLHTTP');
			else
				return false;
			
			xhr_object.open('GET',url,false);
			
			xhr_object.send(null);
			if(xhr_object.readyState != 4)
				return false;
			
			if(xhr_object.responseText!='0')
				return false;
			
			var ancre=document.getElementById('ancre'+index);
			var tr=ancre.parentNode.parentNode;
			var table=tr.parentNode;
			table.removeChild(tr);
			
			return true;
		}
		catch(e)
		{
			return false;
		}
	}
</script>
</head>
<body>
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="annonce_detail">Nos annonces du jour - D&eacute;tail</h1>
  <p id="annonce_detail"><img src="<?php print(URL_ADHERENT_V2.'image/aide.png');?>" alt="Aide" title="Aide" />Pour retourner &agrave; la liste des annonces, <a href="<?php print(URL_ADHERENT_V2.'annonce/liste.php');?>">cliquez ici</a>. Pour imprimer la liste, <a href="<?php print(URL_ADHERENT_V2.'annonce/impression.php');?>" target="_blank">cliquez ici</a></p>
  <table id="annonce_detail" cellspacing="9">
    <caption>
    D&eacute;tail des annonces
    </caption>
    <?php
	$identifiant=array();
	$k=0;
	for($i=0;$i<$annonce_liste->total;$i++)
	{
?>
    <tr id="<?php print('position'.$i);?>">
      <td><a name="<?php print($i);?>" id="ancre<?php print($i);?>"></a><div id="provenance"><img src="<?php print(URL_INCLUSION.'gd.php?forme=rectangle&x=8&y=8&c='.urlencode($annonce_liste->occurrence[$i]['provenance_couleur']));?>" alt="<?php print(ma_htmlentities($annonce_liste->occurrence[$i]['provenance_designation']))?>" title="<?php print(ma_htmlentities($annonce_liste->occurrence[$i]['provenance_designation']))?>" /></div>
        <div id="image"><?php if($annonce_liste->occurrence[$i]['image']!==NULL) print('<img src="'.$annonce_liste->occurrence[$i]['image'].'" />');?></div>
        <div id="localite"><?php print(ma_htmlentities($annonce_liste->occurrence[$i]['code_postal'].' '.$annonce_liste->occurrence[$i]['ville']));?></div>
        <div id="type"><?php print(ma_htmlentities($annonce_liste->occurrence[$i]['type']));?></div>
        <div id="meuble">
          <?php if($annonce_liste->occurrence[$i]['meuble']=='OUI') print('Meubl&eacute;'); elseif($annonce_liste->occurrence[$i]['meuble']=='NON') print('Non meubl&eacute;'); else print('');?>
        </div>
        <div id="loyer">
          <?php if($annonce_liste->occurrence[$i]['loyer']!==NULL) print(ma_htmlentities($annonce_liste->occurrence[$i]['loyer']).'&euro;'); else print('- &euro;');?>
        </div>
        <div id="statut">
          <?php if($annonce_liste->occurrence[$i]['statut']=='PARTICULIER') print('Particulier'); elseif($annonce_liste->occurrence[$i]['statut']=='PROFESSIONNEL') print('Professionnel'); else print('Statut N.C.');?>
        </div>
        <div id="descriptif"><?php print(nl2br(ma_htmlentities($annonce_liste->occurrence[$i]['descriptif'])));?></div>
        <div id="identifiant"><?php print('R&eacute;f.: '.ma_htmlentities($annonce_liste->occurrence[$i]['identifiant']));?></div>
        <div id="contact">
          <?php
			$contact=array();
			if($annonce_liste->occurrence[$i]['telephone']!='')
			{
				$telephone=explode(', ',$annonce_liste->occurrence[$i]['telephone']);
				for($j=0;$j<sizeof($telephone);$j++)
					$telephone[$j]=formater($telephone[$j],'telephone_espace');
				$contact=$telephone;
			}
			if($annonce_liste->occurrence[$i]['email']!='')
			{
				$email=explode(', ',$annonce_liste->occurrence[$i]['email']);
				for($j=0;$j<sizeof($email);$j++)
					$email[$j]='<a href="mailto:'.urlencode($email[$j]).'">'.$email[$j].'</a>';
				$contact=array_merge($contact,$email);
			}
			print(implode(', ',$contact));
		?>
        </div>
        <div id="url"><?php if($annonce_liste->occurrence[$i]['url']!==NULL) print('<a href="'.$annonce_liste->occurrence[$i]['url'].'" target="_blank">Plus d\'info</a>');?></div>
        <div id="poubelle"><?php print('<a href="'.URL_ADHERENT_V2.'annonce/detail.php?annonce_submit=poubelle&annonce_identifiant%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']).'#'.$i.'" onclick="return !EnleverAnnonce(\''.HTTP_ADHERENT_V2.'annonce/detail.php?annonce_submit=poubelle&annonce_identifiant%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']).'&ajax=\','.$i.');"><img src="'.URL_ADHERENT_V2.'image/poubelle.jpg" alt="Enlever l\'annonce de cette liste" title="Enlever l\'annonce de cette liste" /></a>');?></div>
        <div id="abus"><a href="<?php print(URL_ADHERENT_V2.'annonce/abus.php?annonce_identifiant='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>" ><img src="<?php print(URL_ADHERENT_V2.'image/abus.jpg');?>" alt="Signaler un incident" title="Signaler un incident"></a></div></td>
    </tr>
    <?php
		if((($i+1)%ADSENSE_REPETITION==0 || $i+1==$annonce_liste->total) && $k<ADSENSE_LIMITE)
		{
?>
    <!--tr id="<?php print('adsense'.$k);?>">
      <td><iframe src="<?php print(URL_ADHERENT_V2);?>adsense.php?adsense_identifiant=728x90" id="adsense728x90_detail" scrolling="no" frameborder="0"></iframe></td>
    </tr-->
    <?php
			$k++;
		}
		
		$identifiant[]=$annonce_liste->occurrence[$i]['identifiant'];
	}
	
	if(sizeof($identifiant))
	{
		$adherent_annonce=new ld_adherent_annonce();
		$adherent_annonce->enregistrer($_SESSION['adherent_identifiant'],$identifiant);
	}
?>
  </table>
  <a id="annonce_detail_retour" href="<?php print(URL_ADHERENT_V2.'annonce/liste.php');?>">Retour &agrave; la liste des annonces</a>
  <a id="annonce_detail_impression" href="<?php print(URL_ADHERENT_V2.'annonce/impression.php');?>" target="_blank"><img src="<?php print(URL_ADHERENT_V2.'image/bouton_impression.jpg');?>" alt="Imprimer la liste" title="Imprimer la liste" /></a>
  <table id="annonce_provenance">
    <caption>
    L&eacute;gende
    </caption>
    <tr>
      <td id="position1"><?php
		$i=0;
		for($i=$i;$i<$provenance_liste->total/4;$i++)
			print('<a id="provenance'.$i.'" href="'.$provenance_liste->occurrence[$i]['url'].'" target="_blank"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=8&y=8&c='.urlencode($provenance_liste->occurrence[$i]['couleur']).'" />'.ma_htmlentities($provenance_liste->occurrence[$i]['designation']).'</a>'.CRLF);
		?>
      </td>
      <td id="position2"><?php
		for($i=$i;$i<$provenance_liste->total/4*2;$i++)
			print('<a id="provenance'.$i.'" href="'.$provenance_liste->occurrence[$i]['url'].'" target="_blank"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=8&y=8&c='.urlencode($provenance_liste->occurrence[$i]['couleur']).'" />'.ma_htmlentities($provenance_liste->occurrence[$i]['designation']).'</a>'.CRLF);
		?>
      </td>
      <td id="position3"><?php
		for($i=$i;$i<$provenance_liste->total/4*3;$i++)
			print('<a id="provenance'.$i.'" href="'.$provenance_liste->occurrence[$i]['url'].'" target="_blank"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=8&y=8&c='.urlencode($provenance_liste->occurrence[$i]['couleur']).'" />'.ma_htmlentities($provenance_liste->occurrence[$i]['designation']).'</a>'.CRLF);
		?>
      </td>
      <td id="position4"><?php
		for($i=$i;$i<$provenance_liste->total;$i++)
			print('<a id="provenance'.$i.'" href="'.$provenance_liste->occurrence[$i]['url'].'" target="_blank"><img src="'.URL_INCLUSION.'gd.php?forme=rectangle&x=8&y=8&c='.urlencode($provenance_liste->occurrence[$i]['couleur']).'" />'.ma_htmlentities($provenance_liste->occurrence[$i]['designation']).'</a>'.CRLF);
		?>
      </td>
    </tr>
  </table>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
