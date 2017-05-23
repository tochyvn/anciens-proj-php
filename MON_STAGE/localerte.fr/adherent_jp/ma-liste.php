<?php
	//VERS DETAIL	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'Go':
			default:
				if(isset($_REQUEST['annonce_identifiant']))
				{
					$_SESSION['annonce_identifiant']=$_REQUEST['annonce_identifiant'];
					header('location: '.url_use_trans_sid(URL_ADHERENT.'/mes-paiements.php'));
					die();
				}
				break;
		}
	} else $_SESSION['annonce_identifiant']=array();
	
	require_once(__DIR__.'/inc/liste.php');
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<link href="http://cdn.leafletjs.com/leaflet-0.4/leaflet.css" rel="stylesheet">
<?php $head_title='Ma liste - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
<script type="text/javascript">
	var msgbox_message_special_01='<h1>Besoin d\'aide ?</h1><p class="center">Cochez les annonces de votre choix</p><p class="center">parmi la liste affich&eacute;e,</p><p class="center">puis Consultez</p>';
</script>
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
  <div class="section">
    <form action="ma-liste.php" method="post" class="ma-liste">
      <?php
        if($liste->total)
        	if($_SESSION['annonce_page']==1) print('<div class="adsearch" id="adsearch-01" title="Location '.ma_htmlentities($ville->nom).'"></div>');
      ?>
      <?php
	  	if($_SESSION['annonce_page']==1 && $paiement=='/mes-offres-reservees.php')
			print
			('
				<div class="offre-reservee-02">
				<p>'.$adherent->email.' : </p>
				<p><strong> OFFRE RESERVEE : votre 1er abonnement LOCALERTE est &agrave; prix promo</strong><br>
				<em>Plus que <span class="timer-bis">'.date('r',$minuteur).'</span> pour en profiter</em></p>
				</div>
			');
      ?>
      <?php print('<h2><em>'.number_format($liste->total).' annonce'.($liste->total>1?'s':'').' de moins de 4 jours correspondant &agrave; votre alerte</em></h2>');?>
      <?php include_once(__DIR__.'/inc/filtre.php');?>
      <?php
	if($liste->total)
	{
		print
		('
	  	  	<p class="action">
        	<span>Cochez les annonces &agrave; d&eacute;couvrir, puis </span>
	        <button class="bouton" type="submit" name="annonce_submit" value="Go">Cliquez ici</button>
    	  	</p>
		');
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
			
			if($_SESSION['annonce_tri']=='distance' && $i==0  && $_SESSION['annonce_page']==1 && !(float)$liste->occurrence[$i]['distance']) print('<div class="exact-debut"><div><img src="'.HTTP_STATIC.'/img/marker-orange.png" width=14 height="24" alt="" >Dans la localit&eacute; exacte de votre recherche</div></div>');
			
			print
			('
				<div class="pre-annonce'.($liste->occurrence[$i]['adherent_annonce']?' deja-lu':'').''.(!(float)$liste->occurrence[$i]['distance']?' exact':'').'" id="annonce_'.$liste->occurrence[$i]['identifiant'].'">
				  <div class="colonne1">
					<label><input type="checkbox" name="annonce_identifiant[]" value="'.$liste->occurrence[$i]['identifiant'].'"'.(isset($_SESSION['annonce_identifiant']) && array_search($liste->occurrence[$i]['identifiant'],$_SESSION['annonce_identifiant'])!==false?' checked="checked"':'').'></label>
				  </div>
				  <div class="colonne2">
					<p class="parution"><strong>'.ma_htmlentities(strftime('%d/%m/%Y',$liste->occurrence[$i]['parution'])).'</strong></p>
					<p class="fraicheur">'.($annonce_moins_16h?'<img src="'.HTTP_STATIC.'/img/12h.png" alt="Annonce de moins de 12h" width="74" height="20">':($annonce_moins_6h?'<img src="'.HTTP_STATIC.'/img/6h.png" alt="Annonce de moins de 6h" width="74" height="20">':'&nbsp;')).'</p>
				  </div>
				  <div class="colonne3">
					'.($liste->occurrence[$i]['image']?'<img src="'.ma_htmlentities(HTTP_STATIC.'/api/gd/'.$liste->occurrence[$i]['identifiant'].'.png').'" alt="" width="60" height="45">':'<img src="'.ma_htmlentities(HTTP_STATIC.'/img/indisponible.png').'" alt="" width="60" height="45">').'
				  </div>
				  <div class="colonne4">
					<p class="type-ville">'.(preg_match('/(T[1-9]|Studio)/i',$liste->occurrence[$i]['type'])?'Appartement ':'').ma_htmlentities($liste->occurrence[$i]['type']).' - '.ma_htmlentities(ucwords(strtoupper($liste->occurrence[$i]['ville']))).' ('.ma_htmlentities($liste->occurrence[$i]['code_postal']).')</p>
					<p class="statut">'.($liste->occurrence[$i]['statut']=='PARTICULIER'?'Annonce de <strong>Particulier</strong>':'Annonce de Professionnel').'</p>
				  </div>
  				  <div class="colonne5">
					<p class="loyer">Loyer : '.ma_htmlentities($liste->occurrence[$i]['loyer']?((int)$liste->occurrence[$i]['loyer']==(float)$liste->occurrence[$i]['loyer']?round($liste->occurrence[$i]['loyer'],0):$liste->occurrence[$i]['loyer']):'- ').'&euro;</p>
					<p class="vu">'.($liste->occurrence[$i]['adherent_annonce']?'<img src="'.HTTP_STATIC.'/img/vu_ok.png" alt="D&eacute;j&agrave; consult&eacute;e" width="100" height="19">':'<img src="'.HTTP_STATIC.'/img/vu_ko.png" alt="Pas consult&eacute;e" width="20" height="19">').'</p>
				  </div>
				  <div class="clear"></div>
				</div>
			');
			
			if($_SESSION['annonce_tri']=='distance' && !(float)$liste->occurrence[$i]['distance'] && ($i+1==sizeof($liste->occurrence) || (float)$liste->occurrence[$i+1]['distance'])) print('<div class="exact-fin"></div>');
						
			//if(($i+1)%5==0 && ($i+1)<sizeof($liste->occurrence)) print('<div class="rappel">S&eacute;lectionnez les annonces &agrave; consulter</div>');
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
    </form>
    <div class="footer">
      <?php include_once(__DIR__.'/inc/style2.footer.php');?>
    </div>
  </div>
  <div class="clear"></div>
</div>
</body>
</html>
