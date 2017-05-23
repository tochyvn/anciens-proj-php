<?php
	require_once(PWD_INCLUSION.'liste.php');
	$liste=new ld_liste('select round(count(identifiant)*1.1) as nombre from liste');
?>

<p><a href="./" title="Retour &agrave; page d'accueil"><img src="<?php print(HTTP_STATIC.'/img/logo1.png');?>" alt="<?php print(ma_htmlentities($head_title));?>" width="252" height="97"></a></p>
<p>Moteur de recherche sp&eacute;cialis&eacute; en locations        immobili&egrave;res &agrave; l'ann&eacute;e, qui r&eacute;unit les annonces web &amp; papier        de plusieurs dizaines d'annonceurs.</p>
<h1>Aujourd&rsquo;hui, <strong><?php print(number_format($liste->occurrence[0]['nombre'], 0, '.', ' '));?> annonces</strong> <em>de moins de 4 jours vous  attendent</em></h1>
<div class="clear"></div>