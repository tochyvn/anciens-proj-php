<?php
	define('ADSENSE_REPETITION',5);
	define('ADSENSE_LIMITE',3);
	define('COOKIE_DUREE',time()+20*24*60*60);
	define('COOKIE_LIMITE',150);
	define('COOKIE_RESTANT',125);
	
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'adherent_annonce.php');
	require_once(PWD_ADHERENT_V2.'annonce/verification.php');

	if(!isset($_SESSION['annonce_tri']))
		$_SESSION['annonce_tri']='parution';
	if(!isset($_SESSION['annonce_ordre']))
		$_SESSION['annonce_ordre']='desc';
	
	$tableau=array('poubelle','aime','deteste','web');
	for($j=0;$j<sizeof($tableau);$j++)
	{
		if(isset($_COOKIE['memo'][$tableau[$j]]))
		{
			$k=sizeof($_COOKIE['memo'][$tableau[$j]]);
			if($k>=COOKIE_LIMITE)
			{
				$i=0;
				foreach($_COOKIE['memo'][$tableau[$j]] as $clef=>$valeur)
				{
					if($i<$k-COOKIE_RESTANT)
					{
						unset($_COOKIE['memo'][$tableau[$j]][$clef]);
						setcookie('memo['.$tableau[$j].']['.$clef.']',time(),time()-36000,'/',ini_get('session.cookie_domain'),false);
						$i++;
					}
				}
			}
		}
	}
	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'poubelle':
				for($i=0;$i<sizeof($_REQUEST['detail']);$i++)
				{
					$maintenant=time();
					setcookie('memo[poubelle]['.$_REQUEST['detail'][$i].']',$maintenant,COOKIE_DUREE,'/',ini_get('session.cookie_domain'),false);
					$_COOKIE['memo']['poubelle'][$_REQUEST['detail'][$i]]=$maintenant;
				}
				
				if(isset($_REQUEST['ajax']))
					die('0');
				
				break;
			case 'aime':
				for($i=0;$i<sizeof($_REQUEST['detail']);$i++)
				{
					$maintenant=time();
					setcookie('memo[aime]['.$_REQUEST['detail'][$i].']',$maintenant,COOKIE_DUREE,'/',ini_get('session.cookie_domain'),false);
					$_COOKIE['memo']['aime'][$_REQUEST['detail'][$i]]=$maintenant;
					if(isset($_COOKIE['memo']['deteste'][$_REQUEST['detail'][$i]]))
					{
						unset($_COOKIE['memo']['deteste'][$_REQUEST['detail'][$i]]);
						setcookie('memo[deteste]['.$_REQUEST['detail'][$i].']',$maintenant,time()-36000,'/',ini_get('session.cookie_domain'),false);
					}
				}
				
				if(isset($_REQUEST['ajax']))
					die('0');
				
				break;
			case 'deteste':
				for($i=0;$i<sizeof($_REQUEST['detail']);$i++)
				{
					$maintenant=time();
					setcookie('memo[deteste]['.$_REQUEST['detail'][$i].']',$maintenant,COOKIE_DUREE,'/',ini_get('session.cookie_domain'),false);
					$_COOKIE['memo']['deteste'][$_REQUEST['detail'][$i]]=$maintenant;
					if(isset($_COOKIE['memo']['aime'][$_REQUEST['detail'][$i]]))
					{
						unset($_COOKIE['memo']['aime'][$_REQUEST['detail'][$i]]);
						setcookie('memo[aime]['.$_REQUEST['detail'][$i].']',$maintenant,time()-36000,'/',ini_get('session.cookie_domain'),false);
					}
				}
				
				if(isset($_REQUEST['ajax']))
					die('0');
				
				break;
			case 'web':
				for($i=0;$i<sizeof($_REQUEST['detail']);$i++)
				{
					$maintenant=time();
					setcookie('memo[web]['.$_REQUEST['detail'][$i].']',$maintenant,COOKIE_DUREE,'/',ini_get('session.cookie_domain'),false);
					$_COOKIE['memo']['web'][$_REQUEST['detail'][$i]]=$maintenant;
				}
				
				$liste=new ld_liste('select url from liste where identifiant=\''.addslashes($_REQUEST['detail'][0]).'\'');
				if($liste->total)
				{
					if(isset($_REQUEST['ajax']))
						//die('../tinyurl.com.php?url='.urlencode($liste->occurrence[0]['url']));
						die('http://temp.alertimmo.fr/refresh.php?url='.urlencode($liste->occurrence[0]['url']));
					
					//header('location: ../tinyurl.com.php?url='.urlencode($liste->occurrence[0]['url']));
					header('location: http://temp.alertimmo.fr/refresh.php?url='.urlencode($liste->occurrence[0]['url']));
					die();
				}
				
				if(isset($_REQUEST['ajax']))
					die();
				
				break;
		}
	}
	
	ini_set('memory_limit','32M');
	
	$preference=new ld_preference();
	
	$liste=new ld_liste('select identifiant, designation, url from provenance');
	$provenance=array();
	for($i=0;$i<$liste->total;$i++)
		$provenance[$liste->occurrence[$i]['identifiant']]=$liste->occurrence[$i]['url'];
	
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
			provenance_identifiant,
			provenance_designation,
			provenance_couleur
		from liste
		where identifiant in (\''.implode('\', \'',array_map('addslashes',$_SESSION['annonce_identifiant'])).'\')
	    	'.((isset($_COOKIE['memo']['poubelle']))?('and identifiant not in (\''.implode('\', \'',array_map('addslashes',array_keys($_COOKIE['memo']['poubelle']))).'\')'):('')).'
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
			and annonce.identifiant in (\''.implode('\', \'',array_map('addslashes',$_COOKIE['memo']['poubelle'])).'\')
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
	function poubelle(identifiant,index)
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
			
			xhr_object.open('GET','<?php print(HTTP_ADHERENT_V2.'annonce/detail.php?ajax=&annonce_submit=poubelle&detail%5B%5D=');?>'+identifiant,false);
			
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
	
	function aime(identifiant,index)
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
			
			xhr_object.open('GET','<?php print(HTTP_ADHERENT_V2.'annonce/detail.php?ajax=&annonce_submit=aime&detail%5B%5D=');?>'+identifiant,false);
			
			xhr_object.send(null);
			if(xhr_object.readyState != 4)
				return false;
			
			if(xhr_object.responseText!='0')
				return false;
			
			document.getElementById('aime'+index).src='<?php print(HTTP_ADHERENT_V2.'image/aime.jpg');?>';
			document.getElementById('deteste'+index).src='<?php print(HTTP_ADHERENT_V2.'image/deteste_gris.jpg');?>';
			
			return true;
		}
		catch(e)
		{
			return false;
		}
	}
	
	function deteste(identifiant,index)
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
			
			xhr_object.open('GET','<?php print(HTTP_ADHERENT_V2.'annonce/detail.php?ajax=&annonce_submit=deteste&detail%5B%5D=');?>'+identifiant,false);
			
			xhr_object.send(null);
			if(xhr_object.readyState != 4)
				return false;
			
			if(xhr_object.responseText!='0')
				return false;
			
			document.getElementById('aime'+index).src='<?php print(HTTP_ADHERENT_V2.'image/aime_gris.jpg');?>';
			document.getElementById('deteste'+index).src='<?php print(HTTP_ADHERENT_V2.'image/deteste.jpg');?>';
			
			return true;
		}
		catch(e)
		{
			return false;
		}
	}
	
	function web(identifiant,index)
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
			
			xhr_object.open('GET','<?php print(HTTP_ADHERENT_V2.'annonce/detail.php?ajax=&annonce_submit=web&detail%5B%5D=');?>'+identifiant,false);
			
			xhr_object.send(null);
			if(xhr_object.readyState != 4)
				return false;
			
			if(xhr_object.responseText==''/* || xhr_object.responseText.search(/^https?:\/\//)==-1*/)
				return false;
			
			window.open(xhr_object.responseText);
			document.getElementById('web'+index).style.visibility='visible';
			
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
  <p id="annonce_detail"><img src="<?php print(URL_ADHERENT_V2.'image/aide.png');?>" alt="Aide" title="Aide" />Pour retourner &agrave; la liste des annonces, <a href="<?php print(URL_ADHERENT_V2.'annonce/liste.php');?>">cliquez ici</a>.</p>
  <table id="annonce_detail" cellspacing="9">
    <caption>
    D&eacute;tail des annonces
    </caption>
    <?php
	$identifiant=array();
	$k=0;
	for($i=0;$i<$annonce_liste->total;$i++)
	{
		$descriptif=$annonce_liste->occurrence[$i]['descriptif'];
		$descriptif=preg_replace('/^[ \r\n\t]+/','',$descriptif);
		$descriptif=preg_replace('/[ \r\n\t]+$/','',$descriptif);
		if($annonce_liste->occurrence[$i]['url']!='')
		{
			$delimiteur='<!-- '.strrnd(10,7).' -->';
			$descriptif=wordwrap($descriptif,300,$delimiteur,false);
			$descriptif.=$delimiteur;
			$descriptif=substr($descriptif,0,strpos($descriptif,$delimiteur));
			$descriptif=preg_replace('/'.STRING_TROUVE_TELEPHONE_TRES_LAXISTE.'/',' ',$descriptif);
			$descriptif=preg_replace('/'.STRING_TROUVE_EMAIL.'/',' ',$descriptif);
			$descriptif.='...';
		}
		else
		{
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
			if(sizeof($contact)) $descriptif.=CRLF.'Contact: '.implode(',',$contact);
		}
?>
    <tr id="<?php print('position'.$i);?>">
      <td><a name="<?php print($i);?>" id="ancre<?php print($i);?>"></a><div id="provenance"><img src="<?php print(URL_INCLUSION.'gd.php?forme=rectangle&x=8&y=8&c='.urlencode($annonce_liste->occurrence[$i]['provenance_couleur']));?>" alt="<?php print(ma_htmlentities($annonce_liste->occurrence[$i]['provenance_designation']))?>" title="<?php print(ma_htmlentities($annonce_liste->occurrence[$i]['provenance_designation']))?>" /></div>
        <div id="image"><?php if($annonce_liste->occurrence[$i]['image']!==NULL) print('<a href="'.URL_ADHERENT_V2.'annonce/detail.php?annonce_submit=web&detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']).'" onclick="web('.$annonce_liste->occurrence[$i]['identifiant'].','.$i.'); return false;" target="_blank"><img src="'.$annonce_liste->occurrence[$i]['image'].'" style="border:none;" /></a>');?></div>
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
        <div id="descriptif"><?php print(nl2br(ma_htmlentities($descriptif)));?></div>
        <div id="identifiant"><?php print('R&eacute;f.: '.ma_htmlentities($annonce_liste->occurrence[$i]['identifiant']));?></div>
        <div id="contact">&nbsp;</div>
        <div id="url2"><?php if($annonce_liste->occurrence[$i]['url']!='') print('<a href="'.URL_ADHERENT_V2.'annonce/detail.php?annonce_submit=web&detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']).'" onclick="web('.$annonce_liste->occurrence[$i]['identifiant'].','.$i.'); return false;" target="_blank">Consultez la suite de l\'annonce ici</a>'); else print('<a id="image'.$i.'" onclick="this.style.backgroundImage=\'url(../image/annonce_url2_sombre.jpg)\';" href="'.$provenance[$annonce_liste->occurrence[$i]['provenance_identifiant']].'" target="_blank">Retrouvez l\'annonce sur '.$annonce_liste->occurrence[$i]['provenance_designation'].'</a>')?></div>
        <div id="picto">
		  <img id="<?php print('web'.$i);?>" src="<?php print(URL_ADHERENT_V2.'image/web.jpg');?>" alt="J'ai d&eacute;j&agrave; consult&eacute; le d&eacute;tail de cette annonce" title="J'ai d&eacute;j&agrave; consult&eacute; le d&eacute;tail de cette annonce"<?php if(!isset($_COOKIE['memo']['web'][$annonce_liste->occurrence[$i]['identifiant']])) print('style="visibility: hidden;"');?> />
          <a href="<?php print(URL_ADHERENT_V2.'annonce/detail.php?annonce_submit=aime&detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>" onclick="aime(<?php print($annonce_liste->occurrence[$i]['identifiant']);?>,<?php print($i);?>); return false;"><img id="<?php print('aime'.$i);?>" src="<?php print(URL_ADHERENT_V2.'image/aime'.((!isset($_COOKIE['memo']['aime'][$annonce_liste->occurrence[$i]['identifiant']]))?('_gris'):('')).'.jpg');?>" alt="J'aime cette annonce" title="J'aime cette annonce" /></a>
          <a href="<?php print(URL_ADHERENT_V2.'annonce/detail.php?annonce_submit=deteste&detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>" onclick="deteste(<?php print($annonce_liste->occurrence[$i]['identifiant']);?>,<?php print($i);?>); return false;"><img id="<?php print('deteste'.$i);?>" src="<?php print(URL_ADHERENT_V2.'image/deteste'.((!isset($_COOKIE['memo']['deteste'][$annonce_liste->occurrence[$i]['identifiant']]))?('_gris'):('')).'.jpg');?>" alt="Je n'aime pas cette annonce" title="Je n'aime pas cette annonce" /></a>
          <a href="<?php print(URL_ADHERENT_V2.'annonce/detail.php?annonce_submit=poubelle&detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>" onclick="poubelle(<?php print($annonce_liste->occurrence[$i]['identifiant']);?>,<?php print($i);?>); return false;"><img src="<?php print(URL_ADHERENT_V2.'image/corbeille.jpg');?>" alt="J'enl&egrave;ve l'annonce de cette liste" title="J'enl&egrave;ve l'annonce de cette liste" /></a>
          <a href="<?php print(URL_ADHERENT_V2.'annonce/abus.php?annonce_identifiant='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>"><img src="<?php print(URL_ADHERENT_V2.'image/erreur.jpg');?>" alt="Je veux commenter de cette annonce" title="Je veux commenter cette annonce" /></a>
        </div>
        </td>
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
  <a id="annonce_detail_impression" target="_blank">&nbsp;</a>
  <iframe src="<?php print(URL_ADHERENT_V2);?>adsense.php?adsense_identifiant=728x90&adsense_mode=detail" id="adsense728x90" scrolling="no" frameborder="0"></iframe>
  <br />&nbsp;
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
