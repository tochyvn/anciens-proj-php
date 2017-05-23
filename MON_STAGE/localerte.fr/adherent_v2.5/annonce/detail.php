<?php
	define('COOKIE_DUREE',time()+20*24*60*60);
	define('COOKIE_LIMITE',150);
	define('COOKIE_RESTANT',125);
	
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'preference.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'adherent_annonce.php');
	
	if((!isset($_SESSION['code_reference']) && !isset($_SESSION['allopass_reference']) && !isset($_SESSION['wha_identifiant']) && $abonnement['resultat']!='ABONNEMENT_UTILISABLE' && $abonnement['resultat']!='ABONNEMENT_DELAI_PERIME') || !isset($_SESSION['annonce_identifiant']))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/liste.php'));
		die();
	}
	
	if($abonnement['resultat']!='ABONNEMENT_UTILISABLE' && !isset($_SESSION['allopass_reference']) && !isset($_SESSION['wha_identifiant']) && !isset($_SESSION['code_reference']))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/tarif.php'));
		die();
	}

	//if(!isset($_SESSION['annonce_tri']))
		//$_SESSION['annonce_tri']='parution';
	//if(!isset($_SESSION['annonce_ordre']))
		//$_SESSION['annonce_ordre']='desc';
	
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
			if(datediff(enregistrement,modification)=0,unix_timestamp(enregistrement),unix_timestamp(parution)) as parution,
			telephone,
			email,
			provenance_identifiant,
			provenance_designation,
			provenance_couleur
		from liste
		where identifiant in (\''.implode('\', \'',array_map('addslashes',$_SESSION['annonce_identifiant'])).'\')
	    	'.((isset($_COOKIE['memo']['poubelle']))?('and identifiant not in (\''.implode('\', \'',array_map('addslashes',array_keys($_COOKIE['memo']['poubelle']))).'\')'):('')).'
		order by /*`'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].'*/ parution desc
	');
	
	/* Mots clés adsense */
	$tab_mot_cle = array();
	$mot_cle='';
	for($i=0; $i<$annonce_liste->total && !$i; $i++) {
		$tab_mot_cle[] = $annonce_liste->occurrence[$i]['ville'];/*.' ('.$annonce_liste->occurrence[$i]['code_postal'].') '*/;
		//$tab_mot_cle[] = $annonce_liste->occurrence[$i]['ville'].' ('.$annonce_liste->occurrence[$i]['code_postal'].') ';
		//$tab_mot_cle[] = $annonce_liste->occurrence[$i]['type'];
	}
	$tab_mot_cle = array_unique($tab_mot_cle);
	$tab_mot_cle = array_values($tab_mot_cle);
	for($i=0; $i<sizeof($tab_mot_cle); $i++)
		$mot_cle.=$tab_mot_cle[$i];
	/*********************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
<script type="text/javascript">
<!--
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
			
			xhr_object.open('GET','<?php print(HTTP_ADHERENT.'annonce/detail.php?ajax=&annonce_submit=poubelle&detail%5B%5D=');?>'+identifiant,false);
			
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
			
			xhr_object.open('GET','<?php print(HTTP_ADHERENT.'annonce/detail.php?ajax=&annonce_submit=aime&detail%5B%5D=');?>'+identifiant,false);
			
			xhr_object.send(null);
			if(xhr_object.readyState != 4)
				return false;
			
			if(xhr_object.responseText!='0')
				return false;
			
			document.getElementById('aime'+index).src='<?php print(HTTP_ADHERENT.'image/aime.jpg');?>';
			document.getElementById('deteste'+index).src='<?php print(HTTP_ADHERENT.'image/deteste_gris.jpg');?>';
			
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
			
			xhr_object.open('GET','<?php print(HTTP_ADHERENT.'annonce/detail.php?ajax=&annonce_submit=deteste&detail%5B%5D=');?>'+identifiant,false);
			
			xhr_object.send(null);
			if(xhr_object.readyState != 4)
				return false;
			
			if(xhr_object.responseText!='0')
				return false;
			
			document.getElementById('aime'+index).src='<?php print(HTTP_ADHERENT.'image/aime_gris.jpg');?>';
			document.getElementById('deteste'+index).src='<?php print(HTTP_ADHERENT.'image/deteste.jpg');?>';
			
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
			
			xhr_object.open('GET','<?php print(HTTP_ADHERENT.'annonce/detail.php?ajax=&annonce_submit=web&detail%5B%5D=');?>'+identifiant,false);
			
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
-->
</script>
</head>
<body>
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
    <div id="detail_liste">
      <p class="lien"><a class="bleu_fonce gras" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste des annonces</a><br />
        <a class="orange2 gras" href="<?php print(URL_ADHERENT.'alerte/liste.php');?>">Modifier mes alertes</a><br />
        <br />
      </p>
      <table cellspacing="15" class="detail_liste">
        <tr>
          <td>
            <div id="adsense-liste1" class="adsense-liste"></div>
          </td>
        </tr>
        <?php
	$identifiant=array();
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
<?php
	if($i==5)
	{
?>
        <tr>
          <td>
            <div id="adsense-liste2" class="adsense-liste"></div>
          </td>
        </tr>
<?php
	}
?>
        <tr>
          <td><table cellpadding="0" cellspacing="0" class="annonce_detail">
              <tr>
                <td width="150"><a name="<?php print($i);?>" id="ancre<?php print($i);?>"></a> <?php print('<a href="'.URL_ADHERENT.'annonce/detail.php?annonce_submit=web&amp;detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']).'" onclick="web('.$annonce_liste->occurrence[$i]['identifiant'].','.$i.'); return false;" class="js-blank"><img src="'.(($annonce_liste->occurrence[$i]['image']!==NULL)?(ma_htmlentities(URL_INCLUSION.'gd.php?forme=vignette&largeur=150&url='.urlencode($annonce_liste->occurrence[$i]['image']))):(URL_ADHERENT.'image/detail/pasdimage.jpg')).'" style="border:none;" alt="" width="134" /></a>');?></td>
                <td width="100" class="gauche"><span class="orange2 gras t18"><?php print(ma_htmlentities($annonce_liste->occurrence[$i]['type']));?></span><br />
                  <span class="orange2 gras t18">
                  <?php if($annonce_liste->occurrence[$i]['loyer']!==NULL) print(ma_htmlentities(number_format($annonce_liste->occurrence[$i]['loyer'], 0, ',', ' ')).' &euro;'); else print('- &euro;');?>
                  </span><br />
                  <?php print('R&eacute;f.: '.ma_htmlentities($annonce_liste->occurrence[$i]['identifiant']));?><br />
                  Annonceur: <img src="<?php print(URL_INCLUSION.'gd.php?forme=rectangle&amp;x=8&amp;y=8&amp;c='.urlencode($annonce_liste->occurrence[$i]['provenance_couleur']));?>" alt="" title="" /></td>
                <td width="430" class="gauche"><table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td><span class="orange2 gras t15"><?php print(ma_htmlentities($annonce_liste->occurrence[$i]['code_postal'].' '.$annonce_liste->occurrence[$i]['ville']));?></span></td>
                      <td class="droite"><span class="orange2 gras t13" style="margin-right:0;">Parue le <?php print(strftime('%d %B %Y', $annonce_liste->occurrence[$i]['parution']));?></span></td>
                    </tr>
                  </table>
                  <br />
                  <?php print(nl2br(ma_htmlentities($descriptif)));?> 
                  <!--img id="<?php print('web'.$i);?>" src="<?php print(URL_ADHERENT.'image/web.jpg');?>" alt="J'ai d&eacute;j&agrave; consult&eacute; le d&eacute;tail de cette annonce" title="J'ai d&eacute;j&agrave; consult&eacute; le d&eacute;tail de cette annonce"<?php if(!isset($_COOKIE['memo']['web'][$annonce_liste->occurrence[$i]['identifiant']])) print(' style="visibility: hidden;"');?> /--> 
                  <!--a href="<?php print(URL_ADHERENT.'annonce/detail.php?annonce_submit=aime&amp;detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>" onclick="aime(<?php print($annonce_liste->occurrence[$i]['identifiant']);?>,<?php print($i);?>); return false;"><img id="<?php print('aime'.$i);?>" src="<?php print(URL_ADHERENT.'image/aime'.((!isset($_COOKIE['memo']['aime'][$annonce_liste->occurrence[$i]['identifiant']]))?('_gris'):('')).'.jpg');?>" alt="J'aime cette annonce" title="J'aime cette annonce" /></a--> 
                  <!--a href="<?php print(URL_ADHERENT.'annonce/detail.php?annonce_submit=deteste&amp;detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>" onclick="deteste(<?php print($annonce_liste->occurrence[$i]['identifiant']);?>,<?php print($i);?>); return false;"><img id="<?php print('deteste'.$i);?>" src="<?php print(URL_ADHERENT.'image/deteste'.((!isset($_COOKIE['memo']['deteste'][$annonce_liste->occurrence[$i]['identifiant']]))?('_gris'):('')).'.jpg');?>" alt="Je n'aime pas cette annonce" title="Je n'aime pas cette annonce" /></a--></td>
              </tr>
              <tr>
                <td colspan="3" class="bleu_clair droite"><span><a class="bleu_clair gras" href="<?php print(URL_ADHERENT.'annonce/detail.php?annonce_submit=poubelle&amp;detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>" onclick="poubelle(<?php print($annonce_liste->occurrence[$i]['identifiant']);?>,<?php print($i);?>); return false;">Supprimer de la liste</a> - <a class="bleu_clair gras" href="<?php print(URL_ADHERENT.'annonce/abus.php?annonce_identifiant='.urlencode($annonce_liste->occurrence[$i]['identifiant']));?>">Signaler une erreur</a></span> 
                  <!--?php if($annonce_liste->occurrence[$i]['meuble']=='OUI') print('Meubl&eacute;'); elseif($annonce_liste->occurrence[$i]['meuble']=='NON') print('Non meubl&eacute;'); else print('');?--> 
                  <!--?php if($annonce_liste->occurrence[$i]['statut']=='PARTICULIER') print('Particulier'); elseif($annonce_liste->occurrence[$i]['statut']=='PROFESSIONNEL') print('Professionnel'); else print('Statut N.C.');?-->
                  
                  <?php if($annonce_liste->occurrence[$i]['url']!='')
				print('<a href="'.URL_ADHERENT.'annonce/detail.php?annonce_submit=web&amp;detail%5B%5D='.urlencode($annonce_liste->occurrence[$i]['identifiant']).'" onclick="web('.$annonce_liste->occurrence[$i]['identifiant'].','.$i.'); return false;" class="js-blank nodeco"><span class="bouton_orange3">En savoir plus</span></a>'); else print('<!--a id="image'.$i.'" onclick="this.style.backgroundImage=\'url(../image/annonce_url2_sombre.jpg)\';" href="'.$provenance[$annonce_liste->occurrence[$i]['provenance_identifiant']].'" class="js-blank">Retrouvez l\'annonce sur '.$annonce_liste->occurrence[$i]['provenance_designation'].'</a-->')?></td>
              </tr>
            </table></td>
        </tr>
        <?php
		$identifiant[]=$annonce_liste->occurrence[$i]['identifiant'];
		
		if($i%10==0)
		{
			print
			('
				<script type="text/javascript">
				<!--
					js_blank();
				//-->
				</script>
			');
		}
	}
	
	if(sizeof($identifiant))
	{
		$adherent_annonce=new ld_adherent_annonce();
		$adherent_annonce->enregistrer($_SESSION['adherent_identifiant'],$identifiant);
	}
?>
<?php
	if($i<5)
	{
?>
        <tr>
          <td>
            <div id="adsense-liste2" class="adsense-liste"></div>
          </td>
        </tr>
<?php
	}
?>
        <tr>
          <td>
            <div id="adsense-liste3" class="adsense-liste"></div>
          </td>
        </tr>
      </table>
	<script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script> 
    <script type="text/javascript" charset="utf-8"> 
        <!--
        var pageOptions2 = { 
          'pubId' : 'pub-9592588828246820',
          'query' : '<?php print(addslashes('location '.ma_htmlentities($mot_cle)));?>',
          'channel' : '0901693454',
          'hl' : 'fr',
          'linkTarget' : '_blank'
        };
        
        var adblock1 = { 
          'container' : 'adsense-liste1',
		  'width' : '650px',
		  'number' : '2',
		  'colorTitleLink' : '#e57503',
		  'colorText' : '#195292',
		  'colorDomainLink' : '#000000',
		  'fontSizeTitle' : '18px',
		  'siteLinks' : false
        };
        
        var adblock2 = { 
          'container' : 'adsense-liste2',
		  'width' : '650px',
		  'number' : '2',
		  'colorTitleLink' : '#e57503',
		  'colorText' : '#195292',
		  'colorDomainLink' : '#000000',
		  'fontSizeTitle' : '18px',
		  'siteLinks' : false
        };
        
        var adblock3 = { 
          'container' : 'adsense-liste3',
		  'width' : '650px',
		  'number' : '4',
		  'colorTitleLink' : '#e57503',
		  'colorText' : '#195292',
		  'colorDomainLink' : '#000000',
		  'fontSizeTitle' : '18px',
		  'siteLinks' : false
        };
        
        new google.ads.search.Ads(pageOptions2, adblock1, adblock2, adblock3);
    //--></script> 
      <p class="lien"><a class="orange2 gras" href="<?php print(URL_ADHERENT.'alerte/liste.php');?>">Modifier mes alertes</a><br />
        <a class="bleu_fonce gras" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste des annonces</a></p>
      <p class="gauche"><a class="t11 orange_fonce" href="<?php print(URL_ADHERENT.'annonce/provenance.php');?>">Voir la liste des annonceurs</a></p>
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
