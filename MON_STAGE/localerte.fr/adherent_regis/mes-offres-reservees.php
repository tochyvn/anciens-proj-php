<?php
	if($paiement!='/mes-offres-reservees.php')
	{
		require_once(__DIR__.$paiement);
		die();
	}
	
	$tarif_possible=array('or0001','or0002','or0003','or0004','ab0023');
	$tarif_defaut='';
	
	require_once(__DIR__.'/inc/mes-paiements.php');
?>
<!DOCTYPE HTML>
<html lang="<?php print(LANGUAGE);?>">
<head>
<?php $head_title='Mes ventes flash - Localerte.fr'; include_once(__DIR__.'/inc/head.php');?>
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
      <h3>Consultation pendant 24H:</h3>
      <p>Vous acc&eacute;dez librement &agrave; toutes les annonces relev&eacute;es par Localerte durant 24H. Votre session se cl&ocirc;ture automatiquement au-del&agrave; de cette p&eacute;riode.</p>
      <h3>Consultation par abonnements :</h3>
      <p>Apr&egrave;s avoir souscrit un abonnement, vous acc&eacute;dez  librement &agrave; toutes les annonces  relev&eacute;es par Localerte le  temps de votre abonnement. Le d&eacute;compte du  nombre de jours est actif depuis la premi&egrave;re visite sur le site et jusqu'&agrave;  &eacute;puisement de la dur&eacute;e.</p>
    </div>
    <div class="nb-selection">
      <h3>Votre s&eacute;lection :</h3>
      <p>
        <?php $total=sizeof($_SESSION['annonce_identifiant']); print($total.' annonce'.($total>1?'s':''));?>
      </p>
    </div>
  </div>
  <div class="section mes-paiements mes-offres-reservees">
    <div class="offre-reservee-01">
      <p><strong>OFFRE SPECIALE</strong> &agrave; <?php print($adherent->email);?></p>
      <p>Plus que <span class="timer-bis"><?php print(date('r',$minuteur));?></span> pour en profiter</p>
    </div>
    <h3><strong>Acc&egrave;s &agrave; toutes les annonces par abonnement, 24H/24 :</strong></h3>
    <hr class="orange">
    <div class="etiquette paybox<?php if($selected) print($selected=='paybox-7euros'?' selected':' unselected');?>">
      <h4>Carte bancaire</h4>
      <p class="accroche">Plate-forme s&eacute;curis&eacute;e Paybox</p>
      <p class="tarif long"><span>&agrave; partir de 5&euro;</span></p>
      <p class="montant"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=or0001&amp;paiement_mode=CB&amp;annonce_submit=Valider"><strong>7 jours</strong> <em>5 &euro; <del>7 &euro;</del></em></a></p>
      <p class="montant"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=or0002&amp;paiement_mode=CB&amp;annonce_submit=Valider"><strong>14 jours</strong> <em>10 &euro; <del>13 &euro;</del></em></a></p>
      <p class="montant"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=or0003&amp;paiement_mode=CB&amp;annonce_submit=Valider"><strong>21 jours</strong> <em>13 &euro; <del>18 &euro;</del></em></a></p>
      <p class="montant"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=or0004&amp;paiement_mode=CB&amp;annonce_submit=Valider"><strong>28 jours</strong> <em>17 &euro; <del>24 &euro;</del></em></a></p>
      <div class="clear"></div>
    </div>
    <div class="etiquette wha<?php if($selected) print($selected=='wha-7euros'?' selected':' unselected');?>">
      <h4>Internet+</h4>
      <p class="accroche">R&eacute;glez avec votre facture Internet</p>
      <p class="tarif long"><span>&agrave; partir de 5&euro;</span></p>
      <p class="montant"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=or0001&amp;paiement_mode=WHA&amp;annonce_submit=Valider"><strong>7 jours</strong> <em>5 &euro; <del>7 &euro;</del></em></a></p>
      <p class="montant"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=or0002&amp;paiement_mode=WHA&amp;annonce_submit=Valider"><strong>14 jours</strong> <em>10 &euro; <del>13 &euro;</del></em></a></p>
      <p class="montant"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=or0003&amp;paiement_mode=WHA&amp;annonce_submit=Valider"><strong>21 jours</strong> <em>13 &euro; <del>18 &euro;</del></em></a></p>
      <p class="montant"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=or0004&amp;paiement_mode=WHA&amp;annonce_submit=Valider"><strong>28 jours</strong> <em>17 &euro; <del>24 &euro;</del></em></a></p>
      <div class="clear"></div>
    </div>
    <h3><strong>Acc&egrave;s &agrave; toutes les annonces pendant 24H :</strong></h3>
    <hr class="orange">
    <div class="etiquette paybox<?php if($selected) print($selected=='paybox-2euros'?' selected':' unselected');?>">
      <h4>Carte bancaire</h4>
      <p class="accroche">Plate-forme s&eacute;curis&eacute;e Paybox</p>
      <p class="tarif"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=ab0023&amp;paiement_mode=CB&amp;annonce_submit=Valider">3&euro;</a></p>
    </div>
    <div class="etiquette wha<?php if($selected) print($selected=='wha-2euros'?' selected':' unselected');?>">
      <h4>Internet+</h4>
      <p class="accroche">R&eacute;glez avec votre facture Internet</p>
      <p class="tarif"><a href="mes-offres-reservees.php?tarif_abonnement_identifiant=ab0023&amp;paiement_mode=WHA&amp;annonce_submit=Valider">3&euro;</a></p>
    </div>
    <div class="etiquette allopass<?php if($selected) print($selected=='allopass'?' selected':' unselected');?>">
      <h4>SMS, Audiotel</h4>
      <p class="accroche">Service factur&eacute; au num&eacute;ro appelant</p>
      <p class="tarif"><span>3&euro;</span></p>
      <p class="sms">Envoyez le mot <strong><em>CODE</em></strong> au 81 083*</p>
      <p class="audiotel">Appelez le 08 99 23 02 52*</p>
      <div class="clear"></div>
      <form action="mes-offres-reservees.php" method="get">
        <?php
	  		if(isset($_REQUEST['code_submit']) && $_REQUEST['code_submit']=='Valider')
				print
				('
					<ul class="erreur">
			        <li><strong>Code mal saisi ou d&eacute;j&agrave; utilis&eacute; (1 code de 8 caractères valable 24 heures).</strong> Votre code vous sera communiqu&eacute; soit par SMS si vous envoyez le mot «CODE» par SMS au 81 083*, soit par messagerie vocale si vous choisissez d\'appeler le 08 99 23 02 52*.</li>
					</ul>
				');
		?>
        <p class="champ">
          <input type="text" name="code_reference" value="<?php if(isset($_SESSION['code_2']) && $_SESSION['code_2']!='message') print($_SESSION['code_2']);?>" placeholder="Saisissez le code d&eacute;livr&eacute; ici" class="inputreset" autocomplete="off"<?php if($selected=='allopass') print(' autofocus');?>>
        </p>
        <p class="action">
          <button class="bouton" type="submit" name="code_submit" value="Valider">Valider</button>
        </p>
        <div class="clear"></div>
      </form>
      <p class="cout"><small>*SMS au 81 083 au tarif de 3,00&euro; + prix du SMS,
        Appel au 08 99 23 02 52 au tarif de 1,80&euro; hors surco&ucirc;t &eacute;ventuel des op&eacute;rateurs</small></p>
    </div>
    <div>
      <p class="retour"><a class="bouton" href="ma-liste.php">Retour &agrave; votre s&eacute;lection</a></p>
    </div>
    <h3><strong>Vous disposez d'un Code offert ? saisissez-le ici :</strong></h3>
    <hr class="orange">
    <div class="etiquette offert<?php if($selected) print($selected=='offert'?' selected':' unselected');?>">
      <h4>Code offert</h4>
      <p class="accroche">Nous vous avons offert un code d'acc&egrave;s</p>
      <p>&nbsp;</p>
      <form action="mes-offres-reservees.php" method="get">
        <?php
	  		if(isset($_REQUEST['code_submit']) && $_REQUEST['code_submit']=='Valider2')
				print
				('
					<ul class="erreur">
			        <li><strong>Code mal saisi ou d&eacute;j&agrave; utilis&eacute; (1 code de 8 caractères valable 24 heures).</strong></li>
					</ul>
				');
		?>
        <p class="champ">
          <input type="text" name="code_reference" value="" placeholder="Saisissez le code offert ici" class="inputreset" autocomplete="off"<?php if($selected=='offert') print(' autofocus')?>>
        </p>
        <p class="action">
          <button class="bouton" type="submit" name="code_submit" value="Valider2">Valider</button>
        </p>
        <div class="clear"></div>
      </form>
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
