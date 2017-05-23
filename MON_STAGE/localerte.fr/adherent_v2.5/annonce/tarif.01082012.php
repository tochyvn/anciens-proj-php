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
	
	define('LIEN_WHA','https://mps.w-ha.com/app-mps/purchase?mctId=5216&amp;pid=LA001&amp;fid=1&amp;mp_wha_desc2=current&amp;mp_securite='.$_SESSION['wha_securite'].'&amp;mp_adherent_identifiant='.urlencode($_SESSION['adherent_identifiant']).'&amp;mp_r='.urlencode(HTTP_ADHERENT.'annonce/tarif.php').'&amp;mp_acte=LA001');
		
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
	
	//ABONNEMENT
	if(!isset($_REQUEST['tarif_abonnement_identifiant']) || !preg_match('/^(ab0013|ab0014|ab0015)$/i',$_REQUEST['tarif_abonnement_identifiant']))
		$_REQUEST['tarif_abonnement_identifiant']='ab0015';
	if(!isset($_REQUEST['paiement_mode']) || !preg_match('/^(CB|WHA)$/i',$_REQUEST['paiement_mode']))
		$_REQUEST['paiement_mode']='CB';
	
	$tarif_abonnement=new ld_tarif_abonnement();
	$tarif_abonnement->identifiant=$_REQUEST['tarif_abonnement_identifiant'];
	$tarif_abonnement->lire();

	if(isset($_REQUEST['annonce_submit']) && $_REQUEST['annonce_submit']!='CB_REFUS' && $_REQUEST['annonce_submit']!='CB_ANNULATION')
	{
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
						$facture->payer('WHA');
						$facture->envoyer();
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
    <table>
      <tr>
        <td colspan="4" width="655"><table cellpadding="0" cellspacing="0" width="655">
            <tr>
              <td width="655" style="padding:5px; padding-left:10px; background-color:#FFF;"><h3 style="color:#FF7602; font-size:16px;">Consultation sans abonnement</h3>
                <script type="text/javascript">
				  <!--
					document.write('<span class="bulle fleche-haut-gauche" style="top:85px; left:370px; width:300px; display:none;" id="aide1a">');
					document.write('<span class="cadre">');
					document.write('<span class="haut-gauche"></span>');
					document.write('<span class="haut-centre"></span>');
					document.write('<span class="haut-droite"></span>');
					document.write('<span class="milieu" style="font-size:11px;">Vous consultez librement la totalit&eacute; des annonces (dont votre s&eacute;lection) le temps de votre session ; c\'est &agrave; dire tant que vous restez connect&eacute; et actif sur LOCALERTE.<br />Vous pouvez r&eacute;gler sans carte bancaire gr&acirc;ce &agrave; notre solution Audiotel s&eacute;curis&eacute;e, ou directement avec votre facture Internet (cf. formule Internet Plus).</span>');
					document.write('<span class="bas-gauche"></span>');
					document.write('<span class="bas-centre"></span>');
					document.write('<span class="bas-droite"></span>');
					document.write('</span>');
					document.write('<span class="fleche"></span>');
					document.write('</span>');

				  //-->
				  </script>
                <script type="text/javascript">
				  <!--
					document.write('<span class="bulle fleche-haut-gauche" style="top:127px; left:20px; width:300px; display:none;" id="aide1b">');
					document.write('<span class="cadre">');
					document.write('<span class="haut-gauche"></span>');
					document.write('<span class="haut-centre"></span>');
					document.write('<span class="haut-droite"></span>');
					document.write('<span class="milieu" style="font-size:11px;">Vous consultez librement la totalit&eacute; des annonces (dont votre s&eacute;lection) le temps de votre session ; c\'est &agrave; dire tant que vous restez connect&eacute; et actif sur LOCALERTE.<br />Vous pouvez r&eacute;gler sans carte bancaire gr&acirc;ce &agrave; notre solution Audiotel s&eacute;curis&eacute;e, ou directement avec votre facture Internet (cf. formule Internet Plus).</span>');
					document.write('<span class="bas-gauche"></span>');
					document.write('<span class="bas-centre"></span>');
					document.write('<span class="bas-droite"></span>');
					document.write('</span>');
					document.write('<span class="fleche"></span>');
					document.write('</span>');

				  //-->
				  </script>
                <script type="text/javascript">
				  <!--
					document.write('<span class="bulle fleche-haut-gauche" style="top:235px; left:20px; width:420px; display:none;" id="aide2a">');
					document.write('<span class="cadre">');
					document.write('<span class="haut-gauche"></span>');
					document.write('<span class="haut-centre"></span>');
					document.write('<span class="haut-droite"></span>');
					document.write('<span class="milieu" style="font-size:11px;">Notre service Audiotel vous permet de r&eacute;gler votre achat tr&egrave;s simplement, gr&acirc;ce &agrave; votre t&eacute;l&eacute;phone, sans utiliser votre carte bancaire.<br />Sit&ocirc;t votre appel pass&eacute; ou votre SMS envoy&eacute;, nous vous communiquons votre code de connexion. Apr&egrave;s l\'avoir resaisi dans la case alou&eacute;e, vous pourrez naviguer sans restriction de coordonn&eacute;es sur toutes les annonces de LOCALERTE, le temps de votre session (c\'est &agrave; dire tant que vous resterez connect&eacute; et actif sur notre site).<br />Notre service est utilis&eacute; chaque jour par de nombreux internautes. Il est &eacute;dit&eacute; par notre partenaire Allopass - Groupe Hi-M&eacute;dia, Paris 75002.</span>');
					document.write('<span class="bas-gauche"></span>');
					document.write('<span class="bas-centre"></span>');
					document.write('<span class="bas-droite"></span>');
					document.write('</span>');
					document.write('<span class="fleche"></span>');
					document.write('</span>');

				  //-->
				  </script>
                <script type="text/javascript">
				  <!--
					document.write('<span class="bulle fleche-bas-gauche" style="top:542px; left:55px; width:300px; display:none;" id="aide2b">');
					document.write('<span class="cadre">');
					document.write('<span class="haut-gauche"></span>');
					document.write('<span class="haut-centre"></span>');
					document.write('<span class="haut-droite"></span>');
					document.write('<span class="milieu" style="font-size:11px;">Saisissez directement votre Code promo dans la fen&ecirc;tre de validation en haut &agrave; droite de cette page.<br /></span>');
					document.write('<span class="bas-gauche"></span>');
					document.write('<span class="bas-centre"></span>');
					document.write('<span class="bas-droite"></span>');
					document.write('</span>');
					document.write('<span class="fleche"></span>');
					document.write('</span>');

				  //-->
				  </script>
                <span style="color:#e57503; font-size:12px;">Consultez le temps de votre session <a href="#" onmouseover="document.getElementById('aide1a').style.display='block';" onmouseout="document.getElementById('aide1a').style.display='none';" style="color:#FF7602; padding-left:120px; font-size:11px;">En savoir plus ?</a></span></td>
              <td></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td valign="top" align="left" width="315" style="background-color:#D8E3F0; font-size:13px; font-weight:bold; padding-left:10px;"><br />
          <a href="#" onmouseover="document.getElementById('aide1b').style.display='block';" onmouseout="document.getElementById('aide1b').style.display='none';" style="color:#195292; font-size:11px;">En savoir plus ?</a><br />
          <br />
          Pour <span style="color:#e57503;">visualiser toutes les annonces</span> d&eacute;taill&eacute;es,<br />
          vous avez besoin d'un code que vous pouvez obtenir par t&eacute;l&eacute;phone ou par SMS.<br />
          Vous pourrez alors naviguer <span style="color:#e57503;">librement</span> et <span style="color:#e57503;">imm&eacute;diatement</span> entre la liste et le d&eacute;tail des annonces <br />
          <br /></td>
        <td width="580" valign="top" style="background-color:#D8E3F0;"><table cellpadding="0" cellspacing="0" width="580">
            <tr>
              <td align="center" colspan="2">
                <p class="gras"><br />
                  <img src="<?php print(URL_ADHERENT.'image/paiement/sms.jpg');?>" alt="Envoyer LOC par SMS au 81 083*" style="vertical-align:middle;" /> OU <img src="<?php print(URL_ADHERENT.'image/paiement/tel.jpg');?>" alt="Appeler 0 899 23 08 89*" style="vertical-align:middle;" /><br />
                  <br />
                  <?php	if(isset($_REQUEST['formulaire1'])) print('<font class="orange_fonce gras">Code invalide.</font>'); else print('Saisissez ici le code obtenu :');?><br />
                  <br />
                </p>
                <form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" class="code">
                  <p>
                    <input type="hidden" name="formulaire1" value="" />
                    <input type="text" id="code_reference" name="code_reference" value="" />
                    <input style="font-family:Arial, Helvetica, sans-serif; background-image:url(<?php print(URL_ADHERENT.'image/paiement/v6/bouton.jpg');?>); font-size:14px; font-weight:bold; color:#FFF; cursor:pointer; width:145px; height:30px; text-align:center; margin:5px;" type="submit" name="code_submit" value="Valider" />
                  </p>
                </form>
                <p class="petit"><br />
                  * LOC par SMS au <?php print(ma_htmlentities($plateforme['S1'][1]));?> au tarif de <?php print(ma_htmlentities($plateforme['S1'][2]));?>&euro;+prix du sms.<br />
                  Appel au <?php print(ma_htmlentities(formater($plateforme['FR'][1],'telephone_espace')));?> au tarif de <?php print(ma_htmlentities($plateforme['FR'][2]));?>&euro; hors surco&ucirc;t &eacute;ventuel des op&eacute;rateurs</p></td>
            </tr>
            <tr>
              <td height="3" colspan="2"></td>
            </tr>
          </table></td>
      </tr>
            <tr>
            <td width="315"></td>
              <td style="padding-left:10px; background-color:#D8E3F0;" width="300" colspan="2" align="center"><script type="text/javascript">
				  <!--
					document.write('<span class="bulle fleche-bas-droite" style="top:227px; left:440px; width:300px; display:none; text-align:left;" id="aide4b">');
					document.write('<span class="cadre">');
					document.write('<span class="haut-gauche"></span>');
					document.write('<span class="haut-centre"></span>');
					document.write('<span class="haut-droite"></span>');
					document.write('<span class="milieu" style="font-size:11px; font-weight:normal;">Internet Plus est la solution de paiement s&eacute;curis&eacute;e qui vous permet de r&eacute;gler votre achat &agrave; l\'aide de votre facture Internet (Orange, Free, Bouygues T&eacute;l&eacute;com, SFR, Alice).</span>');
					document.write('<span class="bas-gauche"></span>');
					document.write('<span class="bas-centre"></span>');
					document.write('<span class="bas-droite"></span>');
					document.write('</span>');
					document.write('<span class="fleche"></span>');
					document.write('</span>');

				  //-->
				  </script>
                <script type="text/javascript">
	  <!--
	  document.write('<table cellpadding="0" cellspacing="0">');
	  document.write('<tr>');
	  document.write('<td width="100"><a href="<?php print(LIEN_WHA);?>"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/facture.jpg');?>" alt="Facture sur tel" /></a> <img src="<?php print(URL_ADHERENT.'image/paiement/v6/fleche_bleue.jpg');?>" alt="&gt;" style="padding-bottom:10px; padding-left:5px;" /></td>');
	  document.write('<td style="padding:8px;" bgcolor="#D8E3F0" width="200"><table cellpadding="0" cellspacing="0" bgcolor="#FF7602" width="180" style="background-image:url(<?php print(URL_ADHERENT.'image/paiement/v6/fond_sansabo.jpg');?>);">');
	  document.write('<tr>');
	  document.write('<td align="center" height="21"><a href="<?php print(LIEN_WHA);?>" style="text-decoration:none; color:#FFFFFF;">Cliquez ici</a></td>');
	  document.write('</tr>');
	  document.write('<tr>');
	  document.write('<td bgcolor="#FFFFFF" align="center" height="25"><a href="<?php print(LIEN_WHA);?>" style="text-decoration:none; color:#FF7602;"><b><img src="<?php print(URL_ADHERENT.'image/paiement/v6/internet77x22.jpg');?>" alt="Internet+" /></b></a> <a href="#" onmouseover="document.getElementById(\'aide4b\').style.display=\'block\';" onmouseout="document.getElementById(\'aide4b\').style.display=\'none\';"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/info.jpg');?>" alt="?" /></a></td>');
	  document.write('</tr>');
	  document.write('</table></td>');
	  document.write('</tr>');
	  document.write('</table>');
	  -->
	  </script></td>
              <!--td align="center" width="280" valign="middle"  bgcolor="#FFFFFF"><p style="color:#C46100; font-size:15px;"><br />
                  <i>&laquo; Vous avez &eacute;t&eacute; plus de 3 000<br />
                  &agrave; nous faire confiance<br />
                  en Juin ! Merci. &raquo;</i></p></td-->
            </tr>
      <tr>
        <td colspan="4" width="655"><table width="655" cellpadding="0" cellspacing="0">
            <tr>
              <td width="655" bgcolor="#FFFFFF" style="padding:5px; padding-left:10px;"><h3><span style="color:#e57503; font-size:16px;">Consultation avec abonnement</span></h3>
                <script type="text/javascript">
				  <!--
					document.write('<span class="bulle fleche-haut-gauche" style="top:368px; left:380px; width:300px; display:none;" id="aide3a">');
					document.write('<span class="cadre">');
					document.write('<span class="haut-gauche"></span>');
					document.write('<span class="haut-centre"></span>');
					document.write('<span class="haut-droite"></span>');
					document.write('<span class="milieu" style="font-size:11px;">Vous consultez librement la totalit&eacute; des annonces (dont votre s&eacute;lection) durant toute la dur&eacute;e de votre abonnement (au choix 7, 14, 21 ou 28 jours).<br />Vous pouvez r&eacute;gler par Carte Bancaire (paiement s&eacute;curis&eacute;), ou directement avec votre facture Internet (cf. formule Internet Plus).</span>');
					document.write('<span class="bas-gauche"></span>');
					document.write('<span class="bas-centre"></span>');
					document.write('<span class="bas-droite"></span>');
					document.write('</span>');
					document.write('<span class="fleche"></span>');
					document.write('</span>');

				  //-->
				  </script>
                <script type="text/javascript">
				  <!--
					document.write('<span class="bulle fleche-haut-gauche" style="top:408px; left:20px; width:300px; display:none;" id="aide3b">');
					document.write('<span class="cadre">');
					document.write('<span class="haut-gauche"></span>');
					document.write('<span class="haut-centre"></span>');
					document.write('<span class="haut-droite"></span>');
					document.write('<span class="milieu" style="font-size:11px;">Vous consultez librement la totalit&eacute; des annonces (dont votre s&eacute;lection) durant toute la dur&eacute;e de votre abonnement (au choix 7, 14, 21 ou 28 jours).<br />Vous pouvez r&eacute;gler par Carte Bancaire (paiement s&eacute;curis&eacute;), ou directement avec votre facture Internet (cf. formule Internet Plus).</span>');
					document.write('<span class="bas-gauche"></span>');
					document.write('<span class="bas-centre"></span>');
					document.write('<span class="bas-droite"></span>');
					document.write('</span>');
					document.write('<span class="fleche"></span>');
					document.write('</span>');

				  //-->
				  </script>
                <span style="color:#e57503; font-size:12px;">Au choix : 7, 14, 21 ou 28 jours <a href="#" onmouseover="document.getElementById('aide3a').style.display='block';" onmouseout="document.getElementById('aide3a').style.display='none';" style="color:#e57503; padding-left:185px; font-size:11px;">En savoir plus ?</a></span></td>
              <td width="1"></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="4"><form action="<?php print(URL_ADHERENT.'annonce/tarif.php');?>" method="post" onsubmit="return GererWHA();" id="form_paiement">
            <table align="left">
              <tr>
                <td valign="top" align="left" width="315" style=" background-color:#D8E3F0; font-size:13px; font-weight:bold; padding-left:10px;"><br />
                  <a href="#" onmouseover="document.getElementById('aide3b').style.display='block';" onmouseout="document.getElementById('aide3b').style.display='none';" style="color:#195292; font-size:11px;">En savoir plus ?</a><br />
                  <br />
                  Passez en acc&egrave;s libre et consultez<br />
                  toutes les annonces en d&eacute;tail<br />
                  avec les coordonn&eacute;es des propri&eacute;taires,<br />
                  le temps de votre session.<br />
                  <br />
                  <br /></td>
                <td width="580" valign="top"><table cellpadding="0" cellspacing="0" width="100%">
                    <tr bgcolor="#d8e3f0">
                      <td width="300" align="center" style="color:#E77503; font-size:14px; font-weight:bold; height:30px;">Choisissez votre formule :</td>
                      <td width="280"></td>
                    </tr>
                    <tr>
                      <td align="center" width="300" valign="top" bgcolor="#d8e3f0"><table cellpadding="0" cellspacing="0" style="background-color:#D8E3F0;">
                          <tr>
                            <td width="15" height="121"></td>
                            <td><table width="270" cellpadding="0" cellspacing="0">
                                <tr abackground="<?php print(URL_ADHERENT.'image/paiement/v6/formule.jpg');?>">
                                  <td height="30" width="66" align="center"><input type="radio" name="tarif_abonnement_identifiant" id="abo13" value="ab0013"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0013')) print(' checked="checked"');?> /></td>
                                  <td width="67" align="center"><input type="radio" name="tarif_abonnement_identifiant" id="abo14" value="ab0014"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0014')) print(' checked="checked"');?> /></td>
                                  <td width="67" align="center"><input type="radio" name="tarif_abonnement_identifiant" id="abo16" value="ab0016"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0016')) print(' checked="checked"');?> /></td>
                                  <td width="66" align="center"><input type="radio" name="tarif_abonnement_identifiant" id="abo15" value="ab0015"<?php if(isset($_REQUEST['tarif_abonnement_identifiant']) && ($_REQUEST['tarif_abonnement_identifiant']=='ab0015')) print(' checked="checked"');?> /></td>
                                </tr>
                                <tr>
                                  <td height="45" align="center"><label for="abo13" style="cursor:pointer;"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/7j.jpg');?>" alt="7 jours" /></label></td>
                                  <td align="center"><label for="abo14" style="cursor:pointer;"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/14j.jpg');?>" alt="14 jours" /></label></td>
                                  <td align="center"><label for="abo16" style="cursor:pointer;"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/21j.jpg');?>" alt="21 jours" /></label></td>
                                  <td align="center"><label for="abo15" style="cursor:pointer;"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/28j.jpg');?>" alt="28 jours" /></label></td>
                                </tr>
                                <tr>
                                  <td height="30" align="center"><label for="abo13" style="cursor:pointer;"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/7e.jpg');?>" alt="7 &euro;" width="66" /></label></td>
                                  <td align="center"><label for="abo14" style="cursor:pointer;"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/13e.jpg');?>" alt="13 &euro;" width="66" /></label></td>
                                  <td align="center"><label for="abo16" style="cursor:pointer;"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/19e.jpg');?>" alt="19 &euro;" width="66" /></label></td>
                                  <td align="center"><label for="abo15" style="cursor:pointer;"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/24e.jpg');?>" alt="24 &euro;" width="66" /></label></td>
                                </tr>
                              </table></td>
                            <td width="15"></td>
                          </tr>
                        </table></td>
                      <td align="center" width="280" valign="top"><table cellpadding="0" cellspacing="0" width="280">
                          <tr>
                            <td width="280" style="aborder:solid 5px #FF7602; background-color:#D8E3F0;; color:#FF7602; padding:5px; font-size:12px; font-weight:bold;" align="center"><b>Validez votre mode de r&eacute;glement :</b><br />
                              <script type="text/javascript">
				  <!--
					document.write('<span class="bulle fleche-bas-droite" style="top:390px; left:560px; width:300px; display:none; text-align:left;" id="aide4">');
					document.write('<span class="cadre">');
					document.write('<span class="haut-gauche"></span>');
					document.write('<span class="haut-centre"></span>');
					document.write('<span class="haut-droite"></span>');
					document.write('<span class="milieu" style="font-size:11px; font-weight:normal;">Internet Plus est la solution de paiement s&eacute;curis&eacute;e qui vous permet de r&eacute;gler votre achat &agrave; l\'aide de votre facture Internet (Orange, Free, Bouygues T&eacute;l&eacute;com, SFR, Alice).</span>');
					document.write('<span class="bas-gauche"></span>');
					document.write('<span class="bas-centre"></span>');
					document.write('<span class="bas-droite"></span>');
					document.write('</span>');
					document.write('<span class="fleche"></span>');
					document.write('</span>');

				  //-->
				  </script>
                              <table>
                                <tr>
                                  <td rowspan="2" width="30"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/fleche_orange.gif');?>" alt="&gt;" /></td>
                                  <td><input id="paiement_mode_cb" type="radio" name="paiement_mode" value="CB"<?php if(isset($_REQUEST['paiement_mode']) && ($_REQUEST['paiement_mode']=='CB')) print(' checked="checked"');?> />
                                    <label for="paiement_mode_cb"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/cb.jpg');?>" alt="CB Visa Amex" /></label></td>
                                </tr>
                                <tr>
                                  <td><script type="text/javascript">
		  <!--
		    document.write('<input type="radio" name="paiement_mode" value="WHA" id="WHA"<?php if(isset($_REQUEST['paiement_mode']) && ($_REQUEST['paiement_mode']=='WHA')) print(' checked="checked"');?> /> ');
			document.write('<label for="WHA"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/internet.jpg');?>" alt="Internet Plus" /></label> <a href="#" onmouseover="document.getElementById(\'aide4\').style.display=\'block\';" onmouseout="document.getElementById(\'aide4\').style.display=\'none\';"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/info.jpg');?>" alt="?" /></a>');
		  //-->
		  </script></td>
                                </tr>
                              </table>
                              <input type="submit" style="font-family:Arial, Helvetica, sans-serif; background-image:url(<?php print(URL_ADHERENT.'image/paiement/v6/bouton.jpg');?>); font-size:14px; font-weight:bold; color:#FFF; cursor:pointer; width:145px; height:30px; text-align:center; margin:5px;" name="annonce_submit" value="Valider" /></td>
                          </tr>
                          <tr>
                            <td align="center" bgcolor="#d8e3f0"><img src="<?php print(URL_ADHERENT.'image/paiement/v6/ca.jpg');?>" alt="CB Visa Amex" /></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td><br /><br /><b><a href="#" onmouseover="document.getElementById('aide2b').style.display='block';" onmouseout="document.getElementById('aide2b').style.display='none';" style="color:#195292; font-size:13px; font-weight:bold; color:#FF7602;">Vous disposez d'un code promo ?</a></b></td>
              </tr>
            </table>
          </form></td>
      </tr>
    </table>
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