<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'allopass.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'socket_http.php');
	
	if(isset($_REQUEST['code_reference']))
	{
		$allopass_access=false;
		$allopass_checkcode=false;
		
		if(!isset($_SESSION['code_reference']))
		{
			$code=new ld_code();
			if($code->identifier($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'])=='CODE_UTILISABLE')
			{
				$_SESSION['code_reference']=$_REQUEST['code_reference'];
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'CODE'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
			}
			else
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'CODE'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
		
		if(!isset($_SESSION['code_reference']))
		{
			$identifiant=array('102802','1042318','1607385');
			$socket=new ld_socket_http();
			$socket->url='http://payment.allopass.com/acte/access.apu';
			$socket->delai=30;
			$socket->methode='POST';
			$socket->corps='ids='.urlencode($identifiant[0]).'&'.'idd='.urlencode($identifiant[1]).'&data=&recall=1&code%5B%5D='.urlencode($_REQUEST['code_reference']);
			$socket->executer();
			if(isset($socket->resultat_entete['Location']) && strpos($socket->resultat_entete['Location'],'http://www.localerte.fr/adherent/message.php?message_submit=code_allopass')===false)
			{
				$_SESSION['allopass_reference']=$_REQUEST['code_reference'];
				$allopass_access=$identifiant;
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-270837'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
			}
			else
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-270837'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
				
		if(!isset($_SESSION['code_reference']))
		{
			$identifiant=array('102802','1042319','1607385');
			$socket=new ld_socket_http();
			$socket->url='http://payment.allopass.com/acte/access.apu';
			$socket->delai=30;
			$socket->methode='POST';
			$socket->corps='ids='.urlencode($identifiant[0]).'&'.'idd='.urlencode($identifiant[1]).'&data=&recall=1&code%5B%5D='.urlencode($_REQUEST['code_reference']);
			$socket->executer();
			if(isset($socket->resultat_entete['Location']) && strpos($socket->resultat_entete['Location'],'http://www.localerte.fr/adherent/message.php?message_submit=code_allopass')===false)
			{
				$_SESSION['allopass_reference']=$_REQUEST['code_reference'];
				$allopass_access=$identifiant;
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-481363'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
			}
			else
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-481363'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
		
		if($allopass_access!==false)
		{
			$resultat=explode(CRLF,trim(file_get_contents('http://payment.allopass.com/api/checkcode.apu?code='.urlencode($_REQUEST['code_reference']).'&auth='.urlencode(implode('/',$allopass_access)))));
			if($resultat[0]=='OK')
				if(preg_match('/<revers_palier>(.*)<\/revers_palier>/',file_get_contents('http://payment.allopass.com/api/infocode.apu?code='.urlencode($_REQUEST['code_reference']).'&auth='.urlencode(implode('/',$allopass_access))),$resultat))
				{
					$allopass=new ld_allopass();
					$allopass->reference='';
					$allopass->nouveau_reference=$_REQUEST['code_reference'];
					$allopass->palier=$allopass_access[1];
					$allopass->adherent=$_SESSION['adherent_identifiant'];
					$allopass->prix=floatval($resultat[1]);
					$allopass->ajouter();
					$allopass_checkcode=true;
					file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-CHECK'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
				}
			
			if(!$allopass_checkcode)
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-CHECK'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
	}
	
	if(isset($_SESSION['allopass_reference']) || isset($_SESSION['wha_identifiant']) || isset($_SESSION['code_reference']) || $abonnement['resultat']=='ABONNEMENT_UTILISABLE')
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/detail.php'));
		die();
	}
	
	$temp='FR%0899230889%1.46%EUR%%audio'.LF.'S1%81038%3.00%EUR%CODE au 81 038 - 3,00 euros par envoi prix d\'un SMS, 1 envoi de SMS par code d\'acces%sms'.LF.'S3%72720%30.00%SEK%AP till 72 720 - 30 SEK/SMS + (ev. SMS-taxa tillkommer)%sms'.LF.'S9%2098%30.00%NOK%AP till 2098 - 30 NOK pr. SMS%sms';
	//$temp=trim(file_get_contents('http://payment.allopass.com/api/getnum.apu?format=1&idd='.urlencode('270837')));
	$ligne=explode(LF,$temp);
	$plateforme=array();
	for($i=0;$i<sizeof($ligne);$i++)
	{
		$colonne=explode('%',$ligne[$i]);
		$plateforme[$colonne[0]]=$colonne;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
</head>
<body onload="document.getElementById('code_reference').focus();">
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <!--p class="orange2 moyen gras gauche decale15">Pour consulter librement les annonces et &ecirc;tre mis en relation,<br />
      choisissez votre formule :<br /><br />
    </p-->
    <p class="lien"><a class="bleu_fonce gras decale20d" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste d'annonces</a><br /><br /></p>
    <div class="tarif">
      <h4>Par t&eacute;l&eacute;phone ou SMS : naviguez librement sur le site, le temps de votre session</h4>
    <?php
  	if(isset($_REQUEST['formulaire1'])) print('<p class="orange_fonce gauche gras"><br />Code invalide.<br />
Votre code vous sera communiqu&eacute; par SMS si vous envoyez le mot « LOC » par SMS au 81 038,<br />ou par messagerie vocale si vous choisissez d\'appeler le 0 899 23 08 89.
</p>');
	?>
      <br />
      <p class="gras">
      <img src="<?php print(URL_ADHERENT.'image/paiement/sms.jpg');?>" alt="Envoyer LOC par SMS au 81 038*" /> OU <img src="<?php print(URL_ADHERENT.'image/paiement/tel.jpg');?>" alt="Appeler 0 899 23 08 89*" /><br /><br />
      Saisissez ici le code obtenu<br /><br />
      <form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" class="code">
        <input type="hidden" name="formulaire1" value="" />
        <input type="text" id="code_reference" name="code_reference" value="" />
        <input type="submit" class="submit simple" name="annonce_submit" value="Valider" />
      </form>
      </p>
      <p class="petit"><br />* LOC par SMS au 81 038 tarif de <?php print(ma_htmlentities($plateforme['S1'][1]));?> (<?php print(ma_htmlentities($plateforme['S1'][2]));?>&euro;+prix du sms).<br />
      Appel au <?php print(ma_htmlentities(formater($plateforme['FR'][1],'telephone_espace')));?> au tarif de <?php print(ma_htmlentities($plateforme['FR'][2]));?>&euro; hors surco&ucirc;t &eacute;ventuel des op&eacute;rateurs</p></div>
    <br />
    <div class="tarif">
      <h4>Par abonnements : illimit&eacute;e 24h/24, le temps de votre abonnement</h4>
      <br />
      <table id="abonnement_tarif">
        <tr>
          <td><a href="abonnement.php?tarif_abonnement_identifiant=ab0013"><img src="<?php print(URL_ADHERENT.'image/paiement/abo7j.jpg');?>" alt="Abonnement de 7 jours" /></a></td>
          <td class="prix"><a href="abonnement.php?tarif_abonnement_identifiant=ab0013">7&euro;</a></td>
          <td><a href="abonnement.php?tarif_abonnement_identifiant=ab0013"><span class="bouton_orange">Choisir cette offre</span></a></td>
        </tr>
        <tr>
          <td><a href="abonnement.php?tarif_abonnement_identifiant=ab0014"><img src="<?php print(URL_ADHERENT.'image/paiement/abo14j.jpg');?>" alt="Abonnement de 14 jours" /></a></td>
          <td class="prix"><a href="abonnement.php?tarif_abonnement_identifiant=ab0014">13&euro; au lieu de 14&euro;</a></td>
          <td><a href="abonnement.php?tarif_abonnement_identifiant=ab0014"><span class="bouton_orange">Choisir cette offre</span></a></td>
        </tr>
        <tr>
          <td><a href="abonnement.php?tarif_abonnement_identifiant=ab0015"><img src="<?php print(URL_ADHERENT.'image/paiement/abo28j.jpg');?>" alt="Abonnement de 28 jours" /></a></td>
          <td class="prix"><a href="abonnement.php?tarif_abonnement_identifiant=ab0015">24&euro; au lieu de 28&euro;</a></td>
          <td><a href="abonnement.php?tarif_abonnement_identifiant=ab0015"><span class="bouton_orange">Choisir cette offre</span></a></td>
        </tr>
      </table>
      <br /><img src="<?php print(URL_ADHERENT.'image/paiement/moyens.jpg');?>" alt="CB Mastercard Visa American Express Internet+ Paypal" />
    </div>
    <br />
    <div class="tarif">
      <h4>Code promotionnel :</h4>
    <?php
  	if(isset($_REQUEST['formulaire2'])) print('<p class="orange_fonce gauche gras"><br />Code invalide.<br />Merci de v&eacute;rifier le code promotionnel que vous avez re&ccedil;u.<br /><br /></p>');
	?>
      <form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" class="code">
        <input type="hidden" name="formulaire2" value="" />
        <input type="text" name="code_reference" value="" />
        <input type="submit" class="submit simple" name="annonce_submit" value="Valider" />
      </form>
    </div>
    <p class="lien"><a class="bleu_fonce gras decale20d" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste d'annonces</a></p>
  </div>
  <div id="centre_bas"></div>
</div>
<div id="footer">
  <?php include(PWD_ADHERENT.'pied.php');?>
</div>
<?php include(PWD_ADHERENT.'fin.php');?>
</body>
</html>