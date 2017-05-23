<?php
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'abonnement.php');
	require_once(PWD_INCLUSION.'code.php');
	require_once(PWD_INCLUSION.'allopass.php');
	require_once(PWD_INCLUSION.'string.php');
	require_once(PWD_INCLUSION.'wha.php');
	require_once(PWD_INCLUSION.'socket_http.php');
 	require_once(PWD_INCLUSION.'mail.php');
	require_once(PWD_INCLUSION.'liste.php');
	require_once(PWD_INCLUSION.'facture.php');
	require_once(PWD_INCLUSION.'date.php');
	
	if(!isset($_SESSION['annonce_identifiant']))
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'/ma-liste.php'));
		die();
	}
	
	//ABONNEMENT
	if(!isset($_REQUEST['tarif_abonnement_identifiant']) || !preg_match('/^('.implode('|',$tarif_possible).')$/i',$_REQUEST['tarif_abonnement_identifiant']))
		$_REQUEST['tarif_abonnement_identifiant']=$tarif_defaut;

	if(!isset($_REQUEST['paiement_mode']) || !preg_match('/^(CB|WHA|WHA_POST|PAYPAL)$/i',$_REQUEST['paiement_mode']))
		$_REQUEST['paiement_mode']='CB';

	if($_REQUEST['paiement_mode']=='WHA_POST'){

		$_REQUEST['paiement_mode']='WHA';
		if(isset($_SESSION['WHA_PAYE']))
		{
			$facture=new ld_facture();
			$facture->identifiant=$_SESSION['WHA_FACTURE'];
			$facture->payer('WHA');
			$facture->envoyer();
			unset($_SESSION['WHA_PAYE']);
			header('location: '.url_use_trans_sid(URL_ADHERENT.'/ma-selection.php'));
			die();
		}
	}

	if(isset($_REQUEST['annonce_submit']) && $_REQUEST['annonce_submit']=='CB_OK' && $_REQUEST['paiement_mode']=='PAYPAL') sleep(10);

					
	$tarif_abonnement=new ld_tarif_abonnement();
	$tarif_abonnement->identifiant=$_REQUEST['tarif_abonnement_identifiant'];
	$tarif_abonnement->lire();

	if(isset($_REQUEST['annonce_submit']) && $_REQUEST['annonce_submit']!='CB_OK' && $_REQUEST['annonce_submit']!='CB_REFUS' && $_REQUEST['annonce_submit']!='CB_ANNULATION' && $_REQUEST['annonce_submit']!='WHA_ANNULATION')
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
					$paybox['PBX_MODE']=1;	//1 = POST
					$paybox['PBX_SITE']='0559343';	//'1999888';//'0559343';					//donne par la banque
					$paybox['PBX_RANG']='01';		//'99';//'01';						//donne par la banque
					$paybox['PBX_TOTAL']=round($tarif_abonnement->prix_ht*(1+$tarif_abonnement->tva/100)*100,0);	//TOTAL en centimes
					$paybox['PBX_DEVISE']=978;										//978 = EUROS
					$paybox['PBX_CMD']='LA'.$facture->identifiant;					//REFERENCE
					$paybox['PBX_PORTEUR']=$adherent->email;						//EMAIL DU CLIENT
					//$paybox['PBX_PAYBOX']='https://tpeweb.paybox.com/cgi/ChoixPaiementMobile.cgi';						//EMAIL DU CLIENT
					//$paybox['PBX_BACKUP1']='https://tpeweb.paybox.com/cgi/ChoixPaiementMobile.cgi';						//EMAIL DU CLIENT
					$paybox['PBX_IDENTIFIANT']='20738281';
					$paybox['PBX_RETOUR']='ref:R;trans:T;auto:A;tarif:M';			//VALIDE LE PAIEMENT
					$paybox['PBX_EFFECTUE']=HTTP_ADHERENT.'/ma-selection.php';
					$paybox['PBX_REFUSE']=HTTP_ADHERENT.'/mes-paiements.php?tarif_abonnement_identifiant='.$tarif_abonnement->identifiant.'&paiement_mode=CB&annonce_submit=CB_REFUS';
					$paybox['PBX_ANNULE']=HTTP_ADHERENT.'/mes-paiements.php?tarif_abonnement_identifiant='.$tarif_abonnement->identifiant.'&paiement_mode=CB&annonce_submit=CB_ANNULATION';
					
					//print_r($paybox);
                                        $string = '';
                                        $erreur = '';
					$socket=fsockopen('paiement.aicom.fr',80, $erreur, $string);

					if($socket){


						$post=array();
						foreach($paybox as $clef=>$valeur)
							$post[]=urlencode($clef).'='.urlencode($valeur);
						$query=implode('&',$post);
						//$out='';
						//$out.='GET /cgi-bin/modulev3-20.cgi?'.$query.' HTTP/1.0'.CRLF;
						//$out.='Host: paiement.aicom.fr'.CRLF;
						//$out.='Connection: Close'.CRLF;
						$out='';
						$out.='POST /cgi-bin/modulev3-20.cgi HTTP/1.0'.CRLF;
						$out.='Host: paiement.aicom.fr'.CRLF;
						$out.='Connection: Close'.CRLF;
						$out.='Content-Type: application/x-www-form-urlencode'.CRLF;
						$out.='Content-Length: '.strlen($query).CRLF.CRLF;
						$out.=$query;
						fputs($socket,$out,strlen($out));
						$in='';
                                                while(!feof($socket)){
					           $in.=fgets($socket);
                                                }
						list($header,$body)=explode(CRLF.CRLF,$in,2);
						print($body);
						fclose($socket);
						die();
					}
					break;
				case 'PAYPAL':
					$facture->ajouter();
					
					$paypal=array();
					$paypal['cmd']='_s-xclick';
					$paypal['hosted_button_id']=$tarif_abonnement->paypal;//'YPM8Y6XWVRCJ6';
					$paypal['page_style']='LOCALERTE';
					$paypal['invoice']='LA-PAYPAL'.$facture->identifiant;
					
					header('location: https://www.paypal.com/cgi-bin/webscr?'.http_build_query($paypal,'','&'));
					die();
					
					break;
				case 'WHA':
					$facture->ajouter();
					$_SESSION['WHA_FACTURE']=$facture->identifiant;
					
					header('location: https://mps.w-ha.com/app-mps/purchase?mctId=5216&pid='.urlencode($_REQUEST['tarif_abonnement_identifiant']).'&fid=1&mp_wha_desc2=current&mp_securite='.$_SESSION['wha_securite'].'&mp_r='.urlencode(HTTP_ADHERENT.'/mes-paiements.php').'&mp_adherent_identifiant='.urlencode($_SESSION['adherent_identifiant']).'&mp_paiement_mode=WHA_POST&mp_annonce_submit=WHA_ANNULATION&mp_tarif_abonnement_identifiant='.urlencode($_REQUEST['tarif_abonnement_identifiant']));
					die();
					break;
			}
		}
	}
	
	//CODE
	if(isset($_SESSION['code_reference']))
	{
		$_REQUEST['code_reference']=$_SESSION['code_reference'];
		unset($_SESSION['code_reference']);
	}
	if(isset($_SESSION['allopass_reference']))
	{
		$_REQUEST['code_reference']=$_SESSION['allopass_reference'];
		unset($_SESSION['allopass_reference']);
	}
	
	if(isset($_REQUEST['code_reference']))
	{
		$allopass_access=false;
		$allopass_checkcode=false;
		
		if(!isset($_SESSION['code_reference']) && !isset($_SESSION['allopass_reference']))
		{
			$liste=new ld_liste
			('
				select adddate(date_premiere_connexion, interval 1 day)>=now() as autorise
				from code
				where reference=\''.addslashes($_REQUEST['code_reference']).'\'
					and date_premiere_connexion is not null
			');
			if($liste->total && $liste->occurrence[0]['autorise'])
			{
				$_SESSION['code_reference']=$_REQUEST['code_reference'];
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'CODE'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK-24'.CRLF,FILE_APPEND);
				$code=new ld_code();
				$code->logguer($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'],date('Y-m-d H:i:s'),'OK-24','CODE','www.localerte.fr');
			}
			elseif(!$liste->total)
			{
				$code=new ld_code();
				if($code->identifier($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'])=='CODE_UTILISABLE')
				{
					$_SESSION['code_reference']=$_REQUEST['code_reference'];
					file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'CODE'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
					$code=new ld_code();
					$code->logguer($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'],date('Y-m-d H:i:s'),'OK','CODE','www.localerte.fr');
				}
				else
				{
					file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'CODE'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
					$code=new ld_code();
					$code->logguer($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'],date('Y-m-d H:i:s'),'KO','CODE','www.localerte.fr');
				}
			}
			else
			{
				$code_doublon=true;
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'CODE'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO-DOUBLON'.CRLF,FILE_APPEND);
				$code=new ld_code();
				$code->logguer($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'],date('Y-m-d H:i:s'),'KO-DOUBLON','CODE','www.localerte.fr');
			}
		}
		if(!isset($_SESSION['code_reference']) && !isset($_SESSION['allopass_reference']))
		{
			$liste=new ld_liste
			('
				select palier, adddate(enregistrement, interval 1 day)>=now() as autorise
				from allopass
				where reference=\''.addslashes($_REQUEST['code_reference']).'\'
			');
			if($liste->total && $liste->occurrence[0]['palier']=='1042318' && $liste->occurrence[0]['autorise'])
			{
				$_SESSION['allopass_reference']=$_REQUEST['code_reference'];
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-1042318'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK-24'.CRLF,FILE_APPEND);
				$code=new ld_code();
				$code->logguer($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'],date('Y-m-d H:i:s'),'OK-24','ALLOPASS-1042318','www.localerte.fr');
			}
			elseif(!$liste->total)
			{
				$identifiant=array('102802','1042318','1607385');
				$socket=new ld_socket_http();
				$socket->url='http://payment.allopass.com/acte/access.apu';
				$socket->delai=30;
				$socket->methode='POST';
				$socket->corps='ids='.urlencode($identifiant[0]).'&'.'idd='.urlencode($identifiant[1]).'&data=&recall=1&code%5B%5D='.urlencode($_REQUEST['code_reference']);
				$socket->executer();
				if(isset($socket->resultat_entete['Location']) && strpos($socket->resultat_entete['Location'],'http://www.localerte.fr/adh'.'erent/message.php?message_submit=code_allopass')===false)
				{
					$_SESSION['allopass_reference']=$_REQUEST['code_reference'];
					$allopass_access=$identifiant;
					file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-1042318'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'OK'.CRLF,FILE_APPEND);
					$code=new ld_code();
					$code->logguer($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'],date('Y-m-d H:i:s'),'OK','ALLOPASS-1042318','www.localerte.fr');
				}
				else
				{
					file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-1042318'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO'.CRLF,FILE_APPEND);
					$code=new ld_code();
					$code->logguer($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'],date('Y-m-d H:i:s'),'KO','ALLOPASS-1042318','www.localerte.fr');
				}
			}
			else
			{
				$code_doublon=true;
				file_put_contents(PWD_INCLUSION.'prive/log/code-'.date('Ym').'.log',date('Y-m-d H:i:s').TAB.'ALLOPASS-1042318'.TAB.$_REQUEST['code_reference'].TAB.$_SESSION['adherent_identifiant'].TAB.$_SERVER['REMOTE_ADDR'].TAB.'KO-DOUBLON'.CRLF,FILE_APPEND);
				$code=new ld_code();
				$code->logguer($_REQUEST['code_reference'],$_SESSION['adherent_identifiant'],date('Y-m-d H:i:s'),'KO-DOUBLON','ALLOPASS-1042318','www.localerte.fr');
			}
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
	
	//INTERNET PLUS
	if(isset($_SESSION['WHA_PAYE']) && $_REQUEST['acte']=='LA002')
	{
		$wha=new ld_wha();
		$wha->identifiant='';
		$wha->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_wha','identifiant',WHA_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		$wha->adherent=$_SESSION['adherent_identifiant'];
		$wha->prix=1.77;
		$wha->domaine=$_SERVER['HTTP_HOST'];
		$wha->ajouter();
		$_SESSION['wha_identifiant']=$wha->identifiant;
		
		unset($_SESSION['WHA_PAYE']);
		
		$delai=2;
		$abonnement=new ld_abonnement();
		$abonnement->identifiant='';
		$abonnement->nouveau_identifiant=sql_eviter_doublon_strrnd('ld_abonnement','identifiant',ABONNEMENT_NOUVEAU_IDENTIFIANT_MAX,STRRND_MODE);
		$abonnement->adherent=$_SESSION['adherent_identifiant'];
		$abonnement->delai=$delai*24*60*60;
		$abonnement->domaine='www.localerte.fr';
		$abonnement->ajouter();
	}
	
	//SI PASSE MURAILLE
	if(isset($_SESSION['allopass_reference']) || isset($_SESSION['wha_identifiant']) || isset($_SESSION['code_reference']) || $abonnement['resultat']=='ABONNEMENT_UTILISABLE')
	{
		header('location: '.url_use_trans_sid(URL_ADHERENT.'/ma-selection.php'));
		die();
	}
?>
