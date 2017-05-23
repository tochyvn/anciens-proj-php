<?php
	require_once(PWD_ADHERENT_V2.'configuration.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'allopass.php');
	require_once(PWD_INCLUSION.'wha.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'date.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'adherent.php');
	require_once(PWD_INCLUSION.'socket_http.php');
	require_once(PWD_INCLUSION.'preference.php');
	
	define('LIEN_WHA','https://mps.w-ha.com/app-mps/purchase?mctId=5216&pid=LA001&fid=1&mp_wha_desc2=current&mp_securite='.$_SESSION['wha_securite'].'&mp_adherent_identifiant='.urlencode($_SESSION['adherent_identifiant']).'&mp_annonce_submit=wha&mp_r='.urlencode(HTTP_ADHERENT_V2.'annonce/identification.php').'&mp_acte=LA001');
	//define('LIEN_WHA','http://212.43.196.170/bundle/pos_init?action=authorize&wha_desc2=current&pid=LA001&DATAS=&rand='.urlencode(strrnd(64,4)).'&'.urlencode(session_name()).'='.urlencode(session_id()).'&adherent_identifiant='.urlencode($_SESSION['adherent_identifiant']).'&annonce_submit=wha&r='.urlencode(HTTP_ADHERENT_V2.'annonce/identification.php').'&acte=LA001');
	
	if(isset($_REQUEST['annonce_submit']))
	{
		switch($_REQUEST['annonce_submit'])
		{
			case 'abonnement':
				$tarif_abonnement=new ld_tarif_abonnement();
				$tarif_abonnement->identifiant=$_REQUEST['tarif_abonnement_identifiant'];
				if(!$tarif_abonnement->lire())
				{
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=tarif_abonnement'));
					die();
				}
				
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
						$paybox['PBX_EFFECTUE']=HTTP_ADHERENT_V2.'annonce/detail.php';
						$paybox['PBX_REFUSE']=HTTP_ADHERENT_V2.'annonce/identification.php';
						$paybox['PBX_ANNULE']=HTTP_ADHERENT_V2.'annonce/identification.php';
						
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
					case 'CHEQUE':
						$facture->ajouter();
						$facture->envoyer();
						header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=abonnement_cheque&facture_identifiant='.urlencode($facture->identifiant)));
						die();
						break;
					case 'WHA':
						if(isset($_SESSION['WHA_PAYE']))
						{
							$facture->ajouter();
							$facture->payer();
							$facture->envoyer();
							unset($_SESSION['WHA_PAYE']);
						}
						else
						{
							header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=abonnement_wha'));
							die();
						}
						break;
				}
			
				header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/detail.php'));
				die();
				break;
			case 'code':
				if(isset($_REQUEST['code_reference']))
				{
					$code=new ld_code();
					if($code->identifier($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'])=='CODE_UTILISABLE')
						$_SESSION['code_reference']=$_REQUEST['code_reference'];
					else
					{
						header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=code_audiotel'));
						die();
					}
				}
				else
				{
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=code_audiotel'));
					die();
				}
				break;
			case 'allopass':
				if(isset($_REQUEST['allopass_reference']))
				{
					$code=new ld_code();
					if($code->identifier($_REQUEST['allopass_reference'],$_SESSION['adherent_identifiant'])=='CODE_UTILISABLE')
						$_SESSION['code_reference']=$_REQUEST['allopass_reference'];
					else
					{
						if($_REQUEST['allopass_reference']!='fiVus19--')
						{
							$succes=NULL;
							
							$identifiant=array('102802','270837','1607385');
							$socket=new ld_socket_http();
							$socket->url='http://payment.allopass.com/acte/access.apu';
							$socket->delai=30;
							$socket->methode='POST';
							$socket->corps='ids='.urlencode($identifiant[0]).'&'.'idd='.urlencode($identifiant[1]).'&data=&recall=1&code%5B%5D='.urlencode($_REQUEST['allopass_reference']);
							$socket->executer();
							if(isset($socket->resultat_entete['Location']) && strpos($socket->resultat_entete['Location'],'http://www.localerte.fr/adherent/message.php?message_submit=code_allopass')===false)
								$succes=$identifiant;
							
							if($succes===NULL)
							{
								$identifiant=array('102802','481363','1607385');
								$socket=new ld_socket_http();
								$socket->url='http://payment.allopass.com/acte/access.apu';
								$socket->delai=30;
								$socket->methode='POST';
								$socket->corps='ids='.urlencode($identifiant[0]).'&'.'idd='.urlencode($identifiant[1]).'&data=&recall=1&code%5B%5D='.urlencode($_REQUEST['allopass_reference']);
								$socket->executer();
								if(isset($socket->resultat_entete['Location']) && strpos($socket->resultat_entete['Location'],'http://www.localerte.fr/adherent/message.php?message_submit=code_allopass')===false)
									$succes=$identifiant;
							}
							
							if($succes!==NULL)
							{
								$resultat=explode(CRLF,trim(file_get_contents('http://payment.allopass.com/api/checkcode.apu?code='.urlencode($_REQUEST['allopass_reference']).'&auth='.urlencode(implode('/',$succes)))));
								if($resultat[0]=='OK')
								{
									if(preg_match('/<revers_palier>(.*)<\/revers_palier>/',file_get_contents('http://payment.allopass.com/api/infocode.apu?code='.urlencode($_REQUEST['allopass_reference']).'&auth='.urlencode(implode('/',$succes))),$resultat))
									{
										$allopass=new ld_allopass();
										$allopass->reference='';
										$allopass->nouveau_reference=$_REQUEST['allopass_reference'];
										$allopass->palier=$succes[1];
										$allopass->adherent=$_SESSION['adherent_identifiant'];
										$allopass->prix=floatval($resultat[1]);
										$allopass->ajouter();
									}
									else
									{
										$fichier=fopen(PWD_INCLUSION.'prive/log/erreur_allopass.log','a');
										fputs($fichier,date('Y-m-d H:i:s').TAB.$_SESSION['adherent_identifiant'].TAB.$_REQUEST['allopass_reference'].TAB.'3'.CRLF);
										fclose($fichier);
										
										header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=code_allopass'));
										die();
									}
								}
								else
								{
									$fichier=fopen(PWD_INCLUSION.'prive/log/erreur_allopass.log','a');
									fputs($fichier,date('Y-m-d H:i:s').TAB.$_SESSION['adherent_identifiant'].TAB.$_REQUEST['allopass_reference'].TAB.'2'.CRLF);
									fclose($fichier);
									
									header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=code_allopass'));
									die();
								}
							}
							else
							{
								$fichier=fopen(PWD_INCLUSION.'prive/log/erreur_allopass.log','a');
								fputs($fichier,date('Y-m-d H:i:s').TAB.$_SESSION['adherent_identifiant'].TAB.$_REQUEST['allopass_reference'].TAB.'1'.CRLF);
								fclose($fichier);
								
								header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=code_allopass'));
								die();
							}
						}
					
						$_SESSION['allopass_reference']=$_REQUEST['allopass_reference'];
					}
				}
				else
				{
					$fichier=fopen(PWD_INCLUSION.'prive/log/erreur_allopass.log','a');
					fputs($fichier,date('Y-m-d H:i:s').TAB.$_SESSION['adherent_identifiant'].TAB.''.TAB.'0'.CRLF);
					fclose($fichier);
					
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=code_allopass'));
					die();
				}
				break;
			case 'wha':
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
				else
				{
					header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=code_wha'));
					die();
				}
				break;
		}
	}
	
	$preference=new ld_preference();
	
	if($preference->annonce_vue_jour!==NULL)
	{
		$liste=new ld_liste
		('
			select count(*) as nombre
			from adherent_annonce
			where adherent=\''.addslashes($_SESSION['adherent_identifiant']).'\'
				and lu>=now() - interval 1 day
		');
		
		if($liste->occurrence[0]['nombre']>$preference->annonce_vue_jour)
		{
			header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'message.php?message_submit=annonce_vue_jour'));
			die();
		}
	}
	
	if(isset($_SESSION['allopass_reference']) || isset($_SESSION['wha_identifiant']) || isset($_SESSION['code_reference']) || $abonnement['resultat']=='ABONNEMENT_UTILISABLE')
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT_V2.'annonce/detail.php'));
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
<?php include(PWD_ADHERENT_V2.'entete.php');?>
<script src="<?php print(URL_INCLUSION);?>liste.js" language="javascript" type="text/javascript"></script>
<script language="javascript">
	function GererWHA()
	{
		if(document.getElementById('paiement_mode2').checked)
		{
			for(i=0;i<document.getElementsByName('tarif_abonnement_identifiant').length;i++)
				if(document.getElementsByName('tarif_abonnement_identifiant')[i].checked)
					OuvrirPopup('https://mps.w-ha.com/app-mps/purchase?mctId=5216&pid='+encodeURIComponent(document.getElementsByName('tarif_abonnement_identifiant')[i].value)+'&fid=1&mp_wha_desc2=current&mp_securite=<?php print($_SESSION['wha_securite'])?>&mp_r=<?php print(urlencode(HTTP_ADHERENT_V2.'annonce/identification.php'));?>&mp_adherent_identifiant=<?php print(urlencode($_SESSION['adherent_identifiant']));?>&mp_paiement_mode=WHA&mp_annonce_submit=abonnement&mp_tarif_abonnement_identifiant='+encodeURIComponent(document.getElementsByName('tarif_abonnement_identifiant')[i].value),true,'_self','width=640,height=480');
					//OuvrirPopup('<?php print('http://212.43.196.170/bundle/pos_init?action=authorize&wha_desc2=current&pid=');?>'+encodeURIComponent(document.getElementsByName('tarif_abonnement_identifiant')[i].value)+'&DATAS=&rand=<?php print(urlencode(strrnd(64,4)).'&'.urlencode(session_name()).'='.urlencode(session_id()));?>&r=<?php print(urlencode(HTTP_ADHERENT_V2.'annonce/identification.php'));?>&adherent_identifiant=<?php print(urlencode($_SESSION['adherent_identifiant']));?>&paiement_mode=WHA&annonce_submit=abonnement&tarif_abonnement_identifiant='+encodeURIComponent(document.getElementsByName('tarif_abonnement_identifiant')[i].value),true,'_self','width=640,height=480');
			return false;
		}
		
		return true;
	}
</script>
</head>
<body onload="DonnerFocus('annonce_identification','code_reference',0);">
<?php include(PWD_ADHERENT_V2.'debut.php');?>
<div id="conteneur">
  <?php include(PWD_ADHERENT_V2.'tete.php');?>
  <h1 id="annonce_identification">Nos annonces du jours - Identification</h1>
  <h2 id="code">Par t&eacute;l&eacute;phone ou SMS</h2>
  <p id="code"><img src="<?php print(URL_ADHERENT_V2.'image/aide.png');?>" alt="Aide" title="Aide" />Pour visualiser toutes les annonces d&eacute;taill&eacute;es, vous avez besoin d'un code que vous 
    pouvez obtenir de la mani&egrave;re suivante : </p>
  <ul id="code1">
    <li>Par sms, envoyez LOC au <?php print(ma_htmlentities($plateforme['S1'][1]));?> (<?php print(ma_htmlentities($plateforme['S1'][2]));?>&euro;+prix du sms) ou appelez le num&eacute;ro <?php print(ma_htmlentities(formater($plateforme['FR'][1],'telephone_espace')));?> &agrave; partir d'un t&eacute;l&eacute;phone fixe ou d'un mobile (<?php print(ma_htmlentities($plateforme['FR'][2]));?>&euro;/appel).</li>
  </ul>
  <form id="annonce_code" action="<?php print(URL_ADHERENT_V2.'annonce/identification.php');?>" method="post">
	<input type="hidden" name="annonce_submit" value="allopass" />
    <div id="code_reference">
      <label><span id="telephone1">Par t&eacute;l&eacute;phone, appelez le </span><span id="telephone2"><?php print(ma_htmlentities(formater($plateforme['FR'][1],'telephone_espace')));?></span><span id="ou"> ou </span><span id="sms1">par SMS, envoyez LOC au </span><span id="sms2"><?php print(ma_htmlentities($plateforme['S1'][1]));?></span><span id="saisie">et saisissez le code obtenu:</span></label>
      <input type="text" name="allopass_reference" value="" />
    </div>
    <div id="annonce_submit">
      <input type="image" src="<?php print(URL_ADHERENT_V2.'image/bouton_ok.png');?>" />
    </div>
  </form>
  <ul id="code2">
    <li>Vous pouvez naviguer imm&eacute;diatement entre la liste et le d&eacute;tail des annonces sans avoir &agrave; saisir un 
      nouveau code. Votre code restera valable pour toute la dur&eacute;e de votre session. </li>
    <li><span><a href="forfait.php">Offre sp&eacute;ciale:</a></span>&nbsp;<a href="forfait.php">5 codes pour 6&euro; / 10 codes pour 11&euro; </a><span><a href="forfait.php">&agrave; utiliser quand vous le souhaitez</a></span></li>
  </ul>
  <h2 id="abonnement">Abonnement</h2>
  <p id="abonnement"><img src="<?php print(URL_ADHERENT_V2.'image/aide.png');?>" alt="Aide" title="Aide" />Abonnez-vous &agrave; des tarifs pr&eacute;f&eacute;rentiels et acc&eacute;dez 24/24h &agrave; toutes les annonces d&eacute;taill&eacute;es</p>
  <form id="annonce_abonnement" action="<?php print(URL_ADHERENT_V2.'annonce/identification.php');?>" method="post" onsubmit="return GererWHA();">
    <input type="hidden" name="annonce_submit" value="abonnement" />
    <div id="tarif_abonnement">
      <label id="champ">Choix de l'abonnement:</label>
      <input type="radio" name="tarif_abonnement_identifiant" value="ab0009" id="tarif_abonnement_identifiant1" />
      <label for="tarif_abonnement_identifiant1" id="position1">7 jours<span id="prix">7&euro;</span></label>
      <input type="radio" name="tarif_abonnement_identifiant" value="ab0010" id="tarif_abonnement_identifiant2" />
      <label for="tarif_abonnement_identifiant2" id="position2">14 jours<span id="prix">13&euro;</span></label>
      <input type="radio" name="tarif_abonnement_identifiant" value="ab0011" id="tarif_abonnement_identifiant3" />
      <label for="tarif_abonnement_identifiant3" id="position3">21 jours<span id="prix">19&euro;</span></label>
      <input type="radio" name="tarif_abonnement_identifiant" value="ab0012" id="tarif_abonnement_identifiant4" checked="checked" />
      <label for="tarif_abonnement_identifiant4" id="position4">28 jours<span id="prix">24&euro;</span></label>
    </div>
    <div id="paiement_mode">
      <label id="champ">Mode de paiement:</label>
      <input type="radio" name="paiement_mode" value="CB" id="paiement_mode1" checked="checked" />
      <label for="paiement_mode1" id="position1"><img src="<?php print(URL_ADHERENT_V2.'image/cb.jpg');?>" alt="Carte bleue" title="Carte bleue" onclick="document.getElementById('paiement_mode1').checked=true;" /></label>
      <script language="javascript">
	    document.write('<input type="radio" name="paiement_mode" value="WHA" id="paiement_mode2" />');
        document.write('<label for="paiement_mode2" id="position2"><img src="<?php print(URL_ADHERENT_V2.'image/internetplus.jpg');?>" alt="Internet Plus" title="Internet Plus" onclick="document.getElementById(\'paiement_mode2\').checked=true;" /></label>');
      </script>
      <input type="radio" name="paiement_mode" value="CHEQUE" id="paiement_mode3" />
      <label for="paiement_mode3" id="position3"><img src="<?php print(URL_ADHERENT_V2.'image/cheque.jpg');?>" alt="Ch&egrave;ques" title="Ch&egrave;ques" onclick="document.getElementById('paiement_mode3').checked=true;" /></label>
    </div>
    <div id="annonce_submit">
      <input type="image" src="<?php print(URL_ADHERENT_V2.'image/bouton_suivant.jpg');?>" />
    </div>
  </form>
  <h2 id="wha">Par Internet Plus</h2>
  <p id="wha">Vous pouvez &eacute;galement obtenir votre acc&egrave;s par Internet+ en <a  href="<?php print(LIEN_WHA);?>">cliquant ici</a>. Le montant d&eacute;bit&eacute; de 1&euro;50 appara&icirc;tra directement sur votre facture internet.</p>
  <a href="<?php print(LIEN_WHA);?>" id="wha"><img src="<?php print(URL_ADHERENT_V2.'image/wha.jpg');?>" /></a>
  <?php include(PWD_ADHERENT_V2.'pied.php');?>
</div>
<center>
<br />
<iframe style="clear:both" src="<?php print(URL_ADHERENT_V2);?>adsense.php?adsense_identifiant=728x90" id="adsense728x90" scrolling="no" frameborder="0"></iframe>
</center>
<?php include(PWD_ADHERENT_V2.'fin.php');?>
</body>
</html>
