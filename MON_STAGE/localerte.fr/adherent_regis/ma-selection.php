<?php
	if((!isset($_SESSION['code_reference']) && !isset($_SESSION['allopass_reference']) && !isset($_SESSION['wha_identifiant']) && $abonnement['resultat']!='ABONNEMENT_UTILISABLE' && $abonnement['resultat']!='ABONNEMENT_DELAI_PERIME') || !isset($_SESSION['annonce_identifiant']))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT_PUBLIC.'/ma-liste.php'));
		die();
	}
	
	if($abonnement['resultat']!='ABONNEMENT_UTILISABLE' && !isset($_SESSION['allopass_reference']) && !isset($_SESSION['wha_identifiant']) && !isset($_SESSION['code_reference']))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT_PUBLIC.'/mes-paiements.php'));
		die();
	}
	
	require_once(PWD_INCLUSION.'adherent_annonce.php');
	require_once(__DIR__.'/inc/liste.php');
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<link href="http://cdn.leafletjs.com/leaflet-0.4/leaflet.css" rel="stylesheet">
<?php $head_title='Mon sélection - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
<script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script>
</head>
<body>
<div class="style2">
  <div class="header">
    <?php include_once(__DIR__.'/inc/style2.header.php');?>
  </div>
  <div class="gauche">
    <div class="carte">
      <?php include_once(__DIR__.'/inc/map.php');?>
    </div>
    <div class="menu">
      <?php include_once(__DIR__.'/inc/ville.php');?>
    </div>
  </div>
  <div class="section ma-selection">
    <?php
	if($liste->total)
		if($_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-01" title="Location '.ma_htmlentities($ville->nom).'"></div>');
  ?>
    <div class="regis-01"> <?php print('<h2>'.$liste->total.' '.($liste->total>1?'annonces s&eacute;lectionn&eacute;es':'annonce s&eacute;lectionn&eacute;e').'</h2>');?>
      <p class="retour"><a class="bouton" href="ma-liste.php">Retour &agrave; ma s&eacute;lection</a></p>
    </div>
    <?php include_once(__DIR__.'/inc/filtre.php');?>
    <?php
	if($liste->total)
	{
		print('<p class="explication"> <strong>Pour voir vos annonces, cliquez sur</strong> <span class="bouton">Voir</span> </p>');
    	print('<div id="resultat">');
		for($i=0;$i<sizeof($liste->occurrence);$i++)
		{
			if($i==5  && $_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-02"></div>');
			if($i==15 && $_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-03"></div>');
			if($i==30 && $_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-04"></div>');
			if($i==0  && $_SESSION['annonce_page']==2) print('<div class="adsearch" id="adsearch-05" title="Location '.ma_htmlentities($type[0]->designation).'"></div>');
			if($i==5  && $_SESSION['annonce_page']==2) print('<div class="adsearch" id="adsearch-06"></div>');
			if($i==15 && $_SESSION['annonce_page']==2) print('<div class="adsearch" id="adsearch-07"></div>');
			
			$annonce_moins_6h = time()-$liste->occurrence[$i]['enregistrement']<(3600*6);
			$annonce_moins_16h = time()-$liste->occurrence[$i]['enregistrement']<(3600*12) && time()-$liste->occurrence[$i]['enregistrement']>=(3600*4) ;
			
			$descriptif=$liste->occurrence[$i]['descriptif'];
			$descriptif=preg_replace('/^[ \r\n\t]+/','',$descriptif);
			$descriptif=preg_replace('/[ \r\n\t]+$/','',$descriptif);
			$delimiteur='<!-- '.strrnd(10,7).' -->';
			$descriptif=wordwrap($descriptif,150,$delimiteur,false);
			$descriptif.=$delimiteur;
			$descriptif=substr($descriptif,0,strpos($descriptif,$delimiteur));
			$descriptif=preg_replace('/'.STRING_TROUVE_TELEPHONE_TRES_LAXISTE.'/',' ',$descriptif);
			$descriptif=preg_replace('/'.STRING_TROUVE_EMAIL.'/',' ',$descriptif);
			$descriptif.='...';
			
			print
			('
				<div class="annonce" id="annonce_'.$liste->occurrence[$i]['identifiant'].'">
				  <div class="colonne1">
					<p class="parution">'.ma_htmlentities(strftime('%d/%m/%Y',$liste->occurrence[$i]['parution'])).'</p>
					<p class="fraicheur">'.($annonce_moins_16h?'<img src="'.HTTP_STATIC.'/img/12h.png" alt="Annonce de moins de 12h" width="74" height="20">':($annonce_moins_6h?'<img src="'.HTTP_STATIC.'/img/6h.png" alt="Annonce de moins de 6h" width="74" height="20">':'')).'</p>
					<p class="lien"><a class="bouton" href="'.ma_htmlentities($liste->occurrence[$i]['url']).'" target="_blank">Voir</a></p>
				  </div>
				  <div class="colonne2">
					'.($liste->occurrence[$i]['image']?'<img src="'.ma_htmlentities(HTTP_STATIC.'/api/gd/'.$liste->occurrence[$i]['identifiant'].'.png').'" alt="" width="160" height="120">':'<img src="'.ma_htmlentities(HTTP_STATIC.'/img/indisponible.png').'" alt="" width="160" height="120">').'
				  </div>
				  <div class="colonne3">
					<p class="type-ville">'.(preg_match('/(T[1-9]|Studio)/i',$liste->occurrence[$i]['type'])?'Appartement ':'').ma_htmlentities($liste->occurrence[$i]['type']).' - '.ma_htmlentities(ucwords(strtolower($liste->occurrence[$i]['ville']))).' ('.ma_htmlentities($liste->occurrence[$i]['code_postal']).')</p>
					<p class="loyer">Loyer : '.ma_htmlentities($liste->occurrence[$i]['loyer']?((int)$liste->occurrence[$i]['loyer']==(float)$liste->occurrence[$i]['loyer']?round($liste->occurrence[$i]['loyer'],0):$liste->occurrence[$i]['loyer']):'- ').'&euro;</p>
					<p class="descriptif">'.ma_htmlentities($descriptif).'</p>
					'.($liste->occurrence[$i]['statut']=='PARTICULIER'?'<p class="statut">Annonce de Particulier</p>':'').'
					<p class="signal"><small><a class="signaler-une-erreur" href="signaler-une-erreur.php?mail_de='.urlencode($adherent->email).'&amp;annonce_identifiant='.urlencode($liste->occurrence[$i]['identifiant']).'">Signaler une erreur</a></small></p>
				  </div>
				</div>
			');
			
			$adherent_annonce=new ld_adherent_annonce();
			$adherent_annonce->enregistrer($_SESSION['adherent_identifiant'],array($liste->occurrence[$i]['identifiant']));
		}
		
		if($i==0 && $_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-01" title="Location '.ma_htmlentities($ville->nom).'"></div>');
		if($i<5  && $_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-02"></div>');
		if($i<15 && $_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-03"></div>');
		if(         $_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-04"></div>');
		if($i<0  && $_SESSION['annonce_page']==2) print('<div class="adsearch" id="adsearch-05" title="Location '.ma_htmlentities($type[0]->designation).'"></div>');
		if($i<5  && $_SESSION['annonce_page']==2) print('<div class="adsearch" id="adsearch-06"></div>');
		if($i<15 && $_SESSION['annonce_page']==2) print('<div class="adsearch" id="adsearch-07"></div>');
		if(         $_SESSION['annonce_page']==2) print('<div class="adsearch" id="adsearch-08"></div>');
		
	  	if($liste->page_courante<$liste->page_total)
			print('<a class="resultat" href="?annonce_page='.$liste->page_suivante.'">Afficher les '.$_SESSION['annonce_nombre'].' r&eacute;sultats suivants</a>');
		
		print('</div>');
	}
	else
	{
		print('<div class="aucun">');
		if($_SESSION['annonce_ville'] || $_SESSION['annonce_statut'])
			print
			('
				<h3>Vos crit&egrave;res de recherche ne peuvent aboutir.</h3>
				<p>Nous vous recommandons d\'utiliser moins de filtres afin d\'&eacute;largir votre recherche.</p>
			');
		else
			print
			('
				<h3>Vos crit&egrave;res de recherche ne peuvent aboutir. </h3>
				<p>Nous vous recommandons d\'&eacute;largir votre recherche &agrave; d\'autres habitations ou &agrave; un secteur avoisinant.</p>
			');
		print('</div>');
		
		print('<div class="adsearch" id="adsearch-09" title="Location '.ma_htmlentities($ville->nom).'"></div>');
		print('<div class="adsearch" id="adsearch-10" title="Location '.ma_htmlentities($type[0]->designation).'"></div>');
	}
?>
    <div class="footer">
      <?php include_once(__DIR__.'/inc/style2.footer.php');?>
    </div>
  </div>
  <div class="clear"></div>
</div>
</body>
</html>
