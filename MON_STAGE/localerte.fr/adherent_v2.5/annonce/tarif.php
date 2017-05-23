<?php
	require_once(PWD_ADHERENT.'configuration.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'allopass.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'socket_http.php');
	require_once(PWD_INCLUSION.'wha.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'date.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'adherent.php');
	
	file_put_contents(PWD_INCLUSION.'prive/log/tarif.txt',date('Y-m-d H:i:s').' '.$_SESSION['adherent_identifiant'].' '.'TOUS'.CRLF,FILE_APPEND);
	
	define('LIEN_WHA','https://mps.w-ha.com/app-mps/purchase?mctId=5216&amp;pid=LA001&amp;fid=1&amp;mp_wha_desc2=current&amp;mp_securite='.$_SESSION['wha_securite'].'&amp;mp_adherent_identifiant='.urlencode($_SESSION['adherent_identifiant']).'&amp;mp_r='.urlencode(HTTP_ADHERENT.'annonce/tarif.php').'&amp;mp_acte=LA001');
	
	//CODE
	if(isset($_REQUEST['code_reference']))
	{
		file_put_contents(PWD_INCLUSION.'prive/log/tarif.txt',date('Y-m-d H:i:s').' '.$_SESSION['adherent_identifiant'].' '.'CODE'.CRLF,FILE_APPEND);
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
			{
				if(preg_match('/<revers_palier>(.*)<\/revers_palier>/',file_get_contents('http://payment.allopass.com/api/infocode.apu?code='.urlencode($_REQUEST['code_reference']).'&auth='.urlencode(implode('/',$allopass_access))),$resultat))
				{
					$allopass=new ld_allopass();
					$allopass->reference='';
					$allopass->nouveau_reference=$_REQUEST['code_reference'];
					$allopass->palier=$allopass_access[1];
					$allopass->adherent=$_SESSION['adherent_identifiant'];
					$allopass->prix=floatval($resultat[1]);
					$allopass->domaine=$_SERVER['HTTP_HOST'];
					$allopass->ajouter();
					$allopass_checkcode=true;
					file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-CHECK'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
				}
			}
			
			if(!$allopass_checkcode)
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-CHECK'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
		}
	}
	
	//ABONNEMENT
	if(!isset($_REQUEST['tarif_abonnement_identifiant']) || !preg_match('/^(ab0013|ab0014|ab0015|ab0017)$/i',$_REQUEST['tarif_abonnement_identifiant']))
		$_REQUEST['tarif_abonnement_identifiant']='ab0015';
	if(!isset($_REQUEST['paiement_mode']) || !preg_match('/^(CB|WHA)$/i',$_REQUEST['paiement_mode']))
		$_REQUEST['paiement_mode']='CB';
	
	$tarif_abonnement=new ld_tarif_abonnement();
	$tarif_abonnement->identifiant=$_REQUEST['tarif_abonnement_identifiant'];
	$tarif_abonnement->lire();

	if(isset($_REQUEST['annonce_submit']) && $_REQUEST['annonce_submit']!='CB_REFUS' && $_REQUEST['annonce_submit']!='CB_ANNULATION')
	{
		file_put_contents(PWD_INCLUSION.'prive/log/tarif.txt',date('Y-m-d H:i:s').' '.$_SESSION['adherent_identifiant'].' '.'ABONNEMENT'.CRLF,FILE_APPEND);
		$tarif_abonnement=new ld_tarif_abonnement();
		$tarif_abonnement->identifiant=$_REQUEST['tarif_abonnement_identifiant'];
		if($tarif_abonnement->lire())
		{
			$facture=new ld_facture();
			$facture->identifiant='';
			$facture->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_facture','identifiant',FACTURE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
			$facture->adherent=$_SESSION['adherent_identifiant'];
			$facture->adresse=NULL;
			$facture->complement_adresse=NULL;
			$facture->code_postal=NULL;
			$facture->ville=NULL;
			$facture->raison_sociale=NULL;
			$facture->nom=NULL;
			$facture->prenom=NULL;
			$facture->domaine=$_SERVER['HTTP_HOST'];
			
			$facture_ligne=new ld_facture_ligne();
			$facture_ligne->identifiant='';
			$facture_ligne->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_facture_ligne','identifiant',FACTURE_LIGNE_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
			$facture_ligne->facture=$facture->nouveau_identifiant;
			$facture_ligne->reference=$tarif_abonnement->identifiant;
			$facture_ligne->designation=duree($tarif_abonnement->delai,'Abonnement de %j jours');
			$facture_ligne->prix_ht=$tarif_abonnement->prix_ht;
			$facture_ligne->quantite=1;
			$facture_ligne->tva=$tarif_abonnement->tva;
			$facture->facture_ligne_ajouter($facture_ligne,'ajouter');
			
			switch($_REQUEST['paiement_mode'])
			{
				case 'CB':
					$facture->ajouter();
					
					$adherent=new ld_adherent();
					$adherent->identifiant=$facture->adherent;
					$adherent->lire();
					
					$paybox=array();
					$paybox['PBX_MODE']=1;											//1 = POST
					$paybox['PBX_SITE']='0559343';	//'1999888';//'0559343';					//donne par la banque
					$paybox['PBX_RANG']='01';		//'99';//'01';						//donne par la banque
					$paybox['PBX_TOTAL']=round($tarif_abonnement->prix_ht*(1+$tarif_abonnement->tva/100)*100,0);	//TOTAL en centimes
					$paybox['PBX_DEVISE']=978;										//978 = EUROS
					$paybox['PBX_CMD']='LA'.$facture->identifiant;					//REFERENCE
					$paybox['PBX_PORTEUR']=$adherent->email;						//EMAIL DU CLIENT
					$paybox['PBX_IDENTIFIANT']='20738281';
					$paybox['PBX_RETOUR']='ref:R;trans:T;auto:A;tarif:M';			//VALIDE LE PAIEMENT
					$paybox['PBX_EFFECTUE']=HTTP_ADHERENT.'annonce/detail.php';
					$paybox['PBX_REFUSE']=HTTP_ADHERENT.'annonce/tarif.php?tarif_abonnement_identifiant='.$tarif_abonnement->identifiant.'&paiement_mode=CB&annonce_submit=CB_REFUS';
					$paybox['PBX_ANNULE']=HTTP_ADHERENT.'annonce/tarif.php?tarif_abonnement_identifiant='.$tarif_abonnement->identifiant.'&paiement_mode=CB&annonce_submit=CB_ANNULATION';
					
					//print_r($paybox);
					
					if($socket=fsockopen('paiement.aicom.fr',80))
					{
						$post=array();
						foreach($paybox as $clef=>$valeur)
							$post[]=urlencode($clef).'='.urlencode($valeur);
						$query=implode('&',$post);
						
						$out='';
						$out.='POST /cgi-bin/modulev2.cgi HTTP/1.0'.CRLF;
						$out.='Host: paiement.aicom.fr'.CRLF;
						$out.='Connection: Close'.CRLF;
						$out.='Content-Type: application/x-www-form-urlencode'.CRLF;
						$out.='Content-Length: '.strlen($query).CRLF.CRLF;
						$out.=$query;
						
						fputs($socket,$out,strlen($out));
						
						$in='';
						while(!feof($socket))
							$in.=fgets($socket);
						
						list($header,$body)=explode(CRLF.CRLF,$in,2);
						
						print($body);
						
						fclose($socket);
						die();
					}
					break;
				case 'WHA':
					if(isset($_SESSION['WHA_PAYE']))
					{
						$facture->ajouter();
						$facture->payer();
						$facture->envoyer('WHA');
						unset($_SESSION['WHA_PAYE']);
						header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/detail.php'));
						die();
					}
					break;
			}
		}
	}
	
	//INTERNET PLUS
	if(isset($_SESSION['WHA_PAYE']))
	{
		$wha=new ld_wha();
		$wha->identifiant='';
		$wha->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_wha','identifiant',WHA_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		$wha->adherent=$_SESSION['adherent_identifiant'];
		$wha->prix=1.05;
		$wha->domaine=$_SERVER['HTTP_HOST'];
		$wha->ajouter();
		$_SESSION['wha_identifiant']=$wha->identifiant;
		
		unset($_SESSION['WHA_PAYE']);
	}
	
	//SI PASSE MURAILLE
	if(isset($_SESSION['allopass_reference']) || isset($_SESSION['wha_identifiant']) || isset($_SESSION['code_reference']) || $abonnement['resultat']=='ABONNEMENT_UTILISABLE')
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'annonce/detail.php'));
		die();
	}
	
	$temp='FR%0899230889%1.46%EUR%%audio'.LF.'S1%81083%3.00%EUR%CODE au 81 083 - 3,00 euros par envoi prix d\'un SMS, 1 envoi de SMS par code d\'acces%sms'.LF.'S3%72720%30.00%SEK%AP till 72 720 - 30 SEK/SMS + (ev. SMS-taxa tillkommer)%sms'.LF.'S9%2098%30.00%NOK%AP till 2098 - 30 NOK pr. SMS%sms';
	//$temp=trim(file_get_contents('http://payment.allopass.com/api/getnum.apu?format=1&idd='.urlencode('270837')));
	$ligne=explode(LF,$temp);
	$plateforme=array();
	for($i=0;$i<sizeof($ligne);$i++)
	{
		$colonne=explode('%',$ligne[$i]);
		$plateforme[$colonne[0]]=$colonne;
	}
	
	
	/* Mots clés adsense */
	$liste=new ld_liste
	('
		select ville_nom as ville
		from liste
		where identifiant in (\''.implode('\', \'',array_map('addslashes',$_SESSION['annonce_identifiant'])).'\')
	    	'.((isset($_COOKIE['memo']['poubelle']))?('and identifiant not in (\''.implode('\', \'',array_map('addslashes',array_keys($_COOKIE['memo']['poubelle']))).'\')'):('')).'
		order by /*`'.$_SESSION['annonce_tri'].'` '.$_SESSION['annonce_ordre'].'*/ parution desc
	');
	if($liste->total) $mot_cle=$liste->occurrence[0]['ville'];
	else $mot_cle='';
	/*********************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include(PWD_ADHERENT.'entete.php');?>
<script type="text/javascript">
<!--
	function GererWHA()
	{
		if(document.getElementById('WHA').checked)
		{
			for(i=0;i<document.getElementsByName('tarif_abonnement_identifiant').length;i++)
				if(document.getElementsByName('tarif_abonnement_identifiant')[i].checked)
					window.location='https://mps.w-ha.com/app-mps/purchase?mctId=5216&pid='+encodeURIComponent(document.getElementsByName('tarif_abonnement_identifiant')[i].value)+'&fid=1&mp_wha_desc2=current&mp_securite=<?php print($_SESSION['wha_securite'])?>&mp_r=<?php print(urlencode(HTTP_ADHERENT.'annonce/tarif.php'));?>&mp_adherent_identifiant=<?php print(urlencode($_SESSION['adherent_identifiant']));?>&mp_paiement_mode=WHA&mp_annonce_submit=WHA_ANNULATION&mp_tarif_abonnement_identifiant='+encodeURIComponent(document.getElementsByName('tarif_abonnement_identifiant')[i].value);
			return false;
		}
		
		return true;
	}
//-->
</script>
<?php
	if(isset($_SESSION['code_2']) && $_SESSION['code_2']=='message'){
		print('
			<script type="text/javascript">
			  $(window).load(function(){$.msgBox({classCSS:\'msgbox msgbox-code_2\',html:\'<p syle="text-align:center;"><strong style="font-size:1.3em;">Pour vous c\\\'est gratuit !</strong><br /><br />Nous avons envoyé<br />un Code d\\\'accès gratuit à votre adresse :<br /><br />'.$adherent->email.'<br /><br /><strong>Merci d\\\'en prendre connaissance et de l\\\'activer.</strong><br /><br />NB. Pensez à vérifier votre Courrier indésirable !<br /><br /></p>\',\'close\':function(){},\'success\':function(){}})});
			</script>
		');
	}
?>
</head>
<body onload="document.getElementById('code_reference').focus();">
<?php include(PWD_ADHERENT.'debut.php');?>
<div id="principal">
  <div id="header">
    <?php include(PWD_ADHERENT.'tete.php');?>
  </div>
  <div id="centre_haut"></div>
  <div id="centre">
    <p class="lien"><a class="bleu_fonce gras decale20d" href="<?php print(URL_ADHERENT.'annonce/liste.php');?>">Retour &agrave; la liste d'annonces</a><br />
      <br />
    </p>
    <div class="tarif">
      <h4>Pour <span style="color:#e57503;">visualiser toutes les annonces</span> d&eacute;taill&eacute;es,<br />vous avez besoin d'un code que vous pouvez obtenir par t&eacute;l&eacute;phone ou par SMS.<br />Vous pourrez alors naviguer <span style="color:#e57503;">librement</span> et <span style="color:#e57503;">imm&eacute;diatement</span> entre la liste et le d&eacute;tail des annonces :</h4>
      <?php
  	if(isset($_REQUEST['formulaire1'])) print('<p class="orange_fonce gauche gras"><br />Code invalide.<br />
Votre code vous sera communiqu&eacute; par SMS si vous envoyez le mot « LOC » par SMS au 81 083,<br />ou par messagerie vocale si vous choisissez d\'appeler le 0 899 23 08 89.</p>');
	?>
      <br />
      <p class="gras"> <img src="<?php print(URL_ADHERENT.'image/paiement/sms.jpg');?>" alt="Envoyer LOC par SMS au 81 083*" /> OU <img src="<?php print(URL_ADHERENT.'image/paiement/tel.jpg');?>" alt="Appeler 0 899 23 08 89*" /><br />
        <br />
        Saisissez ici le code obtenu<br />
        <br />
      </p>
      <form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" class="code">
        <p>
          <input type="hidden" name="formulaire1" value="" />
          <input type="text" id="code_reference" name="code_reference" value="<?php if(isset($_SESSION['code_2']) && $_SESSION['code_2']!='message') print($_SESSION['code_2']);?>" />
          <input type="submit" class="submit simple" name="code_submit" value="Valider" />
        </p>
      </form>
      <p class="petit"><br />
        * LOC par SMS au <?php print(ma_htmlentities($plateforme['S1'][1]));?> au tarif de <?php print(ma_htmlentities($plateforme['S1'][2]));?>&euro;+prix du sms.<br />
        Appel au <?php print(ma_htmlentities(formater($plateforme['FR'][1],'telephone_espace')));?> au tarif de <?php print(ma_htmlentities($plateforme['FR'][2]));?>&euro; hors surco&ucirc;t &eacute;ventuel des op&eacute;rateurs</p>
    </div>
    <br />
    <div class="tarif">
      <h4>Acc&egrave;s libre par abonnement : illimit&eacute;e 24h/24, le temps de votre abonnement</h4>
      <br />
      <form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" onsubmit="return GererWHA();" id="form_paiement">
        <table id="abonnement_tarif">
          <tr>
            <td><input type="radio" style="margin-left:15px;" name="tarif_abonnement_identifiant" id="abo13" value="ab0013"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0013')) print(' checked="checked"');?> />
              <label for="abo13" style="cursor:pointer;"><span style="padding:5px; border:solid 2px #FFF; color:#FFF; background-color:#195292; display:inline-block; width:140px;">Abonnement de 7 jours</span> <span style="padding:5px; border:solid 2px #F49737; color:#F49737; background-color:#FFF; display:inline-block; width:40px;">7&euro;</span></label></td>
            <td><input type="radio" style="margin-left:15px;" name="tarif_abonnement_identifiant" id="abo14" value="ab0014"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0014')) print(' checked="checked"');?> />
              <label for="abo14" style="cursor:pointer;"><span style="padding:5px; border:solid 2px #FFF; color:#FFF; background-color:#195292; display:inline-block; width:140px;">Abonnement de 14 jours</span> <span style="padding:5px; border:solid 2px #F49737; color:#F49737; background-color:#FFF; display:inline-block; width:40px;">13&euro;</span></label></td>
            <td rowspan="2"><div style="float:left; border:solid 2px #195292; width:229px; padding-top:10px; padding-left:10px;	margin-left:30px; text-align:left; background-color:#FFF;">
                <input id="paiement_mode_cb" type="radio" name="paiement_mode" value="CB"<?php if(isset($_REQUEST['paiement_mode']) && ($_REQUEST['paiement_mode']=='CB')) print(' checked="checked"');?> />
                <label for="paiement_mode_cb"><img src="<?php print(URL_ADHERENT.'image/paiement/cb.jpg');?>" alt="CB" style="vertical-align:middle;" /></label>
                <br />
          <script type="text/javascript">
		  <!--
		    document.write('<input type="radio" name="paiement_mode" value="WHA" id="WHA"<?php if(isset($_REQUEST['paiement_mode']) && ($_REQUEST['paiement_mode']=='WHA')) print(' checked="checked"');?> />');
			document.write('<label for="WHA"><img src="<?php print(URL_ADHERENT.'image/paiement/wha.jpg');?>" alt="Internet Plus" style="vertical-align:middle; padding-bottom:4px; padding-left:4px;" /></label>');
		  //-->
		  </script>
              </div></td>
          </tr>
          <tr>
            <td><input type="radio" style="margin-left:15px;" name="tarif_abonnement_identifiant" id="abo17" value="ab0017"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0017')) print(' checked="checked"');?> />
              <label for="abo17" style="cursor:pointer;"><span style="padding:5px; border:solid 2px #FFF; color:#FFF; background-color:#195292; display:inline-block; width:140px;">Abonnement de 21 jours</span> <span style="padding:5px; border:solid 2px #F49737; color:#F49737; background-color:#FFF; display:inline-block; width:40px;">18&euro;</span></label></td>
            <td><input type="radio" style="margin-left:15px;" name="tarif_abonnement_identifiant" id="abo15" value="ab0015"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0015')) print(' checked="checked"');?> />
              <label for="abo15" style="cursor:pointer;"><span style="padding:5px; border:solid 2px #FFF; color:#FFF; background-color:#195292; display:inline-block; width:140px;">Abonnement de 28 jours</span> <span style="padding:5px; border:solid 2px #F49737; color:#F49737; background-color:#FFF; display:inline-block; width:40px;">24&euro;</span></label></td>
          </tr>
          <tr><td colspan="3"><br /><span style="display:inline-block; width:190px;"></span><input class="simple" type="submit" name="annonce_submit" value="Valider" /></td></tr>
        </table>
      </form>
      <br />
      <!--img src="<?php print(URL_ADHERENT.'image/paiement/moyens.jpg');?>" alt="CB Mastercard Visa American Express Internet+ Paypal" /-->
    </div>
    <script type="text/javascript">
	  <!--
	  document.write('<br /><div class="tarif"><h4>Par votre facture internet :</h4><br /><p class="gras">En choisissant cette offre, le montant de 1,50 &euro; sera d&eacute;bit&eacute; directement sur votre prochaine facture Internet.<br /><br /><a href="<?php print(LIEN_WHA);?>" id="wha"><img src="<?php print(URL_ADHERENT.'image/paiement/wha2.jpg');?>" alt="wha" /></a></p></div>');
	  -->
	  </script>
    <br />
    <!--div class="tarif">
      <h4>Code promotionnel :</h4>
      <?php
  	if(isset($_REQUEST['formulaire2'])) print('<p class="orange_fonce gauche gras"><br />Code invalide.<br />Merci de v&eacute;rifier le code promotionnel que vous avez re&ccedil;u.<br /><br /></p>');
	?>
      <form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" class="code">
        <p>
          <input type="hidden" name="formulaire2" value="" />
          <input type="text" name="code_reference" value="" />
          <input type="submit" class="submit simple" name="code_submit" value="Valider" />
        </p>
      </form>
    </div-->
    <div id="adsense-liste1" style="margin-left:30px;"></div>
	<script src="http://www.google.com/adsense/search/ads.js" type="text/javascript"></script> 
    <script type="text/javascript" charset="utf-8"> 
        <!--
        var pageOptions2 = { 
          'pubId' : 'pub-9592588828246820',
          'query' : '<?php print(addslashes('location '.ma_htmlentities($mot_cle)));?>',
          'channel' : '3813962498',
          'hl' : 'fr',
          'linkTarget' : '_blank'
        };
        
        var adblock1 = { 
          'container' : 'adsense-liste1',
		  'width' : '650px',
		  'number' : '4',
		  'colorTitleLink' : '#e57503',
		  'colorText' : '#195292',
		  'colorDomainLink' : '#000000',
		  'fontSizeTitle' : '18px',
		  'siteLinks' : false
        };
        
        new google.ads.search.Ads(pageOptions2, adblock1);
    //--></script> 
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
