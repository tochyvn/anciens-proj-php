<?php
	if($paiement!='/mes-paiements.php')
	{
		require_once(__DIR__.$paiement);
		die();
	}
	
	$tarif_possible=array('ab0013','ab0014','ab0017','ab0015');
	$tarif_defaut='ab0015';
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
    <div class="info">
      <h3>Consultation &agrave; la session :</h3>
      <p>Apr&egrave;s avoir re&ccedil;u (par SMS ou t&eacute;l&eacute;phone) et entr&eacute; votre code de session, vous acc&eacute;dez librement aux annonces relev&eacute;es par Localerte. Votre session se termine si vous quittez le site ou en cas d'inactivit&eacute; prolong&eacute;e.</p>
      <h3>Consultation par abonnements :</h3>
      <p>Apr&egrave;s avoir souscrit un abonnement, vous acc&eacute;dez librement aux annonces relev&eacute;es par Localerte. Le d&eacute;compte du nombre de jours est actif depuis la premi&egrave;re visite sur le site et jusqu'&agrave; &eacute;puisement de la dur&eacute;e.</p>
    </div>
  </div>
  <div class="section mes-paiements">
    <div>
      <p class="retour"><a class="bouton" href="ma-liste.php">Retour &agrave; votre s&eacute;lection</a></p>
    </div>
    <h3><strong>Pour visualiser toutes les annonces le temps de votre session,</strong> vous avez besoin d'un code que vous pouvez obtenir par SMS ou par t&eacute;l&eacute;phone* : </h3>
    <form action="mes-paiements.php" method="get" class="code">
      <?php
  	if(isset($_REQUEST['code_submit']) && $_REQUEST['code_submit']=='Valider')
		print
		('
			<ul class="erreur">
			<li><strong>Code invalide.</strong> Votre code vous sera communiqu&eacute; soit par SMS si vous envoyez le mot «LOC» par SMS au 81 083, soit par messagerie vocale si vous choisissez d\'appeler le 0 899 23 08 89.</li>
			</ul>
		');
?>
      <p class="image"><img src="<?php print(HTTP_STATIC.'/img/sms.png');?>" width="248" height="28" alt="Envoyez LOC par SMS au 81 083*"> Ou, <img src="<?php print(HTTP_STATIC.'/img/audiotel.png');?>" width="248" height="28" alt="Appelez le 0 899 23 08 89*"></p>
      <div class="ddd">
        <p class="champ">
          <input type="text" name="code_reference" value="<?php if(isset($_SESSION['code_2']) && $_SESSION['code_2']!='message') print($_SESSION['code_2']);?>" class="inputreset" autocomplete="off" autofocus placeholder="Saisissez le code d&eacute;livr&eacute; ici">
        </p>
        <p class="action">
          <button class="bouton" type="submit" name="code_submit" value="Valider">Valider</button>
        </p>
      </div>
      <div class="clear"></div>
    </form>
    <hr class="orange">
    <h3><strong>Pour visualiser toutes les annonces 24H/24,</strong> vous pouvez &eacute;galement choisir un abonnement :</h3>
    <form action="mes-paiements.php" method="post" class="abonnement">
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
        <label><strong>7 jours</strong> <em>7 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant" value="ab0013"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0013')) print(' checked="checked"');?>>
        </label>
        <label><strong>14 jours</strong> <em>13 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant" value="ab0014"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0014')) print(' checked="checked"');?>>
        </label>
        <label><strong>21 jours</strong> <em>18 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant" value="ab0017"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0017')) print(' checked="checked"');?>>
        </label>
        <label><strong>28 jours</strong> <em>24 &euro;</em>
          <input type="radio" name="tarif_abonnement_identifiant" value="ab0015"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0015')) print(' checked="checked"');?>>
        </label>
      </p>
      <p class="mode">
        <label>
          <input type="radio" name="paiement_mode" value="CB"<?php if($_REQUEST['paiement_mode']=='CB') print(' checked="checked"');?>>
          <img src="<?php print(HTTP_STATIC.'/img/paybox.png');?>" alt="Payez par carte bleue" width="200" height="25"></label>
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
    <h3>Vous pouvez &eacute;galement utiliser votre abonnement t&eacute;l&eacute;phonique pour une consultation &agrave; la session** :</h3>
    <form action="https://mps.w-ha.com/app-mps/purchase" method="get" class="internetplus">
      <?php
  	if(isset($_REQUEST['acte']))
		print
		('
			<ul class="erreur">
			<li>Paiement annul&eacute;</li>
			</ul>
		');
?>
      <p class="image">
        <input type="image" width="334" height="38" src="<?php print(HTTP_STATIC.'/img/internetplus.v2.png');?>" alt="R&eacute;glez avec votre facture Internet">
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
    <h3>Si vous disposez d'un Code promo, merci de le saisir ici :</h3>
    <form action="mes-paiements.php" method="get" class="gratuit">
      <?php
  	if(isset($_REQUEST['code_submit']) && $_REQUEST['code_submit']=='Valider2')
		print
		('
			<ul class="erreur">
			<li><strong>Code invalide.</strong></li>
			</ul>
		');
?>
      <div class="ddd">
        <p class="champ">
          <input type="text" name="code_reference" value="" placeholder="Saisissez le code d&eacute;livr&eacute; ici" class="inputreset" autocomplete="off" autofocus>
        </p>
        <p class="action">
          <button class="bouton" type="submit" name="code_submit" value="Valider2">Valider</button>
        </p>
      </div>
      <div class="clear"></div>
    </form>
    <p class="tarif"><small>*LOC par SMS au 81 083 au tarif de  3&euro; + prix du SMS,
      Appel au 0899 23 08 89 au tarif  de 1,46&euro; hors surco&ucirc;t &eacute;ventuel des op&eacute;rateurs</small></p>
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
