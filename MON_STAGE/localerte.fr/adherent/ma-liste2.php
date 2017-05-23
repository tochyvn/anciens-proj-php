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
					print('
<!DOCTYPE HTML>
<html lang="'.LANGUAGE.'">
<head>
					');
					$head_title='Ma liste - Localerte.fr'; include_once(__DIR__.'/inc/head.php');
					print('
<meta http-equiv="refresh" content="0; url='.URL_ADHERENT.'/mes-paiements.php">
</head>
<body>
<p style="text-align:center"><a href="'.URL_ADHERENT.'/mes-paiements.php">Si rien ne se passe, cliquez ici</a></p>
</body>
					');
					die();
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
<?php $head_title='Ma liste - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
</head>
<body>
<?php if(0 && !isset($_SESSION['defilement']) && (!isset($_REQUEST['msgbox']) || $_REQUEST['msgbox']!='desabonnement')){?>
<script type="text/javascript">
<!--
	document.body.style.overflow='hidden';
	document.write('<div id="defilement" style="position:absolute; z-index:100000; width:100%; height:100000px; background-color:#ffffff; text-align:center;">\
	<img src="http://static.localerte.fr/adherent/img/logo3.png" width="250" height="80" alt="Localerte" style="margin-top:30px;">\
	<p style="font-weight:bold; font-size:2em; color:#1c5290; display:block; width:520px; margin:auto; text-align:left;">&nbsp;</p>\
	<img src="http://static.localerte.fr/adherent/img/attente.gif" width="80" height="80" alt="Chargement" style="margin-top:30px;">\
	<p style="margin-top:100px;"><a href="ma-liste.php" style="color:#999999;">Si rien ne se passe, cliquez ici</a></p>\
	</div>');
	
	var defil_d=1000;
	var defil_t=Array('recherche sur : Internet g&eacute;n&eacute;raliste',
		'recherche sur : Web sp&eacute;cialis&eacute;',
		'recherche sur : Presse r&eacute;gionale',
		'recherche sur : Quotidiens nationaux',
		'recherche sur : Journaux gratuits',
		'<span style="display:block; text-align:center;"><?php print(number_format($liste->total,0,'.',' ').' annonce'.($liste->total>1?'s':'').' trouv&eacute;e'.($liste->total>1?'s':''));?></span>');
	var defil_p=0;
	var defil_c=document.getElementById('defilement').getElementsByTagName('p')[0];
	var defil_i=setInterval(function(){
		if(defil_p<defil_t.length){
			defil_c.innerHTML=defil_t[defil_p];
			defil_p++;
		}
		else{
			document.getElementById('defilement').style.display='none';
			document.body.style.overflow='visible';
		}
	},defil_d);
	window.scrollTo(0,0);
//-->
</script>
<?php
		$_SESSION['defilement']='1';
	}
?>
<div class="style2">
  <div class="header">
    <?php include_once(__DIR__.'/inc/style2.header.php');?>
  </div>
  <div class="gauche">
    <?php include_once(__DIR__.'/inc/logo.php');?>
    <?php include_once(__DIR__.'/inc/mes-alertes.php');?>
  </div>
  <div class="section">
    <form action="ma-liste.php" method="get" class="ma-liste">
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
      <?php
      	print('<h2><em>Localerte a trouv&eacute;
			'.number_format($liste->total,0,'.',' ').' annonce'.($liste->total>1?'s':'').' de moins de 10 jours
			correspondant &agrave; votre recherche</em></h2>');
	  ?>
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
		print
		('
			<div class="nom-colonne">
			  <div class="colonne1">&nbsp;</div>
			  <div class="colonne2">
			    Commune
			    <sup><a href="?annonce_tri=distance&amp;annonce_ordre=asc">&darr;</a></sup>
			    <sup><a href="?annonce_tri=distance&amp;annonce_ordre=desc">&uarr;</a></sup>
			  </div>
			  <div class="colonne3">
			    Type
			    <sup><a href="?annonce_tri=type&amp;annonce_ordre=asc">&darr;</a></sup>
			    <sup><a href="?annonce_tri=type&amp;annonce_ordre=desc">&uarr;</a></sup>
			  </div>
			  <div class="colonne4">
			    Loyer
			    <sup><a href="?annonce_tri=loyer&amp;annonce_ordre=asc">&darr;</a></sup>
			    <sup><a href="?annonce_tri=loyer&amp;annonce_ordre=desc">&uarr;</a></sup>
			  </div>
			  <div class="colonne6">
			    &nbsp;
			    <sup><a href="?annonce_tri=enregistrement&amp;annonce_ordre=desc">&darr;</a></sup>
			    <sup><a href="?annonce_tri=enregistrement&amp;annonce_ordre=asc">&uarr;</a></sup>
			  </div>
			  <div class="colonne5">
			    Date
			    <sup><a href="?annonce_tri=parution&amp;annonce_ordre=asc">&darr;</a></sup>
			    <sup><a href="?annonce_tri=parution&amp;annonce_ordre=desc">&uarr;</a></sup>
			  </div>
			  <div class="colonne7">&nbsp;</div>
			  <div class="clear"></div>
			</div>
		');
      	print('<div id="resultat">');
		
		for($i=0;$i<sizeof($liste->occurrence);$i++)
		{
			$annonce_moins_6h = time()-$liste->occurrence[$i]['enregistrement']<(3600*6);
			$annonce_moins_16h = time()-$liste->occurrence[$i]['enregistrement']<(3600*12) && time()-$liste->occurrence[$i]['enregistrement']>=(3600*4) ;
			
			/*if( $i == (int)(sizeof( $liste->occurrence)/3)  ) {
				echo '<div id="adcontainer2"></div>';
				print
				('
					<p class="action">
					<span>Cochez les annonces &agrave; d&eacute;couvrir, puis </span>
					<button class="bouton" type="submit" name="annonce_submit" value="Go">Cliquez ici</button>
					</p>
				');
			}
			if( $i == (int)(sizeof( $liste->occurrence)/2) ) {
				echo '<div id="adcontainer3"></div>';
				print
				('
					<p class="action">
					<span>Cochez les annonces &agrave; d&eacute;couvrir, puis </span>
					<button class="bouton" type="submit" name="annonce_submit" value="Go">Cliquez ici</button>
					</p>
				');
			}*/
			print
			('
				<div class="pre-annonce'.($liste->occurrence[$i]['adherent_annonce']?' deja-lu':'').'" id="annonce_'.$liste->occurrence[$i]['identifiant'].'">
				  <div class="colonne1">
					<label><input type="checkbox" name="annonce_identifiant[]" value="'.$liste->occurrence[$i]['identifiant'].'"'.(isset($_SESSION['annonce_identifiant']) && array_search($liste->occurrence[$i]['identifiant'],$_SESSION['annonce_identifiant'])!==false?' checked="checked"':'').'></label>
				  </div>
				  <div class="colonne2">
					<p><strong>'.ma_htmlentities(ucwords(strtoupper($liste->occurrence[$i]['ville']))).'</strong></p>
				  </div>
				  <div class="colonne3">
					<p><strong>'.ma_htmlentities($liste->occurrence[$i]['type']).'</strong></p>
				  </div>
  				  <div class="colonne4">
					<p>'.ma_htmlentities($liste->occurrence[$i]['loyer']?round($liste->occurrence[$i]['loyer'],0):'- ').'&euro;</p>
				  </div>
				  <div class="colonne6">
					<p>'.($annonce_moins_16h?'- 12H':($annonce_moins_6h?'- 6H':'&nbsp;')).'</p>
				  </div>
				  <div class="colonne5">
					<p>'.ma_htmlentities(strftime('%d/%m/%y',$liste->occurrence[$i]['parution'])).'</p>
				  </div>
  				  <div class="colonne7">
					<p>'.($liste->occurrence[$i]['adherent_annonce']?'Vu':'&nbsp;').'</p>
				  </div>
				  <div class="clear"></div>
				</div>
			');
		}
		echo '<div id="adcontainer4"></div>';
		if($liste->page_courante<$liste->page_total)
			print('<a class="resultat" href="?annonce_page='.$liste->page_suivante.'">Afficher les r&eacute;sultats suivants</a>');
			// '.$_SESSION['annonce_nombre'].' pour afficher nombre total d'annonce.
	    
		print('</div>');
		
		print
		('
	  	  	<p class="action">
        	<span>Cochez les annonces &agrave; d&eacute;couvrir, puis </span>
	        <button class="bouton" type="submit" name="annonce_submit" value="Go">Cliquez ici</button>
    	  	</p>
		');
		if ( $liste->total < 20 )
			echo '<div id="adcontainer1"></div>';
			echo '<div id="adcontainer2"></div>';
			echo '<div id="adcontainer3"></div>';
			echo '<div id="adcontainer4"></div>';
		
		print('
			<!--script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Localerte bas adaptable -->
			<ins class="adsbygoogle"
				style="display:block"
				 data-ad-client="ca-pub-9592588828246820"
				 data-ad-slot="2998570892"
				 data-ad-format="auto"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script-->
		');
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
<!--script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script-->
<?php $adsense_type = explode(',',$mesalertes_liste->occurrence[0]['type']); ?>
<script type="text/javascript"> 
	var query = '<?php echo "Location ".$adsense_type[0].' '.$mesalertes_liste->occurrence[0]['ville'] ?>';
	var pageOptions = { 
	  'pubId': 'pub-9592588828246820',
	  'query': query,
	  'hl': 'fr',
	  'channel': '0901693454', 
	  'linkTarget': '_blank'
	};

	var adblock1 = { 
	  'container': 'adcontainer1',
	  'maxTop': 2,
	  'fontFamily': 'trebuchet ms',
	  'fontSizeTitle': 16,
	  'colorTitleLink': '#2A6496',
	  'colorText': '#333333',
	  'colorDomainLink': '#2A6496',
	  'noTitleUnderline': true
	};

	var adblock2 = { 
	  'container': 'adcontainer2',
	  'maxTop': 0,
	  'fontFamily': 'trebuchet ms',
	  'fontSizeTitle': 16,
	  'colorTitleLink': '#2A6496',
	  'colorText': '#333333',
	  'colorDomainLink': '#2A6496',
	  'noTitleUnderline': true
	};

	var adblock3 = { 
	  'container': 'adcontainer3',
	  'maxTop': 0,
	  'fontFamily': 'trebuchet ms',
	  'fontSizeTitle': 16,
	  'colorTitleLink': '#2A6496',
	  'colorText': '#333333',
	  'colorDomainLink': '#2A6496',
	  'noTitleUnderline': true
	};

	var adblock4 = { 
	  'container': 'adcontainer4',
	  'maxTop': 0,
	  'fontFamily': 'trebuchet ms',
	  'fontSizeTitle': 16,
	  'colorTitleLink': '#2A6496',
	  'colorText': '#333333',
	  'colorDomainLink': '#2A6496',
	  'noTitleUnderline': true
	};

	//_googCsa('ads', pageOptions, adblock1, adblock2, adblock3, adblock4);
</script>
