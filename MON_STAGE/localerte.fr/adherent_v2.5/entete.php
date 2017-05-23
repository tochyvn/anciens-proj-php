<?php
	$query=array();
	$query[]=rand(100000,999999);
	if(defined('ALERTE_CARDINALITE'))
		$query[]='ALERTE_CARDINALITE='.urlencode(ALERTE_CARDINALITE);
	if(defined('ALERTE_ALERTE_TYPE_MAX'))
		$query[]='ALERTE_ALERTE_TYPE_MAX='.urlencode(ALERTE_ALERTE_TYPE_MAX);
	if(defined('ADSENSE_LIMITE'))
		$query[]='ADSENSE_LIMITE='.urlencode(ADSENSE_LIMITE);
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="description" content="Moteur de recherche sp&eacute;cialis&eacute; en locations immobili&egrave;res &agrave; l'ann&eacute;e. Retrouvez chaque jour pr&egrave;s de 50.000 annonces de moins de 4 jours vues sur le Web et dans la Presse." />
<title>Localerte - On cherche pour vous</title>
<link rel="SHORTCUT ICON" href="<?php print(URL_INCLUSION);?>favicon.ico" />
<link rel="stylesheet" href="<?php print(URL_ADHERENT);?>general2.css" type="text/css" />
<script src="<?php print(URL_INCLUSION);?>general.js" type="text/javascript"></script>
<script src="<?php print(URL_ADHERENT);?>general.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script src="<?php print(URL_ADHERENT);?>/jquery.msgBox.js" type="text/javascript"></script>
<script src="<?php print(URL_ADHERENT);?>localisation3.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
	AjouterEvenement(window,'load',function(e){
		/*LocalisationCharger();*/
		js_label();
		js_blank();
		js_submit();
		js_autocomplete();
	},false);
	
//-->
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-382336-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>