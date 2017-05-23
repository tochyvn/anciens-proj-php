<?php
	if($paiement!='/mes-offres-reservees.php')
	{
		require_once(__DIR__.$paiement);
		die();
	}
	
	$tarif_possible=array('or0001','or0002','or0003','or0004');
	$tarif_defaut='or0004';
	require_once(__DIR__.'/inc/mes-paiements.php');
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Mes offres réservées - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
<?php
	if(isset($_SESSION['code_2']) && $_SESSION['code_2']=='message'){
		print('
			<script type="text/javascript">
				var msgbox_message=\'<h1>Pour vous c\\\'est gratuit !</h1><p>Nous avons envoy&eacute; un Code d\\\'acc&egrave;s gratuit &agrave; votre adresse : '.$adherent->email.'</p><p><strong>Merci d\\\'en prendre connaissance et de l\\\'activer.</strong></p><p>NB. Pensez &agrave; v&eacute;rifier votre Courrier ind&eacute;sirable !</p>\';
			</script>
		');
	}
?>
</head>
<body>
<div class="style2">
  <div class="header">
    <?php include_once(__DIR__.'/inc/style4.header.php');?>
  </div>
  <div class="gauche">
    <div class="logo">
      <h1><a href="./" title="Retour &agrave; page d'accueil"><img src="<?php print(HTTP_STATIC.'/img/logo2.png');?>" alt="<?php print(ma_htmlentities($head_title));?>" width="230" height="89"></a></h1>
    </div>
  </div>
  <div class="section mes-paiements mes-offres-reservees">
    <div class="offre-reservee-01">
      <p><strong>OFFRE SPECIALE</strong> &agrave; <?php print($adherent->email);?></p>
      <p>Plus que <span class="timer-bis"><?php print(date('r',$minuteur));?></span> pour en profiter</p>
    </div>
    <h3>Pour visualiser toutes les annonces 24H/24:</h3>
    <form action="mes-offres-reservees.php" method="post" class="abonnement">
      <?php
	if(isset($_REQUEST['annonce_submit']))
	{
		print('<ul class="erreur">');
		if($_REQUEST['annonce_submit']=='CB_ANNULATION') print('<li>Paiement annul&eacute;</li>');
		if($_REQUEST['annonce_submit']=='WHA_ANNULATION') print('<li>Paiement annul&eacute;</li>');
		if($_REQUEST['annonce_submit']=='CB_REFUS') print('<li>Paiement refus&eacute;</li>');
		print('</ul>');
	}
    ?>
      <p class="montant">
        <label><strong>7 jours</strong> <em>5 &euro; <del>(7 &euro;)</del></em>
          <input type="radio" name="tarif_abonnement_identifiant" value="or0001"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='or0001')) print(' checked="checked"');?>>
        </label>
        <label><strong>14 jours</strong> <em>10 &euro; <del>(13 &euro;)</del></em>
          <input type="radio" name="tarif_abonnement_identifiant" value="or0002"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='or0002')) print(' checked="checked"');?>>
        </label>
        <label><strong>21 jours</strong> <em>13 &euro; <del>(18 &euro;)</del></em>
          <input type="radio" name="tarif_abonnement_identifiant" value="or0003"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='or0003')) print(' checked="checked"');?>>
        </label>
        <label><strong>28 jours</strong> <em>17 &euro; <del>(24 &euro;)</del></em>
          <input type="radio" name="tarif_abonnement_identifiant" value="or0004"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='or0004')) print(' checked="checked"');?>>
        </label>
      </p>
      <p class="mode">
        <label>
          <input type="radio" name="paiement_mode" value="CB"<?php if($_REQUEST['paiement_mode']=='CB') print(' checked="checked"');?>>
          <img src="<?php print(HTTP_STATIC.'/img/paybox.png');?>" alt="Payez par carte bleue" width="200" height="25"></label>
        <label>
          <input type="radio" name="paiement_mode" value="PAYPAL"<?php if($_REQUEST['paiement_mode']=='PAYPAL') print(' checked="checked"');?>>
          <img src="<?php print(HTTP_STATIC.'/img/paypal.png');?>" alt="Payez par paypal" width="200" height="25"></label>
        <label>
          <input type="radio" name="paiement_mode" value="WHA"<?php if($_REQUEST['paiement_mode']=='WHA') print(' checked="checked"');?>>
          <img src="<?php print(HTTP_STATIC.'/img/wha.png');?>" alt="Payez par votre fournisseur Internt (Orange, SFR, Free, Bouygues, Alice)" width="200" height="60"></label>
      </p>
      <p class="action">
        <button class="bouton" type="submit" name="annonce_submit" value="Valider">Valider</button>
      </p>
      <div class="clear"></div>
    </form>
    <hr class="orange">
    <h3>Pour <span class="orange">visualiser toutes les annonces</span> d&eacute;taill&eacute;es,<br>
	vous avez besoin d'un code que vous pouvez obtenir par téléphone ou SMS.<br>
	Vous pourrez alors naviguer <span class="orange">librement</span> et <span class="orange">imm&eacute;diatement</span> entre la liste et le détail des annonces.</h3>
    <form action="mes-offres-reservees.php" method="get" class="code">
      <?php
  	if(isset($_REQUEST['code_submit']) && $_REQUEST['code_submit']=='Valider')
		print
		('
			<ul class="erreur">
			<li><strong>Code mal saisi ou d&eacute;j&agrave; utilis&eacute;. Votre code doit &ecirc;tre de 8 caract&egrave;res.</strong> Votre code vous sera communiqu&eacute; soit par SMS si vous envoyez le mot «LOC» par SMS au 81 083*, soit par messagerie vocale si vous choisissez d\'appeler le 08 99 23 01 23*. Votre code est valable 24 heures.</li>
			</ul>
		');
?>
      <p class="image"><img src="<?php print(HTTP_STATIC.'/img/sms.png');?>" width="248" height="28" alt="Envoyez LOC par SMS au 81 083*"> Ou, <img src="<?php print(HTTP_STATIC.'/img/audiotel.2.png');?>" width="230" height="28" alt="Appelez le 08 99 23 01 23*"></p>
      <div class="ddd">
        <p class="label">Saisissez ici le code obtenu</p> 
        <p class="champ">
          <input type="text" name="code_reference" value="<?php if(isset($_SESSION['code_2']) && $_SESSION['code_2']!='message') print($_SESSION['code_2']);?>" class="inputreset">
        </p>
        <p class="action">
          <button class="bouton" type="submit" name="code_submit" value="Valider">Valider</button>
        </p>
      </div>
      <div class="clear"></div>
    </form>
    <h3>Vous pouvez &eacute;galement utiliser votre abonnement t&eacute;l&eacute;phonique** :</h3>
    <form action="https://mps.w-ha.com/app-mps/purchase" method="get" class="internetplus">
      <p class="image">
        <input type="image" width="577" height="36" src="<?php print(HTTP_STATIC.'/img/internetplus.v3.png');?>" alt="R&eacute;glez avec votre facture Internet">
      </p>
      <p class="cache">
        <input type="hidden" name="mctId" value="5216">
        <input type="hidden" name="pid" value="LA001">
        <input type="hidden" name="fid" value="1">
        <input type="hidden" name="mp_wha_desc2" value="current">
        <input type="hidden" name="mp_securite" value="<?php print($_SESSION['wha_securite']);?>">
        <input type="hidden" name="mp_adherent_identifiant" value="<?php print($_SESSION['adherent_identifiant']);?>">
        <input type="hidden" name="mp_r" value="<?php print(HTTP_ADHERENT.'/mes-paiements.php');?>">
        <input type="hidden" name="mp_acte" value="LA001">
      </p>
    </form>
    <p class="tarif"><small>*LOC par SMS au 81 083 au tarif de  3&euro; + prix du SMS,
      Appel au 08 99 23 01 23 au tarif  de 1,46&euro; hors surco&ucirc;t &eacute;ventuel des op&eacute;rateurs</small></p>
    <p class="tarif"><small>**Montant de 1,50&euro; d&eacute;bit&eacute; sur votre prochaine facture</small></p>
    <div class="regis-02">
      <p class="retour"><a class="bouton" href="ma-liste.php">Retour &agrave; votre s&eacute;lection</a></p>
    </div>
    <p class="image"><img src="<?php print(HTTP_STATIC.'/img/multi-ecran2.png');?>" width="190" height="50" alt=""> <img src="<?php print(HTTP_STATIC.'/img/securite.png');?>" width="190" height="45" alt=""></p>
    <div class="footer">
      <?php include_once(__DIR__.'/inc/style2.footer.php');?>
    </div>
  </div>
  <div class="clear"></div>
</div>
</body>
</html>
