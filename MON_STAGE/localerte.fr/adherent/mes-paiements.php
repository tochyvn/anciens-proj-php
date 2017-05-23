<?php

	if($paiement!='/mes-paiements.php')
	{
		require_once(__DIR__.$paiement);

		die();
	}

	if(isset($_REQUEST['paiement_mode_paybox_x'])) $_REQUEST['paiement_mode']='CB';
	if(isset($_REQUEST['paiement_mode_paypal_x'])) $_REQUEST['paiement_mode']='PAYPAL';
	if(isset($_REQUEST['paiement_mode_wha_x'])) $_REQUEST['paiement_mode']='WHA';
	if(isset($_REQUEST['paiement_mode2_paybox_x'])) $_REQUEST['paiement_mode2']='CB';
	if(isset($_REQUEST['paiement_mode2_paypal_x'])) $_REQUEST['paiement_mode2']='PAYPAL';
	if(isset($_REQUEST['paiement_mode2_wha_x'])) $_REQUEST['paiement_mode2']='WHA';
	
	if(isset($_REQUEST['paiement_mode_paybox'])) $_REQUEST['paiement_mode']='CB';
	if(isset($_REQUEST['paiement_mode_paypal'])) $_REQUEST['paiement_mode']='PAYPAL';
	if(isset($_REQUEST['paiement_mode_wha'])) $_REQUEST['paiement_mode']='WHA';
	if(isset($_REQUEST['paiement_mode2_paybox'])) $_REQUEST['paiement_mode2']='CB';
	if(isset($_REQUEST['paiement_mode2_paypal'])) $_REQUEST['paiement_mode2']='PAYPAL';
	if(isset($_REQUEST['paiement_mode2_wha'])) $_REQUEST['paiement_mode2']='WHA';
	
	if(isset($_REQUEST['annonce_submit2'])){
		$_REQUEST['tarif_abonnement_identifiant']=$_REQUEST['tarif_abonnement_identifiant2'];
		$_REQUEST['paiement_mode']=$_REQUEST['paiement_mode2'];
		$_REQUEST['annonce_submit']=$_REQUEST['annonce_submit2'];
	}
	
	$tarif_possible=array('ab0030','ab0031','ab0014','ab0017','ab0015','ab0029');
	$tarif_defaut='ab0017';
	require_once(__DIR__.'/inc/mes-paiements.php');
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Mes paiements - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
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
  <div class="section mes-paiements">
    <h2>Acc&egrave;s 24H/24, &agrave; toutes les annonces d&eacute;taill&eacute;es</h2>
    <h3>Pour <span class="orange">visualiser toutes les annonces</span> d&eacute;taill&eacute;es,<br>
      vous avez besoin d'un code que vous pouvez obtenir par téléphone ou SMS.<br>
      Vous pourrez alors naviguer <span class="orange">librement</span> et <span class="orange">imm&eacute;diatement</span> entre la liste et le détail des annonces.</h3>
    <form action="mes-paiements.php" method="get" class="code">
      <?php
  	if(isset($_REQUEST['code_submit']) && $_REQUEST['code_submit']=='Valider'){
		if(!strlen($_REQUEST['code_reference'])) $message='Le code ne peut pas être vide.
			Pour obtenir un code par téléphone, appelez le 08 99 23 01 23*.';
		elseif(preg_match('/LOC|81 +083|08 +99 +23 +01 +23/i',$_REQUEST['code_reference'])) $message='Le code ne peut pas être 81 083 ou LOC ou 08 99 23 01 23.
			Pour obtenir un code par téléphone, appelez le 08 99 23 01 23*.';
		elseif($_REQUEST['code_reference']==$adherent->passe) $message='Le code ne peut pas être votre mot de passe de connexion.
			Pour obtenir un code par téléphone, appelez le 08 99 23 01 23*.';
		elseif(strlen($_REQUEST['code_reference'])!=8) $message='Le code est erroné car il doit être de 8 caractères.
			Pour obtenir un code par téléphone, appelez le 08 99 23 01 23*.';
		elseif(isset($code_doublon) && $code_doublon) $message='Le code est périmé (1 code = 24 heures).
			Pour obtenir un code par téléphone, appelez le 08 99 23 01 23*.';
		else $message='Le code n\'existe pas.
			Pour obtenir un code par téléphone, appelez le 08 99 23 01 23*.';
		print
		('
			<ul class="erreur">
			<li style="color:#FF0000"><strong style="color:#FF0000">'.nl2br(ma_htmlentities($message)).'</strong></li>
			</ul>
		');
		//print
		//('
		//	<ul class="erreur">
		//	<li><strong>Code mal saisi ou d&eacute;j&agrave; utilis&eacute;.
		//	Votre code doit &ecirc;tre de 8 caract&egrave;res.</strong>
		//	Votre code vous sera communiqu&eacute; soit par SMS si, depuis votre t&eacute;l&eacute;phone portable, vous envoyez le mot «LOC» par SMS au 81 083*, soit vocalement si vous t&eacute;l&eacute;phonez au 08 99 23 01 23*. Votre code est valable 24 heures.</li>
		//	</ul>
		//');
	}
?>
      <p class="image"><img src="<?php print(HTTP_STATIC.'/img/sms.png');?>" width="248" height="28" alt="Envoyez LOC par SMS au 81 083*"> Ou, <img src="<?php print(HTTP_STATIC.'/img/audiotel.2.png');?>" width="230" height="28" alt="Appelez le 08 99 23 01 23*"></p>
      <div class="ddd">
        <p class="label">Saisissez ici le code obtenu</p>
        <p class="champ">
          <input type="text" name="code_reference" value="<?php if(isset($_SESSION['code_2']) && $_SESSION['code_2']!='message') print($_SESSION['code_2']);?>" class="inputreset" autofocus>
        </p>
        <p class="action">
          <button class="bouton" type="submit" name="code_submit" value="Valider">Valider</button>
        </p>
      </div>
      <div class="clear"></div>
    </form>
    <hr class="orange">
    <h3>Acc&egrave;s imm&eacute;diat pour 48H en utilisant votre abonnement t&eacute;l&eacute;phonique** :</h3>
    <form action="https://mps.w-ha.com/app-mps/purchase" method="get" class="internetplus">
      <p class="image">
        <input type="image" width="577" height="36" src="<?php print(HTTP_STATIC.'/img/internetplus.v3.png');?>" alt="R&eacute;glez avec votre facture Internet">
      </p>
      <p class="cache">
        <input type="hidden" name="mctId" value="5216">
        <input type="hidden" name="pid" value="LA002">
        <input type="hidden" name="fid" value="1">
        <input type="hidden" name="mp_wha_desc2" value="current">
        <input type="hidden" name="mp_securite" value="<?php print($_SESSION['wha_securite']);?>">
        <input type="hidden" name="mp_adherent_identifiant" value="<?php print($_SESSION['adherent_identifiant']);?>">
        <input type="hidden" name="mp_r" value="<?php print(HTTP_ADHERENT.'/mes-paiements.php');?>">
        <input type="hidden" name="mp_acte" value="LA002">
      </p>
    </form>
    <hr class="orange">
    <h3>Abonnements longue dur&eacute;e</h3>
    <form action="mes-paiements.php" method="get" class="abonnement">
      <input type="hidden" name="annonce_submit" value="Valider">
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
        <label><strong>14 jours</strong> <em>13 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant" value="ab0014"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && $_REQUEST['tarif_abonnement_identifiant']=='ab0014') print(' checked="checked"');?>>
        </label>
        <label><strong>21 jours</strong> <em>18 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant" value="ab0017"<?php if(!isset($_REQUEST['tarif_abonnement_identifiant']) || array_search($_REQUEST['tarif_abonnement_identifiant'],array('ab0014','ab0029','ab0015'))===false) print(' checked="checked"');?>>
        </label>
        <label><strong>28 jours</strong> <em>24 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant" value="ab0015"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && $_REQUEST['tarif_abonnement_identifiant']=='ab0015') print(' checked="checked"');?>>
        </label>
        <label><strong>60 jours</strong> <em>40 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant" value="ab0029"<?php  if(isset($_REQUEST['tarif_abonnement_identifiant']) && $_REQUEST['tarif_abonnement_identifiant']=='ab0029') print(' checked="checked"');?>>
        </label>
      </p>
      <p class="mode">
        <label><input type="image" src="<?php print(HTTP_STATIC.'/img/paybox.png');?>" name="paiement_mode_paybox" alt="Payez par carte bleue" width="200" height="25"></label>
        <label><input type="image" src="<?php print(HTTP_STATIC.'/img/paypal.png');?>" name="paiement_mode_paypal" alt="Payez par paypal" width="200" height="25"></label>
        <label><input type="image" src="<?php print(HTTP_STATIC.'/img/wha.png');?>" name="paiement_mode_wha" alt="Payez par votre fournisseur Internt (Orange, SFR, Free, Bouygues, Alice)" width="200" height="60"></label>
      </p>
      <p class="action">
        <input type="hidden" name="annonce_submit" value="Valider">
      </p>
      <div class="clear"></div>
    </form>
    <hr class="orange">
    <h3>Micro abonnements</h3>
    <form action="mes-paiements.php" method="get" class="abonnement">
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
        <label><strong>5 jours</strong> <em>7 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant2" value="ab0030"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && $_REQUEST['tarif_abonnement_identifiant']=='ab0030') print(' checked="checked"');?>>
        </label>
        <label><strong>10 jours</strong> <em>10 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant2" value="ab0031"<?php if(!isset($_REQUEST['tarif_abonnement_identifiant']) || array_search($_REQUEST['tarif_abonnement_identifiant'],array('ab0030'))===false) print(' checked="checked"');?>>
        </label>
      </p>
      <p class="mode">
        <label><input type="image" src="<?php print(HTTP_STATIC.'/img/paybox.png');?>" name="paiement_mode2_paybox" alt="Payez par carte bleue" width="200" height="25"></label>
        <label><input type="image" src="<?php print(HTTP_STATIC.'/img/paypal.png');?>" name="paiement_mode2_paypal" alt="Payez par paypal" width="200" height="25"></label>
        <label><input type="image" src="<?php print(HTTP_STATIC.'/img/wha.png');?>" name="paiement_mode2_wha" alt="Payez par votre fournisseur Internt (Orange, SFR, Free, Bouygues, Alice)" width="200" height="60"></label>
      </p>
      <p class="action">
        <input type="hidden" name="annonce_submit2" value="Valider">
      </p>
      <div class="clear"></div>
    </form>
    <p class="tarif"><small>*LOC par SMS au 81 083 au tarif de  3&euro; + prix du SMS,
      Appel au 08 99 23 01 23 au tarif  de 1,46&euro; hors surco&ucirc;t &eacute;ventuel des op&eacute;rateurs</small></p>
    <p class="tarif"><small>**Montant de 3&euro; d&eacute;bit&eacute; sur votre prochaine facture</small></p>
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
